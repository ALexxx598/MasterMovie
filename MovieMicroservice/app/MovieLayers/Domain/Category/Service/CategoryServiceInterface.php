<?php

namespace App\MovieLayers\Domain\Category\Service;

use App\MovieLayers\Domain\Category\Category;
use App\MovieLayers\Domain\Category\CategoryCollection;
use App\MovieLayers\Domain\Category\Filter\CategoryFilter;
use App\MovieLayers\Domain\Category\DPO\CategoryCreateDPO;

interface CategoryServiceInterface
{
    /**
     * @param CategoryCreateDPO $payload
     * @return Category
     */
    public function create(CategoryCreateDPO $payload): Category;

    /**
     * @param CategoryFilter $filter
     * @return CategoryCollection
     */
    public function list(CategoryFilter $filter): CategoryCollection;

    /**
     * @param int $categoryId
     */
    public function delete(int $categoryId): void;
}
