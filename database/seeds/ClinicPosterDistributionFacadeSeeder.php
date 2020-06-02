<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class ClinicPosterDistributionFacadeSeeder extends CsvSeeder
{
    public function __construct()
	{
		$this->table = 'clinic_poster_distribution_facades';
		$this->csv_delimiter = ',';
		$this->filename = base_path().'/database/seeds/csvs/clinic_poster_distribution_facades.csv';
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

		foreach (\App\ClinicPosterDistributionFacade::get() as $clinicDistributionFacade) {
			$f = $clinicDistributionFacade->complete_facade()->first();
			$path = 'clinics/' . $clinicDistributionFacade->clinic_poster_distribution->clinic->id . '/facadesByCampaign/' . $clinicDistributionFacade->campaign->id;
			if ($f) $f->renameFile($f->name, $path);
			else dump($clinicDistributionFacade->id);
			// break;
		}
	}
}
