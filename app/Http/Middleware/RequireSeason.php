<?php

namespace App\Http\Middleware;

use Closure;

class RequireSeason
{
    public function handle($request, Closure $next)
    {
        if (! $request->hasAny(['season', 'season_id'])) {
            return response()->json([
                'error' => [
                    'message'    => 'You must filter by season',
                    'statusCode' => 401,
                ],
            ], 401);
        }

        return $next($request);
    }
}
