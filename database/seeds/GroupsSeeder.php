<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$profile = factory('App\Group')->create([
			'name' => 'Administrators',
		]);
		$profile = factory('App\Group')->create([
			'name' => 'Dentists',
		]);
		$profile = factory('App\Group')->create([
			'name' => 'Users',
		]);
		$profile = factory('App\Group')->create([
			'name' => 'RRHH',
		]);
		$profile = factory('App\Group')->create([
			'name' => 'Marketing',
		]);
		$profile = factory('App\Group')->create([
			'name' => 'Clinics',
		]);
	}
}
