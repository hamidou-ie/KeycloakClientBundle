<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation\Collection;

use HamidouIe\KeycloakClientBundle\Representation\UserConsentRepresentation;

/**
 * @extends Collection<UserConsentRepresentation>
 */
class UserConsentCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return UserConsentRepresentation::class;
    }
}
