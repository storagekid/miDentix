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
            CountrySeeder::class,
            StateSeeder::class,
            CountySeeder::class,
            CurrencySeeder::class,
            CostCenterSeeder::class,
            // StreetTypeSeeder::class,
            ClinicSeeder::class,
            StandSeeder::class,
            ClinicSiblingSeeder::class,
            CompanySeeder::class,
            StoreSeeder::class,
            JobSeeder::class,
            JobTypeSeeder::class,
            // MunicipioSeeder::class,
            // UsersSeeder::class,
            GroupSeeder::class,
            FileSeeder::class,
            // ProvidersSeeder::class,
            // StationarySeederCSV::class,
            // ClinicStationarySeeder::class,
            // ProductProviderSeeder::class,
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
            MailingSeeder::class,
            MailingDesignSeeder::class,
            MailingDesignPromotionSeeder::class,
            MailingDesignClaimSeeder::class,
            MailingDesignClinicSeeder::class,
            ClinicMailingSeeder::class,
            ClaimSeeder::class,
            PromotionSeeder::class,
            LegalSeeder::class,
            SanitaryCodeSeeder::class,
            ProductSeeder::class,
            ServiceSeeder::class,
            ProviderSeeder::class,
            ProductProviderSeeder::class,
            ServiceProviderSeeder::class,
        ]);
        if (!$this->profileCSV) {
            $this->call([
            ]);
        } else {
            $this->call([
                ProfileSeeder::class,
                ClinicProfileMeta4Seeder::class,
                ClinicScheduleSeeder::class,
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
