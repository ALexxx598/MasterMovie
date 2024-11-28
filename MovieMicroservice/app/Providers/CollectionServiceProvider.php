<?php

namespace App\Providers;

use App\Common\ProcessHandleTypeEnum;
use App\MovieLayers\Domain\Collection\Repository\CollectionRepositoryInterface;
use App\MovieLayers\Domain\Collection\Service\AsyncCollectionService;
use App\MovieLayers\Domain\Collection\Service\CollectionService;
use App\MovieLayers\Domain\Collection\Service\CollectionServiceInterface;
use App\MovieLayers\Domain\Movie\MovieCollection\Repository\MovieCollectionRepositoryInterface;
use App\MovieLayers\Infrustructure\Collection\Repository\CollectionRepository;
use App\MovieLayers\Infrustructure\MovieCollection\Repository\MovieCollectionRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CollectionServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->registerCollectionService();

        $this->registerCollectionRepository();

        $this->registerMovieCollectionRepository();
    }

    public static function registerCollectionService(?ProcessHandleTypeEnum $handleType = ProcessHandleTypeEnum::SYNC): void
    {
        match ($handleType->value) {
            ProcessHandleTypeEnum::ASYNC_AMPHP->value
                => APP::singleton(
                    CollectionServiceInterface::class,
                    AsyncCollectionService::class
            ),
            default => APP::singleton(
                CollectionServiceInterface::class,
                CollectionService::class
            ),
        };
    }

    public static function registerCollectionRepository(): void
    {
        APP::singleton(CollectionRepositoryInterface::class, CollectionRepository::class);
    }

    public static function registerMovieCollectionRepository(): void
    {
        APP::singleton(MovieCollectionRepositoryInterface::class, MovieCollectionRepository::class);
    }
}
