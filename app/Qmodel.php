<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Quasarable;
use App\Traits\Tableable;
use App\Traits\Scope;

class Qmodel extends Model
{
    use Quasarable, Tableable, Scope;

    // Quasar DATA
    // protected $relatedTo = array();
    // protected $onRelationMode = array();
    // protected $quasarFormNewLayout = array();
    // protected $quasarFormUpdateLayout = array();
    // protected $quasarFormFields = array();
    // protected $listFields = array();
    // protected $keyField = 'id';
    protected $appends = ['label', 'value'];
    protected $permissions = [];
    // END Quasar DATA

    // Tableable DATA
    // protected $tableColumns = array();
    // protected $tableViews = array();
    // protected $tableOptions = [['show','edit','delete'], true, true];
    // END Tableable Data

    // protected static $full = array();
    // protected static $show = array();

    public function getShowView($view=null) {
      $views = [
        'distributions' => [
          'county',
          'costCenter',
          'addresses',
          'phones',
          'area_manager',
          'clinic_manager',
          'clinic_poster_priorities',
          'poster_distributions' => function ($q) { return $q->with(['original_facade', 'complete_facades']); }
        ],
        'default' => static::$show ? static::$show : []
      ];
      if (!$view) $view = 'default';
      else if (!array_key_exists($view, $views)) $view = 'default';
      return $views[$view];
    }
}
