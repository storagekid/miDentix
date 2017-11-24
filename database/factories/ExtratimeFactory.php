<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Extratime::class, function (Faker $faker) {
    // $cp = new \App\Clinic_Profile;
    // $cp->clinic_id = 2;
    // $cp->profile_id = 23;
    // $cp->save();
    // $index = mt_rand(0,count($clinic_profile)-1);
    $schedule = "{01: {9: 'extra', 10: null, 11: null, 12: null, 13: null, 14: null, 15: null, 16: null, 17: 'extra', 18: null, 19: null, 20: null}02: {9: null, 10: 'extra', 11: 'extra', 12: null, 13: 'extra', 14: null, 15: null, 16: 'extra', 17: null, 18: null, 19: null, 20: null}03: {9: 'extra', 10: null, 11: null, 12: null, 13: null, 14: null, 15: null, 16: 'extra', 17: 'extra', 18: 'extra', 19: null, 20: null}04: {9: null, 10: null, 11: null, 12: null, 13: null, 14: 'extra', 15: null, 16: null, 17: 'extra', 18: null, 19: 'extra', 20: null}05: {9: null, 10: null, 11: 'extra', 12: null, 13: 'extra', 14: null, 15: 'extra', 16: null, 17: 'extra', 18: 'extra', 19: 'extra', 20: null}06: {9: null, 10: 'extra', 11: 'extra', 12: null, 13: null, 14: null, 15: 'extra', 16: null, 17: null, 18: null, 19: null, 20: 'extra'}07: {9: null, 10: null, 11: 'extra', 12: null, 13: null, 14: null, 15: null, 16: null, 17: null, 18: null, 19: null, 20: 'extra'}";
    return [
        'profile_id' => factory('App\Profile')->create()->id,
        // 'clinic_id' => $cp->clinic_id,
        'schedule' => $schedule,
        'created_at' => $faker->dateTimeThisYear($max = 'now', $timezone = date_default_timezone_get()),
    ];
});
