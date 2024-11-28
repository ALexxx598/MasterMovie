<?php

namespace App\MovieLayers\Domain\User\Token;

use App\MovieLayers\Domain\User\Service\UserServiceInterface;
use App\MovieLayers\Domain\User\User;

class UserTokenService implements UserTokenServiceInterface
{
    public function __construct(
        private UserTokenRepositoryInterface $tokenRepository,
        private UserServiceInterface $userService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getUserByToken(string $token): User
    {
        return $this->userService->findUser($this->tokenRepository->getUserByToken($token));
    }
}
