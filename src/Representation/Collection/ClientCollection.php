<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation\Collection;

use Hamikod\KeycloakClientBundle\Representation\ClientRepresentation;

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
