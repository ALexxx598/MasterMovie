<?php

namespace App\Http\Resource\Movie;

use App\Common\MovieMicroserviceResource;
use App\Http\Resource\Category\CategoryResource;
use App\MovieLayers\Domain\Category\Category;
use App\MovieLayers\Domain\Movie\Movie;

/**
 * @mixin Movie
 */
class MovieResource extends MovieMicroserviceResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => [
                'screening_date' => $this->getDescription()->getScreeningDate()?->format('Y-m-d'),
                'short_description' => $this->getDescription()->getShortDescription(),
                'rating' => $this->getDescription()->getRating(),
                'actors' => $this->getDescription()->getActors(),
                'slogan' => $this->getDescription()->getSlogan(),
                'country' => $this->getDescription()->getCountry(),
            ],
            'categories' => CategoryResource::collection($this->getCategories()),
            'storage_image_url' => $this->getFullImagePath(),
            'storage_movie_url' => $this->getFullMoviePath(),
        ];
    }
}
