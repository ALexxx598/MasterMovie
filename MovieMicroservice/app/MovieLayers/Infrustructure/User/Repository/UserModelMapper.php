<?php

namespace App\MovieLayers\Infrustructure\User\Repository;

use App\Models\User as UserModel;
use App\MovieLayers\Infrustructure\Role\Repository\RoleRepositoryMapper;
use App\MovieLayers\Domain\User\Token\Hash\HashServiceInterface;
use App\MovieLayers\Domain\User\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class UserModelMapper
{
    /**
     * @param HashServiceInterface $hashService
     * @param RoleRepositoryMapper $roleRepositoryMapper
     */
    public function __construct(
        private HashServiceInterface $hashService,
        private RoleRepositoryMapper $roleRepositoryMapper,
    ) {
    }

    /**
     * @param User $user
     * @param UserModel $model
     * @return void
     */
    public function mapEntityToModel(User $user, UserModel $model): void
    {
        $model->name = $user->getName();
        $model->surname = $user->getSurname();
        $model->password = $this->hashService->makeHash($user->getPassword());
        $model->email = $user->getEmail();

        if ($user->getId()) {
            $model->id = $user->getId();
        }
    }

    /**
     * @param UserModel $model
     * @return User
     */
    public function mapModelToEntity(UserModel $model): User
    {
        return new User(
            id: $model->id,
            name: $model->name,
            surname: $model->surname,
            email: $model->email,
            password: $model->password,
            roles: $this->roleRepositoryMapper->mapModelsToEntities($model->roles()->getEager()),
            accessToken: $model->tokens()->get()->first()->token,
            createDate: Carbon::make($model->created_at),
        );
    }
}
