<?php

namespace App;

use App\Country;

class State extends Qmodel
{
    protected $with = ['country'];
    protected static $permissions = [
        'view' => ['*'],
    ];
    
    public function country() {
    	return $this->belongsTo(Country::class);
    }
}
