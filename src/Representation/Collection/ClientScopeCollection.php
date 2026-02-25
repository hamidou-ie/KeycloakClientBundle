<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation\Collection;

use HamidouIe\KeycloakClientBundle\Representation\ClientScopeRepresentation;

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
