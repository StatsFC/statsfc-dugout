<?php

namespace App\Http\Controllers;

use App\Match;
use App\Transformers\MatchTransformer;
use Illuminate\Http\{JsonResponse, Request};

class ResultsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $matches = Match::query()
            ->with([
                'away',
                'competition',
                'events',
                'events.assist',
                'events.player',
                'events.team',
                'home',
                'round',
                'round.season',
            ])
            ->select('matches.*')
            ->visibleByCustomer($request->session()->get('customer_id'))
            ->filterSeason($request)
            ->filterCompetition($request)
            ->filterTeam($request)
            ->filterDates($request)
            ->hasEnded()
            ->groupBy('matches.id')
            ->orderBy('matches.start')
            ->orderBy('matches.id')
            ->get();

        return response()->json([
            'data' => (new MatchTransformer)->transformCollection($matches),
        ], 200);
    }
}
