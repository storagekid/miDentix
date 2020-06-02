<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class ClinicCampaignFacadeSeeder extends CsvSeeder
{
    public function __construct()
	{
		$this->table = 'clinic_campaign_facades';
		$this->csv_delimiter = ',';
		$this->filename = base_path().'/database/seeds/csvs/clinic_campaign_facades.csv';
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

		foreach (\App\ClinicCampaignFacade::get() as $clinicCampaignFacade) {
			$f = $clinicCampaignFacade->facades()->first();
			$path = 'clinics/' . $clinicCampaignFacade->clinic->id . '/facadesByCampaign/' . $clinicCampaignFacade->campaign->id;
			$f->renameFile($f->name, $path);
		}

		// $f = App\Clinic::first()->campaign_facades()->first()->facades()->first();
		// // A Coruna (Juana de Vega, 23)-Follow Up-posters.pdf
		// // $name = $f->fileable()->clinic->nickname . '-' . $f->fileable()->campaign->name . '-'
		// // dump($f->fileable);
		// $path = 'clinics/' . $f->fileable->clinic->id . '/facadesByCampaign';
		// $f->renameFile($f->name, $path);
	}
}
