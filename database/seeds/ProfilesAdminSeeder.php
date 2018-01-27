<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProfilesAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$group = \App\Group::where('name','Administrators')->first()->id;
		$profile = factory('App\Profile')->create([
			'email' => 'jgvillalba@dentix.es',
			'personal_id_number' => '50459500F',
			'name' => 'Juan Gabriel',
			'lastname1' => 'Villalba',
		]);
		$user = $profile->user;
		$user->email = $profile->email;
		$user->password = Hash::make('Migabinete01');
		$user->role = 'root';
		$user->group_id = $group;
		$user->save();
		$profile = factory('App\Profile')->create([
			'email' => 'ralvarado@dentix.es',
			'name' => 'Rafael',
			'lastname1' => 'Alvarado',
		]);
		$user = $profile->user;
		$user->email = $profile->email;
		$user->password = Hash::make('Migabinete01');
		$user->role = 'admin';
		$user->group_id = $group;
		$user->save();
		$profile = factory('App\Profile')->create([
			'email' => 'dhernandez@dentix.es',
			'name' => 'Diego',
			'lastname1' => 'Hernández',
		]);
		$user = $profile->user;
		$user->email = $profile->email;
		$user->password = Hash::make('Migabinete01');
		$user->role = 'admin';
		$user->group_id = $group;
		$user->save();
	}
}
