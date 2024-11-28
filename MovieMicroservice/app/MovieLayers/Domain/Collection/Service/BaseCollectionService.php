<?php

namespace App\MovieLayers\Domain\Collection\Service;

use App\MovieLayers\Domain\Collection\Collection;
use App\MovieLayers\Domain\Collection\CollectionTypeEnum;
use App\MovieLayers\Domain\Collection\Filter\CollectionFilter;
use App\MovieLayers\Domain\Collection\MovieCollections;
use App\MovieLayers\Domain\Collection\Repository\CollectionRepositoryInterface;
use App\MovieLayers\Domain\Movie\MovieCollection\Repository\MovieCollectionRepositoryInterface;
use App\MovieLayers\Domain\User\Service\UserServiceInterface;

abstract class BaseCollectionService implements CollectionServiceInterface
{
    /**
     * @param UserServiceInterface $userService
     * @param CollectionRepositoryInterface $collectionRepository
     * @param MovieCollectionRepositoryInterface $movieCollectionRepository
     */
    public function __construct(
        protected UserServiceInterface $userService,
        protected CollectionRepositoryInterface $collectionRepository,
        protected MovieCollectionRepositoryInterface $movieCollectionRepository,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): Collection
    {
        return $this->collectionRepository->findById($id);
    }

    /**
     * @param CollectionFilter $filter
     * @return MovieCollections
     */
    public function list(CollectionFilter $filter): MovieCollections
    {
        return $this->collectionRepository->list($filter);
    }

    /**
     * @param CollectionFilter $filter
     * @return MovieCollections
     */
    public function listOfDefaults(CollectionFilter $filter): MovieCollections
    {
        $filter->setType(CollectionTypeEnum::DEFAULT);

        return $this->collectionRepository->list($filter);
    }
    /**
     * @inheritDoc
     */
    public function delete(int $collectionId): void
    {
        $this->movieCollectionRepository->deleteByCollectionId($collectionId);
        $this->collectionRepository->delete($collectionId);
    }
}
