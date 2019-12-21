<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return view('welcome');
});
//kareem

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/docs', function() { return redirect('/docs/login'); });
Route::group(['prefix' => '/docs'], function() {

	Route::get('/login', function() { return view('api.login'); });
	Route::get('/register', function() { return view('api.register'); });
	Route::get('/edit-profile', function() { return view('api.edit-profile'); });
	Route::get('/upload-profile-picture', function() { return view('api.upload-profile-picture'); });
	Route::get('/categories', function() { return view('api.categories'); });
	Route::get('/items', function() { return view('api.items'); });
	Route::get('/item-details', function() { return view('api.item-details'); });
	Route::get('/favorites', function() { return view('api.favorites'); });
	Route::get('/add-favorite', function() { return view('api.add-favorite'); });
	Route::get('/remove-favorite', function() { return view('api.remove-favorite'); });

});

Route::get('/admin', function() {

	return redirect()->route('admin.dashboard');

})->name('admin');


Route::middleware(['auth', 'admin'])->group(function() {


	Route::get('/admin/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');


	Route::get('/admin/user/profile', 'Admin\UserController@show')->name('admin.user.profile');


	Route::get('/admin/categories'					, 'Admin\CategoryController@index'	)->name('admin.category.view'	);
	Route::get('/admin/category/create'				, 'Admin\CategoryController@create'	)->name('admin.category.create'	);
	Route::post('/admin/category'					, 'Admin\CategoryController@store'	)->name('admin.category.add'	);
	Route::get('/admin/category/{category}/edit'	, 'Admin\CategoryController@edit'	)->name('admin.category.edit'	);
	Route::patch('/admin/category/{category}'		, 'Admin\CategoryController@update'	)->name('admin.category.update'	);
	Route::delete('/admin/category/{category}'		, 'Admin\CategoryController@destroy')->name('admin.category.delete'	);
	Route::patch('/admin/category/{category}/upload', 'Admin\CategoryController@upload'	)->name('admin.category.upload'	);



	Route::get('/admin/items'			, 'Admin\ItemController@index'		)->name('admin.item.view'	);
	Route::get('/admin/item/create'		, 'Admin\ItemController@create'		)->name('admin.item.create'	);
	Route::post('/admin/item'			, 'Admin\ItemController@store'		)->name('admin.item.add'	);
	Route::get('/admin/item/{item}/edit', 'Admin\ItemController@edit'		)->name('admin.item.edit'	);
	Route::patch('/admin/item/{item}'	, 'Admin\ItemController@update'		)->name('admin.item.update'	);
	Route::delete('/admin/item/{item}'	, 'Admin\ItemController@destroy'	)->name('admin.item.delete'	);


	Route::get('/admin/images'				, 'Admin\ImageController@index'		)->name('admin.image.view'	);
	Route::get('/admin/image/item/{item}'	, 'Admin\ImageController@upload'	)->name('admin.image.upload');
	Route::post('/admin/image/item/{item}'	, 'Admin\ImageController@store'		)->name('admin.image.store'	);
	Route::delete('/admin/image/{image}'	, 'Admin\ImageController@destroy'	)->name('admin.image.delete');


	Route::get('/admin/languages'					, 'Admin\LanguageController@index'		)->name('admin.language.view'	);
	Route::get('/admin/language/create'				, 'Admin\LanguageController@create'		)->name('admin.language.create'	);
	Route::post('/admin/language'					, 'Admin\LanguageController@store'		)->name('admin.language.add'	);
	Route::get('/admin/language/{language}/edit'	, 'Admin\LanguageController@edit'		)->name('admin.language.edit'	);
	Route::patch('/admin/language/{language}'		, 'Admin\LanguageController@update'		)->name('admin.language.update'	);
	Route::delete('/admin/language/{language}'		, 'Admin\LanguageController@destroy'	)->name('admin.language.delete'	);
	Route::patch('/admin/language/{language}/image'	, 'Admin\LanguageController@editImage'	)->name('admin.language.upload'	);


});
