<?php

namespace App\MovieLayers\Domain\Collection\Repository;

use App\MovieLayers\Domain\Collection\Collection;
use App\MovieLayers\Domain\Collection\Exception\CollectionEntityNotFoundException;
use App\MovieLayers\Domain\Collection\Filter\CollectionFilter;
use App\MovieLayers\Domain\Collection\MovieCollections;

interface CollectionRepositoryInterface
{
    /**
     * @param Collection $collection
     * @return int
     */
    public function save(Collection $collection): int;

    /**
     * @param CollectionFilter $filter
     * @return MovieCollections
     */
    public function list(CollectionFilter $filter): MovieCollections;

    /**
     * @param int $id
     * @return Collection
     * @throws CollectionEntityNotFoundException
     */
    public function findById(int $id): Collection;

    /**
     * @param int $id
     */
    public function delete(int $id): void;
}
