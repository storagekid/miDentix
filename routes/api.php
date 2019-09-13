<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('rest')->namespace('api')->group(function() {
    Route::prefix('auth')->group(function () {
        Route::post('/login', 'AuthController@login')->middleware('guest:api');
    });
    Route::middleware('auth:api')->group(function () {

        Route::get('/user', 'UserController@index');
        
        Route::resource('/users', 'UserController');
        Route::get('/users', 'UserController@indexAll');

        Route::resource('menus', 'MenuController');
        Route::resource('menus/{menu}/menu_items', 'MenuItemController');
        Route::resource('menu_items', 'MenuItemController');

        Route::resource('groups', 'GroupController');

        Route::resource('orders', 'OrderController');

        Route::resource('profiles', 'ProfileController');
        Route::resource('clinics', 'ClinicController');
        Route::post('clinics/{clinic}/posterDistribution', 'ClinicController@posterDistributionComposer');
        Route::post('clinics/{clinic}/posterDistributionByCampaing', 'ClinicController@posterDistributionByCampaignComposer');
        Route::post('clinics/{clinic}/posterDistributionClone', 'ClinicController@posterDistributionClone');
        Route::post('clinics/{clinic}/posterDistributionLauncher', 'ClinicController@launchCampaignDistribution');


        Route::resource('cost_centers', 'CostCenterController');
        Route::resource('jobs', 'JobController');
		Route::resource('job_types', 'JobTypeController');
        Route::resource('companies', 'CompanyController');
        Route::resource('countries', 'CountryController');
        Route::resource('stores', 'StoreController');
        Route::resource('emails', 'EmailController');
        Route::resource('phones', 'PhoneController');
        Route::resource('addresses', 'AddressController');
        Route::resource('sanitary_codes', 'SanitaryCodeController');
        
        Route::resource('clinic_schedules', 'ClinicScheduleController');
        Route::post('/clinic_schedules/download-tags', 'ClinicScheduleController@downloadTags');

        Route::resource('clinic_profiles', 'ClinicProfileController');
        Route::resource('store_profiles', 'StoreProfileController');
        Route::resource('group_users', 'ClinicProfileController');

        Route::resource('campaigns', 'CampaignController');
        Route::resource('campaigns/{campaign}/campaign_posters', 'CampaignPosterController');
        Route::resource('campaigns/{campaign}/campaign_poster_priorities', 'CampaignPosterPriorityController');
        Route::resource('campaign_posters', 'CampaignPosterController');
        Route::get('campaign_posters/{campaignposter}/download', 'CampaignPosterController@download');
        Route::resource('campaign_poster_priorities', 'CampaignPosterPriorityController');
        Route::resource('clinic_posters', 'ClinicPosterController');
        Route::post('clinic_posters/{clinicposter}/clinic_poster_priorities', 'ClinicPosterPriorityController@store');
        Route::resource('clinic_poster_priorities', 'ClinicPosterPriorityController');
        Route::resource('poster_distributions', 'ClinicPosterDistributionController');
        Route::post('poster_distributions/launch', 'ClinicPosterDistributionController@launch');
        Route::get('poster_distributions/{clinicposterdistribution}/complete', 'ClinicPosterDistributionController@completeFacade');
        Route::get('poster_distributions/{clinicposterdistribution}/compose', 'ClinicPosterDistributionController@composeFacade');
        Route::get('poster_distributions/{clinicposterdistribution}/removeFacade', 'ClinicPosterDistributionController@removeFacade');
        Route::resource('languages', 'LanguageController');
        Route::resource('posters', 'PosterController');
        Route::resource('poster_models', 'PosterModelController');
        Route::resource('files', 'FileController');
        // Route::resource('clinicSchedule', 'ClinicScheduleController');
        // Route::post('profiles/{profile}/{clinic}/schedules', 'ClinicScheduleController@store');
        // Route::post('profiles/{profile}/clinic_schedules', 'ClinicScheduleController@store');
        Route::post('users/{user}/group_users', 'GroupUserController@store');
        Route::post('profiles/{profile}/clinic_profiles', 'ClinicProfileController@store');
        Route::post('profiles/{profile}/store_profiles', 'StoreProfileController@store');
        
        Route::patch('model/{id}/restore', 'RestoreModelController@restore');
        Route::post('/belongstomany', 'BelongsToManyController@store');
        Route::delete('/belongstomany', 'BelongsToManyController@destroy');
        Route::get('/table', 'TableController@index');
        Route::get('/form', 'FormController@index');
        Route::post('/exportExcel', 'ExportController@exportExcel');
        Route::get('/images/thumbnail', 'ImageController@fetchThumbnail');
        Route::post('/images/thumbnails', 'ImageController@fetchThumbnails');
    });
});
