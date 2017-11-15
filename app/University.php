<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Master;

class University extends Model
{
    public function masters() {
        return $this->belongsToMany(Master::class)->withPivot('id');
    }
}
