<?php

use Illuminate\Database\Seeder;

class StationariesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stationary = new \App\Stationary;
        $stationary->name = 'a4sheet';
        $stationary->description = 'Hoja A4';
        $stationary->price = 1;
        $stationary->save();

        $stationary = new \App\Stationary;
        $stationary->name = 'recepi';
        $stationary->description = 'Recetario';
        $stationary->price = 0.5;
        $stationary->save();

        $stationary = new \App\Stationary;
        $stationary->name = 'envelope';
        $stationary->description = 'Sobre Americano 225x115';
        $stationary->price = 0.5;
        $stationary->save();

        $stationary = new \App\Stationary;
        $stationary->name = 'envelopeBig';
        $stationary->description = 'Sobre Bolsa 324x229';
        $stationary->price = 0.5;
        $stationary->save();
    }
}
