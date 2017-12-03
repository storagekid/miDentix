<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Clinic;
use App\Profile;

class Request extends Model
{
    protected $fillable = ['profile_id','clinic_id','type','type_detail1','description','closed_at'];
    protected $with = ['clinic'];
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
    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }
    public function profile() {
        return $this->belongsTo(Profile::class);
    }
}
