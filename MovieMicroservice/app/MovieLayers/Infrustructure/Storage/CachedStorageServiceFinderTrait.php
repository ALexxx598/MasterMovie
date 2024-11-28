<?php

namespace App\MovieLayers\Infrustructure\Storage;

use Closure;

trait CachedStorageServiceFinderTrait
{
    /**
     * @var Closure|null
     */
    private static ?Closure $masterMovieCachedStorageServiceResolver = null;

    /**
     * @var CachedStorageServiceInterface|null
     */
    private static ?CachedStorageServiceInterface $masterMovieCachedStorageService = null;

    /**
     * @param Closure|null $collectionResolver
     */
    public static function setMasterMovieCachedStorageServiceResolver(?Closure $cachedStorageServiceResolver = null): void
    {
        self::$masterMovieCachedStorageService = null;

        self::$masterMovieCachedStorageServiceResolver = $cachedStorageServiceResolver;
    }

    /**
     * @return CachedStorageServiceInterface
     */
    public static function getMasterMovieCachedStorageService(): CachedStorageServiceInterface
    {
        return self::$masterMovieCachedStorageService
            ?? self::$masterMovieCachedStorageService = call_user_func(self::$masterMovieCachedStorageServiceResolver);
    }
}
