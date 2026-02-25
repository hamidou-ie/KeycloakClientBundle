<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\DependencyInjection\EnvVarProcessor;

use Symfony\Component\DependencyInjection\EnvVarProcessorInterface;

/**
 * Derives Keycloak OIDC endpoints from IAM_* environment variables.
 *
 * Usage examples:
 * - %env(keycloak_issuer:IAM_BASE_URL)%
 * - %env(keycloak_discovery_base_uri:IAM_BASE_URL)%
 */
final class KeycloakDerivedEnvVarProcessor implements EnvVarProcessorInterface
{
    /**
     * @return array<string, string>
     */
    public static function getProvidedTypes(): array
    {
        return [
            'keycloak_issuer' => 'string',
            'keycloak_discovery_base_uri' => 'string',
        ];
    }

    public function getEnv(string $prefix, string $name, \Closure $getEnv): mixed
    {
        $baseUrl = (string) $getEnv($name);
        $realm = (string) $getEnv('IAM_REALM');

        $baseUrl = rtrim($baseUrl, '/') . '/';
        $issuer = rtrim($baseUrl . 'realms/' . $realm, '/');

        return match ($prefix) {
            'keycloak_issuer' => $issuer,
            'keycloak_discovery_base_uri' => $issuer . '/',
            default => throw new \RuntimeException(sprintf('Unsupported env var prefix "%s".', $prefix)),
        };
    }
}
