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
		$profile = factory('App\Profile')->create([
			'email' => 'jgvillalba@dentix.es',
			'personal_id_number' => '50459500F',
			'name' => 'Juan Gabriel',
			'lastname1' => 'Villalba',
		]);
		$user = $profile->user;
		$user->email = $profile->email;
		$user->personal_id_number = $profile->personal_id_number;
		$user->password = Hash::make('Migabinete%01');
		$user->role = 'admin';
		$user->save();
	}
}
