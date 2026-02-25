<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Representation\Collection;

use HamidouIe\KeycloakClientBundle\Representation\UserProfileAttributeMetadata;

/**
 * @extends Collection<UserProfileAttributeMetadata>
 */
class UserProfileAttributeMetadataCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return UserProfileAttributeMetadata::class;
    }
}
