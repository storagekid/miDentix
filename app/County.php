<?php

namespace App;


class County extends Qmodel
{
    protected $with = ['state'];

    public function state() {
    	return $this->belongsTo(State::class);
    }
}
