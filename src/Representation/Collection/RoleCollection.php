<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation\Collection;

use HamidouIe\KeycloakClientBundle\Representation\RoleRepresentation;

/**
 * @extends Collection<RoleRepresentation>
 */
class RoleCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return RoleRepresentation::class;
    }
}
