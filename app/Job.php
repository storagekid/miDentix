<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function getNameAttribute($value)
    {
        return ucfirst(strtolower($value));
    }
}
