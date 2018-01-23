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
		// $profiles = \App\Clinic_Profile::all();
		// foreach($profiles as $profile) {
		// 	$i = 1;
		// 	$id = $i == 1 ? $profile->clinic_id : 'null';
		// 	$schedule = '{"01":{"9":"'.$id.'","10":"'.$profile->clinic_id.'","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"02":{"9":"'.$profile->clinic_id.'","10":"'.$profile->clinic_id.'","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"03":{"9":"'.$profile->clinic_id.'","10":"'.$profile->clinic_id.'","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"04":{"9":"'.$profile->clinic_id.'","10":"'.$profile->clinic_id.'","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"05":{"9":"'.$profile->clinic_id.'","10":"'.$profile->clinic_id.'","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"06":{"9":"'.$profile->clinic_id.'","10":"'.$profile->clinic_id.'","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null},"07":{"9":"'.$profile->clinic_id.'","10":"'.$profile->clinic_id.'","11":null,"12":null,"13":null,"14":null,"15":null,"16":null,"17":null,"18":null,"19":null,"20":null}}';
		// 	factory('App\Schedule')->create([
		// 		'profile_id' => $profile->profile_id,
		// 		'clinic_id' => $profile->clinic_id,
		// 		'schedule' => $schedule,
		// 	]);
		$items = \App\Profile::all();
		for ($i = 0; $i < 10; $i++) {
			$ids[$i] = "null";
		}
		foreach($items as $item) {
			$profiles = \App\Clinic_Profile::where('profile_id',$item->id)->get();
			for($o = 0; $o < count($profiles); $o++) {
				$ids[$o] = (string)$profiles[$o]->clinic_id;
				$schedule = '{"01":{"9":'.$ids[0].',"10":'.$ids[0].',"11":'.$ids[1].',"12":'.$ids[1].',"13":'.$ids[2].',"14":'.$ids[4].',"15":'.$ids[5].',"16":'.$ids[5].',"17":'.$ids[6].',"18":'.$ids[6].',"19":'.$ids[7].',"20":'.$ids[8].'},"02":{"9":'.$ids[0].',"10":'.$ids[0].',"11":'.$ids[1].',"12":'.$ids[1].',"13":'.$ids[2].',"14":'.$ids[4].',"15":'.$ids[5].',"16":'.$ids[5].',"17":'.$ids[6].',"18":'.$ids[6].',"19":'.$ids[7].',"20":'.$ids[8].'},"03":{"9":'.$ids[0].',"10":'.$ids[0].',"11":'.$ids[1].',"12":'.$ids[1].',"13":'.$ids[2].',"14":'.$ids[4].',"15":'.$ids[5].',"16":'.$ids[5].',"17":'.$ids[6].',"18":'.$ids[6].',"19":'.$ids[7].',"20":'.$ids[8].'},"04":{"9":'.$ids[0].',"10":'.$ids[0].',"11":'.$ids[1].',"12":'.$ids[1].',"13":'.$ids[2].',"14":'.$ids[4].',"15":'.$ids[5].',"16":'.$ids[5].',"17":'.$ids[6].',"18":'.$ids[6].',"19":'.$ids[7].',"20":'.$ids[8].'},"05":{"9":'.$ids[0].',"10":'.$ids[0].',"11":'.$ids[1].',"12":'.$ids[1].',"13":'.$ids[2].',"14":'.$ids[4].',"15":'.$ids[5].',"16":'.$ids[5].',"17":'.$ids[6].',"18":'.$ids[6].',"19":'.$ids[7].',"20":'.$ids[8].'},"06":{"9":'.$ids[0].',"10":'.$ids[0].',"11":'.$ids[1].',"12":'.$ids[1].',"13":'.$ids[2].',"14":'.$ids[4].',"15":'.$ids[5].',"16":'.$ids[5].',"17":'.$ids[6].',"18":'.$ids[6].',"19":'.$ids[7].',"20":'.$ids[8].'},"07":{"9":'.$ids[0].',"10":'.$ids[0].',"11":'.$ids[1].',"12":'.$ids[1].',"13":'.$ids[2].',"14":'.$ids[4].',"15":'.$ids[5].',"16":'.$ids[5].',"17":'.$ids[6].',"18":'.$ids[6].',"19":'.$ids[7].',"20":'.$ids[8].'}}';
				factory('App\Schedule')->create([
					'profile_id' => $profiles[$o]->profile_id,
					'clinic_id' => $profiles[$o]->clinic_id,
					'schedule' => $schedule,
				]);
				$ids[$o] = "null";
			}
		}
	}
}
