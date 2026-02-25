<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation;

use Hamikod\KeycloakClientBundle\Representation\Type\Map;

final class UserProfileAttributeGroupMetadata extends Representation
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
