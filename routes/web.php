<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');
Route::get('/docs', 'DocsController@index');

Route::group(['middleware' => 'auth', 'prefix' => '/api/v2'], function () {
    Route::get('/competitions', 'CompetitionsController@index');
});
