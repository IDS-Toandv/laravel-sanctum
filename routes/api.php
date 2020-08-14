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
Route::post('/register', 'RegisterController@register');
Route::post('/login', 'LoginController@login');
Route::post('/logout', 'LoginController@logout');
Route::get('/books', 'BookController@index');
Route::get('/list-roles', 'UsersController@getRoles');
Route::get('/list-users', 'UsersController@getListUser');
Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'book'], function () {
    if (auth('sanctum')->check()) {
        Route::post('add', 'BookController@add');
        Route::get('edit/{id}', 'BookController@edit');
        Route::post('update/{id}', 'BookController@update');
        Route::delete('delete/{id}', 'BookController@delete');
    }
});

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'users'], function () {
    if (auth('sanctum')->check()) {
        Route::get('profile/{id}', 'UsersController@getProfileById');
        Route::post('update_profile/{id}', 'UsersController@editProfile');
        Route::delete('delete/{id}', 'UsersController@delete');
    }
});
