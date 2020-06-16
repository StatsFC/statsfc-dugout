<?php

namespace App\Http\Controllers;

use App\Season;
use App\Transformers\SeasonTransformer;
use Illuminate\Http\{JsonResponse, Request};

class SeasonsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $seasons = Season::query()
            ->select('seasons.*')
            ->distinct()
            ->visibleByCustomer($request->session()->get('customer_id'))
            ->groupBy('seasons.id')
            ->orderBy('seasons.name')
            ->get();

        return response()->json([
            'data' => (new SeasonTransformer)->transformCollection($seasons),
        ], 200);
    }
}
