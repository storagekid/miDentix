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

$factory->define(App\Profile::class, function (Faker $faker) {
	$faker = \Faker\Factory::create('es_ES');
    $user = factory('App\User')->create();
    return [
        'user_id' => $user->id,
        'name' => $faker->firstName,
        'lastname1' => $faker->lastName,
        'lastname2' => $faker->lastName,
        'email' => $user->email,
        'phone' => $faker->e164PhoneNumber,
        'personal_id_number' => $faker->swiftBicNumber,
        'license_number' => $faker->swiftBicNumber,
        'license_year' => $faker->year($max = 'now'),
    ];
});
