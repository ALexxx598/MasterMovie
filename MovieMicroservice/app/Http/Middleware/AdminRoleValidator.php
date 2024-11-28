<?php

namespace App\Http\Middleware;

use App\Common\AuthMiddlewareTrait;
use App\MovieLayers\Domain\Role\RoleTypeEnum;
use App\MovieLayers\Domain\User\Token\UserTokenServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class AdminRoleValidator
{
    use AuthMiddlewareTrait;

    public function __construct(
        private UserTokenServiceInterface $userTokenService
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws \App\MovieLayers\Domain\User\Exception\UserNotFoundException
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $this->userTokenService->getUserByToken($this->checkAuthToken($request));

        if ($this->getUserId($request) !== $user->getId()) {
            throw new AccessDeniedException('You must be authorized !!!');
        }

        if (!$user->hasRole(RoleTypeEnum::ADMIN)) {
            throw new AccessDeniedException('You must have admin role');
        }

        return $next($request);
    }
}
