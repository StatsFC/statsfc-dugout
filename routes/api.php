<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'removePoweredByHeader'], 'prefix' => 'v1'], function () {
    Route::get('/competitions', 'DeprecatedController@index');
    Route::get('/fixtures', 'DeprecatedController@index');
    Route::get('/results', 'DeprecatedController@index');
    Route::get('/seasons', 'DeprecatedController@index');
    Route::get('/squads', 'DeprecatedController@index');
    Route::get('/standings', 'DeprecatedController@index');
    Route::get('/states', 'DeprecatedController@index');
    Route::get('/top-scorers', 'DeprecatedController@index');
});

Route::group(['middleware' => ['apiThrottle:1,1', 'auth', 'removePoweredByHeader'], 'prefix' => 'v2'], function () {
    Route::get('/competitions', 'CompetitionsController@index');
    Route::get('/events', 'EventsController@index');
    Route::get('/fixtures', 'FixturesController@index')->middleware('requireSeason');
    Route::get('/results', 'ResultsController@index')->middleware(['requireSeason', 'requireCompetition']);
    Route::get('/seasons', 'SeasonsController@index');
    Route::get('/squads', 'SquadsController@index')->middleware('requireCompetitionOrTeam');
    Route::get('/standings', 'StandingsController@index')->middleware('requireSeason');
    Route::get('/top-scorers', 'TopScorersController@index')->middleware(['requireSeason', 'requireCompetitionOrTeam']);
});
