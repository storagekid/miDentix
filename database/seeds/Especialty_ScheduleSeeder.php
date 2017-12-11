<?php

use Illuminate\Database\Seeder;

class Especialty_ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$schedules = \App\Schedule::all();
		$items = \App\Especialty::all();
		$Selected = [];
		foreach($schedules as $schedule) {
			$times = mt_rand(1,3);
			while($times > 0) {
				$item = $items[mt_rand(0,count($items)-1)];
				if (!in_array($item, $Selected)) {
					$Selected[] = $item;
					$schedule->especialties()->save($item);
					$times--;
				}
			}
			$Selected = [];
		}
	}
}
