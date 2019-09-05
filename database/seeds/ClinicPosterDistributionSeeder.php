<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class ClinicPosterDistributionSeeder extends CsvSeeder
{
    public function __construct()
	{
		$this->table = 'clinic_poster_distributions';
		$this->csv_delimiter = ',';
		$this->filename = base_path().'/database/seeds/csvs/clinic_poster_distributions.csv';
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
		// $distributions = \App\ClinicPosterDistribution::get();
		// foreach ($distributions as $distribution) {
		// 	// $file = \App\ClinicPosterDistribution::storeFile($distribution->facade, 'facades/' . $distribution->clinic->nickname,null,true,1,5,true);
		// 	// $distribution->original_facade_file_id = $file->id;
		// 	// $distribution->save();
		// 	// $distribution->files()->save($file);
		// 	$design = json_decode($distribution->distributions);
		// 	if (isset($design->posterIds->{""})) $design->posterIds = $design->posterIds->{""};
		// 	else $design->posterIds = [];
		// 	// dd($design);
		// 	foreach($design->holders as $holder) {
		// 		$holder->ext = $holder->ext->{""};
		// 		$holder->int = $holder->int->{""};
		// 	}
		// 	$stringify = json_encode($design);
		// 	$distribution->distributions = $stringify;
		// 	$distribution->save();
		// 	// dd($stringify);
		// }
	}
}
