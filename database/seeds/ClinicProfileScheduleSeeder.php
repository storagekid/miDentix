<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class ClinicProfileScheduleSeeder extends CsvSeeder
{
    public function __construct()
	{
		$this->table = 'clinic_schedules';
		$this->csv_delimiter = ',';
		$this->filename = base_path().'/database/seeds/csvs/clinic_profile_schedules.csv';
	}
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		// Recommended when importing larger CSVs
		// DB::disableQueryLog();

		// Uncomment the below to wipe the table clean before populating
		DB::table($this->table)->truncate();

		parent::run();

		// $cs = App\ClinicSchedule::get();
		// foreach ($cs as $schedule) {
		// 	$timeTable = [];
		// 	for ($i = 1; $i <= 7; $i++) {
		// 		for ($o = 8; $o <= 22; $o++) {
		// 			if ($o >= 9 && $o <= 14) {
		// 				$timeTable[$i][$o] = $schedule->clinicProfile->clinic_id;
		// 			} else {
		// 				$timeTable[$i][$o] = false;
		// 			}
		// 		}
		// 	}
		// 	$schedule->schedule = $timeTable;
		// 	$schedule->save();
		// }
	}
}
