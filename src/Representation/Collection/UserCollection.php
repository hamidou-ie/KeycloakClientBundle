<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation\Collection;

use Hamikod\KeycloakClientBundle\Representation\UserRepresentation;

/**
 * @extends Collection<UserRepresentation>
 */
class UserCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return UserRepresentation::class;
    }
}
