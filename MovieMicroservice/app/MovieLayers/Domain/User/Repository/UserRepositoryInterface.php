<?php

namespace App\MovieLayers\Domain\User\Repository;

use App\Models\User as UserModel;
use App\MovieLayers\Domain\User\Exception\UserNotFoundException;
use App\MovieLayers\Domain\User\User;

interface UserRepositoryInterface
{
    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findById(int $id): User;

    /**
     * @param string $email
     * @param string $password
     * @return User
     */
    public function findByEmailAndPassword(string $email, string $password): User;

    /**
     * @param User $user
     * @return int
     */
    public function save(User $user): int;

    /**
     * @param int $id
     * @return UserModel
     * @throws UserNotFoundException
     */
    public function getUserModel(int $id): UserModel;
}
