<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation\Collection;

use HamidouIe\KeycloakClientBundle\Representation\ClientRepresentation;

/**
 * @extends Collection<ClientRepresentation>
 */
class ClientCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return ClientRepresentation::class;
    }
}
