<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation\Collection;

use HamidouIe\KeycloakClientBundle\Representation\UserRepresentation;

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
