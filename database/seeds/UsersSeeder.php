<?php

use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;

class UsersSeeder extends CsvSeeder
{
	public function __construct()
	{
		$this->table = 'users';
		$this->csv_delimiter = ',';
		$this->filename = base_path().'/database/seeds/csvs/users.csv';
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
		// $users = \App\User::all();
		// foreach ($users as $user) {
		// 	factory('App\Profile')->create([
		// 		'user_id' => $user->id,
		// 		'personal_id_number' => $user->personal_id_number,
		// 	]);
		// }
	}
}
