<?php

namespace App\Http\Controllers;

use App\Standing;
use App\Transformers\StandingTransformer;
use Illuminate\Http\{JsonResponse, Request};

class StandingsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $standings = Standing::query()
            ->with('competition', 'season', 'team')
            ->select('standings.*')
            ->visibleByCustomer($request->session()->get('customer_id'))
            ->filterSeason($request)
            ->filterCompetition($request)
            ->join('teams', 'teams.id', '=', 'standings.team_id')
            ->groupBy([
                'standings.id',
                'standings.competition_id',
                'standings.season_id',
                'standings.team_id',
            ])
            ->orderBy('seasons.name')
            ->orderBy('competitions.country')
            ->orderBy('competitions.order')
            ->orderBy('standings.group_name')
            ->orderBy('standings.position')
            ->get();

        return response()->json([
            'data' => (new StandingTransformer)->transformCollection($standings),
        ], 200);
    }
}
