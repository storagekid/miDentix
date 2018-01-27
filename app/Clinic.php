<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Provincia;
use App\CostCenter;

class Clinic extends Model
{
	protected $with = ['provincia'];

	public function costCenter() {
        return $this->belongsTo(CostCenter::class);
    }
    public function provincia() {
    	return $this->belongsTo(Provincia::class);
    }
    public function profiles() {
    	return $this->belongsToMany(Profile::class);
    }
    public function schedules() {
    	return $this->HasMany(Schedule::class);
    }
}
