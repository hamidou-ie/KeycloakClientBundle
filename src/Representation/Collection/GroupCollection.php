<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation\Collection;

use Hamikod\KeycloakClientBundle\Representation\GroupRepresentation;

/**
 * @extends Collection<GroupRepresentation>
 */
class GroupCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return GroupRepresentation::class;
    }
}
