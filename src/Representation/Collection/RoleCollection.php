<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation\Collection;

use Hamikod\KeycloakClientBundle\Representation\RoleRepresentation;

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
