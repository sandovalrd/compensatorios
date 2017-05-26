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


Route::group (['prefix' => 'admin', 'middleware'=>['auth']], function(){

	Route::resource('groups','GroupsController');
	Route::get('groups/{id}/destroy', 'GroupsController@destroy')->name('groups.destroy');

	Route::resource('Users','UsersController');
	Route::get('groups/{id}/destroy', 'UsersController@destroy')->name('Users.destroy');	

});

Route::get('/login', "AuthController@getLogin")->name('login');
Route::post('/login', "AuthController@posLogin")->name('login');
Route::get('/logout', "AuthController@getlogout")->name('logout');

Route::get('/home', 'HomeController@index')->name('home');