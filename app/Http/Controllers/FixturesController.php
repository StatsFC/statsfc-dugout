<?php

namespace App\Http\Controllers;

use App\Match;
use App\Transformers\MatchTransformer;
use Illuminate\Http\{JsonResponse, Request};

class FixturesController extends Controller
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

        $matches = Match::query()
            ->with([
                'away',
                'competition',
                'events',
                'home',
                'matchPlayers',
                'round',
                'round.season',
            ])
            ->select('matches.*')
            ->visibleByCustomer($request->session()->get('customer_id'))
            ->filterSeason($request)
            ->filterCompetition($request)
            ->filterTeam($request)
            ->filterDates($request)
            ->hasNotEnded()
            ->groupBy('matches.id')
            ->orderBy('matches.start')
            ->orderBy('matches.id')
            ->get();

        return response()->json([
            'data' => (new MatchTransformer)->transformCollection($matches),
        ], 200);
    }
}
