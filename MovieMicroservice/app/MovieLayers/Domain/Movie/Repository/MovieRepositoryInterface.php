<?php

namespace App\MovieLayers\Domain\Movie\Repository;

use App\MovieLayers\Domain\Collection\MovieCollections;
use App\MovieLayers\Domain\Movie\Exception\MovieEntityNotFoundException;
use App\MovieLayers\Domain\Movie\Filter\MovieFilter;
use App\MovieLayers\Domain\Movie\Movie;

interface MovieRepositoryInterface
{
    /**
     * @param Movie $movie
     * @return int
     */
    public function save(Movie $movie): int;

    /**
     * @param MovieFilter $filter
     * @return MovieCollections
     * @throws MovieEntityNotFoundException
     */
    public function list(MovieFilter $filter): MovieCollections;

    /**
     * @param int $id
     * @return Movie
     */
    public function findById(int $id): Movie;

    /**
     * @param int $movieId
     * @param int[]|null $collectionIds
     */
    public function syncCollections(int $movieId, ?array $collectionIds): void;

    /**
     * @param int $id
     */
    public function delete(int $id): void;

    /**
     * @param int[] $categoryIds
     */
    public function syncCategories(int $movieId, ?array $categoryIds): void;
}
