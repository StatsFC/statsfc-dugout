<?php

namespace App\Http\Controllers;

use App\Match;
use App\Transformers\MatchTransformer;
use Carbon\Carbon;
use Illuminate\Http\{JsonResponse, Request};

class LiveController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $matches = Match::query()
            ->with([
                'away',
                'competition',
                'events',
                'home',
                'round',
                'round.season',
            ])
            ->select('matches.*')
            ->visibleByCustomer($request->session()->get('customer_id'))
            ->whereDate('matches.start', '=', Carbon::now()->toDateString())
            ->groupBy('matches.id')
            ->orderBy('matches.start')
            ->orderBy('matches.id')
            ->get();

        return response()->json([
            'data' => (new MatchTransformer)->transformCollection($matches),
        ], 200);
    }
}
