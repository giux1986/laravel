<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');
Route::get('register', 'ClientController@register');
Route::post('create', 'ClientController@create');
Route::get('delete', 'ClientController@delete');
Route::get('edit', 'ClientController@edit');
Route::post('editPost', 'ClientController@edit');
Route::get('deletePhoto', 'ClientController@deletePhoto');

Route::get('getClients', 'ClientController@index');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'client' => 'ClientController',
	'password' => 'Auth\PasswordController',
]);
