<?php

use Illuminate\Database\Seeder;

class Master_University_ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$profiles = \App\Profile::all();
		$items = \App\Master_University::all();
		$Selected = [];
		foreach($profiles as $profile) {
			if(!$profile->tutorial_completed) {
				$times = mt_rand(0,3);
				while($times > 0) {
					$item = $items[mt_rand(0,count($items)-1)];
					if (!in_array($item, $Selected)) {
						$Selected[] = $item;
						$profile->masters()->save($item);
						$times--;
					}
				}
				$Selected = [];
			}
		}
	}
}
