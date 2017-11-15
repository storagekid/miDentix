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
    return [
        'user_id' => factory('App\User')->create()->id,
        'name' => $faker->firstName,
        'lastname1' => $faker->lastName,
        'lastname2' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->e164PhoneNumber,
        'personal_id_number' => $faker->swiftBicNumber,
        'license_number' => $faker->swiftBicNumber,
        'license_year' => $faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});
