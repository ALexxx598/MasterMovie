<?php

namespace App\MovieLayers\Domain\Movie\Service;

use App\MovieLayers\Domain\Category\Category;
use App\MovieLayers\Domain\Category\Filter\CategoryFilter;
use App\MovieLayers\Domain\Collection\Collection;
use App\MovieLayers\Domain\Collection\CollectionTypeEnum;
use App\MovieLayers\Domain\Collection\Filter\CollectionFilter;
use App\MovieLayers\Domain\Movie\Exception\InvalidImageUrlException;
use App\MovieLayers\Domain\Movie\Exception\InvalidMovieUrlException;
use App\MovieLayers\Domain\Movie\Movie;
use App\MovieLayers\Domain\Movie\MovieDescription;
use App\MovieLayers\Domain\Movie\DPO\MovieCategoryDPO;
use App\MovieLayers\Domain\Movie\DPO\MovieCollectionDPO;
use App\MovieLayers\Domain\Movie\DPO\MovieCreateDPO;

class MovieService extends BaseMovieService implements MovieServiceInterface
{
    /**
     * @inheritDoc
     */
    public function create(MovieCreateDPO $payload): Movie
    {
        if (!$this->masterMovieStorageService->validatePath($payload->getStorageMovieUrl())) {
            throw new InvalidMovieUrlException();
        }

        if (!$this->masterMovieStorageService->validatePath($payload->getStorageImageUrl())) {
            throw new InvalidImageUrlException();
        };

        $movie = new Movie(
            name: $payload->getName(),
            description: new MovieDescription(
                rating: $payload->getDescriptionRating(),
                slogan: $payload->getDescriptionSlogan(),
                screeningDate: $payload->getDescriptionScreeningDate(),
                country: $payload->getDescriptionCountry(),
                actors: $payload->getDescriptionActors(),
                shortDescription: $payload->getShortDescription()
            ),
            storageMovieUrl: $payload->getStorageMovieUrl(),
            storageImageUrl: $payload->getStorageImageUrl(),
        );

        return $movie->setId($this->movieRepository->save($movie));
    }

    /**
     * @inheritDoc
     */
    public function syncCollections(MovieCollectionDPO $payload): void
    {
        $user = $this->userService->findUser($payload->getUserId());

        $movie = $this->movieRepository->findById($payload->getMovieId());

        $collectionIds = $this
            ->collectionService
            ->list(
                CollectionFilter::make(
                    userId: $user->getId(),
                    type: CollectionTypeEnum::CUSTOM,
                    collectionIds: $payload->getCollectionIds()
                )
            )
            ->map(fn (Collection $collection) => $collection->getId())
            ->toArray();

        $defaultCollectionIds = $this->collectionService
            ->list(
                CollectionFilter::make(
                    movieId: $movie->getId(),
                    withoutUserId: $user->getId(),
                ),
            )
            ->map(fn (Collection $collection): int => $collection->getId())
            ->toArray();

        $collectionIds = array_merge($collectionIds, $defaultCollectionIds);

        $this->movieRepository->syncCollections($movie->getId(), $collectionIds);
    }

    /**
     * @inheritDoc
     */
    public function syncDefaultCollections(MovieCollectionDPO $payload): void
    {
        $movie = $this->movieRepository->findById($payload->getMovieId());

        $collectionIds = $this
            ->collectionService
            ->list(
                CollectionFilter::make(
                    type: CollectionTypeEnum::DEFAULT,
                    collectionIds: $payload->getCollectionIds()
                )
            )
            ->map(fn (Collection $collection) => $collection->getId())
            ->toArray();

        $customCollectionIds = $this->collectionService
            ->list(CollectionFilter::make(movieId: $movie->getId(), type: CollectionTypeEnum::CUSTOM))
            ->map(fn (Collection $collection): int => $collection->getId())
            ->toArray();

        $collectionIds = array_merge($collectionIds, $customCollectionIds);

        $this->movieRepository->syncCollections($movie->getId(), $collectionIds);
    }

    /**
     * @param MovieCategoryDPO $payload
     * @return void
     */
    public function syncCategories(MovieCategoryDPO $payload): void
    {
        $movie = $this->movieRepository->findById($payload->getMovieId());

        $categoryIds = $this
            ->categoryService
            ->list(
                CategoryFilter::make(
                    categoryIds: $payload->getCategoryIds()->toArray()
                )
            )
            ->map(fn (Category $category) => $category->getId())
            ->toArray();

        $this->movieRepository->syncCategories($movie->getId(), $categoryIds);
    }
}
