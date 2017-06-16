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

	Route::resource('users','UsersController');
	Route::get('users/{id}/destroy', 'UsersController@destroy')->name('users.destroy');	

	Route::get('roles/{id}/index', 'RolesController@index')->name('roles.index');
	Route::get('roles/{id}/create', 'RolesController@create')->name('roles.create');
	Route::post('roles/store', 'RolesController@store')->name('roles.store');
	Route::get('roles/{id}/{rol}/destroy', 'RolesController@destroy')->name('roles.destroy');	

	Route::resource('guardias', 'GuardiasController');
	Route::get('guardias/{id}/destroy', 'GuardiasController@destroy')->name('guardias.destroy');	
	Route::get('guardia/{id}/create', 'GuardiasController@create')->name('guardias.create');
	Route::get('change', 'GuardiasController@getChange')->name('guardias.getChange');	

});


Route::resource('guardia', 'EstatusGuardiasController');

Route::resource('solicitud', 'SolicitudCompensatorioControllers');
Route::resource('perfil', 'PerfilController');


Route::get('/login', "AuthController@getLogin")->name('login');
Route::post('/login', "AuthController@posLogin")->name('login');
Route::get('/logout', "AuthController@getlogout")->name('logout');

Route::get('/home', 'HomeController@index')->name('home');
