<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    public $types = [
    	'Gestión de Clínica',
    	'Relacciones Equipo Médico',
    	'Relacciones Equipo Gestión',
    	'Nóminas',
    	'Laboratorio'
    ];
    public $type_details1 = [
    	[
	   		'Agendas',
	   		'Auxiliares',
	   		'Materiales'
    	],
    ];
}
