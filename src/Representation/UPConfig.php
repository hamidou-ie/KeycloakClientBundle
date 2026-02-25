<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation;

use HamidouIe\KeycloakClientBundle\Representation\Collection\UPAttributeCollection;
use HamidouIe\KeycloakClientBundle\Representation\Collection\UPGroupCollection;

final class UPConfig extends Representation
{
    public function __construct(
        public ?UPAttributeCollection $attributes = null,
        public ?UPGroupCollection $groups = null,
        public ?UnmanagedAttributePolicyEnum $unmanagedAttributePolicy = null,
    ) {
    }
}
