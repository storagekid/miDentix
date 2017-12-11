<?php

use Illuminate\Database\Seeder;

class SchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$profiles = \App\Clinic_Profile::all();
		// $items = \App\Experience::all();
		// $Selected = [];
		foreach($profiles as $profile) {
			$schedule = '{"01":{"9":"'.$profile->clinic_id.'","10":"'.$profile->clinic_id.'","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"02":{"9":"'.$profile->clinic_id.'","10":"'.$profile->clinic_id.'","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"03":{"9":"'.$profile->clinic_id.'","10":"'.$profile->clinic_id.'","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"04":{"9":"'.$profile->clinic_id.'","10":"'.$profile->clinic_id.'","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"05":{"9":"'.$profile->clinic_id.'","10":"'.$profile->clinic_id.'","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"06":{"9":"'.$profile->clinic_id.'","10":"'.$profile->clinic_id.'","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"07":{"9":"'.$profile->clinic_id.'","10":"'.$profile->clinic_id.'","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null}}';
			factory('App\Schedule')->create([
				'profile_id' => $profile->profile_id,
				'clinic_id' => $profile->clinic_id,
				'schedule' => $schedule,
			]);
			// $times = mt_rand(0,8);
			// while($times > 0) {
			// 	factory('App\Request')
			// 	$item = $items[mt_rand(0,count($items)-1)];
			// 	if (!in_array($item, $Selected)) {
			// 		$Selected[] = $item;
			// 		$profile->experiences()->save($item);
			// 		$times--;
			// 	}
			// }
			// $Selected = [];
		}
	}
}
