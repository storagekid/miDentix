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
		$items = \App\Clinic::all();
		$Selected = [];
		foreach($profiles as $profile) {
			if(!$profile->tutorial_completed) {
				$times = mt_rand(1,3);
				while($times > 0) {
					$item = $items[mt_rand(0,count($items)-1)];
					if (!in_array($item, $Selected)) {
						$Selected[] = $item;
						$profile->clinics()->save($item);
						$times--;
					}
				}
				$Selected = [];
			}
		}
	}
}
