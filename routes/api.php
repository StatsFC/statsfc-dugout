<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth', 'prefix' => '/api/v2'], function () {
    Route::get('/competitions', 'CompetitionsController@index');
});
