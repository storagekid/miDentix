<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Provincia;
use App\CostCenter;

class Clinic extends Model
{
	protected $with = ['provincia'];
    protected $appends = ['fullName','provinciaName','stateName','countryName'];
    protected $casts = ['postal_code'=>'string'];

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
    public function getFullNameAttribute() {
        return $this->city." (".$this->address_real_1.")";
    }
    public function getProvinciaNameAttribute() {
        return $this->provincia->nombre;
    }
    public function getStateNameAttribute() {
        return $this->provincia->state->name;
    }
    public function getCountryNameAttribute() {
        return $this->provincia->state->country->name;
    }
    public function getPostalCodeAttribute($value) {
        while (strlen($value) < 5) {
            $value = '0'.$value;
        }
        return $value;
    }
}
