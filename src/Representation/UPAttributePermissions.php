<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation;

use Hamikod\KeycloakClientBundle\Representation\Type\Map;

final class UPAttributePermissions extends Representation
{
    /**
     * @param ?Map<string> $view
     * @param ?Map<string> $edit
     */
    public function __construct(
        public ?Map $view = null,
        public ?Map $edit = null,
    ) {
    }
}
