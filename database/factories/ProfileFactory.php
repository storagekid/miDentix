<?php

use Carbon\Carbon;
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

$factory->define(App\Profile::class, function (Faker $faker) {
	$faker = \Faker\Factory::create('es_ES');
    $tutorial = mt_rand(0,1);
    $user = factory('App\User')->create([
        'last_access' => $tutorial ? null : Carbon::now(),
    ]);
    return [
        'user_id' => $user->id,
        'name' => $faker->firstName,
        'lastname1' => $faker->lastName,
        'lastname2' => $faker->lastName,
        'email' => $user->email,
        'phone' => $faker->e164PhoneNumber,
        'personal_id_number' => $user->personal_id_number,
        'license_number' => $faker->swiftBicNumber,
        'license_year' => $faker->year($max = 'now'),
        'tutorial_completed' => $tutorial,
    ];
});
