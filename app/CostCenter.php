<?php

namespace App;

class CostCenter extends Qmodel
{
    public function clinics() {
    	return $this->HasMany(Clinic::class)->withTrashed();
    }
}
