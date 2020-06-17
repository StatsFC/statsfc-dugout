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
            ->groupBy('id')
            ->orderBy('name')
            ->get();

        return response()->json([
            'data' => (new SeasonTransformer)->transformCollection($seasons),
        ], 200);
    }
}
