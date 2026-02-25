<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation;

use HamidouIe\KeycloakClientBundle\Representation\Collection\ProtocolMapperCollection;
use HamidouIe\KeycloakClientBundle\Representation\Type\Map;

final class ClientScopeRepresentation extends Representation
{
    /**
     * @param ?Map<string> $attributes
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $description = null,
        public ?string $protocol = null,
        public ?Map $attributes = null,
        public ?ProtocolMapperCollection $protocolMappers = null,
    ) {
    }
}
