<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class MailingDesignStateSeeder extends CsvSeeder
{
    public function __construct()
	{
		$this->table = 'mailing_design_states';
		$this->csv_delimiter = ',';
		$this->filename = base_path().'/database/seeds/csvs/mailing_design_states.csv';
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
