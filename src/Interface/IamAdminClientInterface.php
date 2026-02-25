<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Interface;

use Hamikod\KeycloakClientBundle\Service\ClientsService;
use Hamikod\KeycloakClientBundle\Service\GroupsService;
use Hamikod\KeycloakClientBundle\Service\RealmsService;
use Hamikod\KeycloakClientBundle\Service\RolesService;
use Hamikod\KeycloakClientBundle\Service\UsersService;

interface IamAdminClientInterface
{
    public function getBaseUrl(): string;

    public function getRealm(): string;

    public function getClientId(): string;

    public function realms(): RealmsService;

    public function clients(): ClientsService;

    public function users(): UsersService;

    public function groups(): GroupsService;

    public function roles(): RolesService;
}
