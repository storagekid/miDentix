<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Provincia;

class Clinic extends Model
{
	protected $with = ['provincia'];
	
    public function provincia() {
    	return $this->belongsTo(Provincia::class);
    }
    public function profiles() {
    	return $this->belongsToMany(Profile::class);
    }
}
