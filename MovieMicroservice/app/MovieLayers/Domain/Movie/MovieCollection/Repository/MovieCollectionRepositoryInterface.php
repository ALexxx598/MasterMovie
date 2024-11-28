<?php

namespace App\MovieLayers\Domain\Movie\MovieCollection\Repository;

interface MovieCollectionRepositoryInterface
{
    /**
     * @param int $collectionId
     */
    public function deleteByCollectionId(int $collectionId): void;
}
