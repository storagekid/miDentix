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

$factory->define(App\Clinic::class, function (Faker $faker) {
	$faker = \Faker\Factory::create('es_ES');
    return [
        'city' => $faker->word,
        'address_real_1' => $faker->word,
        'address_real_2' => $faker->word,
        'address_adv_1' => $faker->word,
        'address_adv_2' => $faker->word,
        'postal_code' => $faker->word,
        'phone_real' => $faker->word,
        'phone_adv' => $faker->word,
        'email_ext' => $faker->word,
        'sanitary_code' => $faker->word,
        'provincia_id' => 1,
        'clinic-cloud_id' => $faker->word,
    ];
});
