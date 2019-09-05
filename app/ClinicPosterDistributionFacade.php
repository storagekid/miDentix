<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Fileable;

class ClinicPosterDistributionFacade extends Qmodel
{
    use Fileable;

    protected $fillable = ['campaign_id', 'complete_facade_file_id'];
}
