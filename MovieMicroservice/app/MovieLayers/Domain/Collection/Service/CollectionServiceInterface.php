<?php

namespace App\MovieLayers\Domain\Collection\Service;

use App\MovieLayers\Domain\Collection\Collection;
use App\MovieLayers\Domain\Collection\Filter\CollectionFilter;
use App\MovieLayers\Domain\Collection\MovieCollections;
use App\MovieLayers\Domain\Collection\DPO\CollectionCreateDPO;

interface CollectionServiceInterface
{
    /**
     * @param int $id
     * @return Collection
     * @throws \App\MovieLayers\Domain\Collection\Exception\CollectionEntityNotFoundException
     */
    public function findById(int $id): Collection;

    /**
     * @param CollectionCreateDPO $payload
     * @return Collection
     */
    public function create(CollectionCreateDPO $payload): Collection;

    /**
     * @param CollectionFilter $filter
     * @return MovieCollections
     */
    public function list(CollectionFilter $filter): MovieCollections;

    /**
     * @param CollectionFilter $filter
     * @return MovieCollections
     */
    public function listOfDefaults(CollectionFilter $filter): MovieCollections;

    /**
     * @param int $userId
     * @param int $collectionId
     * @throws \App\MovieLayers\Domain\User\Exception\UserNotFoundException
     * @throws \App\MovieLayers\Domain\Collection\Exception\CollectionEntityNotFoundException
     */
    public function deleteWithPermissionCheck(int $userId, int $collectionId): void;

    /**
     * @param int $collectionId
     */
    public function delete(int $collectionId): void;
}
