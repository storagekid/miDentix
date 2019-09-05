<?php

namespace App;


class JobType extends Qmodel
{
    
    public function getNameAttribute($value)
    {
        $upperCaseNames = ['psi'];
        if (in_array(strtolower($value), $upperCaseNames)) {
            return strtoupper($value);
        }
            // return ucwords(strtolower($value));
        return mb_convert_case(strtolower($value), MB_CASE_TITLE, 'UTF-8');
    }

}
