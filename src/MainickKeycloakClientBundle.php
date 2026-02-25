<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle;

use Hamikod\KeycloakClientBundle\DependencyInjection\HamikodKeycloakClientExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class HamikodKeycloakClientBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return dirname(__DIR__);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new HamikodKeycloakClientExtension();
    }
}
