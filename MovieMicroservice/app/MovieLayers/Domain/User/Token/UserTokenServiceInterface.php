<?php

namespace App\MovieLayers\Domain\User\Token;

use App\MovieLayers\Domain\User\Exception\UserNotFoundException;
use App\MovieLayers\Domain\User\User;

interface UserTokenServiceInterface
{
    /**
     * @param string $token
     * @return User
     * @throws UserNotFoundException
     */
    public function getUserByToken(string $token): User;
}
