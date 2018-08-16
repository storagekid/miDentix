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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::namespace('API')->group(function () {
    Route::get('/clinics/table', 'ClinicController@table');
    Route::resource('clinics', 'ClinicController');
    Route::get('/providers/table', 'ProviderController@table');
    Route::get('/providers/form', 'ProviderController@form');
    Route::resource('providers', 'ProviderController');
    Route::resource('orders', 'OrderController');
    Route::resource('shoppingBags', 'ShoppingBagController');
    Route::get('/stationaries/table', 'StationaryController@table');
    Route::get('/stationaries/form', 'StationaryController@form');
    Route::resource('stationaries', 'StationaryController');
    Route::resource('counties', 'CountyController');
    Route::resource('states', 'StateController');
    Route::resource('countries', 'CountryController');

    Route::get('/table', 'TableController@index');
    Route::get('/form', 'FormController@index');
    Route::resource('relations', 'RelationController');
    
});
