<?php

namespace App\MovieLayers\Domain\Role;

class Role
{
    /**
     * @param int $id
     * @param int $userId
     * @param RoleTypeEnum $role
     */
    public function __construct(
        private int $id,
        private int $userId,
        private RoleTypeEnum $role
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return RoleTypeEnum
     */
    public function getRole(): RoleTypeEnum
    {
        return $this->role;
    }
}
