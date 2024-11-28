<?php

namespace App\MovieLayers\Infrustructure\Movie\Repository;

use App\Models\Movie as MovieModel;
use App\MovieLayers\Infrustructure\Category\Repository\CategoryModelMapper;
use App\MovieLayers\Domain\Movie\Movie;
use App\MovieLayers\Domain\Movie\MovieDescription;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class MovieModelMapper
{
    /**
     * @param CategoryModelMapper $categoryModelMapper
     */
    public function __construct(
        private CategoryModelMapper $categoryModelMapper,
    ) {
    }

    /**
     * @param Movie $movie
     * @return MovieModel
     */
    public function mapEntityToModel(Movie $movie): MovieModel
    {
        $movieModel = new MovieModel();

        $movieModel->name = $movie->getName();

        $movieModel->description = json_encode([
            'screeningDate' => $movie->getDescription()->getScreeningDate()?->format('Y-m-d H:i:s'),
            'shortDescription' => $movie->getDescription()->getShortDescription(),
            'rating' => $movie->getDescription()->getRating(),
            'actors' => $movie->getDescription()->getActors(),
            'slogan' => $movie->getDescription()->getSlogan(),
            'country' => $movie->getDescription()->getCountry(),
        ]);

        $movieModel->storage_image_link = $movie->getStorageImageUrl();
        $movieModel->storage_movie_link = $movie->getStorageMovieUrl();

        if ($movie->getId() !== null) {
            $movieModel->id = $movie->getId();
        }

        return $movieModel;
    }

    /**
     * @param MovieModel $movieModel
     * @return Movie
     */
    public function mapModelToEntity(MovieModel $movieModel): Movie
    {
        $description = json_decode($movieModel->description, true);

        $movie = new Movie(
            name: $movieModel->name,
            description: new MovieDescription(
                rating: $description['rating'] ?? null,
                slogan: $description['slogan'] ?? null,
                screeningDate: ($description['screeningDate'] ?? null) !== null
                    ? Carbon::make($description['screeningDate'])
                    : null,
                country: $description['country'] ?? null,
                actors: $description['actors'] ?? null,
                shortDescription: $description['shortDescription']?? null
            ),
            storageMovieUrl: $movieModel->storage_movie_link,
            storageImageUrl: $movieModel->storage_image_link,
            id: $movieModel->id,
        );

        if ($movieModel->relationLoaded('categories')) {
            $movie->setCategories($this->categoryModelMapper->mapModelsToEntities($movieModel->categories));
        }

        return $movie;
    }

    /**
     * @param Collection<MovieModel> $models
     * @return Collection
     */
    public function mapModelsToEntities(Collection $models): Collection
    {
        return $models->map(fn (MovieModel $movie): Movie => $this->mapModelToEntity($movie));
    }
}
