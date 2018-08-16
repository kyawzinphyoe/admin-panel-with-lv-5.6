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

Auth::routes();
Route::group(['middleware'=>'auth'],function(){
	Route::get('admin/dashboard','AdminController@dashboard');
	Route::get('admin/setting','AdminController@setting');
	Route::get('admin/check-password','AdminController@checkpwd');
	Route::match(['get','post'],'admin/update-pwd','AdminController@update_pwd');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/logout','AdminController@logout');

Route::match(['get','post'],'admin/login','AdminController@login')->name('admin.login');
