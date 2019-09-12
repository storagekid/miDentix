<?php

namespace App;

class CostCenter extends Qmodel
{
    protected static $permissions = [
        'view' => [
          'Marketing' => ['*'],
        ]
    ];
    
    public function clinics() {
    	return $this->HasMany(Clinic::class)->withTrashed();
    }
}
