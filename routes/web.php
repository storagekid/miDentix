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

	Route::get('/tutorial', 'TutorialController@index')->name('tutorial');
	Route::patch('/tutorial/{profile}', 'TutorialController@update');

	Route::get('/tools', 'ToolController@index');
	Route::post('/tools/meta4', 'ToolController@meta4Upload');

	Route::patch('/requests/{request}', 'RequestController@update');

	Route::get('/dentists', 'DentistController@index');

	Route::get('/api/schedule', 'ScheduleController@indexApi');
	Route::get('/api/schedule/{profile}', 'ScheduleController@indexProfileApi');
	Route::post('/schedule', 'ScheduleController@store');
	Route::delete('/schedule/{schedule}', 'ScheduleController@destroy');
	Route::patch('/schedule/{schedule}', 'ScheduleController@update');

	Route::get('/api/profile', 'ProfileController@indexApi');
	Route::get('/api/profile/{profile}', 'ProfileController@indexApiById');
	Route::patch('/profile/{profile}', 'ProfileController@update');

	Route::get('/api/experience', 'ExperienceController@indexApi');
	Route::get('/api/especialty', 'EspecialtyController@indexApi');

	Route::get('/api/masters', 'MasterController@indexApi');
	Route::post('/masters/{profile}', 'MasterUniversityController@store');
	Route::delete('/masters/{master_university}', 'MasterUniversityController@destroy');
	Route::delete('/courses/{course}', 'CourseController@destroy');

	Route::get('/extratime', 'ExtratimeController@index');

	Route::get('/api/menu', 'MenuController@indexApi');
	Route::delete('/api/clinic', 'ClinicController@destroyApi');
	Route::get('/api/universities', 'UniversityController@indexApi');
	Route::get('/api/requests', 'RequestController@indexApi');

	Route::patch('/api/user/passreset', 'UserController@resetPassApi');
	Route::get('/api/users', 'UserController@indexApi');
	Route::get('/api/user', function (Request $request) {
        return request()->user();
    });

	Route::get('/api/dentists', 'DentistController@indexApi');

	Route::get('/api/session', 'SessionController@indexApi');

	Route::delete('/clinic_profile/{clinic}/{profile}', 'ClinicProfileController@destroy');

	Route::post('/export-excel', 'ExcelController@export');
});

Route::middleware(['auth','tutorial'])->group(function() {
	Route::get('/', function () {
	    return redirect()->route('home');
	});
	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('/schedule', 'ScheduleController@index');
	Route::get('/schedule/{user}/create', 'ScheduleController@create');
	Route::get('/schedule/{user}/extratime/create', 'ExtratimeController@create');

	Route::post('/extratime', 'ExtratimeController@store');
	Route::patch('/extratime/{extratime}', 'ExtratimeController@update');
	Route::delete('/extratime/{extratime}', 'ExtratimeController@destroy');

	Route::get('/profile/{user}/create', 'ProfileController@create');
	Route::get('/profile', 'ProfileController@index');
	Route::get('/profiles/{profile}', 'ProfileController@show');

	Route::get('/requests', 'RequestController@index');
	Route::get('/requests/create', 'RequestController@create');
	Route::get('/requests/{request}', 'RequestController@show');
	Route::post('/requests/{profile}', 'RequestController@store');

	Route::get('/users', 'UserController@index');

	Route::get('/clinics', 'ClinicController@index');
	Route::patch('/clinics/{clinic}', 'ClinicController@update');

	Route::get('/stationary', 'StationaryController@index');
	Route::get('/stationary/download', 'StationaryController@download');
	Route::get('/stationary/download-all', 'StationaryController@downloadAll');
	Route::get('/stationary/download/{clinic}', 'StationaryController@downloadClinic');
	Route::post('/stationary/complete', 'StationaryController@complete');
	Route::post('/stationary/{clinic}', 'StationaryController@store');
	Route::post('/stationary', 'StationaryController@regen');

	Route::get('/providers', 'ProviderController@index');

	Route::get('/orders', 'OrderController@index');
	Route::post('/order/{clinic}', 'OrderController@store');
	Route::get('/order/{shoppingbag}/{provider}', 'ShoppingBagController@download');
	
});



