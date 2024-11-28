<?php

namespace App\MovieLayers\Infrustructure\Storage;

interface CachedStorageServiceInterface
{
    /**
     * @param int $movieId
     * @param string $path
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function validatePath(int $movieId, string $path): bool;

    /**
     * @param int $movieId
     * @param string $path
     * @return string|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPath(int $movieId, string $path): ?string;
}
