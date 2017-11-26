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

	Route::get('/schedule', 'ScheduleController@index');
	Route::get('/api/schedule', 'ScheduleController@indexApi');
	Route::post('/schedule', 'ScheduleController@store');
	Route::delete('/schedule/{schedule}', 'ScheduleController@destroy');
	Route::patch('/schedule/{schedule}', 'ScheduleController@update');
	Route::get('/schedule/{user}/create', 'ScheduleController@create');
	Route::get('/schedule/{user}/extratime/create', 'ExtratimeController@create');

	Route::post('/extratime', 'ExtratimeController@store');
	Route::delete('/extratime/{extratime}', 'ExtratimeController@destroy');

	Route::get('/profile/{user}/create', 'ProfileController@create');
	Route::get('/profile', 'ProfileController@index');
	Route::get('/api/profile', 'ProfileController@indexApi');
	Route::patch('/profile/{profile}', 'ProfileController@update');

	Route::get('/requests', 'RequestController@index');
	Route::get('/requests/create', 'RequestController@create');
	Route::get('/requests/{request}', 'RequestController@show');
	Route::post('/requests/{profile}', 'RequestController@store');
	Route::post('/masters/{profile}', 'MasterUniversityController@store');
	Route::delete('/masters/{master_university}', 'MasterUniversityController@destroy');

	Route::get('/clinics', 'ClinicController@index');
	Route::patch('/clinics/{clinic}', 'ClinicController@update');

	Route::delete('/clinic_profile/{clinic}/{profile}', 'ClinicProfileController@destroy');

	Route::get('/api/experience', 'ExperienceController@indexApi');
	Route::get('/api/especialty', 'EspecialtyController@indexApi');
	Route::get('/api/masters', 'MasterController@indexApi');
	Route::get('/api/universities', 'UniversityController@indexApi');
	Route::get('/api/requests', 'RequestController@indexApi');
	Route::patch('/api/user/passreset', 'UserController@resetPassApi');
});



