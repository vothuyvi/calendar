<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    Route::post('login','UserController@login');
    Route::post('register','UserController@register');
   
    
    
    Route::group(['middleware' => 'auth:api'], function () {
    
        Route::post('add-event','EventController@addevent');
        Route::get('select-event','EventController@selectEvent');
        Route::post('delete-event','EventController@deleteEvent');
        Route::post('logout', 'UserController@logout');
        Route::get('get-info', 'UserController@getInfo');
        
    });
});


