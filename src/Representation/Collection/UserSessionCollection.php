<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation\Collection;

use Hamikod\KeycloakClientBundle\Representation\UserSessionRepresentation;

/**
 * @extends Collection<UserSessionRepresentation>
 */
class UserSessionCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return UserSessionRepresentation::class;
    }
}
