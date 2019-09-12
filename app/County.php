<?php

namespace App;


class County extends Qmodel
{
    protected $with = ['state'];
    protected static $permissions = [
        'view' => ['*']
    ];
    
    public function state() {
    	return $this->belongsTo(State::class);
    }
}
