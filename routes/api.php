<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Laralum', 'as' => 'API::'], function () {
    Route::get('/{table}/{accessor?}/{data?}', 'APIController@show')->name('show');
	Route::get('/{key}/{type?}', 'APIController@getBalance')->name('balance');
});

#incoming calls api
Route::post('/auto/call/log', 'Crm\LeadsController@auto_call_logs');
