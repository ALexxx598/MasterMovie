<?php

namespace App\MovieLayers\Domain\Role\Repository;

use App\MovieLayers\Domain\Role\Role;
use App\MovieLayers\Domain\Role\RoleTypeEnum;
use Illuminate\Support\Collection;

interface RoleRepositoryInterface
{
    /**
     * @param int $userId
     * @param RoleTypeEnum $customer
     * @return Role
     */
    public function save(int $userId, RoleTypeEnum $customer): Role;

    /**
     * @param int $userId
     * @return Collection<Role>
     */
    public function getRolesByUserId(int $userId): Collection;
}
