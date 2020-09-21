<?php

namespace App\Http\Middleware;

use Closure;

class RequireCompetitionOrTeam
{
    public function handle($request, Closure $next)
    {
        if (! $request->hasAny(['competition_id', 'competition_key', 'competition', 'team_id', 'team'])) {
            header_remove('X-Powered-By');

            return response()->json([
                'error' => [
                    'message'    => 'You must filter by competition or team',
                    'statusCode' => 401,
                ],
            ], 401);
        }

        return $next($request);
    }
}
