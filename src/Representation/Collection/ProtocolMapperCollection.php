<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation\Collection;

use Hamikod\KeycloakClientBundle\Representation\ProtocolMapperRepresentation;

/**
 * @extends Collection<ProtocolMapperRepresentation>
 */
class ProtocolMapperCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return ProtocolMapperRepresentation::class;
    }
}
