<?php

use Illuminate\Database\Seeder;

class Clinic_ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$profiles = \App\Profile::all();
		$clinics = \App\Clinic::all();
		$cSelected = [];
		foreach($profiles as $profile) {
			$times = mt_rand(0,3);
			while($times > 0) {
				$clinic = $clinics[mt_rand(0,count($clinics))];
				if (!in_array($clinic, $cSelected)) {
					$cSelected[] = $clinic;
					$profile->clinics()->save($clinic);
					$times--;
				}
			}
			$cSelected = [];
		}
	}
}
