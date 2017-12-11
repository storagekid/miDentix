<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Profile;

class Especialty extends Model
{
    public function profiles() {
        return $this->belongsToMany(Profile::class);
    }
    public function schedules() {
        return $this->belongsToMany(Schedule::class);
    }
}
