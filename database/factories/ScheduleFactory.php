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

$factory->define(App\Schedule::class, function (Faker $faker) {
    $cp = new \App\Clinic_Profile;
    $cp->clinic_id = 2;
    $cp->profile_id = 23;
    // $cp->save();
    // $index = mt_rand(0,count($clinic_profile)-1);
    $schedule = "{01: {9: 142, 10: null, 11: null, 12: null, 13: 26, 14: null, 15: null, 16: null, 17: 142, 18: 26, 19: null, 20: 26}02: {9: null, 10: 142, 11: 142, 12: 26, 13: 142, 14: 26, 15: null, 16: 142, 17: null, 18: null, 19: null, 20: null}03: {9: 142, 10: 26, 11: null, 12: 26, 13: null, 14: null, 15: 26, 16: 142, 17: 142, 18: 142, 19: null, 20: 26}04: {9: 26, 10: null, 11: null, 12: null, 13: null, 14: 142, 15: null, 16: 26, 17: 142, 18: 26, 19: 142, 20: 26}05: {9: null, 10: 26, 11: 142, 12: 26, 13: 142, 14: null, 15: 142, 16: null, 17: 142, 18: 142, 19: 142, 20: null}06: {9: null, 10: 142, 11: 142, 12: null, 13: null, 14: null, 15: 142, 16: null, 17: null, 18: null, 19: null, 20: 142}07: {9: null, 10: null, 11: 142, 12: null, 13: 26, 14: null, 15: null, 16: null, 17: null, 18: null, 19: 26, 20: 142}";
    return [
        'profile_id' => $cp->profile_id,
        'clinic_id' => $cp->clinic_id,
        'schedule' => $schedule,
        'created_at' => $faker->dateTimeThisYear($max = 'now', $timezone = date_default_timezone_get()),
    ];
});
