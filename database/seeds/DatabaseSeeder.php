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
            MenuSeeder::class,
            MenuItemSeeder::class,
            MenuItemGroupSeeder::class,
            LanguageSeeder::class,
            StateSeeder::class,
            CostCenterSeeder::class,
            // StreetTypeSeeder::class,
            ClinicSeeder::class,
            CompanySeeder::class,
            StoreSeeder::class,
            CountrySeeder::class,
            JobSeeder::class,
            JobTypeSeeder::class,
            // EspecialtiesSeeder::class,
            // MastersSeeder::class,
            // ExperiencesSeeder::class,
            // MunicipioSeeder::class,
            CountySeeder::class,
            // UniversitySeeder::class,
            // LaboratoriesSeeder::class,
            // UsersSeeder::class,
            // Master_UniversitySeeder::class,
            GroupSeeder::class,
            ProvidersSeeder::class,
            FileSeeder::class,
            StationarySeederCSV::class,
            ClinicStationarySeeder::class,
            ProductProviderSeeder::class,
            CampaignSeeder::class,
            PosterSeeder::class,
            PosterModelSeeder::class,
            CampaignPosterSeeder::class,
            CampaignPosterPrioritySeeder::class,
            ClinicPosterSeeder::class,
            ClinicPosterPrioritySeeder::class,
            ClinicPosterDistributionSeeder::class,
            ClinicPosterDistributionFacadeSeeder::class,
            ClinicCampaignFacadeSeeder::class,
            SanitaryCodeSeeder::class,
        ]);
        if (!$this->profileCSV) {
            $this->call([
                // ProfilesDentistsSeeder::class,
                // ProfilesAdminSeeder::class,
                // SchedulesSeeder::class,
                // Especialty_ScheduleSeeder::class,
                // Especialty_ProfileSeeder::class,
                // Experience_ProfileSeeder::class,
                // Master_University_ProfileSeeder::class,
                // RequestsSeeder::class,
                // ExtratimesSeeder::class,
                // Especialty_ExtratimeSeeder::class,
            ]);
        } else {
            $this->call([
                ProfileSeeder::class,
                ClinicProfileMeta4Seeder::class,
                ClinicProfileScheduleSeeder::class,
                // ClinicProfileTestsSeeder::class,
                // ProfilesAdminSeeder::class,
                AddressSeeder::class,
                PhoneSeeder::class,
                EmailSeeder::class,
                UserSeeder::class,
                GroupUserCSVSeeder::class,
                // UsersClinicSeeder::class, // Creación de Usuario para Directores y Subdirectores
            ]);
        }
    }
}
