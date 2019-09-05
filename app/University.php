<?php

namespace App;

use App\Master;

class University extends Qmodel
{
    public function masters() {
        return $this->belongsToMany(Master::class)->withPivot('id');
    }
}
