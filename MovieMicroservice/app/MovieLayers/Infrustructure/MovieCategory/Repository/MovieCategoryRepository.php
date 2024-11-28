<?php

namespace App\MovieLayers\Infrustructure\MovieCategory\Repository;

use App\Models\MovieCategory;
use App\MovieLayers\Domain\Movie\MovieCategory\Repository\MovieCategoryRepositoryInterface;

class MovieCategoryRepository implements MovieCategoryRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function deleteByCategoryId(int $categoryId): void
    {
        MovieCategory::query()->where('category_id', $categoryId)->delete();
    }
}
