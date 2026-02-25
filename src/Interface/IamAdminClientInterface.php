<?php

declare(strict_types=1);

namespace HamidouIe\KeycloakClientBundle\Interface;

use HamidouIe\KeycloakClientBundle\Service\ClientsService;
use HamidouIe\KeycloakClientBundle\Service\GroupsService;
use HamidouIe\KeycloakClientBundle\Service\RealmsService;
use HamidouIe\KeycloakClientBundle\Service\RolesService;
use HamidouIe\KeycloakClientBundle\Service\UsersService;

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
