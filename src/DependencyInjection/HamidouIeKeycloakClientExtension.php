<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\DependencyInjection;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class HamidouIeKeycloakClientExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(dirname(__DIR__).'/Resources/config')
        );
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach (($config['keycloak'] ?? []) as $key => $value) {
            $container->setParameter('hamidou_ie_keycloak_client.keycloak.'.$key, $value);
        }
        foreach (($config['security'] ?? []) as $key => $value) {
            $container->setParameter('hamidou_ie_keycloak_client.security.'.$key, $value);
        }
        foreach (($config['admin_cli'] ?? []) as $key => $value) {
            if ('enabled' === $key) {
                continue;
            }
            $container->setParameter('hamidou_ie_keycloak_client.admin_cli.'.$key, $value);
        }

        // ---- Derived OIDC settings (for Symfony 8 access_token OIDC) ----
        $baseUrl = (string) ($config['keycloak']['base_url'] ?? '');
        $realm = (string) ($config['keycloak']['realm'] ?? '');
        $clientId = (string) ($config['keycloak']['client_id'] ?? '');

        $normalizedBaseUrl = rtrim($baseUrl, '/') . '/';
        $defaultIssuer = rtrim($normalizedBaseUrl . 'realms/' . $realm, '/');
        $issuer = (string) (($config['oidc']['issuer'] ?? null) ?: $defaultIssuer);
        $discoveryBaseUri = (string) (($config['oidc']['discovery_base_uri'] ?? null) ?: (rtrim($issuer, '/') . '/'));
        $audience = (string) (($config['oidc']['audience'] ?? null) ?: $clientId);

        $container->setParameter('hamidou_ie_keycloak_client.oidc.issuer', $issuer);
        $container->setParameter('hamidou_ie_keycloak_client.oidc.discovery_base_uri', $discoveryBaseUri);
        $container->setParameter('hamidou_ie_keycloak_client.oidc.client_id', $clientId);
        $container->setParameter('hamidou_ie_keycloak_client.oidc.audience', $audience);

        // ---- Optional Doctrine-backed OIDC UserProvider ----
        $doctrineProviderConfig = $config['oidc']['doctrine_user_provider'] ?? [];
        $doctrineProviderEnabled = (bool) ($doctrineProviderConfig['enabled'] ?? false);
        $container->setParameter('hamidou_ie_keycloak_client.oidc.doctrine_user_provider.enabled', $doctrineProviderEnabled);
        foreach ($doctrineProviderConfig as $key => $value) {
            if ('enabled' === $key) {
                continue;
            }
            $container->setParameter('hamidou_ie_keycloak_client.oidc.doctrine_user_provider.' . $key, $value);
        }

        // Default doctrine_user_provider client_id to the bundle client_id (needed for token role extraction).
        $configuredProviderClientId = $doctrineProviderConfig['client_id'] ?? null;
        if (!is_string($configuredProviderClientId) || $configuredProviderClientId === '') {
            $container->setParameter('hamidou_ie_keycloak_client.oidc.doctrine_user_provider.client_id', $clientId);
        }

        // Only load Doctrine services if Doctrine ORM is installed and the feature is enabled.
        if ($doctrineProviderEnabled && interface_exists(EntityManagerInterface::class)) {
            $loader->load('services_doctrine.yaml');
        }
    }
}
