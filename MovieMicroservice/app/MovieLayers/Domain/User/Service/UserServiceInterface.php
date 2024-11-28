<?php

namespace App\MovieLayers\Domain\User\Service;

use App\MovieLayers\Domain\Role\RoleTypeEnum;
use App\MovieLayers\Domain\User\Exception\NonValidPasswordException;
use App\MovieLayers\Domain\User\Exception\UserNotFoundException;
use App\MovieLayers\Domain\User\DPO\UserCreateDPO;
use App\MovieLayers\Domain\User\DPO\UserUpdateDPO;
use App\MovieLayers\Domain\User\User;
use GuzzleHttp\Exception\GuzzleException;

interface UserServiceInterface
{
    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findUser(int $id): User;

    /**
     * @param UserCreateDPO $userPayload
     * @return User
     * @throws GuzzleException
     */
    public function create(UserCreateDPO $userPayload): User;

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws NonValidPasswordException
     * @throws UserNotFoundException
     */
    public function getUserByEmailAndPassword(string $email, string $password): User;

    /**
     * @param int $id
     * @param RoleTypeEnum $roleType
     * @return bool
     * @throws UserNotFoundException
     */
    public function hasRole(int $id, RoleTypeEnum $roleType): bool;

    /**
     * @param UserUpdateDPO $updatePayload
     * @return User
     * @throws UserNotFoundException
     */
    public function update(UserUpdateDPO $updatePayload): User;

    /**
     * @param string $email
     * @return void
     * @throws GuzzleException
     */
    public function preRegister(string $email): void;
}
