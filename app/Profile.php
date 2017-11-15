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
}
