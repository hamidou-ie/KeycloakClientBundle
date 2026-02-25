<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation;

use Hamikod\KeycloakClientBundle\Representation\Type\Map;

final class UserProfileAttributeMetadata extends Representation
{
    /**
     * @param ?Map<string> $annotations
     * @param ?Map<string> $validators
     */
    public function __construct(
        public ?string $name = null,
        public ?string $displayName = null,
        public ?bool $required = null,
        public ?bool $readOnly = null,
        public ?Map $annotations = null,
        public ?Map $validators = null,
        public ?string $group = null,
        public ?bool $multivalued = null,
    ) {
    }
}
