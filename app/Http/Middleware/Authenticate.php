<?php

namespace App\Http\Middleware;

use App\{Customer, Competition, RateLimiter};
use Carbon\Carbon;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\App;

class Authenticate extends Middleware
{
    const API_TEST_KEY = 'apitest';

    protected $rateLimiter;

    public function handle($request, Closure $next, ...$guards)
    {
        if (App::isDownForMaintenance()) {
            return $this->respondWithError(503, 'Down for maintenance. We\'ll be right back');
        }

        $key = $request->header('X-StatsFC-Key');

        if (! $key) {
            return $this->respondWithError(401, 'API key not provided');
        }

        $customers = Customer::query()
            ->where('key', '=', $key);

        if ($customers->count() !== 1) {
            return $this->respondWithError(401, 'API key not found');
        }

        $customer = $customers->first();

        if ($key !== static::API_TEST_KEY && ! $this->authenticateRequestIp($request, $customer)) {
            return $this->respondWithError(401, 'IP address does not match');
        }

        if (! $this->hasRequestedValidCompetition($request, $customer)) {
            return $this->respondWithError(401, 'The chosen competition is not in your API subscription');
        }

        if (! $this->isWithinRateLimit($customer)) {
            return $this->respondWithError(429, 'Rate limit exceeded');
        }

        $request->session()->put('customer_id', $customer->id);

        $response = $next($request);

        $this->incrementRateLimiter($customer);
        $this->setRateLimiterHeaders($response, $customer);

        return $response;
    }

    protected function authenticateRequestIp(Request $request, Customer $customer): bool
    {
        return (
            App::environment() === 'local' ||
            $customer->lift_ip_restriction ||
            $request->ip() === $customer->ip
        );
    }

    protected function hasRequestedValidCompetition(Request $request, Customer $customer): bool
    {
        $competitions = Competition::query();

        if ($request->has('competition')) {
            $competitions->where('name', '=', $request->get('competition'));
        } elseif ($request->has('competition_id')) {
            $competitions->where('id', '=', $request->get('competition_id'));
        } elseif ($request->has('competition_key')) {
            $competitions->where('key', '=', $request->get('competition_key'));
        } else {
            return true;
        }

        if ($competitions->count() === 0) {
            return true;
        }

        return in_array($competitions->first()->id, $customer->competitionIds());
    }

    protected function isWithinRateLimit(Customer $customer): bool
    {
        return (
            App::environment() === 'local' ||
            $this->getRateLimiter($customer)->calls < $customer->dailyRateLimit()
        );
    }

    protected function getRateLimiter(Customer $customer): RateLimiter
    {
        if (! $this->rateLimiter) {
            $today = Carbon::today()->toDateString();

            $rateLimiter = RateLimiter::query()
                ->where('customer_id', '=', $customer->id)
                ->where('date', '=', $today)
                ->first();

            if (! $rateLimiter) {
                $rateLimiter       = new RateLimiter;
                $rateLimiter->date = $today;
                $rateLimiter->customer()->associate($customer);
            }

            $this->rateLimiter = $rateLimiter;
        }

        return $this->rateLimiter;
    }

    protected function incrementRateLimiter(Customer $customer): void
    {
        $rateLimiter = $this->getRateLimiter($customer);
        $rateLimiter->calls++;
        $rateLimiter->save();
    }

    protected function setRateLimiterHeaders($response, Customer $customer): void
    {
        $limit = $customer->dailyRateLimit();

        $response->headers->add([
            'X-RateLimit-Limit'     => $limit,
            'X-RateLimit-Remaining' => ($limit - $this->getRateLimiter($customer)->calls),
            'X-RateLimit-Reset'     => Carbon::tomorrow()->getTimestamp(),
        ]);
    }

    protected function respondWithError(int $status, string $message): JsonResponse
    {
        return response()->json([
            'error' => [
                'message'    => $message,
                'statusCode' => $status,
            ],
        ], $status);
    }
}
