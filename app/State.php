<?php

namespace App;

use App\Country;

class State extends Qmodel
{
    protected $with = ['country'];

    public function country() {
    	return $this->belongsTo(Country::class);
    }
}
