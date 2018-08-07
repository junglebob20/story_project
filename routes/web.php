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
Route::get('login', 'LoginController@show')->name('login');
Route::post('logincheck', 'LoginController@log_in');
Route::get('logout', 'LoginController@logout');

//dashboard_page
Route::get('dashboard', 'DashboardController@index')->middleware('auth')->name('dashboard');

//images_page
Route::get('images','ImageController@index')->middleware('auth')->name('images');

Route::get('test_img','ImageController@test')->middleware('auth');

Route::get('image/add', 'ImageController@create')->middleware('auth');
Route::post('image/thumbnail', 'ImageController@thumbnail')->middleware('auth');
Route::post('image/add', 'ImageController@store')->middleware('auth');

Route::get('image/{id}/edit', 'ImageController@edit')->middleware('auth');
Route::post('image/update', 'ImageController@update')->middleware('auth');

Route::get('image/{id}/delete', 'ImageController@delete')->middleware('auth');
Route::post('image/destroy', 'ImageController@destroy')->middleware('auth');

Route::post('images_loading', 'ImageController@lazyLoading')->middleware('auth');

//tags_page
Route::get('tags','TagController@index')->middleware('auth')->name('tags');

Route::get('tags_add_create', 'TagController@create')->middleware('auth');

Route::get('tag/{id}/deleteForm', 'TagController@deleteForm')->middleware('auth');

Route::post('tags_add', 'TagController@store')->middleware('auth');

Route::get('tag/{id}', 'TagController@show')->middleware('auth');

Route::get('tag_edit_form/{id}', 'TagController@edit')->middleware('auth');

Route::post('tags_edit/{id}', 'TagController@update')->middleware('auth');

Route::post('tags_delete/{id}', 'TagController@destroy')->middleware('auth');

Route::get('tags_search', 'TagController@search')->middleware('auth');
Route::post('tags_loading', 'TagController@lazyLoading')->middleware('auth');


//users_list_page
Route::get('userslist','UserController@index')->middleware('auth','admin')->name('userslist');

Route::get('user/add', 'UserController@create')->middleware('auth','admin');
Route::post('user/add', 'UserController@store')->middleware('auth','admin');

Route::get('user/{id}/edit', 'UserController@edit')->middleware('auth','admin');
Route::post('user/update', 'UserController@update')->middleware('auth','admin');

Route::get('user/{id}/delete', 'UserController@delete')->middleware('auth','admin');
Route::post('user/destroy', 'UserController@destroy')->middleware('auth','admin');

Route::post('userslist_loading', 'UserController@lazyLoading')->middleware('auth','admin');


