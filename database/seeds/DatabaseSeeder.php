<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $profileCSV = true;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StatesSeeder::class,
            CostCentersSeeder::class,
            ClinicsSeeder::class,
            CountriesSeeder::class,
            EspecialtiesSeeder::class,
            MastersSeeder::class,
            ExperiencesSeeder::class,
            MunicipiosSeeder::class,
            CountiesSeeder::class,
            UniversitiesSeeder::class,
            LaboratoriesSeeder::class,
            // UsersSeeder::class,
            Master_UniversitySeeder::class,
            GroupsSeeder::class,
            ProvidersSeeder::class,
            StationariesSeederCSV::class,
            // StationariesSeeder::class,
            ProvidersSeeder::class,
        ]);
        if (!$this->profileCSV) {
            $this->call([
                ProfilesDentistsSeeder::class,
                ProfilesAdminSeeder::class,
                Clinic_ProfileSeeder::class,
                SchedulesSeeder::class,
                Especialty_ScheduleSeeder::class,
                // Especialty_ProfileSeeder::class,
                Experience_ProfileSeeder::class,
                Master_University_ProfileSeeder::class,
                RequestsSeeder::class,
                ExtratimesSeeder::class,
                Especialty_ExtratimeSeeder::class,
                UsersClinicSeeder::class,
            ]);
        } else {
            $this->call([
                ProfileCSVSeeder::class,
                ProfilesAdminSeeder::class,
            ]);
        }
    }
}
