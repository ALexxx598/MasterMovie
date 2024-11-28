<?php

namespace App\MovieLayers\Domain\Movie\Service;

use App\MovieLayers\Domain\Category\Service\CategoryServiceInterface;
use App\MovieLayers\Domain\Collection\MovieCollections;
use App\MovieLayers\Domain\Collection\Service\CollectionServiceInterface;
use App\MovieLayers\Domain\Movie\Filter\MovieFilter;
use App\MovieLayers\Domain\Movie\Movie;
use App\MovieLayers\Domain\Movie\Repository\MovieRepositoryInterface;
use App\MovieLayers\Domain\User\Service\UserServiceInterface;
use BestMovie\Common\BestMovieStorage\Service\BestMovieStorageServiceInterface;

abstract class BaseMovieService implements MovieServiceInterface
{
    /**
     * @param MovieRepositoryInterface $movieRepository
     * @param UserServiceInterface $userService
     * @param CollectionServiceInterface $collectionService
     * @param CategoryServiceInterface $categoryService
     * @param BestMovieStorageServiceInterface $masterMovieStorageService
     */
    public function __construct(
        protected MovieRepositoryInterface $movieRepository,
        protected UserServiceInterface $userService,
        protected CollectionServiceInterface $collectionService,
        protected CategoryServiceInterface $categoryService,
        protected BestMovieStorageServiceInterface $masterMovieStorageService,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): Movie
    {
        return $this->movieRepository->findById($id);
    }

    /**
     * @inheritDoc
     */
    public function list(MovieFilter $filter): MovieCollections
    {
        return $this->movieRepository->list($filter);
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->movieRepository->delete($id);
    }
}