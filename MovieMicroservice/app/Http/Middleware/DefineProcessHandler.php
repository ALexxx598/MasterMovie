<?php

namespace App\Http\Middleware;

use App\Common\ProcessHandleTypeEnum;
use App\Providers\CollectionServiceProvider;
use App\Providers\MovieServiceProvider;
use Closure;
use Illuminate\Http\Request;


class DefineProcessHandler
{
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
        $requestHandleType = $request->get('handler_type') !== null
            ? ProcessHandleTypeEnum::tryFrom($request->get('handler_type'))
            : ProcessHandleTypeEnum::SYNC;
        
        CollectionServiceProvider::registerCollectionService($requestHandleType);
        MovieServiceProvider::registerMovieService($requestHandleType);

        return $next($request);
    }
}