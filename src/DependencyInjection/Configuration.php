<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('hamidou_ie_keycloak_client');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->arrayNode('keycloak')
            ->children()
            ->booleanNode('verify_ssl')
            ->defaultTrue()
            ->end()
            ->scalarNode('base_url')
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('realm')
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('client_id')
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('client_secret')
            ->defaultNull()
            ->end()
            ->scalarNode('redirect_uri')
            ->defaultNull()
            ->end()
            ->scalarNode('encryption_algorithm')
            ->defaultValue('JWKS')
            ->end()
            ->scalarNode('encryption_key')
            ->defaultNull()
            ->end()
            ->scalarNode('encryption_key_path')
            ->defaultNull()
            ->end()
            ->scalarNode('encryption_key_passphrase')
            ->defaultNull()
            ->end()
            ->scalarNode('version')
            ->defaultNull()
            ->end()
            ->arrayNode('allowed_jwks_domains')
            ->info(
                'Whitelist of allowed domains for JWKS endpoint requests. If empty, only the base_url domain is allowed.',
            )
            ->scalarPrototype()
            ->end()
            ->end()
            ->end()
            ->end()
            ->arrayNode('security')
            ->info(
                'Enable this if you want to use the Keycloak security layer. This will protect your application with Keycloak.',
            )
            ->canBeEnabled()
            ->children()
            ->scalarNode('default_target_route_name')
            ->defaultNull()
            ->end()
            ->end()
            ->end()
            ->arrayNode('admin_cli')
            ->info(
                'Enable this if you want to use the admin-cli client to authenticate with Keycloak. This is useful if you want to use the Keycloak Admin REST API.',
            )
            ->canBeEnabled()
            ->children()
            ->scalarNode('realm')
            ->defaultNull()
            ->end()
            ->scalarNode('client_id')
            ->defaultNull()
            ->end()
            ->scalarNode('username')
            ->defaultNull()
            ->end()
            ->scalarNode('password')
            ->defaultNull()
            ->end()
            ->end()
            ->end()
            ->end();

        $rootNode
            ->children()
                ->arrayNode('oidc')
                    ->addDefaultsIfNotSet()
                    ->info('Helpers for Symfony 8 access_token OIDC configuration (derived from IAM_*).')
                    ->children()
                        ->scalarNode('audience')
                            ->defaultNull()
                            ->info('Overrides audience for JWT validation. Defaults to keycloak.client_id when null.')
                        ->end()
                        ->scalarNode('issuer')
                            ->defaultNull()
                            ->info('Overrides issuer for JWT validation. Defaults to {base_url}/realms/{realm} when null.')
                        ->end()
                        ->scalarNode('discovery_base_uri')
                            ->defaultNull()
                            ->info('Overrides discovery base URI. Defaults to issuer + "/" when null.')
                        ->end()

                        ->arrayNode('doctrine_user_provider')
                            ->canBeEnabled()
                            ->info('Optional Doctrine-backed OIDC user provider that syncs a local User entity from Keycloak claims.')
                            ->children()
                                ->scalarNode('user_class')
                                    ->defaultValue('Api\\Entity\\User')
                                    ->info('Fully-qualified class name of your User entity (must implement Symfony UserInterface).')
                                ->end()
                                ->scalarNode('dn_field')
                                    ->defaultValue('dn')
                                    ->info('Field used to store stable Keycloak subject (format: oidc:{sub}).')
                                ->end()
                                ->scalarNode('email_field')
                                    ->defaultValue('email')
                                ->end()
                                ->scalarNode('subject_claim')
                                    ->defaultValue('sub')
                                ->end()
                                ->scalarNode('email_claim')
                                    ->defaultValue('email')
                                ->end()
                                ->scalarNode('username_claim')
                                    ->defaultValue('preferred_username')
                                ->end()
                                ->scalarNode('firstname_claim')
                                    ->defaultValue('given_name')
                                ->end()
                                ->scalarNode('lastname_claim')
                                    ->defaultValue('family_name')
                                ->end()
                                ->scalarNode('dn_prefix')
                                    ->defaultValue('oidc:')
                                ->end()
                                ->booleanNode('sync_roles')
                                    ->defaultTrue()
                                    ->info('When true, roles from the token are synchronized into the local user.roles field.')
                                ->end()
                                ->enumNode('roles_source')
                                    ->values(['realm_and_client', 'client'])
                                    ->defaultValue('realm_and_client')
                                    ->info('Which token roles to sync into the local user.roles field. "client" uses resource_access[client_id] only; "realm_and_client" includes realm_access + client roles.')
                                ->end()
                                ->scalarNode('client_id')
                                    ->defaultNull()
                                    ->info('Client ID used to extract resource_access roles. Defaults to keycloak.client_id when null.')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        $rootNode
            ->validate()
                ->ifTrue(static function (array $v): bool {
                    $adminCli = $v['admin_cli'] ?? [];
                    if (!($adminCli['enabled'] ?? false)) {
                        return false;
                    }

                    return empty($adminCli['realm'])
                        || empty($adminCli['client_id'])
                        || empty($adminCli['username'])
                        || empty($adminCli['password']);
                })
                ->thenInvalid('When admin_cli is enabled, you must configure realm, client_id, username and password.')
            ->end();

        return $treeBuilder;
    }
}
