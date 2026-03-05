<?php

namespace App\Http\Middleware;

use Closure;

class Breadcrumb
{
    public function handle($request, Closure $next, ...$segments)
    {
        view()->share('breadcrumbs', $segments);
        return $next($request);
    }
}
