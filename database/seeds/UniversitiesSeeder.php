<?php

use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;

class UniversitiesSeeder extends CsvSeeder
{
	public function __construct()
	{
		$this->table = 'universities';
		$this->csv_delimiter = ',';
		$this->filename = base_path().'/database/seeds/csvs/universities.csv';
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
	}
}
