<?php

namespace App\Providers;

use App\MovieLayers\Domain\Role\Repository\RoleRepositoryInterface;
use App\MovieLayers\Domain\User\Repository\UserRepositoryInterface;
use App\MovieLayers\Domain\User\Token\Hash\HashService;
use App\MovieLayers\Domain\User\Token\Hash\HashServiceInterface;
use App\MovieLayers\Infrustructure\User\Repository\UserRepository;
use App\MovieLayers\Domain\User\Service\UserService;
use App\MovieLayers\Domain\User\Service\UserServiceInterface;
use App\MovieLayers\Domain\User\Token\UserTokenRepository;
use App\MovieLayers\Domain\User\Token\UserTokenRepositoryInterface;
use App\MovieLayers\Domain\User\Token\UserTokenService;
use App\MovieLayers\Domain\User\Token\UserTokenServiceInterface;
use App\MovieLayers\Domain\User\User;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        // TODO parse on methods
        $this->app->singleton(UserServiceInterface::class, UserService::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(HashServiceInterface::class, HashService::class);
        $this->app->singleton(UserTokenServiceInterface::class, UserTokenService::class);
        $this->app->singleton(UserTokenRepositoryInterface::class, UserTokenRepository::class);
    }

    public function boot()
    {
        User::setRoleRepositoryResolver(function () {
            return $this->app[RoleRepositoryInterface::class];
        });
        User::setUserRepositoryResolver(function () {
            return $this->app[UserRepositoryInterface::class];
        });
    }
}
