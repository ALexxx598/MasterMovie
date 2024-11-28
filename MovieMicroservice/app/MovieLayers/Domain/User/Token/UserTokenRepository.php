<?php

namespace App\MovieLayers\Domain\User\Token;

use App\Models\PersonalAccessToken;
use App\MovieLayers\Domain\User\Exception\UserNotFoundException;

class UserTokenRepository implements UserTokenRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getUserByToken(string $token): int
    {
        /** * @var PersonalAccessToken $tokenModel */
        $tokenModel = PersonalAccessToken::query()->where('token', $token)->get()->first();

        if (is_null($tokenModel)) {
            throw new UserNotFoundException();
        }

        return $tokenModel->tokenable_id;
    }
}
