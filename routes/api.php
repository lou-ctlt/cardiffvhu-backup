<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes pour les fonctions photos
Route::get('photos', 'ApiController@getAllPhotos');
Route::get('photos/{user_id}', 'ApiController@getPhotoByUserId');
Route::post('photos', 'ApiController@uploadPhoto');
Route::put('photos/{id}', 'ApiController@updatePhoto');
Route::delete('photos/{id}','ApiController@deletePhoto');

// Routes pour les fonctions utilisateur
Route::get('users', 'ApiController@getAllUsers');
Route::get('users/{id}', 'ApiController@getSingleUser');
Route::post('users', 'ApiController@createUser');
Route::put('users/{id}', "ApiController@editUser");
Route::delete('users/{id}', 'ApiController@deleteUser');