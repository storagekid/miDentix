<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Especialty;
use App\Experience;

class Profile extends Model
{
    public function especialties() {
        return $this->belongsToMany(Especialty::class);
    }
    public function experiences() {
        return $this->belongsToMany(Experience::class);
    }
    public function masters() {
    	return $this
    		->belongsToMany(
    			Master_University::class,
    			'master_university_profile',
    			'profile_id',
    			'master_university_id'
    		);
    }
    public function clinics() {
        return $this->belongsToMany(Clinic::class);
    }
    public function schedules() {
        return $this->hasMany(Schedule::class);
    }
    public function requests() {
        return $this->hasMany(Request::class);
    }
    public function extratimes() {
        return $this->hasMany(Extratime::class);
    }
}
