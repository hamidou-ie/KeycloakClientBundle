<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation\Collection;

use HamidouIe\KeycloakClientBundle\Representation\CredentialRepresentation;

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
