<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extratime extends Model
{
	protected $fillable = [
        'clinic_id', 'state_id', 'county_id', 'profile_id', 'state', 'schedule',
    ];
    protected $with = ['clinic','county','states','especialties'];

    public function clinic() {
    	return $this->belongsTo(Clinic::class);
    }
    public function county() {
    	return $this->belongsTo(County::class);
    }
    public function states() {
    	return $this->belongsTo(State::class, 'state_id');
    }
    public function profile() {
        return $this->belongsTo(Profile::class);
    }
    public function especialties() {
        return $this->belongsToMany(Especialty::class)->withTimestamps();
    }
}
