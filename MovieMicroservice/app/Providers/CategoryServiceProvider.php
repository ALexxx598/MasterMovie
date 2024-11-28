<?php

namespace App\Providers;

use App\MovieLayers\Domain\Category\Repository\CategoryRepositoryInterface;
use App\MovieLayers\Domain\Category\Service\CategoryService;
use App\MovieLayers\Domain\Category\Service\CategoryServiceInterface;
use App\MovieLayers\Domain\Movie\MovieCategory\Repository\MovieCategoryRepositoryInterface;
use App\MovieLayers\Infrustructure\Category\Repository\CategoryRepository;
use App\MovieLayers\Infrustructure\MovieCategory\Repository\MovieCategoryRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerCategoryService();
        $this->registerCategoryRepository();
        $this->registerMovieCategoryRepository();
    }

    public static function registerCategoryService(): void
    {
        App::singleton(CategoryServiceInterface::class, CategoryService::class);
    }

    public static function registerCategoryRepository(): void
    {
        App::singleton(CategoryRepositoryInterface::class, CategoryRepository::class);
    }

    public static function registerMovieCategoryRepository(): void
    {
        App::singleton(MovieCategoryRepositoryInterface::class, MovieCategoryRepository::class);
    }
}
