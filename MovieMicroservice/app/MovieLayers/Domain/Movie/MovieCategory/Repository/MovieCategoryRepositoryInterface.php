<?php

namespace App\MovieLayers\Domain\Movie\MovieCategory\Repository;

interface MovieCategoryRepositoryInterface
{
    /**
     * @param int $categoryId
     */
    public function deleteByCategoryId(int $categoryId): void;
}
