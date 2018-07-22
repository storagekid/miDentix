<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;

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
        Passport::routes();
        // \View::composer(['layouts.home.home','layouts.schedule.*'], function($view){
        //     $profile = auth()->user()->profile;
        //     $profileClinics = $profile->clinics;
        //     $profileSchedules = $profile->schedules;
        //     $clinics = \App\Clinic::all();
        //     $states = \App\State::all();
        //     $counties = \App\County::all();
        //     $view->with([
        //         'profile' => $profile, 
        //         'clinics' => $clinics,
        //         'states' => $states,
        //         'counties' => $counties,
        //     ]);
        // });
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
