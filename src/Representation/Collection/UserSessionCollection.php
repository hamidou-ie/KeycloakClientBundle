<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation\Collection;

use HamidouIe\KeycloakClientBundle\Representation\UserSessionRepresentation;

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
