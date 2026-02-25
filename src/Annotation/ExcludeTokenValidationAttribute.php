<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Annotation;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
final class ExcludeTokenValidationAttribute
{
}
