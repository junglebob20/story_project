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
Route::post('logincheck', 'LoginController@log_in');
Route::get('logout', 'LoginController@logout');

//dashboard_page
Route::get('dashboard', 'DashboardController@index')->middleware('user');

//images_page
Route::get('images','ImageController@index')->middleware('user');

Route::get('test_img','ImageController@test')->middleware('user');

Route::get('image/add', 'ImageController@create')->middleware('user');
Route::post('image/thumbnail', 'ImageController@thumbnail')->middleware('user');
Route::post('image/add', 'ImageController@store')->middleware('user');

Route::get('image/{id}/edit', 'ImageController@edit')->middleware('user');
Route::post('image/update', 'ImageController@update')->middleware('user');

Route::get('image/{id}/delete', 'ImageController@delete')->middleware('user');
Route::post('image/destroy', 'ImageController@destroy')->middleware('user');

Route::post('images_loading', 'ImageController@lazyLoading')->middleware('user');

//tags_page
Route::get('tags','TagController@index')->middleware('user');

Route::get('tags_add_create', 'TagController@create')->middleware('user');

Route::get('tag/{id}/deleteForm', 'TagController@deleteForm')->middleware('user');

Route::post('tags_add', 'TagController@store')->middleware('user');

Route::get('tag/{id}', 'TagController@show')->middleware('user');

Route::get('tag_edit_form/{id}', 'TagController@edit')->middleware('user');

Route::post('tags_edit/{id}', 'TagController@update')->middleware('user');

Route::post('tags_delete/{id}', 'TagController@destroy')->middleware('user');

Route::get('tags_search', 'TagController@search')->middleware('user');
Route::post('tags_loading', 'TagController@lazyLoading')->middleware('user');


//users_list_page
Route::get('userslist','UserController@index')->middleware('admin');

Route::get('user/add', 'UserController@create')->middleware('admin');
Route::post('user/add', 'UserController@store')->middleware('admin');

Route::get('user/{id}/edit', 'UserController@edit')->middleware('admin');
Route::post('user/update', 'UserController@update')->middleware('admin');

Route::get('user/{id}/delete', 'UserController@delete')->middleware('admin');
Route::post('user/destroy', 'UserController@destroy')->middleware('admin');

Route::post('userslist_loading', 'UserController@lazyLoading')->middleware('user');


