<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Transformers\CompetitionTransformer;
use Illuminate\Http\Request;

class CompetitionsController extends Controller
{
    public function index(Request $request)
    {
        $competitions = Competition::query()
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
