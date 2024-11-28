<?php

namespace App\MovieLayers\Domain\Role\Service;

use App\MovieLayers\Domain\Role\Repository\RoleRepositoryInterface;
use App\MovieLayers\Domain\Role\Role;
use App\MovieLayers\Domain\Role\RoleTypeEnum;

class RoleService implements RoleServiceInterface
{
    /**
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(
        private RoleRepositoryInterface $roleRepository
    ) {
    }

    /**
     * @param int $userId
     * @return Role
     */
    public function addAdminRole(int $userId): Role
    {
        return $this->roleRepository->save($userId, RoleTypeEnum::ADMIN);
    }

    /**
     * @param int $userId
     * @return Role
     */
    public function addViewerRole(int $userId): Role
    {
        return $this->roleRepository->save($userId, RoleTypeEnum::VIEWER);
    }
}
