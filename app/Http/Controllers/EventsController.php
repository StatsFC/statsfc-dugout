<?php

namespace App\Http\Controllers;

use App\Event;
use App\Transformers\EventTransformer;
use Illuminate\Http\{JsonResponse, Request};

class EventsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $events = Event::query()
            ->select('events.*')
            ->with('assist', 'player', 'team')
            ->join('matches', 'matches.id', '=', 'events.match_id')
            ->visibleByCustomer($request->session()->get('customer_id'))
            ->whereRaw('matches.start >= date_sub(now(), interval 1 day)')
            ->orderBy('events.created_at', 'desc')
            ->orderBy('events.id', 'desc')
            ->get();

        return response()->json([
            'data' => (new EventTransformer)->transformCollection($events),
        ], 200);
    }
}
