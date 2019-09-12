<?php

namespace App;

class ClinicStationary extends Qmodel
{

    protected $table = 'clinic_stationary';
    protected $with = ['stationary'];
    protected static $permissions = [
        'view' => [
          'Marketing' => ['*'],
        ]
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class)->withTrashed();
    }
    public function stationary()
    {
        return $this->belongsTo(Stationary::class);
    }
}
