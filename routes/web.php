<?php
use Illuminate\Support\Facades\Cache;
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

	Route::get('/profile-selector', function() {
		return view('profile-selector');
	})->name('profile-selector');
	Route::post('/profile-choice', function() {
		session(['selectedProfile'=> auth()->user()->profiles[request('profile-index')]->id]);
		return redirect()->route('home');
	})->name('profile-choice');
	// Route::get('/tutorial', 'TutorialController@index')->name('tutorial');
	// Route::patch('/tutorial/{profile}', 'TutorialController@update');

	// Route::get('/tools', 'ToolController@index');
	// Route::post('/tools/meta4', 'ToolController@meta4Upload');

	// Route::patch('/requests/{request}', 'RequestController@update');

	// Route::get('/dentists', 'DentistController@index');

	// Route::get('/api/schedule', 'ScheduleController@indexApi');
	// Route::get('/api/schedule/{profile}', 'ScheduleController@indexProfileApi');
	// Route::post('/schedule', 'ScheduleController@store');
	// Route::delete('/schedule/{schedule}', 'ScheduleController@destroy');
	// Route::patch('/schedule/{schedule}', 'ScheduleController@update');

	Route::get('/api/profile', 'ProfileController@indexApi');
	Route::get('/api/profile/{profile}', 'ProfileController@indexApiById');
	Route::patch('/profile/{profile}', 'ProfileController@update');

	// Route::get('/api/experience', 'ExperienceController@indexApi');
	// Route::get('/api/especialty', 'EspecialtyController@indexApi');

	// Route::get('/api/masters', 'MasterController@indexApi');
	// Route::post('/masters/{profile}', 'MasterUniversityController@store');
	// Route::delete('/masters/{master_university}', 'MasterUniversityController@destroy');
	// Route::delete('/courses/{course}', 'CourseController@destroy');

	// Route::get('/extratime', 'ExtratimeController@index');

	Route::get('/api/menu', 'MenuController@indexApi');
	Route::delete('/api/clinic', 'ClinicController@destroyApi');
	// Route::get('/api/universities', 'UniversityController@indexApi');
	// Route::get('/api/requests', 'RequestController@indexApi');

	Route::patch('/api/user/passreset', 'UserController@resetPassApi');
	Route::get('/api/users', 'UserController@indexApi');
	Route::get('/api/user', function (Request $request) {
		$user = Cache::rememberForever('user_' . session('user.email'), function() {
			$user = auth()->user();
			$profile = \App\Profile::find(session('selectedProfile'))->append('clinicScope', 'clinicIdsScope', 'countryIdsScope', 'stateIdsScope', 'countyIdsScope');
			$user['profile'] = $profile;
			return $user;
		});
        session(['clinicsScope' => $user->profile->clinicIdsScope->toArray()]);

		return $user;
    });

	// Route::get('/api/dentists', 'DentistController@indexApi');

	// Route::get('/api/session', 'SessionController@indexApi');

	Route::delete('/clinic_profile/{clinic}/{profile}', 'ClinicProfileController@destroy');

	Route::post('/export-excel', 'ExcelController@export');

	Route::namespace('API')->prefix('api')->group(function () {
		Route::get('/clinics/table', 'ClinicController@table');
		Route::resource('clinics', 'ClinicController');
		Route::resource('profiles', 'ProfileController');
		Route::resource('cost_centers', 'CostCenterController');
		Route::get('/providers/table', 'ProviderController@table');
		Route::get('/providers/form', 'ProviderController@form');
		Route::resource('providers', 'ProviderController');
		Route::resource('jobs', 'JobController');
		Route::resource('job_types', 'JobTypeController');
		Route::resource('orders', 'OrderController');
		Route::resource('shoppingBags', 'ShoppingBagController');
		Route::get('/stationaries/table', 'StationaryController@table');
		Route::get('/stationaries/form', 'StationaryController@form');
		Route::resource('stationaries', 'StationaryController');
		Route::resource('counties', 'CountyController');
		Route::resource('states', 'StateController');
		Route::resource('countries', 'CountryController');
	
		Route::resource('clinic_stationaries', 'ClinicStationaryController');

		Route::get('/table', 'TableController@index');
		Route::get('/form', 'FormController@index');
		Route::resource('relations', 'RelationController');
		
	});
});

Route::middleware(['auth', 'tutorial', 'profile-count'])->group(function() {
	Route::get('/', function () {
	    return redirect()->route('home');
	});
	Route::get('/home', 'HomeController@index')->name('home');

	// Route::get('/schedule', 'ScheduleController@index');
	// Route::get('/schedule/{user}/create', 'ScheduleController@create');
	// Route::get('/schedule/{user}/extratime/create', 'ExtratimeController@create');

	// Route::post('/extratime', 'ExtratimeController@store');
	// Route::patch('/extratime/{extratime}', 'ExtratimeController@update');
	// Route::delete('/extratime/{extratime}', 'ExtratimeController@destroy');

	Route::get('/profile/{user}/create', 'ProfileController@create');
	Route::get('/profile', 'ProfileController@index');
	Route::get('/profiles/download-tags', 'ProfileController@downloadTags');
	Route::get('/profiles/download-business-cards', 'ProfileController@downloadBusinessCard');
	Route::get('/profiles/download-charts', 'ProfileController@downloadCharts');
	Route::get('/profiles/download-jobcharts', 'ProfileController@downloadJobCharts');
	Route::get('/profiles/{profile}', 'ProfileController@show');

	// Route::get('/requests', 'RequestController@index');
	// Route::get('/requests/create', 'RequestController@create');
	// Route::get('/requests/{request}', 'RequestController@show');
	// Route::post('/requests/{profile}', 'RequestController@store');

	Route::get('/users', 'UserController@index');

	Route::get('/clinics', 'ClinicController@index');
	Route::patch('/clinics/{clinic}', 'ClinicController@update');

	Route::get('/stationary', 'StationaryController@index');
	Route::get('/stationary/download', 'StationaryController@download');
	Route::get('/stationary/download-all', 'StationaryController@downloadAll');
	Route::get('/stationary/download/{clinic}', 'StationaryController@downloadClinic');
	Route::post('/stationary/regen', 'StationaryController@regen');
	Route::post('/stationary/{clinic}', 'StationaryController@store');

	Route::get('/providers', 'ProviderController@index');

	Route::get('/orders', 'OrderController@index');
	Route::post('/order/{clinic}', 'OrderController@store');
	Route::get('/order/{shoppingbag}/{provider}', 'ShoppingBagController@download');
	
});



