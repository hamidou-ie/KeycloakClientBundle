<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation\Collection;

use HamidouIe\KeycloakClientBundle\Representation\UPGroup;

/**
 * @extends Collection<UPGroup>
 */
class UPGroupCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return UPGroup::class;
    }
}
