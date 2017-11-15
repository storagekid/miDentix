<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Profile;

class Master_University extends Model
{
	protected $table = 'master_university';
    public function profiles() {
    	return $this->belongsToMany(Profile::class);
    }
}
