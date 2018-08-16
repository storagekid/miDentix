<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Tableable;
use App\Traits\Formable;

class Clinic extends Model
{
  use Tableable;
  use Formable;

  // Tableable DATA
  protected $tableColumns = [
    'fullName' => [
      'label' => 'Clínica',
      'filtering' => ['search'],
      'linebreak' => [
        'needles' => ['(', 'esq.'],
        'options' => [
          'small' => true
        ]
      ],
    ],
    'city' => [
      'label' => 'Ciudad',
      'filtering' => ['search'],
    ],
    'address_real_1' => [
      'label' => 'Dir. Real',
      'filtering' => ['search'],
    ],
    'address_real_2' => [
      'label' => 'Dir. Real 2',
      'filtering' => ['search'],
    ],
    'address_adv_1' => [
      'label' => 'Dir. Comercial',
      'filtering' => ['search'],
    ],
    'address_adv_2' => [
      'label' => 'Dir. Comercial 2',
      'filtering' => ['search'],
    ],
    'postal_code' => [
      'label' => 'CP',
      'filtering' => ['search'],
    ],
    'phone_real' => [
      'label' => 'Tel. Real',
      'filtering' => ['search'],
    ],
    'phone_adv' => [
      'label' => 'Tel. Comercial',
      'filtering' => ['search'],
    ],
    'email_ext' => [
      'label' => 'Email Ext.',
      'filtering' => ['search'],
    ],
    'sanitary_code' => [
      'label' => 'Código Sanitario',
      'filtering' => ['search'],
    ],
    'countyName' => [
      'label' => 'Provincia',
      'filtering' => ['search'],
    ],
    'stateName' => [
      'label' => 'CCAA',
      'filtering' => ['search'],
    ],
    'countryName' => [
      'label' => 'País',
      'filtering' => ['search'],
    ],
  ];
  protected $tableOptions = [['show','edit','delete'], true, true];

  // END Tableable Data

  // Formable DATA
  protected $formFields = [
    'country_id' => [
        'label' =>'Nombre',
        'dontRecord' => true,
        'affects' => 'state_id',
        'type' => [
          'name' =>'select',
          'model' => 'countries',
          'text' =>  'name',
          'value' => 'id',
          'default' => [
            'value' => null,
            'text' => 'Selecciona un País',
            'disabled' => true,
          ],
        ],
    ],
    'state_id' => [
      'label' =>'CCAA',
      'dontRecord' => true,
      'dependsOn' => 'country_id',
      'affects' => 'county_id',
      'type' => [
        'name' =>'select',
        'model' => 'states',
        'text' =>  'name',
        'value' => 'id',
        'default' => [
          'value' => null,
          'text' => 'Selecciona una CCAA',
          'disabled' => true,
        ],
      ],
    ],
    'county_id' => [
      'label' =>'Provincia',
      'rules' => ['required'],
      'dependsOn' => 'state_id',
      'type' => [
        'name' =>'select',
        'model' => 'counties',
        'text' =>  'name',
        'value' => 'id',
        'default' => [
          'value' => null,
          'text' => 'Selecciona una Provincia',
          'disabled' => true,
        ],
      ],
    ],
    'city' => [
      'label' =>'Ciudad/Municipio',
      'rules' => ['required','min:5','max:64'],
    ],
    'address_real_1' => [
      'label' =>'Dirección Real 1',
      'rules' => ['required','min:5','max:255'],
    ],
    'address_real_2' => [
      'label' =>'Dirección Real 2',
      'rules' => ['min:5','max:255'],
    ],
    'address_adv_1' => [
      'label' =>'Dirección Comercial 1',
      'rules' => ['required','min:5','max:255'],
    ],
    'address_adv_2' => [
      'label' =>'Dirección Comercial 2',
      'rules' => ['min:5','max:255'],
    ],
    'phone_real' => [
      'label' =>'Teléfono Real',
      'rules' => ['required', 'min:9','max:12'],
    ],
    'phone_adv' => [
      'label' =>'Teléfono Comercial',
      'rules' => ['min:9','max:12'],
    ],
    'postal_code' => [
      'label' =>'CP',
      'rules' => ['required', 'min:4','max:5'],
    ],
    'sanitary_code' => [
      'label' =>'Código Sanitario',
      'rules' => ['required', 'min:4','max:255'],
      'batch' => true,
    ],
    'email_ext' => [
      'label' =>'Extensión Email',
      'rules' => ['required', 'min:4','max:255'],
    ],
];

protected $formModels = ['countries','counties','states'];

protected $formRelations = [
];

// END Formable DATA

  protected $fillable = ['city', 'address_real_1', 'address_real_2', 'address_adv_1', 'address_adv_2', 'postal_code', 'phone_real', 'phone_adv', 'email_ext', 'sanitary_code', 'county_id'];
  protected $guarded = [];
  protected $with = ['county'];
  protected $appends = ['fullName', 'cleanName', 'countyName', 'stateName', 'countryName'];
  protected $casts = ['postal_code' => 'string'];
  protected $stationary = [];

  public function costCenter()
  {
      return $this->belongsTo(CostCenter::class);
  }

  public function county()
  {
      return $this->belongsTo(County::class);
  }

  public function profiles()
  {
      return $this->belongsToMany(Profile::class);
  }

  public function schedules()
  {
      return $this->HasMany(Schedule::class);
  }

  public function orders()
  {
      return $this->hasMany(Order::class);
  }

  public function stationaries()
  {
      return $this->belongsToMany(Stationary::class)
          ->withPivot(['id', 'file', 'thumbnail']);
  }

  public function setStationaryLinksAttribute()
  {
      $stationary = \App\Stationary::all();
      $dir = 'stationary/';
      $fullName = $this->getFullNameAttribute();
      foreach ($stationary as $item) {
          $file = $item->description . ' ' . $fullName . '.pdf';
          $this->attributes[$item->description] = storage_path('app/' . $dir . $fullName . '/' . $file);
      }
  }

  public function getStationaryFilesUrl()
  {
      $stationary = \App\Stationary::all();
      $dir = 'stationary/';
      $fullName = $this->getFullNameAttribute();
      foreach ($stationary as $item) {
          $file = $item->description . ' ' . $fullName . '.pdf';
          $this->stationary[$item->description] = storage_path('app/' . $dir . $fullName . '/' . $file);
      }
      return $this;
  }

  public function getFullNameAttribute()
  {
      $street = trim(str_replace(['C/', 'c/', 's/n', '/'], ['', '', 's.n.', '-'], $this->address_real_1));
      return $this->city . ' (' . $street . ')';
  }

  public function getCleanNameAttribute() {
    $cleanName = cleanString($this->fullName);
    return $cleanName;
  }

  public function getCountyNameAttribute()
  {
      return $this->county->name;
  }

  public function getStateNameAttribute()
  {
      return $this->county->state->name;
  }

  public function getCountryNameAttribute()
  {
      return $this->county->state->country->name;
  }

  public function getPostalCodeAttribute($value)
  {
      while (strlen($value) < 5) {
          $value = '0' . $value;
      }
      return $value;
  }
}
