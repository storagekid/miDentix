<?php

use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;
use Carbon\Carbon;

class ProfileCSVSeeder extends CsvSeeder
{
	public function __construct()
	{
		$this->table = 'profiles';
		$this->csv_delimiter = ',';
		$this->filename = base_path().'/database/seeds/csvs/meta4-100.csv';
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
		$profiles = \App\Profile::all();
		foreach ($profiles as $profile) {
			$profile->user_id = factory('App\User')->create([
				'personal_id_number' => $profile->personal_id_number,
			])->id;
			$profile->created_at = Carbon::now();
			$profile->save();
		}
	}
}
