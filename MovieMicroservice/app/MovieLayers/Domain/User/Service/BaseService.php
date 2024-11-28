<?php

namespace App\MovieLayers\Domain\User\Service;

use App\MovieLayers\Domain\Role\RoleTypeEnum;
use App\MovieLayers\Domain\Role\Service\RoleServiceInterface;
use App\MovieLayers\Domain\User\DPO\UserPayloadToEntityMapper;
use App\MovieLayers\Domain\User\DPO\UserUpdateDPO;
use App\MovieLayers\Domain\User\Repository\UserRepositoryInterface;
use App\MovieLayers\Domain\User\User;
use BestMovie\Common\EmailTemplateMicroservice\Service\EmailTemplateServiceInterface;

abstract class BaseService implements UserServiceInterface
{
    /**
     * @param UserRepositoryInterface $userRepository
     * @param UserPayloadToEntityMapper $mapper
     * @param RoleServiceInterface $roleService
     * @param EmailTemplateServiceInterface $emailTemplateService
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected UserPayloadToEntityMapper $mapper,
        protected RoleServiceInterface $roleService,
        protected EmailTemplateServiceInterface $emailTemplateService,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function findUser(int $id): User
    {
        return $this->userRepository->findById($id);
    }

    /**
     * @inheritDoc
     */
    public function getUserByEmailAndPassword(string $email, string $password): User
    {
        return $this->userRepository->findByEmailAndPassword($email, $password);
    }

    /**
     * @inheritDoc
     */
    public function hasRole(int $id, RoleTypeEnum $roleType): bool
    {
        return $this->findUser($id)->hasRole($roleType);
    }

    /**
     * @inheritDoc
     */
    public function preRegister(string $email): void
    {
        $this->emailTemplateService->generateCode($email);
    }

    /**
     * @inheritDoc
     */
    public function update(UserUpdateDPO $updatePayload): User
    {
        $user = $this->findUser($updatePayload->getId());

        if (!is_null($updatePayload->getName())) {
            $user->setName($updatePayload->getName());
        }

        if (!is_null($updatePayload->getSurname())) {
            $user->setSurname($updatePayload->getSurname());
        }

        return $user->setId($this->userRepository->save($user));
    }
}