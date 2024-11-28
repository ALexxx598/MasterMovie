<?php

namespace App\MovieLayers\Domain\Movie\Service;

use App\MovieLayers\Domain\Collection\MovieCollections;
use App\MovieLayers\Domain\Movie\Exception\InvalidImageUrlException;
use App\MovieLayers\Domain\Movie\Exception\InvalidMovieUrlException;
use App\MovieLayers\Domain\Movie\Filter\MovieFilter;
use App\MovieLayers\Domain\Movie\Movie;
use App\MovieLayers\Domain\Movie\DPO\MovieCategoryDPO;
use App\MovieLayers\Domain\Movie\DPO\MovieCollectionDPO;
use App\MovieLayers\Domain\Movie\DPO\MovieCreateDPO;

interface MovieServiceInterface
{
    /**
     * @param MovieCreateDPO $payload
     * @return Movie
     *@throws InvalidImageUrlException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws InvalidMovieUrlException
     */
    public function create(MovieCreateDPO $payload): Movie;

    /**
     * @param MovieFilter $filter
     * @return MovieCollections
     */
    public function list(MovieFilter $filter): MovieCollections;

    /**
     * @param int $id
     * @return Movie
     */
    public function findById(int $id): Movie;

    /**
     * @param MovieCollectionDPO $payload
     * @throws \App\MovieLayers\Domain\User\Exception\UserNotFoundException
     */
    public function syncCollections(MovieCollectionDPO $payload): void;

    /**
     * @param MovieCollectionDPO $payload
     */
    public function syncDefaultCollections(MovieCollectionDPO $payload): void;

    /**
     * @param int $getId
     */
    public function delete(int $id): void;

    /**
     * @param MovieCategoryDPO $payload
     */
    public function syncCategories(MovieCategoryDPO $payload): void;
}
