<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Country;

class State extends Model
{
	protected $with = ['country'];

    public function country() {
    	return $this->belongsTo(Country::class);
    }
}
