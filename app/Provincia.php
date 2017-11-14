<?php

namespace App;
use App\State;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
	protected $with = ['state'];

    public function state() {
    	return $this->belongsTo(State::class);
    }
}
