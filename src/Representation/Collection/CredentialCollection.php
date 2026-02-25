<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation\Collection;

use Hamikod\KeycloakClientBundle\Representation\CredentialRepresentation;

/**
 * @extends Collection<CredentialRepresentation>
 */
class CredentialCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return CredentialRepresentation::class;
    }
}
