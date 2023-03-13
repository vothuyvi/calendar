<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    Route::post('login','UserController@login');
    Route::post('register','UserController@register');


    // Route::group(['middleware' => 'auth:api'], function () {
        Route::post('event','EventController@addevent');
        Route::get('select-event','EventController@selectEvent');
    // });
});



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });