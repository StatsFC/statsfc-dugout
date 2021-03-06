<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Transformers\CompetitionTransformer;
use Illuminate\Http\{JsonResponse, Request};

class CompetitionsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $competitions = Competition::query()
            ->with('rounds')
            ->select('competitions.*')
            ->visibleByCustomer($request->session()->get('customer_id'))
            ->filterRegion($request)
            ->groupBy('competitions.id')
            ->get();

        return response()->json([
            'data' => (new CompetitionTransformer)->transformCollection($competitions),
        ], 200);
    }
}
