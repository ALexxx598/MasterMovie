<?php

namespace App\Http\Middleware;

use App\Common\AuthMiddlewareTrait;
use App\MovieLayers\Domain\User\Exception\UserNotFoundException;
use App\MovieLayers\Domain\User\Token\UserTokenServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class ViewerRoleValidator
{
    use AuthMiddlewareTrait;

    public function __construct(
        private readonly UserTokenServiceInterface $userTokenService
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws UserNotFoundException
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->userTokenService->getUserByToken($this->checkAuthToken($request))->isViewer()) {
            throw new AccessDeniedException('You must have viewer role');
        }

        return $next($request);
    }
}
