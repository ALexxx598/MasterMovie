<?php

namespace App\MovieLayers\Domain\Collection\Filter;

use App\Common\Filter;
use App\MovieLayers\Domain\Collection\CollectionTypeEnum;
use Illuminate\Support\Collection;

class CollectionFilter extends Filter
{
    /**
     * @param int|null $userId
     * @param int|null $movieId
     * @param int|null $withoutUserId
     * @param CollectionTypeEnum|null $type
     * @param Collection|null $types
     * @param Collection<int>|null $collectionIds
     */
    private function __construct(
        private ?int $userId = null,
        private ?int $movieId = null,
        private ?int $withoutUserId = null,
        private ?CollectionTypeEnum $type = null,
        private ?Collection $types = null,
        private ?Collection $collectionIds = null,
    ) {
    }

    /**
     * @param int|null $userId
     * @param int|null $movieId
     * @param int|null $withoutUserId
     * @param CollectionTypeEnum|null $type
     * @param Collection|null $types
     * @param Collection<int>|null $collectionIds
     * @return static
     */
    public static function make(
        ?int $userId = null,
        ?int $movieId = null,
        ?int $withoutUserId = null,
        ?CollectionTypeEnum $type = null,
        ?Collection $types = null,
        ?Collection $collectionIds = null,
    ): self  {
        return new self(
            userId: $userId,
            movieId: $movieId,
            withoutUserId: $withoutUserId,
            type: $type,
            types: $types,
            collectionIds: $collectionIds
        );
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return CollectionTypeEnum|null
     */
    public function getType(): ?CollectionTypeEnum
    {
        return $this->type;
    }

    /**
     * @return Collection<int>|null
     */
    public function getCollectionIds(): ?Collection
    {
        return $this->collectionIds;
    }

    /**
     * @return int|null
     */
    public function getMovieId(): ?int
    {
        return $this->movieId;
    }

    /**
     * @param CollectionTypeEnum|null $type
     * @return self
     */
    public function setType(?CollectionTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getTypes(): ?Collection
    {
        return $this->types;
    }

    /**
     * @return int|null
     */
    public function getWithoutUserId(): ?int
    {
        return $this->withoutUserId;
    }

    /**
     * @return array
     */
    public function getTypesValuesArray(): array
    {
        if (empty($this->getTypes())) {
            return [];
        }

        return $this->getTypes()->map(fn (CollectionTypeEnum $type) => $type->value)->toArray();
    }
}
