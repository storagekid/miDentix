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

	Route::get('/api/profile', 'ProfileController@indexApi');
	Route::get('/api/profile/{profile}', 'ProfileController@indexApiById');
	Route::patch('/profile/{profile}', 'ProfileController@update');

	Route::delete('/api/clinic', 'ClinicController@destroyApi');

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

Route::middleware(['auth', 'profile-count'])->group(function() {
	Route::get('/', function () {
	    return view('layouts.app');
	    // return redirect()->route('home');
	})->name('home');

	Route::get('/profile/{user}/create', 'ProfileController@create');
	Route::get('/profile', 'ProfileController@index');
	Route::get('/profiles/download-tags', 'ProfileController@downloadTags');
	Route::get('/profiles/download-business-cards', 'ProfileController@downloadBusinessCard');
	Route::get('/profiles/download-charts', 'ProfileController@downloadCharts');
	Route::get('/profiles/download-jobcharts', 'ProfileController@downloadJobCharts');
	Route::get('/profiles/{profile}', 'ProfileController@show');

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



