<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation\Collection;

use Hamikod\KeycloakClientBundle\Representation\ClientScopeRepresentation;

/**
 * @extends Collection<ClientScopeRepresentation>
 */
class ClientScopeCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return ClientScopeRepresentation::class;
    }
}
