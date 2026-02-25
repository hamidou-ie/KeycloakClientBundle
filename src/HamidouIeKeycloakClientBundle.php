<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle;

use HamidouIe\KeycloakClientBundle\DependencyInjection\HamidouIeKeycloakClientExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class HamidouIeKeycloakClientBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return dirname(__DIR__);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new HamidouIeKeycloakClientExtension();
    }
}
