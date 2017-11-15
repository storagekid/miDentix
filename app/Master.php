<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\University;

class Master extends Model
{
    public function universities() {
        return $this->belongsToMany(University::class);
    }
}
