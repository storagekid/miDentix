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
		$group = \App\Group::where('name','Clinics')->first()->id;

		$profiles = \App\Profile::get();
		foreach ($profiles as $profile) {
			if ($profile->user_id) continue;
			if (!count($profile->clinics)) continue;
			if (count($profile->clinic_schedules)) {
				foreach ($profile->clinic_schedules as $schedule) {
					if ($schedule->job_type_id === 8) {
						if ($profile->clinics[0]->email_ext) {
							$user = \App\User::where('name','subdirector.'.$profile->clinics[0]->email_ext.'@dentix.es')->first();
							
							if (!$user) {
								$user = factory('App\User')->create([
									'name' => 'subdirector.'.$profile->clinics[0]->email_ext.'@dentix.es',
								]);
								$user->groups()->attach($group, ['role' => 'editor']);
							}
							
							$profile->user_id = $user->id;
							$profile->tutorial_completed = 0;
							$profile->save();
						}
					}
					elseif ($schedule->job_type_id == 5) {
						if ($profile->clinics[0]->email_ext) {
							$user = \App\User::where('name','director.'.$profile->clinics[0]->email_ext.'@dentix.es')->first();
							
							if (!$user) {
								$user = factory('App\User')->create([
									'name' => 'director.'.$profile->clinics[0]->email_ext.'@dentix.es',
								]);
								$user->groups()->attach($group, ['role' => 'administrator']);
							}
							
							$profile->user_id = $user->id;
							$profile->tutorial_completed = 0;
							$profile->save();
						}
					}
				}
			}
		}
	}
}
