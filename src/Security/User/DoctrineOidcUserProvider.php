<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Security\User;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\AttributesBasedUserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Doctrine-backed OIDC user provider.
 *
 * Responsibilities:
 * - Match the currently authenticated Keycloak user to a local User entity.
 * - Sync basic profile fields (firstname, lastname, email, username) from OIDC claims.
 * - Optionally sync roles from the OIDC token into the local user roles.
 *
 * Matching strategy:
 * 1) Prefer stable Keycloak subject: {dnPrefix}{sub} stored in dnField (default: "dn").
 * 2) Fallback to emailField (default: "email").
 */
/**
 * @implements AttributesBasedUserProviderInterface<UserInterface>
 */
final class DoctrineOidcUserProvider implements AttributesBasedUserProviderInterface
{
    private const ROLES_SOURCE_REALM_AND_CLIENT = 'realm_and_client';
    private const ROLES_SOURCE_CLIENT_ONLY = 'client';

    /**
     * @param class-string<UserInterface> $userClass
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly string $userClass,
        private readonly string $clientId,
        private readonly string $dnField = 'dn',
        private readonly string $emailField = 'email',
        private readonly string $subjectClaim = 'sub',
        private readonly string $emailClaim = 'email',
        private readonly string $usernameClaim = 'preferred_username',
        private readonly string $firstnameClaim = 'given_name',
        private readonly string $lastnameClaim = 'family_name',
        private readonly string $dnPrefix = 'oidc:',
        private readonly bool $syncRoles = true,
        private readonly string $rolesSource = self::ROLES_SOURCE_REALM_AND_CLIENT,
    ) {
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function loadUserByIdentifier(string $identifier, array $attributes = []): UserInterface
    {
        /** @var EntityRepository<UserInterface> $repo */
        $repo = $this->entityManager->getRepository($this->userClass);

        $emailClaim = $this->getStringClaim($attributes, $this->emailClaim);
        $usernameClaim = $this->getStringClaim($attributes, $this->usernameClaim);
        $givenNameClaim = $this->getStringClaim($attributes, $this->firstnameClaim);
        $familyNameClaim = $this->getStringClaim($attributes, $this->lastnameClaim);
        $subjectClaim = $this->getStringClaim($attributes, $this->subjectClaim);

        $dn = $subjectClaim !== '' ? $this->dnPrefix . $subjectClaim : '';

        $email = $emailClaim !== '' ? $emailClaim : $identifier;
        $username = $usernameClaim !== '' ? $usernameClaim : $identifier;

        $user = null;

        if ($dn !== '') {
            $user = $repo->findOneBy([$this->dnField => $dn]);
        }

        if (!$user instanceof UserInterface && $emailClaim !== '') {
            $user = $repo->findOneBy([$this->emailField => $emailClaim]);
        }

        if (!$user instanceof UserInterface && $identifier !== '') {
            $user = $repo->findOneBy([$this->emailField => $identifier]);
        }

        $isNew = false;
        $changed = false;

        if (!$user instanceof UserInterface) {
            // @phpstan-ignore-next-line (runtime safety, config may still be wrong)
            if (!is_a($this->userClass, UserInterface::class, true)) {
                throw new UnsupportedUserException(sprintf('Configured user_class "%s" must implement %s.', $this->userClass, UserInterface::class));
            }

            $user = new ($this->userClass)();

            $isNew = true;

            // Initialize typed properties before any potential getters.
            $this->tryCallSetter($user, 'setEmail', (string) $email);
            $this->tryCallSetter($user, 'setUsername', (string) $username);
            $this->tryCallSetter($user, 'setFirstname', $givenNameClaim !== '' ? $givenNameClaim : '-');
            $this->tryCallSetter($user, 'setLastname', $familyNameClaim !== '' ? $familyNameClaim : '-');

            if ($dn !== '') {
                $this->tryCallSetter($user, 'setDn', $dn);
            }

            $changed = true;
        }

        // Sync core profile fields from Keycloak claims when available.
        if ($emailClaim !== '') {
            $changed = $this->trySync($user, 'getEmail', 'setEmail', $emailClaim) || $changed;
        }

        if ($usernameClaim !== '') {
            $changed = $this->trySync($user, 'getUsername', 'setUsername', $usernameClaim) || $changed;
        }

        if ($givenNameClaim !== '') {
            $changed = $this->trySync($user, 'getFirstname', 'setFirstname', $givenNameClaim) || $changed;
        }

        if ($familyNameClaim !== '') {
            $changed = $this->trySync($user, 'getLastname', 'setLastname', $familyNameClaim) || $changed;
        }

        if ($dn !== '') {
            $changed = $this->trySync($user, 'getDn', 'setDn', $dn) || $changed;
        }

