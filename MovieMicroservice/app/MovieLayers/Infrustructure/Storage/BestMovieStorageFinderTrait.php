<?php

namespace App\MovieLayers\Infrustructure\Storage;

use BestMovie\Common\BestMovieStorage\Service\BestMovieStorageServiceInterface;
use Closure;

trait BestMovieStorageFinderTrait
{
    /**
     * @var Closure|null
     */
    private static ?Closure $masterMovieStorageServiceResolver = null;

    /**
     * @var BestMovieStorageServiceInterface|null
     */
    private static ?BestMovieStorageServiceInterface $masterMovieStorageService = null;

    /**
     * @param Closure|null $collectionResolver
     */
    public static function setMasterMovieStorageServiceResolver(?Closure $collectionResolver = null): void
    {
        self::$masterMovieStorageService = null;

        self::$masterMovieStorageServiceResolver = $collectionResolver;
    }

    /**
     * @return BestMovieStorageServiceInterface
     */
    public static function getMasterMovieStorageService(): BestMovieStorageServiceInterface
    {
        return self::$masterMovieStorageService
            ?? self::$masterMovieStorageService = call_user_func(self::$masterMovieStorageServiceResolver);
    }
}
