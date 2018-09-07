<?php

use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;

class ClinicProfileTestsSeeder extends CsvSeeder
{
	public function __construct()
	{
		$this->table = 'clinic_profile';
		$this->csv_delimiter = ',';
		$this->filename = base_path().'/database/seeds/csvs/clinic_profile_tests.csv';
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
		// DB::table($this->table)->truncate();

		parent::run();
	}
}