        if ($this->syncRoles) {
            $roles = $this->extractRoles($attributes);
            if ($roles !== []) {
                $currentRoles = [];
                try {
                    $currentRoles = $user->getRoles();
                } catch (\Throwable) {
                    $currentRoles = [];
                }

                $normalizedCurrent = $this->normalizeRoleList($currentRoles);
                if ($normalizedCurrent !== $roles) {
                    $this->tryCallSetter($user, 'setRoles', $roles);
                    $changed = true;
                }
            }
        }

        if ($changed || $isNew) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$this->supportsClass($user::class)) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', $user::class));
        }

        if (method_exists($user, 'getId')) {
            $id = $user->getId();
            /** @var EntityRepository<UserInterface> $repo */
            $repo = $this->entityManager->getRepository($this->userClass);
            $reloaded = $repo->find($id);

            return $reloaded instanceof UserInterface ? $reloaded : $user;
        }

        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return $class === $this->userClass || is_subclass_of($class, $this->userClass);
    }

    /**
     * @param array<string, mixed> $attributes
     */
    private function getStringClaim(array $attributes, string $key): string
    {
        $value = $attributes[$key] ?? '';

        return is_string($value) ? trim($value) : '';
    }

    private function tryCallSetter(UserInterface $user, string $setter, mixed $value): void
    {
        if (!method_exists($user, $setter)) {
            return;
        }

        $user->{$setter}($value);
    }

    private function trySync(UserInterface $user, string $getter, string $setter, string $value): bool
    {
        if (!method_exists($user, $setter)) {
            return false;
        }

        if (!method_exists($user, $getter)) {
            $user->{$setter}($value);
            return true;
        }

        try {
            $current = (string) $user->{$getter}();
        } catch (\Error) {
            // Typed property uninitialized or other edge: set directly.
            $user->{$setter}($value);
            return true;
        }

        if ($current === $value) {
            return false;
        }

        $user->{$setter}($value);
        return true;
    }

    /**
     * @param array<string, mixed> $attributes
     * @return list<string>
     */
    private function extractRoles(array $attributes): array
    {
        $roles = [];

        if ($this->rolesSource !== self::ROLES_SOURCE_CLIENT_ONLY) {
            $roles = array_merge($roles, $this->extractRealmRoles($attributes));
        }

        $roles = array_merge($roles, $this->extractClientRoles($attributes));

        return $this->normalizeRoleList($roles);
    }

    /**
     * @param array<string, mixed> $attributes
     * @return list<string>
     */
    private function extractRealmRoles(array $attributes): array
    {
        $roles = [];

        if (!isset($attributes['realm_access']['roles']) || !is_array($attributes['realm_access']['roles'])) {
            return [];
        }

        foreach ($attributes['realm_access']['roles'] as $role) {
            if (is_string($role) && $role !== '') {
                $roles[] = $this->normalizeRoleName($role);
            }
        }

        return $roles;
    }

    /**
     * @param array<string, mixed> $attributes
     * @return list<string>
     */
    private function extractClientRoles(array $attributes): array
    {
        $resourceAccess = $attributes['resource_access'] ?? null;
        if (!is_array($resourceAccess)) {
            return [];
        }

        // When roles_source=client, we only want the roles for this client.
        // When roles_source=realm_and_client, we still include the client roles.
        $clientKeys = [];
        if ($this->clientId !== '') {
            $clientKeys[] = $this->clientId;
        }

        // Fallback: some tokens expose the current client as "azp" (authorized party).
        $azp = $attributes['azp'] ?? null;
        if (is_string($azp) && $azp !== '' && $azp !== $this->clientId) {
            $clientKeys[] = $azp;
        }

        $roles = [];
        foreach ($clientKeys as $clientKey) {
            if (!isset($resourceAccess[$clientKey]['roles']) || !is_array($resourceAccess[$clientKey]['roles'])) {
                continue;
            }
            foreach ($resourceAccess[$clientKey]['roles'] as $role) {
                if (is_string($role) && $role !== '') {
                    $roles[] = $this->normalizeRoleName($role);
                }
            }
        }

        return $roles;
    }

    /**
        * @param array<int, mixed> $roles
     * @return list<string>
     */
    private function normalizeRoleList(array $roles): array
    {
        $normalized = [];

        foreach ($roles as $role) {
            if (!is_string($role) || $role === '') {
                continue;
            }
            $normalized[] = $this->normalizeRoleName($role);
        }

        $normalized = array_values(array_unique($normalized));
        sort($normalized);

        return $normalized;
    }

    private function normalizeRoleName(string $role): string
    {
        $upper = strtoupper($role);

        if (str_starts_with($upper, 'ROLE_')) {
            return $upper;
        }

        return 'ROLE_' . $upper;
    }
}
