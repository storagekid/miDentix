<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Fileable;

class ClinicPosterDistributionFacade extends Qmodel
{
    use Fileable;

    protected $fillable = ['campaign_id', 'complete_facade_file_id'];
    protected static $permissions = [
        'view' => [
          'Marketing' => ['*'],
        ]
    ];

    public function clinic_poster_distribution() {
      return $this->belongsTo(ClinicPosterDistribution::class);
    }
    public function campaign() {
      return $this->belongsTo(Campaign::class);
    }
}
