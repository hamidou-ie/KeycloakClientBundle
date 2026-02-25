<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation\Collection;

use Hamikod\KeycloakClientBundle\Representation\UserProfileAttributeMetadata;

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
