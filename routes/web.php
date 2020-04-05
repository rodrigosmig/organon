<?php

use App\Task;
use App\Project;
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
	Route::get('/get-users', 'UserController@getUsersJson')->name('get-users');
});

Route::group([
	'prefix' => 'projects', 
	'as' => 'projects.',
	'middleware' => ['owner']
], function () {
	Route::get('/', 'ProjectController@index')->name('index');
	Route::get('/new', 'ProjectController@create')->name('new');
	Route::post('/store', 'ProjectController@store')->name('store');
	Route::get('/delete/{id}', 'ProjectController@destroy')->name('delete');
	Route::get('/edit/{id}', 'ProjectController@edit')->name('edit');
	Route::post('/update/{id}', 'ProjectController@update')->name('update');
	Route::get('/show/{id}', 'ProjectController@show')->name('show')->middleware(['owner']);;
	Route::post('/{project_id}/add-member', 'ProjectController@addMember')->name('add-member');
	Route::post('/del-member', 'ProjectController@ajaxRemoveMember')->name('del-member');

	Route::group([
		'prefix' => '{project_id}', 
		'as' => 'tasks.',
		'middleware' => ['owner']
	], function () {
		Route::post('/store', 'TaskController@store')->name('store');
		Route::get('/edit/{id}', 'TaskController@edit')->name('edit');
		Route::get('/delete/{id}', 'TaskController@destroy')->name('delete');
		Route::post('/update/{id}', 'TaskController@update')->name('update');
		Route::post('assign-task-member', 'TaskController@assignTaskMember')->name('assign-task-member');
		Route::get('/remove-task-member/{id}', 'TaskController@removeTaskMember')->name('remove-task-member');
	});
	
});
