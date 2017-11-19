<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
	protected $fillable = [
        'clinic_id', 'profile_id', 'schedule',
    ];

    public function profiles() {
    	return $this->belongsToMany(Profile::class);
    }
}
