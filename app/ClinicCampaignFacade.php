<?php

namespace App;

use App\Traits\Fileable;

class ClinicCampaignFacade extends Qmodel
{
    use Fileable;

    protected $fillable = ['campaign_id', 'clinic_id', 'facades_file_id'];
    protected static $permissions = [
        'view' => [
          'Marketing' => ['*'],
        ]
    ];

    public function clinic() {
      return $this->belongsTo(Clinic::class);
    }
    public function campaign() {
      return $this->belongsTo(Campaign::class);
    }
}
