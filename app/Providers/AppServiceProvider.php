<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \View::composer(['layouts.home.home','layouts.schedule.*'], function($view){
            $profile = auth()->user()->profile;
            $profileClinics = $profile->clinics;
            $profileSchedules = $profile->schedules;
            $clinics = \App\Clinic::all();
            $states = \App\State::all();
            $provincias = \App\Provincia::all();
            $view->with([
                'profile' => $profile, 
                'clinics' => $clinics,
                'states' => $states,
                'provincias' => $provincias,
            ]);
        });
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
