<?php

namespace App\Providers;

use App\Common\ProcessHandleTypeEnum;
use App\MovieLayers\Domain\Category\Repository\CategoryRepositoryInterface;
use App\MovieLayers\Domain\Collection\Repository\CollectionRepositoryInterface;
use App\MovieLayers\Domain\Movie\Movie;
use App\MovieLayers\Domain\Movie\Repository\MovieRepositoryInterface;
use App\MovieLayers\Domain\Movie\Service\AsyncMovieService;
use App\MovieLayers\Infrustructure\Movie\Repository\MovieRepository;
use App\MovieLayers\Domain\Movie\Service\MovieService;
use App\MovieLayers\Domain\Movie\Service\MovieServiceInterface;
use App\MovieLayers\Infrustructure\Storage\CachedStorageServiceInterface;
use App\MovieLayers\Infrustructure\Storage\CachedStorageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class MovieServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->registerMovieService();

        $this->registerRepository();

        $this->registerBestMovieCachedStorageServiceInterface();
    }

    /**
     * @inheritDoc
     */
    public function boot()
    {
        Movie::setCategoryRepositoryResolver(function (): CategoryRepositoryInterface {
            return $this->app[CategoryRepositoryInterface::class];
        });

        Movie::setCollectionRepositoryResolver(function (): CollectionRepositoryInterface {
            return $this->app[CollectionRepositoryInterface::class];
        });

        Movie::setMasterMovieCachedStorageServiceResolver(function (): CachedStorageServiceInterface {
            return $this->app[CachedStorageServiceInterface::class];
        });
    }

    /**
     * @param ProcessHandleTypeEnum|null $handleType
     * @return void
     */
    public static function registerMovieService(?ProcessHandleTypeEnum $handleType = ProcessHandleTypeEnum::SYNC): void
    {
        match ($handleType->value) {
            ProcessHandleTypeEnum::ASYNC_AMPHP->value
            => APP::singleton(
                MovieServiceInterface::class,
                AsyncMovieService::class
            ),
            default => APP::singleton(
                MovieServiceInterface::class,
                MovieService::class
            ),
        };
    }

    /**
     * @return void
     */
    public static function registerRepository()
    {
        App::singleton(MovieRepositoryInterface::class, MovieRepository::class);
    }

    /**
     * @return void
     */
    public static function registerBestMovieCachedStorageServiceInterface(): void
    {
        App::singleton(
            CachedStorageServiceInterface::class,
            CachedStorageService::class
        );
    }
}
