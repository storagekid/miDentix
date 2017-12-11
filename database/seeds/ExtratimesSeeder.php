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
		$provincias = \App\Provincia::all();
		$clinics = \App\Clinic::all();
		// $items = \App\Experience::all();
		// $Selected = [];
		foreach($profiles as $profile) {
			if ($profile->user->role == 'admin') break;
			$state_id = null;
			$provincia_id = null;
			$clinic_id = null;
			$times = mt_rand(0,5);
			while ($times) {
				$state = mt_rand(0,1);
				if ($state) {
					$state_id = mt_rand(1,count($states));
					$provincia = mt_rand(0,1);
					$selectedPro = [];
					if ($provincia) {
						foreach ($provincias as $provincia) {
							if ($provincia->state->id == $state_id) {
								$selectedPro[] = $provincia->id;
							}
						}
						if (count($selectedPro)) {
							$provincia_id = $selectedPro[mt_rand(0,count($selectedPro)-1)];
						} else {
							break;
						}
						$clinic = mt_rand(0,1);
						$selectedClinics = [];
						if ($clinic) {
							foreach ($clinics as $clinic) {
								if ($clinic->provincia->id == $provincia_id) {
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
					'provincia_id' => $provincia_id,
					'state_id' => $state_id,
					'schedule' => $schedule,
					'state' => mt_rand(0,2),
				]);
				$times--;
			}
		}
	}
}
