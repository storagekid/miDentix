<?php

use Illuminate\Database\Seeder;
use Keboola\Csv\CsvFile;

class DatabaseSeeder extends Seeder
{
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
        	UsersSeeder::class,
        ]);
    }
}
