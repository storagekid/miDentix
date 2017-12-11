<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
	protected $fillable = [
        'clinic_id', 'profile_id', 'schedule',
    ];
    protected $with = ['especialties'];

    public function profile() {
    	return $this->belongsTo(Profile::class);
    }
    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }
    public function especialties() {
    	return $this->belongsToMany(Especialty::class)->withTimestamps();
    }
}
