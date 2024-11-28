<?php

namespace App\Http\Resource\Collection;

use App\Common\MovieMicroserviceResource;
use App\MovieLayers\Domain\Collection\Collection;

/**
 * @mixin Collection
 */
class CollectionResource extends MovieMicroserviceResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->getId(),
            'user_id' => $this->getUserId(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'movie_ids' => $this->getMovieIds()?->toArray(),
        ];
    }
}
