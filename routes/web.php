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

Route::get('/', function () {
  return view('landings.rgpd-landing');
})->middleware('guest');

Route::middleware('auth:web')->group(function () {
  Route::get('emailings', function () {
    return view('landings.emailings');
  });
  Route::get('landings', function () {
    return view('landings.landings');
  });
  Route::get('sendemail', 'EmailingController@send')->name('sendemailing');
  Route::get('showemail', 'EmailingController@showview')->name('showemail');
});


