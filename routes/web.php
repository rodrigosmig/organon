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
	Route::any('/search', 'ProjectController@search')->name('search');
	Route::get('/', 'ProjectController@index')->name('index');
	Route::get('/new', 'ProjectController@create')->name('new');
	Route::post('/store', 'ProjectController@store')->name('store');
	Route::get('/delete/{project_id}', 'ProjectController@destroy')->name('delete');
	Route::get('/edit/{project_id}', 'ProjectController@edit')->name('edit');
	Route::post('/update/{project_id}', 'ProjectController@update')->name('update');
	Route::get('/show/{project_id}', 'ProjectController@show')->name('show');
	Route::post('/{project_id}/add-member', 'ProjectController@addMember')->name('add-member');
	Route::post('/del-member', 'ProjectController@ajaxRemoveMember')->name('del-member');
	Route::get('/finish-project/{project_id}', 'ProjectController@finishProject')->name('finish-project');
    Route::get('/open-project/{project_id}', 'ProjectController@openProject')->name('open-project');
    Route::post('/{project_id}/assign-task-member', 'ProjectController@assignTaskMember')->name('assign-task-member');
    Route::get('/{project_id}/remove-task-member/{task_id}', 'ProjectController@removeTaskMember')->name('remove-task-member');
});

Route::prefix('tasks')
    ->as('tasks.')
    ->middleware('taskOwner')
	->group(function() {
        Route::get('/create', 'TaskController@create')->name('create');
        Route::post('/store', 'TaskController@store')->name('store');
        Route::get('/edit/{id}', 'TaskController@edit')->name('edit');
        Route::get('/show/{id}', 'TaskController@show')->name('show');
        Route::get('/delete/{id}', 'TaskController@destroy')->name('delete');
        Route::post('/update/{id}', 'TaskController@update')->name('update');
        Route::get('/my-tasks', 'TaskController@index')->name('my-tasks');
        Route::post('/ajax-update-task-time', 'TaskController@ajaxUpdateTaskTime')->name('update-task-time');
        Route::get('/finish-task/{id}', 'TaskController@finishTask')->name('finish-task');
        Route::get('/open-task/{id}', 'TaskController@openTask')->name('open-task');
        Route::get('/task-edit/{id}/project/{project_id}', 'TaskController@editProjectTask')->name('edit-project-task');
        Route::post('/task-update/{id}/project/{project_id}', 'TaskController@updateProjectTask')->name('update-project-task');
        Route::post('/{id}/comment', 'TaskController@commentTask')->name('add-comment');
    });

Route::prefix('clients')
    ->as('clients.')
    ->middleware('clientOwner')
	->group(function() {
		Route::get('/', 'ClientController@index')->name('index');
		Route::get('/new', 'ClientController@create')->name('new');
        Route::post('/store', 'ClientController@store')->name('store');
        Route::get('/show/{client_id}', 'ClientController@show')->name('show');
        Route::put('/update/{client_id}', 'ClientController@update')->name('update');
        Route::get('/edit/{client_id}', 'ClientController@edit')->name('edit');
    });

Route::prefix('notifications')
    ->as('notifications.')
	->group(function() {
        Route::get('/', 'NotificationController@notifications')->name('notifications');
        Route::put('/read', 'NotificationController@markAsRead');
        Route::get('/all', 'NotificationController@all');
    });
