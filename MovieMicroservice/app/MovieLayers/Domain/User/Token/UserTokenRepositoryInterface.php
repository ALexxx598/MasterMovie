<?php

namespace App\MovieLayers\Domain\User\Token;

use App\MovieLayers\Domain\User\Exception\UserNotFoundException;

interface UserTokenRepositoryInterface
{
    /**
     * @param string $token
     * @return int
     * @throws UserNotFoundException
     */
    public function getUserByToken(string $token): int;
}
