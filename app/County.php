<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $with = ['state'];

    public function state() {
    	return $this->belongsTo(State::class);
    }
}
