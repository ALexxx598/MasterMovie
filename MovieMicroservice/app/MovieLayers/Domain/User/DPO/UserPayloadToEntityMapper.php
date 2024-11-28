<?php

namespace App\MovieLayers\Domain\User\DPO;

use App\MovieLayers\Domain\User\User;

class UserPayloadToEntityMapper
{
    /**
     * @param UserCreateDPO $userPayload
     * @return User
     */
    public function mapCreatePayloadToEntity(UserCreateDPO $userPayload): User
    {
        return new User(
            id: null,
            name: $userPayload->getName(),
            surname: $userPayload->getSurname(),
            email: $userPayload->getEmail(),
            password: $userPayload->getPassword(),
        );
    }
}
