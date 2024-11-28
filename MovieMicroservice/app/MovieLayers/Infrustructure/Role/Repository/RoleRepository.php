<?php

namespace App\MovieLayers\Infrustructure\Role\Repository;

use App\MovieLayers\Domain\Role\Repository\RoleRepositoryInterface;
use App\MovieLayers\Domain\Role\Role;
use App\Models\Role as RoleModel;
use App\MovieLayers\Domain\Role\RoleTypeEnum;
use Illuminate\Support\Collection;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * @param RoleRepositoryMapper $roleRepositoryMapper
     */
    public function __construct(
      private RoleRepositoryMapper $roleRepositoryMapper
    ) {
    }

    /**
     * @param int $userId
     * @return Collection<Role>
     */
    public function getRolesByUserId(int $userId): Collection
    {
        $query = RoleModel::query();
        $query->where('user_id', $userId);

        return $this->roleRepositoryMapper->mapModelsToEntities($query->get());
    }

    /**
     * @param int $userId
     * @param RoleTypeEnum $role
     * @return Role
     */
    public function save(int $userId, RoleTypeEnum $role): Role
    {
        $model = new RoleModel();

        $model->user_id = $userId;
        $model->role = $role->value;
        $model->exists = false;

        $model->save();

        return $this->roleRepositoryMapper->mapModelToEntity($model);
    }
}
