<?php

namespace App\Http\Middleware;

//use App\Customer;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Authenticate extends Middleware
{
    const API_TEST_KEY = 'apitest';

    public function handle($request, Closure $next, ...$guards)
    {
        if (App::isDownForMaintenance()) {
            return $this->respondWithError(503, 'Down for maintenance. We\'ll be right back');
        }

        $key = $request->header('X-StatsFC-Key');

        if (! $key) {
            return $this->respondWithError(401, 'API key not provided');
        }

        /*$customers = Customer::where('key', $key)->get();

        if ($customers->count() !== 1) {
            return $this->respondUnauthorised('API key not found');
        }

        $customer = $customers->first();

        if ($key !== static::API_TEST_KEY && ! $this->authenticateRequestIp($request, $customer)) {
            return $this->respondUnauthorised('IP address does not match');
        }

        if ($this->hasRequestedInvalidCompetition($request, $customer)) {
            return $this->respondUnauthorised('The chosen competition is not in your API subscription');
        }

        if ($this->hasExceededRateLimit($customer)) {
            return $this->respondTooManyRequests();
        }

        // Put the customer into a session
        $request->session()->put('customer_id', $customer->id);*/

        return $next($request);
    }

    protected function respondWithError(int $status, string $message)
    {
        return response()->json([
            'error' => [
                'message'    => $message,
                'statusCode' => $status,
            ],
        ], $status);
    }
}
