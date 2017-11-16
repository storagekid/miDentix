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

$factory->define(App\Request::class, function (Faker $faker) {
    $base = new \App\Request;
    $types = $base->types;
    $type_details1 = $base->type_details1;
    $index = mt_rand(0,count($types)-1);
    if ($index === 0) {
        $type_detail1 = $type_details1[0][mt_rand(0,count($type_details1)-1)];
    } elseif ($index === 4) {
        $labs = \App\Laboratory::all();
        $type_detail1 = $labs[mt_rand(0,count($labs)-1)]->name;
    } else {
        $type_detail1 = null;
    }
    return [
        'profile_id' => mt_rand(0,209),
        'clinic_id' => mt_rand(0,209),
        'type' => $types[$index],
        'type_detail1' => $type_detail1,
        'description' => $faker->text,
        'created_at' => $faker->dateTimeThisYear($max = 'now', $timezone = date_default_timezone_get()),
    ];
});
