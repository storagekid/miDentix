<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic_Profile extends Model
{
	protected $fillable = [
        'profile_id', 'clinic_id'
    ];
    protected $table = 'clinic_profile';

    public function profiles() {
    	return $this->belongsToMany(Profile::class);
    }
}
