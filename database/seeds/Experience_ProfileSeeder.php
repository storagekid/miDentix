<?php

use Illuminate\Database\Seeder;

class Experience_ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$profiles = \App\Profile::all();
		$items = \App\Experience::all();
		$Selected = [];
		foreach($profiles as $profile) {
			if(!$profile->tutorial_completed) {
				$times = mt_rand(1,2);
				while($times > 0) {
					$item = $items[mt_rand(0,count($items)-1)];
					if (!in_array($item, $Selected)) {
						$Selected[] = $item;
						$profile->experiences()->save($item);
						$times--;
					}
				}
				$Selected = [];
			}
		}
	}
}
