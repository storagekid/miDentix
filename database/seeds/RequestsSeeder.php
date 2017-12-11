<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$profiles = \App\Clinic_Profile::all()->load('profile');
		// $items = \App\Experience::all();
		// $Selected = [];
		foreach($profiles as $profile) {
			if ($profile->profile->user->role == 'admin') break;
			$closed = mt_rand(0,1);
			factory('App\Request', mt_rand(0,8))->create([
				'profile_id' => $profile->profile_id,
				'clinic_id' => $profile->clinic_id,
				'closed_at' => $closed ? Carbon::now() : null,
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
