<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation;

use HamidouIe\KeycloakClientBundle\Representation\Collection\RealmCollection;
use HamidouIe\KeycloakClientBundle\Representation\Type\Map;

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
