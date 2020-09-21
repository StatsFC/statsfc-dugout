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
}
