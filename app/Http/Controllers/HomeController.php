<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'sections' => [
                'competitions' => 'Competitions',
                'seasons'      => 'Seasons',
                'fixtures'     => 'Fixtures',
                'results'      => 'Results',
                'events'       => 'Events',
                'standings'    => 'Standings',
                'top-scorers'  => 'Top Scorers',
                'squads'       => 'Squads',
            ],
        ]);
    }
}
