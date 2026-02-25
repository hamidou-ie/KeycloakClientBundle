<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation\Collection;

use Hamikod\KeycloakClientBundle\Representation\UserProfileAttributeGroupMetadata;

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
