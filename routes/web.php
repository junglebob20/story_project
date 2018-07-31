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
Route::get('images2','ImageController@test');
Route::post('image', 'ImageController@store');
Route::get('image/delete/{id}', 'ImageController@destroy');

//tags_page
Route::get('tags','TagController@index');
Route::get('tags_search','TagController@search');

Route::get('tags2','TagController@test');

Route::post('tags_add', 'TagController@store');

Route::get('tag/{id}', 'TagController@show');
Route::post('tags_edit/{id}', 'TagController@update');

Route::post('tags_delete/{id}', 'TagController@destroy');

//users_list_page
Route::get('userslist','UserController@index');
Route::get('userslist2','UserController@test');

Route::post('user_add', 'UserController@store');

Route::get('user/{id}', 'UserController@show');
Route::post('user_edit/{id}', 'UserController@update');

Route::post('user_delete/{id}', 'UserController@destroy');


