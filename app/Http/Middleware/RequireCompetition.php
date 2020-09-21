<?php

namespace App\Http\Middleware;

use Closure;

class RequireCompetition
{
    public function handle($request, Closure $next)
    {
        if (! $request->hasAny(['competition', 'competition_id', 'competition_key'])) {
            header_remove('X-Powered-By');

            return response()->json([
                'error' => [
                    'message'    => 'You must filter by competition',
                    'statusCode' => 401,
                ],
            ], 401);
        }

        return $next($request);
    }
}
