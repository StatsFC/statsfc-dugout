<?php

namespace App\Http\Controllers;

use App\Event;
use App\Transformers\TopScorerTransformer;
use Illuminate\Http\{JsonResponse, Request};

class TopScorersController extends Controller
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

        if (! $request->hasAny(['competition_id', 'competition_key', 'competition', 'team_id', 'team'])) {
            return response()->json([
                'error' => [
                    'message'    => 'You must filter by competition or team',
                    'statusCode' => 401,
                ],
            ], 401);
        }

        $topScorers = Event::topScorers()
            ->visibleByCustomer($request->session()->get('customer_id'))
            ->filterTeam($request)
            ->filterSeason($request)
            ->filterCompetition($request)
            ->get();

        return response()->json([
            'data' => (new TopScorerTransformer)->transformCollection($topScorers),
        ], 200);
    }
}
