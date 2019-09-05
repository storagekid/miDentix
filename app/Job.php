<?php

namespace App;


class Job extends Qmodel
{

    public function getNameAttribute($value)
    {
        return ucfirst(strtolower($value));
    }
}
