<?php

use Illuminate\Support\Facades\Route;

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
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
	Route::get('/profile', 'UserController@profile')->name('profile');
	Route::post('/edit-photo', 'UserController@editPhoto')->name('edit-photo');
	Route::post('/edit-info', 'UserController@editInfo')->name('edit-info');
	Route::post('/change-password', 'UserController@changePassword')->name('change-password');
});

Route::group(['prefix' => 'projects', 'as' => 'projects.'], function () {
	Route::get('/', 'ProjectController@index')->name('index');
	
});
