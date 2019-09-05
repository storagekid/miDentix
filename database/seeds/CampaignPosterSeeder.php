<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class CampaignPosterSeeder extends CsvSeeder
{
    public function __construct()
	{
		$this->table = 'campaign_posters';
		$this->csv_delimiter = ',';
		$this->filename = base_path().'/database/seeds/csvs/campaign_posters.csv';
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
