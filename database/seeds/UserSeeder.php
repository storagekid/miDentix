<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class UserSeeder extends CsvSeeder
{
	public function __construct()
	{
			$this->table = 'users';
			$this->csv_delimiter = ',';
			$this->filename = base_path() . '/database/seeds/csvs/users_short.csv';
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
			
			$users = App\User::get();
        foreach ($users as $user) {
            $user->password = bcrypt('Migabinete01');
            $user->save();
        }
	}
}
