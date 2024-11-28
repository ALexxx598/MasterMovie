<?php

namespace App\MovieLayers\Infrustructure\Role\Repository;

use App\Models\Role as RoleModel;
use App\MovieLayers\Domain\Role\Role;
use App\MovieLayers\Domain\Role\RoleTypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as IlluminateCollection;

class RoleRepositoryMapper
{
    /**
     * @param Collection<RoleModel> $rolesCollection
     * @return Collection<Role>
     */
    public function mapModelsToEntities(Collection $rolesCollection): IlluminateCollection
    {
        return $rolesCollection->map(function (RoleModel $role) {
            return $this->mapModelToEntity($role);
        });
    }

    /**
     * @param RoleModel $model
     * @return Role
     */
    public function mapModelToEntity(RoleModel $model): Role
    {
        return new Role(
            id: $model->id,
            userId: $model->user_id,
            role: RoleTypeEnum::from($model->role)
        );
    }
}
