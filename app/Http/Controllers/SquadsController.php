<?php

namespace App\Http\Controllers;

use App\Team;
use App\Transformers\SquadTransformer;
use Illuminate\Http\{JsonResponse, Request};

class SquadsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        if (! $request->hasAny(['competition_id', 'competition_key', 'competition', 'team_id', 'team'])) {
            return response()->json([
                'error' => [
                    'message'    => 'You must filter by competition or team',
                    'statusCode' => 401,
                ],
            ], 401);
        }

        $squads = Team::query()
            ->with('players')
            ->select('teams.*')
            ->distinct()
            ->visibleByCustomer($request->session()->get('customer_id'))
            ->filterSeason($request)
            ->filterCompetition($request)
            ->filterTeam($request)
            ->groupBy('teams.id')
            ->orderBy('teams.name')
            ->get();

        return response()->json([
            'data' => (new SquadTransformer)->transformCollection($squads),
        ], 200);
    }
}
