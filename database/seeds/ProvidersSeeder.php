<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
        DB::table('providers')->truncate();
        
        $provider = new \App\Provider;
        $provider->name = "GesArtes Gráficas";
        $provider->email = 'fernando@ges-artes.com';
        $provider->address = 'C/ Ficticia, 1';
        $provider->phone = '91 467 82 98';
        $provider->CIF = 'B82476302';
        $provider->save();
        
        $provider = new \App\Provider;
        $provider->name = "Litografia San José";
        $provider->email = 'info@litografiasanjose.com';
        $provider->address = 'C/ Pintor, nave 12';
        $provider->phone = '928 337 325';
        $provider->CIF = 'B82476302';
        $provider->save();

        $provider = new \App\Provider;
        $provider->name = "Rotulos Identidad";
        $provider->email = 'info@rotulosidentidad.com';
        $provider->address = 'C/ Pintor, nave 12';
        $provider->phone = '928 337 325';
        $provider->CIF = 'B82476302';
        $provider->save();
	}
}
