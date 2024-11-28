<?php

namespace App\MovieLayers\Domain\User\Service;

use App\MovieLayers\Domain\User\DPO\UserCreateDPO;
use App\MovieLayers\Domain\User\User;

use function Amp\async;

class AsyncUserService extends BaseService implements UserServiceInterface
{
    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function create(UserCreateDPO $userPayload): User
    {
        $emailTemplateMSCheck = async(function () use ($userPayload) {
            if ($this->emailTemplateService->getCode($userPayload->getEmail())->getCode()
                !== $userPayload->getEmailConfirmationCode()
            ) {
                throw new \Exception('Code not found.');
            }
        });

        $user = $this->mapper->mapCreatePayloadToEntity($userPayload);
        $emailTemplateMSCheck->await();

        $user->setId($this->userRepository->save($user));

        $user->addRole($this->roleService->addViewerRole($user->getId()));

        return $user;
    }
}