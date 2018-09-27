<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    public function getNameAttribute($value)
    {
        // return ucwords(strtolower($value));
        return mb_convert_case(strtolower($value), MB_CASE_TITLE, 'UTF-8');
    }
}
