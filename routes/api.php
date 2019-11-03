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

Route::get('/', function() {
	return view('api.docs');
});

Route::post('register', 'Api\RegisterController@index');
Route::post('login', 'Api\LoginController@index');

Route::post('user/{user}/edit', 'Api\UserController@edit');
Route::post('user/{user}/upload', 'Api\UserController@upload');

Route::get('categories/{language?}', 'Api\CategoryController@index');

Route::get('items/{category}/{language?}', 'Api\ItemController@index');
Route::get('item/{item}/{language?}', 'Api\ItemController@show');

Route::get('favorites/{language?}', 'Api\FavoriteController@index');
Route::post('favorite/add/{item}', 'Api\FavoriteController@store');
Route::post('favorite/remove/{item}', 'Api\FavoriteController@destroy');

