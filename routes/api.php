<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();
});

//Route::apiResource(['user'=> 'userController']);

Route::middleware('auth:api')->group( function () {

});
Route::apiResource('user', 'API\userController');

Route::get('/profile', 'API\userController@profile');
Route::put('/profile', 'API\userController@change');


