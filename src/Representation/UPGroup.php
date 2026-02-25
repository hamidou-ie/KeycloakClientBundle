<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation;

use HamidouIe\KeycloakClientBundle\Representation\Type\Map;

final class UPGroup extends Representation
{
    /**
     * @param ?Map<string> $annotations
     */
    public function __construct(
        public ?string $name = null,
        public ?string $displayHeader = null,
        public ?string $displayDescription = null,
        public ?Map $annotations = null,
    ) {
    }
}
