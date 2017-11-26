<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extratime extends Model
{
	protected $fillable = [
        'clinic_id', 'state_id', 'provincia_id', 'profile_id', 'state', 'schedule',
    ];
    protected $with = ['clinic','provincia','states'];

    public function clinic() {
    	return $this->belongsTo(Clinic::class);
    }
    public function provincia() {
    	return $this->belongsTo(Provincia::class);
    }
    public function states() {
    	return $this->belongsTo(State::class, 'state_id');
    }
}