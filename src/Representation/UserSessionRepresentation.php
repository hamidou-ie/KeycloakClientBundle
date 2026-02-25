<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation;

use HamidouIe\KeycloakClientBundle\Representation\Type\Map;

final class UserSessionRepresentation extends Representation
{
    /**
     * @param ?Map<string> $clients
     */
    public function __construct(
        public ?string $id = null,
        public ?string $username = null,
        public ?string $userId = null,
        public ?string $ipAddress = null,
        public ?int $start = null,
        public ?int $lastAccess = null,
        public ?bool $rememberMe = null,
        public ?Map $clients = null,
        public ?bool $transientUser = null,
    ) {
    }
}
