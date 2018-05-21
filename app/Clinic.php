<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $with = ['provincia'];
    protected $appends = ['fullName', 'provinciaName', 'stateName', 'countryName'];
    protected $casts = ['postal_code' => 'string'];
    protected $stationary = [];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function schedules()
    {
        return $this->HasMany(Schedule::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function stationaries() {
        return $this->belongsToMany(Stationary::class)
            ->withPivot(['id','file']);
    }
    
    public function setStationaryLinksAttribute() {
        $stationary = \App\Stationary::all();
        $dir = 'stationary/';
        $fullName = $this->getFullNameAttribute();
        foreach ($stationary as $item) {
            $file = $item->description . ' ' . $fullName . '.pdf';
            $this->attributes[$item->description] = storage_path('app/'.$dir . $fullName .'/' . $file);
        }
    }

    public function getStationaryFilesUrl() {
        $stationary = \App\Stationary::all();
        $dir = 'stationary/';
        $fullName = $this->getFullNameAttribute();
        foreach ($stationary as $item) {
            $file = $item->description . ' ' . $fullName . '.pdf';
            $this->stationary[$item->description] = storage_path('app/'.$dir . $fullName .'/' . $file);
        }
        return $this;
        // $links = $stationary->filter(function($item) {
        //     $dir = 'stationary/';
        //     $fullName = $this->getFullNameAttribute();
        //     $file = $item->description . ' ' . $fullName . '.pdf';
        //     $item['url'] = storage_path('app/'.$dir . $fullName .'/' . $file);
        //     return $item;
        // });
        
        // return $links;
    }

    public function getFullNameAttribute()
    {
        $street = trim(str_replace(['C/', 'c/', 's/n', '/'], ['', '', 's.n.', '-'], $this->address_real_1));
        return $this->city . ' (' . $street . ')';
    }

    public function getProvinciaNameAttribute()
    {
        return $this->provincia->nombre;
    }

    public function getStateNameAttribute()
    {
        return $this->provincia->state->name;
    }

    public function getCountryNameAttribute()
    {
        return $this->provincia->state->country->name;
    }

    public function getPostalCodeAttribute($value)
    {
        while (strlen($value) < 5) {
            $value = '0' . $value;
        }
        return $value;
    }
}
