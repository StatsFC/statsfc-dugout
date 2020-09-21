<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ThrottleRequests;

class CustomThrottleMiddleware extends ThrottleRequests
{
    protected function resolveRequestSignature($request)
    {
        return sha1(implode('|', [
            $request->header('X-StatsFC-Key'),
            $request->path(),
            $request->getQueryString(),
        ]));
    }

    protected function buildException($key, $maxAttempts)
    {
        header_remove('X-Powered-By');

        return response()->json([
            'error' => [
                'message'    => 'You may only make 1 identical request per minute',
                'statusCode' => 429,
            ],
        ], 429);
    }
}
