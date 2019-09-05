<?php

use Illuminate\Database\Seeder;

class StreetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		$types = ['Calle' => 'C/', 'Plaza' => 'Pl.', 'Paseo' => 'P.º', 'Avenida' => 'Avda.', 'Camino' => 'C.º', 'Corredera' => 'Corredera', 'Carretera' => 'Ctra.', 'Bulevar' => 'Blvr.', 'Vía' => 'Vía', 'Gran Vía' => 'Gran Vía', 'Rúa' => 'Rúa', 'Passeig' => 'Pg.', 'Rambla' => 'Rbla.', 'Pujada' => 'Pujada', 'Racó' => 'Racó', 'Ronda' => 'Rda.', 'Kalea' => 'Kalea', 'Ibilbidea' => 'Ibilbidea'];
		foreach ($types as $type => $short) {
			App\StreetType::create(['name' => $type, 'short_name' => $short, 'language_id' => 1]);
		}
	}
}
