<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation\Collection;

use Hamikod\KeycloakClientBundle\Representation\UPAttribute;

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
