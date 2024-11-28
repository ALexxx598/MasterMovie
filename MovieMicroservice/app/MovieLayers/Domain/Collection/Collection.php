<?php

namespace App\MovieLayers\Domain\Collection;

use App\MovieLayers\Domain\User\User;
use Illuminate\Support\Collection as IlluminateCollection;

class Collection
{
    /**
     * @param int|null $id
     * @param int $userId
     * @param CollectionTypeEnum $type
     * @param string $name
     * @param IlluminateCollection|null $movieIds
     */
    public function __construct(
        private ?int $id = null,
        private int $userId,
        private CollectionTypeEnum $type,
        private string $name,
        private ?IlluminateCollection $movieIds = null,
    ) {
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return CollectionTypeEnum
     */
    public function getType(): CollectionTypeEnum
    {
        return $this->type;
    }

    /**
     * @param CollectionTypeEnum $type
     * @return self
     */
    public function setType(CollectionTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return IlluminateCollection|null
     */
    public function getMovieIds(): ?IlluminateCollection
    {
        return $this->movieIds;
    }

    /**
     * @param IlluminateCollection|null $movieIds
     * @return self
     */
    public function setMovieIds(?IlluminateCollection $movieIds = null): self
    {
        $this->movieIds = $movieIds;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->getType()->value === CollectionTypeEnum::DEFAULT->value;
    }

    /**
     * @return bool
     */
    public function isCustom(): bool
    {
        return $this->getType()->value === CollectionTypeEnum::CUSTOM->value;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isBelongToUser(int $id): bool
    {
        return $this->getUserId() === $id;
    }
}
