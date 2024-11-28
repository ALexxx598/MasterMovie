<?php

namespace App\Http\Resource\Category;

use App\Common\MovieMicroserviceResource;
use App\MovieLayers\Domain\Category\Category;

/**
 * @mixin Category
 */
class CategoryResource extends MovieMicroserviceResource
{
    /**
     * @inheritDoc
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'movie_ids' => $this->getMovieIds()?->toArray(),
        ];
    }
}
