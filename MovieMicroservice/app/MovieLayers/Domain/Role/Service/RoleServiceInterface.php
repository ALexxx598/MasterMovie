<?php

namespace App\MovieLayers\Domain\Role\Service;

use App\MovieLayers\Domain\Role\Role;

interface RoleServiceInterface
{
    /**
     * @param int $userId
     * @return Role
     */
    public function addAdminRole(int $userId): Role;

    /**
     * @param int $userId
     * @return Role
     */
    public function addViewerRole(int $userId): Role;
}
