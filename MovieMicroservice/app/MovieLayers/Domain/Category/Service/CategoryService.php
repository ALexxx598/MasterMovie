<?php

namespace App\MovieLayers\Domain\Category\Service;

use App\MovieLayers\Domain\Category\Category;
use App\MovieLayers\Domain\Category\CategoryCollection;
use App\MovieLayers\Domain\Category\DPO\CategoryCreateDPO;
use App\MovieLayers\Domain\Category\Filter\CategoryFilter;
use App\MovieLayers\Domain\Category\Repository\CategoryRepositoryInterface;
use App\MovieLayers\Domain\Movie\MovieCategory\Repository\MovieCategoryRepositoryInterface;

class CategoryService implements CategoryServiceInterface
{
    /**
     * @param CategoryRepositoryInterface $categoryRepository
     * @param MovieCategoryRepositoryInterface $movieCategoryRepository
     */
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private MovieCategoryRepositoryInterface $movieCategoryRepository,
    ) {
    }

    /**
     * @param CategoryFilter $filter
     * @return CategoryCollection
     */
    public function list(CategoryFilter $filter): CategoryCollection
    {
        return $this->categoryRepository->list($filter);
    }

    /**
     * @param CategoryCreateDPO $payload
     * @return Category
     */
    public function create(CategoryCreateDPO $payload): Category
    {
        $category = new Category(
            id: null,
            name: $payload->getName(),
        );

        return $category->setId($this->categoryRepository->save($category));
    }

    public function delete(int $categoryId): void
    {
        $this->movieCategoryRepository->deleteByCategoryId($categoryId);
        $this->categoryRepository->deleteById($categoryId);
    }
}
