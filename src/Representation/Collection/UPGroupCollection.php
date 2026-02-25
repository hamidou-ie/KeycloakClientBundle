<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation\Collection;

use Hamikod\KeycloakClientBundle\Representation\UPGroup;

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
