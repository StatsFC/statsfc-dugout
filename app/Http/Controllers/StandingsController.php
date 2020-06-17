<?php

namespace App\Http\Controllers;

use App\Standing;
use App\Transformers\StandingTransformer;
use Illuminate\Http\{JsonResponse, Request};

class StandingsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        if (! $request->hasAny(['season', 'season_id'])) {
            return response()->json([
                'error' => [
                    'message'    => 'You must filter by season',
                    'statusCode' => 401,
                ],
            ], 401);
        }

        $standings = Standing::query()
            ->select('standings.*')
            ->visibleByCustomer($request->session()->get('customer_id'))
            ->filterSeason($request)
            ->filterCompetition($request)
            ->orderBy('competitions.order')
            ->orderBy('standings.position')
            ->get();

        return response()->json([
            'data' => (new StandingTransformer)->transformCollection($standings),
        ], 200);
    }
}
