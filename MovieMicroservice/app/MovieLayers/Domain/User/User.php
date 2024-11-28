<?php

namespace App\MovieLayers\Domain\User;

use App\MovieLayers\Domain\Role\Repository\RoleRepositoryFinderTrait;
use App\MovieLayers\Domain\Role\Role;
use App\MovieLayers\Domain\Role\RoleTypeEnum;
use App\MovieLayers\Domain\User\Repository\UserRepositoryFinderTrait;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class User
{
    use UserRepositoryFinderTrait;
    use RoleRepositoryFinderTrait;

    /**
     * @param int|null $id
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $password
     * @param Collection|null $roles
     * @param string|null $accessToken
     * @param Carbon|null $createDate
     */
    public function __construct(
        private ?int $id = null,
        private string $name,
        private string $surname,
        private string $email,
        private string $password,
        private ?Collection $roles = null,
        private ?string $accessToken = null,
        private ?Carbon $createDate = null,
    ) {
    }

    /**
     * @param string|null $accessToken
     * @return $this
     */
    public function setAccessToken(?string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $surname
     * @return $this
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param Carbon|null $createDate
     * @return $this
     */
    public function setCreateDate(?Carbon $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Carbon|null
     */
    public function getCreateDate(): ?Carbon
    {
        return $this->createDate;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * @return Collection|null
     */
    public function getRoles(): ?Collection
    {
        return $this->roles ?? $this->roles = $this->getRoleRepository()->getRolesByUserId($this->getId());
    }

    /**
     * @param RoleTypeEnum $roleType
     * @return bool
     */
    public function hasRole(RoleTypeEnum $roleType): bool
    {
        $roles = $this->getRoles();

        /*** @var Role $role */
        foreach ($roles as $role) {
            if ($roleType->value === ($role->getRole()->value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(RoleTypeEnum::ADMIN);
    }

    /**
     * @return bool
     */
    public function isViewer(): bool
    {
        return $this->hasRole(RoleTypeEnum::VIEWER);
    }

    /**
     * @param Role $role
     */
    public function addRole(Role $role): void
    {
        if (!is_null($this->roles)) {
            $this->roles->add($role);
        } else {
            $this->roles = Collection::make([$role]);
        }
    }
}
