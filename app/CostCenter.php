<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    public function clinics() {
    	return $this->HasMany(Clinic::class);
    }
}
