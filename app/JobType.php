<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    public function getNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }
}
