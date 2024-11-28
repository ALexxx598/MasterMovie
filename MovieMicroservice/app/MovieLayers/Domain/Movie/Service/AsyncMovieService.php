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
use App\MovieLayers\Domain\User\User;

use function Amp\async;

class AsyncMovieService extends BaseMovieService implements MovieServiceInterface
{
    /**
     * @inheritDoc
     */
    public function create(MovieCreateDPO $payload): Movie
    {
        $movieValidationPromise = async(function () use ($payload) {
            if (!$this->masterMovieStorageService->validatePath($payload->getStorageMovieUrl())) {
                throw new InvalidMovieUrlException();
            }
        });

        $imageValidationPromise = async(function () use ($payload) {
            if (!$this->masterMovieStorageService->validatePath($payload->getStorageImageUrl())) {
                throw new InvalidImageUrlException();
            };
        });

        $createMoviePromise = async(function () use ($payload) {
            return new Movie(
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
        });

        $movieValidationPromise->await();
        $imageValidationPromise->await();

        /** @var Movie $movie **/
        $movie = $createMoviePromise->await();

        return $movie->setId($this->movieRepository->save($movie));
    }

    /**
     * @inheritDoc
     */
    public function syncCollections(MovieCollectionDPO $payload): void
    {
        $userPromise = async(function () use ($payload): User {
            return $this->userService->findUser($payload->getUserId());
        });

        $moviePromise = async(function () use ($payload): Movie {
            return $this->movieRepository->findById($payload->getMovieId());
        });

        /** @var User $user **/
        $user = $userPromise->await();

        /** @var Movie $user **/
        $movie = $moviePromise->await();

        $collectionIdsPromise = async(function () use ($payload, $movie, $user): array {
            return $this
                ->collectionService
                ->list(
                    CollectionFilter::make(
                        userId: $user->getId(),
                        type: CollectionTypeEnum::CUSTOM,
                        collectionIds: $payload->getCollectionIds()
                    )
                )
                ->map(fn(Collection $collection) => $collection->getId())
                ->toArray();
        });

        $defaultCollectionIdsPromise = async(function () use ($payload, $movie, $user): array {
            return $this->collectionService
                ->list(
                    CollectionFilter::make(
                        movieId: $movie->getId(),
                        withoutUserId: $user->getId(),
                    ),
                )
                ->map(fn (Collection $collection): int => $collection->getId())
                ->toArray();
        });

        $collectionIds = $collectionIdsPromise->await();
        $defaultCollectionIds = $defaultCollectionIdsPromise->await();

        $collectionIds = array_merge($collectionIds, $defaultCollectionIds);

        $this->movieRepository->syncCollections($movie->getId(), $collectionIds);
    }

    /**
     * @inheritDoc
     */
    public function syncDefaultCollections(MovieCollectionDPO $payload): void
    {
        $collectionIdsPromise = async(function () use ($payload): array {
            return $this
                ->collectionService
                ->list(
                    CollectionFilter::make(
                        type: CollectionTypeEnum::DEFAULT,
                        collectionIds: $payload->getCollectionIds()
                    )
                )
                ->map(fn (Collection $collection) => $collection->getId())
                ->toArray();
        });

        $moviePromise = async(function () use ($payload, $collectionIdsPromise): Movie {
           return $this->movieRepository->findById($payload->getMovieId());
        });

        /** @var Movie $movie **/
        $movie = $moviePromise->await();

        $customCollectionIdsPromise = async(function () use ($payload, $movie): array {
            return $this->collectionService
                ->list(CollectionFilter::make(movieId: $movie->getId(), type: CollectionTypeEnum::CUSTOM))
                ->map(fn (Collection $collection): int => $collection->getId())
                ->toArray();
        });

        $customCollectionIds = $customCollectionIdsPromise->await();
        $collectionIds = $collectionIdsPromise->await();

        $this->movieRepository->syncCollections($movie->getId(), array_merge($collectionIds, $customCollectionIds));
    }

    /**
     * @inheritDoc
     */
    public function syncCategories(MovieCategoryDPO $payload): void
    {
        $moviePromise = async(function () use ($payload): Movie {
            return $this->movieRepository->findById($payload->getMovieId());
        });

        $categoryIds = $this->categoryService
            ->list(CategoryFilter::make(categoryIds: $payload->getCategoryIds()->toArray()))
            ->map(fn (Category $category) => $category->getId())
            ->toArray();

        /** @var Movie $movie **/
        $movie = $moviePromise->await();

        $this->movieRepository->syncCategories($movie->getId(), $categoryIds);
    }
}
