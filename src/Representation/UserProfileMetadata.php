<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation;

use Hamikod\KeycloakClientBundle\Representation\Collection\UserProfileAttributeGroupMetadataCollection;
use Hamikod\KeycloakClientBundle\Representation\Collection\UserProfileAttributeMetadataCollection;

final class UserProfileMetadata extends Representation
{
    public function __construct(
        public ?UserProfileAttributeMetadataCollection $userProfileAttributeMetadata = null,
        public ?UserProfileAttributeGroupMetadataCollection $userProfileAttributeGroupMetadata = null,
    ) {
    }
}
