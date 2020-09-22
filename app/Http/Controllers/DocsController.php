<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DocsController extends Controller
{
    public function index(): View
    {
        return view('docs', [
            'sections' => [
                'competitions' => 'Competitions',
                'seasons'      => 'Seasons',
                'fixtures'     => 'Fixtures',
                'results'      => 'Results',
                'live'         => 'Live',
                'events'       => 'Events',
                'standings'    => 'Standings',
                'top-scorers'  => 'Top Scorers',
                'squads'       => 'Squads',
            ],
        ]);
    }
}
