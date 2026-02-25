<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Representation;

enum UnmanagedAttributePolicyEnum: string
{
    case ENABLED = 'ENABLED';
    case ADMIN_VIEW = 'ADMIN_VIEW';
    case ADMIN_EDIT = 'ADMIN_EDIT';
}
