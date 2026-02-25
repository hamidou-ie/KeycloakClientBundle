<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation\Collection;

use HamidouIe\KeycloakClientBundle\Representation\ProtocolMapperRepresentation;

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
