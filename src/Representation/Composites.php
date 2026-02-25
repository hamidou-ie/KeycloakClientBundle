<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation;

use Hamikod\KeycloakClientBundle\Representation\Collection\RealmCollection;
use Hamikod\KeycloakClientBundle\Representation\Type\Map;

final class Composites extends Representation
{
    /**
     * @param ?Map<string> $client
     * @param ?Map<string> $application
     */
    public function __construct(
        public ?RealmCollection $realm = null,
        public ?Map $client = null,
        public ?Map $application = null,
    ) {
    }
}
