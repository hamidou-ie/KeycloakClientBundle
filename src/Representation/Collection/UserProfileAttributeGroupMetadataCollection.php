<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation\Collection;

use HamidouIe\KeycloakClientBundle\Representation\UserProfileAttributeGroupMetadata;

/**
 * @extends Collection<UserProfileAttributeGroupMetadata>
 */
class UserProfileAttributeGroupMetadataCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return UserProfileAttributeGroupMetadata::class;
    }
}
