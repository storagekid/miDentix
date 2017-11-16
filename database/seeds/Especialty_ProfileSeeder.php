<?php

use Illuminate\Database\Seeder;

class Especialty_ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$profiles = \App\Profile::all();
		$items = \App\Especialty::all();
		$Selected = [];
		foreach($profiles as $profile) {
			$times = mt_rand(1,3);
			while($times > 0) {
				$item = $items[mt_rand(0,count($items)-1)];
				if (!in_array($item, $Selected)) {
					$Selected[] = $item;
					$profile->especialties()->save($item);
					$times--;
				}
			}
			$Selected = [];
		}
	}
}
