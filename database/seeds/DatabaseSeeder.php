<?php

use Illuminate\Database\Seeder;
use Keboola\Csv\CsvFile;

class DatabaseSeeder extends Seeder
{
    protected $profileCSV = false;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        	StatesSeeder::class,
        	ClinicsSeeder::class,
        	CountriesSeeder::class,
        	EspecialtiesSeeder::class,
        	MastersSeeder::class,
        	ExperiencesSeeder::class,
        	MunicipiosSeeder::class,
        	ProvinciasSeeder::class,
            UniversitiesSeeder::class,
        	LaboratoriesSeeder::class,
        	// UsersSeeder::class,
            Master_UniversitySeeder::class,
        ]);
        if (!$this->profileCSV) {
            $this->call([
                ProfilesSeeder::class,
                ProfilesAdminSeeder::class,
                Clinic_ProfileSeeder::class,
                SchedulesSeeder::class,
                Especialty_ScheduleSeeder::class,
                // Especialty_ProfileSeeder::class,
                Experience_ProfileSeeder::class,
                Master_University_ProfileSeeder::class,
                RequestsSeeder::class,
                ExtratimesSeeder::class,
            ]);
        } else {
            $this->call([
                ProfileCSVSeeder::class,
                ProfilesAdminSeeder::class,
            ]);
        }
    }
}
