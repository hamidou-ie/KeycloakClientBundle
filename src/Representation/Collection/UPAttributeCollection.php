<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation\Collection;

use HamidouIe\KeycloakClientBundle\Representation\UPAttribute;

/**
 * @extends Collection<UPAttribute>
 */
class UPAttributeCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return UPAttribute::class;
    }
}
