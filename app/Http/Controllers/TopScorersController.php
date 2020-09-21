<?php

namespace App\Http\Controllers;

use App\Event;
use App\Transformers\TopScorerTransformer;
use Illuminate\Http\{JsonResponse, Request};

class TopScorersController extends Controller
{
    public function index(Request $request): JsonResponse
    {
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
