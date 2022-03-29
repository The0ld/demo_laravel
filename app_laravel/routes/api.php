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

Route::prefix('v1')->group(function () {
    Route::prefix('oauth')->namespace('Auth')->group(function () {
        Route::apiResource('signup', 'AuthController')->only(['store']);
        Route::post('login', 'AuthController@login');
    });
});

Route::prefix('v1')->middleware('auth:api')->group(function () {
    Route::prefix('oauth')->namespace('Auth')->group(function () {
        Route::get('/logout/{user}', 'AuthController@logout');
    });

    Route::namespace('User')->group(function () {
        Route::apiResource('user', 'UserController')->except(['store']);
    });

    Route::prefix('delivery')->namespace('Delivery')->group(function () {
        Route::post('/manual', 'ManualController@index');
        Route::post('/paquery', 'PaqueryController@index');
    });
});
