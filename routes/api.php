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


Route::post('register'	, 'Api\RegisterController@index');

Route::post('sign-up'	, 'Api\RegisterController@index');

Route::post('login'		, 'Api\LoginController@index'	);





Route::post('user/{user}/profile-edit'	, 'Api\UserController@edit'		);
Route::post('user/{user}/edit'			, 'Api\UserController@edit'		);

Route::post('user/{user}/upload-image'	, 'Api\UserController@upload'	);
Route::post('user/{user}/image'		, 'Api\UserController@upload'	);





Route::get('categories'					, 'Api\CategoryController@index');

Route::get('category/{category}/items'	, 'Api\ItemController@index'	);
Route::get('cat/{category}/items'		, 'Api\ItemController@index'	);
Route::get('items/{category}/'			, 'Api\ItemController@index'	);

Route::get('item/{item}'				, 'Api\ItemController@show'		);





Route::get(	'user/{user}/favorites'	, 'Api\FavoriteController@index'	);
Route::get(	'user/{user}/favs'		, 'Api\FavoriteController@index'	);
Route::get(	'favorites/{user}'		, 'Api\FavoriteController@index'	);
Route::get(	'favs/{user}'			, 'Api\FavoriteController@index'	);

Route::post('favorite/add'			, 'Api\FavoriteController@store'	);
Route::post('fav/add'				, 'Api\FavoriteController@store'	);

Route::post('favorite/remove'		, 'Api\FavoriteController@destroy'	);
Route::post('fav/remove'			, 'Api\FavoriteController@destroy'	);
Route::post('fav/rm'				, 'Api\FavoriteController@destroy'	);

