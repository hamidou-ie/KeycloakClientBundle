<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Annotation;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY)]
final readonly class Until
{
    public function __construct(
        public string $version,
    ) {
    }
}
