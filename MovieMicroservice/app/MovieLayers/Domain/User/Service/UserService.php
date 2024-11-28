<?php

namespace App\MovieLayers\Domain\User\Service;

use App\MovieLayers\Domain\User\DPO\UserCreateDPO;
use App\MovieLayers\Domain\User\User;

class UserService extends BaseService implements UserServiceInterface
{
    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function create(UserCreateDPO $userPayload): User
    {
        if ($this->emailTemplateService->getCode($userPayload->getEmail())->getCode()
            !== $userPayload->getEmailConfirmationCode()
        ) {
            throw new \Exception('Code not found.');
        }

        $user = $this->mapper->mapCreatePayloadToEntity($userPayload);

        $user->setId($this->userRepository->save($user));

        $user->addRole($this->roleService->addViewerRole($user->getId()));

        return $user;
    }
}
