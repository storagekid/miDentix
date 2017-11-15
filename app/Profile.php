<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Especialty;

class Profile extends Model
{
    public function especialties() {
        return $this->belongsToMany(Especialty::class);
    }
}
