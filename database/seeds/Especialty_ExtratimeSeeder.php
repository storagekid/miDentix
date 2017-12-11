<?php

use Illuminate\Database\Seeder;

class Especialty_ExtratimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$extratimes = \App\Extratime::all();
		$items = \App\Especialty::all();
		$Selected = [];
		foreach($extratimes as $extratime) {
			$times = mt_rand(1,3);
			while($times > 0) {
				$item = $items[mt_rand(0,count($items)-1)];
				if (!in_array($item, $Selected)) {
					$Selected[] = $item;
					$extratime->especialties()->save($item);
					$times--;
				}
			}
			$Selected = [];
		}
	}
}
