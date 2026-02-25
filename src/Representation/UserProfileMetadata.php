<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation;

use HamidouIe\KeycloakClientBundle\Representation\Collection\UserProfileAttributeGroupMetadataCollection;
use HamidouIe\KeycloakClientBundle\Representation\Collection\UserProfileAttributeMetadataCollection;

final class UserProfileMetadata extends Representation
{
    public function __construct(
        public ?UserProfileAttributeMetadataCollection $userProfileAttributeMetadata = null,
        public ?UserProfileAttributeGroupMetadataCollection $userProfileAttributeGroupMetadata = null,
    ) {
    }
}
