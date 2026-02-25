<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation;

use HamidouIe\KeycloakClientBundle\Annotation\Since;
use HamidouIe\KeycloakClientBundle\Representation\Collection\GroupCollection;
use HamidouIe\KeycloakClientBundle\Representation\Type\Map;

final class GroupRepresentation extends Representation
{
    /**
     * @param ?Map<string> $attributes
     * @param ?Map<string> $clientRoles
     * @param ?Map<string> $access
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $path = null,
        #[Since('23.0.0')] public ?string $parentId = null,
        #[Since('23.0.0')] public ?int $subGroupCount = null,
        public ?GroupCollection $subGroups = null,
        public ?Map $attributes = null,
        /** @var string[]|null */
        public ?array $realmRoles = null,
        public ?Map $clientRoles = null,
        public ?Map $access = null,
    ) {
    }
}
