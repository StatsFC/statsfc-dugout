<?php

namespace App\Http\Middleware;

use Closure;

class RemovePoweredByHeader
{
    public function handle($request, Closure $next)
    {
        header_remove('X-Powered-By');

        return $next($request);
    }
}
