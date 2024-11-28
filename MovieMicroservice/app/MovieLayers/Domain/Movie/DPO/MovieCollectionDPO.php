<?php

namespace App\MovieLayers\Domain\Movie\DPO;

use Illuminate\Support\Collection;

class MovieCollectionDPO
{
    /**
     * @param int $userId
     * @param int $movieId
     * @param Collection<int> $collectionIds
     */
    private function __construct(
        private int $userId,
        private int $movieId,
        private Collection $collectionIds,
    ) {
    }

    /**
     * @param int $userId
     * @param int $movieId
     * @param Collection<int> $collectionIds
     * @return static
     */
    public static function make(
        int $userId,
        int $movieId,
        Collection $collectionIds,
    ): self {
        return new self(
            userId: $userId,
            movieId: $movieId,
            collectionIds: $collectionIds
        );
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /**
     * @return Collection
     */
    public function getCollectionIds(): Collection
    {
        return $this->collectionIds;
    }
}
