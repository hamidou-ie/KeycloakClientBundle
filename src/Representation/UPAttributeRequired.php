<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation;

use Hamikod\KeycloakClientBundle\Representation\Type\Map;

final class UPAttributeRequired extends Representation
{
    /**
     * @param ?Map<string> $roles
     * @param ?Map<string> $scopes
     */
    public function __construct(
        public ?Map $roles = null,
        public ?Map $scopes = null,
    ) {
    }
}
