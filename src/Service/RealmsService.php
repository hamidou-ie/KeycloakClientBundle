<?php

declare(strict_types=1);

namespace Hamikod\KeycloakClientBundle\Service;

use Hamikod\KeycloakClientBundle\Representation\Collection\RealmCollection;
use Hamikod\KeycloakClientBundle\Representation\RealmRepresentation;

final class RealmsService extends Service
{
    /**
     * @return RealmCollection<RealmRepresentation>|null
     */
    public function all(?Criteria $criteria = null): ?RealmCollection
    {
        return $this->executeQuery('admin/realms', RealmCollection::class, $criteria);
    }

    public function get(string $realm): ?RealmRepresentation
    {
        return $this->executeQuery('admin/realms/'.$realm, RealmRepresentation::class);
    }

    public function create(RealmRepresentation $realm): bool
    {
        return $this->executeCommand(HttpMethodEnum::POST, 'admin/realms/', $realm);
    }

    public function update(string $realm, RealmRepresentation $realmUpdate): bool
    {
        return $this->executeCommand(HttpMethodEnum::PUT, 'admin/realms/'.$realm, $realmUpdate);
    }

    public function delete(string $realm): bool
    {
        return $this->executeCommand(HttpMethodEnum::DELETE, 'admin/realms/'.$realm);
    }
}
