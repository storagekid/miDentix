<?php

namespace App;
use App\Traits\Scope;

use Illuminate\Database\Eloquent\Model;

class ClinicStationary extends Model
{
    use Scope;

    protected $table = 'clinic_stationary';

    protected $with = ['stationary'];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
    public function stationary()
    {
        return $this->belongsTo(Stationary::class);
    }
}
