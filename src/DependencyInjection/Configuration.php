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
