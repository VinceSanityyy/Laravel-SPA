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

// Route::middleware(['auth:api','can:isAdmin'])->group(function () {
//     Route::apiResource('User', 'API\UserController');
//     Route::get('profile','API\UserController@profile');
//     Route::put('profile','API\UserController@updateProfile');
// });


Route::apiResource('user', 'API\UserController');
Route::get('profile','API\UserController@profile');
Route::put('profile','API\UserController@updateProfile');
Route::get('findUser','API\UserController@search');


Route::get('graphs', 'API\UserController@getGraph');

Route::post('/sendemail', 'API\UserController@sendEmail');