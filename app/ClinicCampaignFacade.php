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
}
