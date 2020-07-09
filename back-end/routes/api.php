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
Route::get('books', 'BookController@index');
Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'book'], function () {
    if (auth('sanctum')->check()) {
        Route::post('add', 'BookController@add');
        Route::get('edit/{id}', 'BookController@edit');
        Route::post('update/{id}', 'BookController@update');
        Route::delete('delete/{id}', 'BookController@delete');
    }
});

/*Route::group(['prefix' => 'book'], function () {
    Route::post('add', 'BookController@add');
    Route::get('edit/{id}', 'BookController@edit');
    Route::post('update/{id}', 'BookController@update');
    Route::delete('delete/{id}', 'BookController@delete');
});*/
