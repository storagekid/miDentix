<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class MailingSeeder extends CsvSeeder
{
    public function __construct()
	{
		$this->table = 'mailings';
		$this->csv_delimiter = ',';
		$this->filename = base_path().'/database/seeds/csvs/mailings.csv';
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
