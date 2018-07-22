<?php

use Illuminate\Database\Seeder;

class ExtratimesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$profiles = \App\Profile::all();
		$states = \App\State::all();
		$counties = \App\County::all();
		$clinics = \App\Clinic::all();
		// $items = \App\Experience::all();
		// $Selected = [];
		foreach($profiles as $profile) {
			if ($profile->user->role == 'admin') break;
			$state_id = null;
			$county_id = null;
			$clinic_id = null;
			$times = mt_rand(0,5);
			while ($times) {
				$state = mt_rand(0,1);
				if ($state) {
					$state_id = mt_rand(1,count($states));
					$county = mt_rand(0,1);
					$selectedPro = [];
					if ($county) {
						foreach ($counties as $county) {
							if ($county->state->id == $state_id) {
								$selectedPro[] = $county->id;
							}
						}
						if (count($selectedPro)) {
							$county_id = $selectedPro[mt_rand(0,count($selectedPro)-1)];
						} else {
							break;
						}
						$clinic = mt_rand(0,1);
						$selectedClinics = [];
						if ($clinic) {
							foreach ($clinics as $clinic) {
								if ($clinic->county->id == $county_id) {
									$selectedClinics[] = $clinic->id;
								}
							}
							if (count($selectedClinics)) {
								$clinic_id = $selectedClinics[mt_rand(0,count($selectedClinics)-1)];
							} else {
								break;
							}
						}
					}
				}
				$schedule = '{"01":{"9":"extra","10":"extra","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"02":{"9":"extra","10":"extra","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"03":{"9":"extra","10":"extra","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"04":{"9":"extra","10":"extra","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"05":{"9":"extra","10":"extra","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"06":{"9":"extra","10":"extra","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"07":{"9":"extra","10":"extra","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null}}';
				factory('App\Extratime')->create([
					'profile_id' => $profile->id,
					'clinic_id' => $clinic_id,
					'county_id' => $county_id,
					'state_id' => $state_id,
					'schedule' => $schedule,
					'state' => mt_rand(0,2),
				]);
				$times--;
			}
		}
	}
}
