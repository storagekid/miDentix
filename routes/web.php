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
Auth::routes();

Route::middleware(['auth'])->group(function() {
	Route::get('/', function () {
	    return redirect()->route('home');
	});
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/requests', 'RequestController@index');
	Route::get('/profile', 'ProfileController@index');

	Route::get('/schedule', 'ScheduleController@index');
	Route::get('/api/schedule', 'ScheduleController@indexApi');
	Route::post('/schedule', 'ScheduleController@store');
	Route::delete('/schedule/{schedule}', 'ScheduleController@destroy');
	Route::get('/schedule/{user}/create', 'ScheduleController@create');
	Route::get('/schedule/{user}/extratime/create', 'ExtratimeController@create');

	Route::get('/profile/{user}/create', 'ProfileController@create');

	Route::get('/requests/create', 'RequestController@create');
	Route::get('/requests/{request}', 'RequestController@show');

	Route::get('/clinics', 'ClinicController@index');
	Route::patch('/clinics/{clinic}', 'ClinicController@update');
});



