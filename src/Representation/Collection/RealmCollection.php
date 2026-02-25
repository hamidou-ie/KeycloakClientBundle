<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation\Collection;

use Hamikod\KeycloakClientBundle\Representation\RealmRepresentation;

/**
 * @extends Collection<RealmRepresentation>
 */
class RealmCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return RealmRepresentation::class;
    }
}
