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
    if(Auth::check()){
        return redirect('dashboard');
    }
    return redirect('login');
});

//login_page
Route::get('login', 'LoginController@show');
Route::get('logincheck', 'LoginController@log_in');
Route::get('logout', 'LoginController@logout');

//dashboard_page
Route::get('dashboard', 'DashboardController@index');

//images_page
Route::get('images','ImageController@index');

Route::get('image/add', 'ImageController@create');
Route::post('image/thumbnail', 'ImageController@thumbnail');
Route::post('image/add', 'ImageController@store');

Route::get('image/{id}/edit', 'ImageController@edit');
Route::post('image/update', 'ImageController@update');

Route::get('image/{id}/delete', 'ImageController@delete');
Route::post('image/destroy', 'ImageController@destroy');


//tags_page
Route::get('tags','TagController@index');
Route::get('tags_search','TagController@search');

Route::get('tags_add_create', 'TagController@create');

Route::get('tag/{id}/deleteForm', 'TagController@deleteForm');

Route::post('tags_add', 'TagController@store');

Route::get('tag/{id}', 'TagController@show');

Route::get('tag_edit_form/{id}', 'TagController@edit');

Route::post('tags_edit/{id}', 'TagController@update');

Route::post('tags_delete/{id}', 'TagController@destroy');

Route::post('tags_loading', 'TagController@lazyLoading');



//users_list_page
Route::get('userslist','UserController@index');

Route::get('user/add', 'UserController@create');
Route::post('user/add', 'UserController@store');

Route::get('user/{id}/edit', 'UserController@edit');
Route::post('user/update', 'UserController@update');

Route::get('user/{id}/delete', 'UserController@delete');
Route::post('user/destroy', 'UserController@destroy');


