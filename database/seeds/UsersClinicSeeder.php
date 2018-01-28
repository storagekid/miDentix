<?php

use Illuminate\Database\Seeder;

class UsersClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$clinics = App\Clinic::all();
		$group = \App\Group::where('name','Clinics')->first()->id;
		foreach($clinics as $clinic) {
			if($clinic->email_ext && !$clinic->closed) {
				$user = factory('App\User')->create([
					'email' => 'info@'.$clinic->email_ext.'.es',
				]);
				$user->group()->attach($group);
				$profile = new App\Profile;
				$profile->name = 'Dentix';
				$profile->lastname1 = $clinic->costCenter->name;
				$profile->lastname2 = null;
				$profile->email = $user->email;
				$profile->phone = $clinic->phone_real ? $clinic->phone_real : null;
				$profile->personal_id_number = null;
				$profile->license_number = null;
				$profile->license_year = null;
				$profile->tutorial_completed = 0;
				$profile->user_id = $user->id;
				$profile->save();
				// $user->profile = factory('App\Profile')->create([
				// 	'name' => 'Dentix',
				// 	'lastname1' => $clinic->costCenter->name,
				// 	'lastname2' => null,
				// 	'email' => $user->email,
				// 	'phone' => $clinic->phone_real ? $clinic->phone_real : null,
				// 	'personal_id_number' => null,
				// 	'license_number' => null,
				// 	'license_year' => null,
				// 	'tutorial_completed' => 0,
				// ]);
			}
		}
	}
}
