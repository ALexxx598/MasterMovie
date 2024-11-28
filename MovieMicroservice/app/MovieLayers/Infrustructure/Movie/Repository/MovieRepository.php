<?php

namespace App\MovieLayers\Infrustructure\Movie\Repository;

use App\MovieLayers\Domain\Collection\MovieCollections;
use App\MovieLayers\Domain\Movie\Exception\MovieEntityNotFoundException;
use App\MovieLayers\Domain\Movie\Filter\MovieFilter;
use App\MovieLayers\Domain\Movie\Movie;
use App\Models\Movie as MovieModel;
use App\MovieLayers\Domain\Movie\Repository\MovieRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class MovieRepository implements MovieRepositoryInterface
{
    /**
     * @param MovieModelMapper $moveModelMapper
     */
    public function __construct(
        private MovieModelMapper $moveModelMapper,
    ) {
    }

    /**
     * @inheritDoc
     * @throws MovieEntityNotFoundException
     */
    public function findById(int $id): Movie
    {
        return $this->moveModelMapper->mapModelToEntity($this->findModelById($id));
    }

    /**
     * @param MovieFilter $filter
     * @return MovieCollections
     */
    public function list(MovieFilter $filter): MovieCollections
    {
        $query = MovieModel::query();

        $query->with(['categories', 'collections']);
        $this->applyToQuery($filter, $query);

        $paginator = $query->paginate(perPage: $filter->getPerPage(), page: $filter->getPage());

        return MovieCollections::make($this->moveModelMapper->mapModelsToEntities(collect($paginator->items())))
            ->setPerPage($paginator->perPage())
            ->setPage($paginator->currentPage())
            ->setTotal($paginator->total())
            ->setLastPage($paginator->lastPage());
    }

    /**
     * @inheritDoc
     */
    public function save(Movie $movie): int
    {
        $model = $this->moveModelMapper->mapEntityToModel($movie);

        $model->exists = $model->id ?? false;
        $model->save();

        return $model->id;
    }

    /**
     * @param MovieFilter $filter
     * @param Builder $query
     */
    private function applyToQuery(MovieFilter $filter, Builder $query): void
    {
        if ($filter->getCategoryIds() !== null) {
            $query->whereHas('categories', function (Builder $query) use ($filter) {
                $query->whereIn('category_id', $filter->getCategoryIds()->toArray());
            });
        }

        if ($filter->getUserId() !== null) {
            $query->whereHas('collections', function (Builder $query) use ($filter) {
                $query->where('user_id', $filter->getUserId());
            });
        }

        if ($filter->getCollectionType() !== null) {
            $query->whereHas('collections', function (Builder $query) use ($filter) {
                $query->where('type', $filter->getCollectionType()->value);
            });
        }

        if ($filter->getCollectionIds() !== null) {
            $query->whereHas('collections', function (Builder $query) use ($filter) {
                $query->whereIn('collection_id', $filter->getCollectionIds()->toArray());
            });
        }
    }

    /**
     * @param int $id
     * @return MovieModel
     * @throws MovieEntityNotFoundException
     */
    private function findModelById(int $id): MovieModel
    {
        if (is_null($movie = MovieModel::find($id))) {
            throw new MovieEntityNotFoundException();
        };

        return $movie;
    }

    /**
     * @param int $movieId
     * @param int[]|null $collectionIds
     * @throws MovieEntityNotFoundException
     */
    public function syncCollections(int $movieId, ?array $collectionIds): void
    {
        $movie = $this->findModelById($movieId);

        if ($collectionIds !== null) {
            $movie->collections()->sync($collectionIds);
        }
    }

    /**
     * @param int $id
     * @return void
     * @throws MovieEntityNotFoundException
     */
    public function delete(int $id): void
    {
        if (is_null($movie = MovieModel::find($id))) {
            throw new MovieEntityNotFoundException();
        };

        $movie->delete();
    }

    /**
     * @param int $movieId
     * @param array|null $categoryIds
     * @throws MovieEntityNotFoundException
     */
    public function syncCategories(int $movieId, ?array $categoryIds): void
    {
        $movie = $this->findModelById($movieId);

        if ($categoryIds !== null) {
            $movie->categories()->sync($categoryIds);
        }
    }
}
