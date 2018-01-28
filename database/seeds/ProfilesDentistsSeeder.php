<?php

use Illuminate\Database\Seeder;

class ProfilesDentistsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$group = \App\Group::where('name','Dentists')->first();
		$dentists = factory('App\Profile', 30)->create();
		foreach ($dentists as $dentist) {
			$dentist->user->group()->attach($group);
		}
	}
}
