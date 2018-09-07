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
		// $clinics = App\Clinic::all();
		$group = \App\Group::where('name','Clinics')->first()->id;
		$profiles = \App\Profile::get();
		foreach ($profiles as $profile) {
			if ($profile->job_type_id == 3) {
				// var_dump($profile);
				if (count($profile->clinics)) {
					// var_dump($profile->clinics);
					if ($profile->clinics[0]->email_ext) {
						$user = \App\User::where('email','info.'.$profile->clinics[0]->email_ext.'@dentix.es')->first();
						
						if (!$user) {
							$user = factory('App\User')->create([
								'email' => 'info.'.$profile->clinics[0]->email_ext.'@dentix.es',
							]);
							$user->group()->attach($group);
						}
						
						$profile->user_id = $user->id;
						$profile->tutorial_completed = 0;
						$profile->save();
					}
				}
			}
		}
		// foreach($clinics as $clinic) {
		// 	if($clinic->email_ext && !$clinic->closed) {
		// 		$user = factory('App\User')->create([
		// 			'email' => 'info@'.$clinic->email_ext.'.es',
		// 		]);
		// 		$user->group()->attach($group);
		// 		$profile = new App\Profile;
		// 		$profile->name = 'Recepción Dentix';
		// 		$profile->lastname1 = $clinic->fullName;
		// 		$profile->lastname2 = null;
		// 		$profile->email = $user->email;
		// 		$profile->phone = $clinic->phone_real ? $clinic->phone_real : null;
		// 		$profile->personal_id_number = null;
		// 		$profile->license_number = null;
		// 		$profile->license_year = null;
		// 		$profile->tutorial_completed = 0;
		// 		$profile->user_id = $user->id;
		// 		$profile->save();
		// 		$profile->clinics()->save($clinic);
		// 	}
		// }
	}
}
