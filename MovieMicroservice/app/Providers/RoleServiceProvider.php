<?php

namespace App\Providers;

use App\MovieLayers\Domain\Role\Repository\RoleRepositoryInterface;
use App\MovieLayers\Infrustructure\Role\Repository\RoleRepository;
use App\MovieLayers\Domain\Role\Service\RoleService;
use App\MovieLayers\Domain\Role\Service\RoleServiceInterface;
use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        // TODO parse on methods
        $this->app->singleton(RoleServiceInterface::class, RoleService::class);
        $this->app->singleton(RoleRepositoryInterface::class, RoleRepository::class);
    }
}
