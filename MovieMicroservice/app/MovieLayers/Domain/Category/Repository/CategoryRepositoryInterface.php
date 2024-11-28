<?php

namespace App\MovieLayers\Domain\Category\Repository;

use App\MovieLayers\Domain\Category\Category;
use App\MovieLayers\Domain\Category\CategoryCollection;
use App\MovieLayers\Domain\Category\Filter\CategoryFilter;

interface CategoryRepositoryInterface
{
    /**
     * @param Category $category
     * @return int
     */
    public function save(Category $category): int;

    /**
     * @param CategoryFilter $filter
     * @return CategoryCollection
     */
    public function list(CategoryFilter $filter): CategoryCollection;

    /**
     * @param int $categoryId
     * @return void
     */
    public function deleteById(int $categoryId): void;
}
