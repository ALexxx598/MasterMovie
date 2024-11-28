<?php

namespace App\MovieLayers\Infrustructure\MovieCollection\Repository;

use App\Models\MovieCollection;
use App\MovieLayers\Domain\Movie\MovieCollection\Repository\MovieCollectionRepositoryInterface;

class MovieCollectionRepository implements MovieCollectionRepositoryInterface
{
    /**
     * @param int $collectionId
     */
    public function deleteByCollectionId(int $collectionId): void
    {
        MovieCollection::query()->where('collection_id', $collectionId)->delete();
    }
}
