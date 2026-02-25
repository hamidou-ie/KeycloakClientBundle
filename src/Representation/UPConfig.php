<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation;

use Hamikod\KeycloakClientBundle\Representation\Collection\UPAttributeCollection;
use Hamikod\KeycloakClientBundle\Representation\Collection\UPGroupCollection;

final class UPConfig extends Representation
{
    public function __construct(
        public ?UPAttributeCollection $attributes = null,
        public ?UPGroupCollection $groups = null,
        public ?UnmanagedAttributePolicyEnum $unmanagedAttributePolicy = null,
    ) {
    }
}
