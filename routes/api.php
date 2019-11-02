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


Route::get('users', 'Api\UserController@index');
Route::post('register', 'Api\RegisterController@register');



Route::get('categories', 'Api\CategoryController@index')->name('category.view');



Route::get('items', 'Api\ItemController@index')->name('item.view');

