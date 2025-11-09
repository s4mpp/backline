<?php

namespace S4mpp\Backline\Middleware;

use Closure;
use Illuminate\Http\Request;
use S4mpp\Backline\Backline;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use S4mpp\Backline\Concerns\Resource as BacklineResource;

final class Resource
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $current_route = Route::current()?->getAction('as') ?? '';

        $path_steps = explode('.', $current_route);

        $resource_class = Backline::getResource($path_steps[1]);

        $resource = new $resource_class;

        App::bind(BacklineResource::class, fn () => $resource);

        return $next($request);
    }
}
