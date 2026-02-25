<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation\Collection;

use Hamikod\KeycloakClientBundle\Representation\UserConsentRepresentation;

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
