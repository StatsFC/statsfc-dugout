<?php

namespace App\Http\Controllers;

//use App\Competition;
use Illuminate\Http\Request;

class CompetitionsController extends Controller
{
    public function index(Request $request)
    {
//        $competitions = Competition::select('competitions.*')
//            ->visibleByCustomer($request->session()->get('customer_id'))
//            ->filterRegion($request)
//            ->groupBy('competitions.id')
//            ->get();

        return response()->json([
            'data' => [], //$this->competitionTransformer->transformCollection($competitions->all()),
        ], 200);
    }
}
