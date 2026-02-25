<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation\Collection;

use HamidouIe\KeycloakClientBundle\Representation\RealmRepresentation;

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
