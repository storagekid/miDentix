<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stand extends Qmodel
{
    use SoftDeletes;

  protected $fillable = ['city', 'language_id', 'district', 'nickname', 'postal_code', 'email_ext', 'sanitary_code', 'county_id', 'clinic_manager_id', 'area_manager_id', 'clinic_cloud_id', 'oracle_id', 'cost_center_id', 'starts_at', 'ends_at'];
  protected static $full = ['county', 'cost_center', 'addresses', 'phones', 'area_manager', 'clinic_manager', 'language'];
  protected $appends = ['label', 'value', 'open', 'active'];
  protected $casts = ['postal_code' => 'string'];
  protected static $permissions = [
      'view' => [
        'Marketing' => ['*'],
      ]
  ];
  public static $cascade = ['addresses', 'phones'];
  // Quasar DATA
  protected $relatedTo = ['addresses', 'phones'];

  protected $quasarFormNewLayout = [
      [
          'title' => 'Información',
          'subtitle' => 'General',
          'fields' => [
            ['language_id', 'city', 'district', 'nickname', 'postal_code', 'email_ext', 'sanitary_code', 'county_id', 'starts_at', 'clinic_cloud_id', 'oracle_id',]
          ],
          'relations' => []
      ]
  ];
  protected $quasarFormUpdateLayout = [
      [
          'title' => 'Información',
          'subtitle' => 'General',
          'fields' => [
            ['language_id', 'city', 'district', 'nickname', 'postal_code', 'email_ext', 'sanitary_code', 'county_id', 'starts_at', 'ends_at', 'clinic_cloud_id', 'oracle_id',]
          ],
          'relations' => []
      ],
      [
          'title' => 'Direcciones / Teléfonos',
          'icon' => 'directions',
          'fields' => [],
          'relations' => ['addresses', 'phones']
      ],
      [
          'title' => 'Managers',
          'icon' => 'supervisor_account',
          'fields' => [
              ['clinic_manager_id', 'area_manager_id']
          ],
      ]
  ];
  protected $quasarFormFields = [
    'county_id' => [
      'label' =>'Provincia',
      'type' => [
        'name' =>'select',
        'model' => 'counties',
        'text' =>  'name',
        'value' => 'id',
        'default' => [
          'text' => 'Selecciona una Provincia',
        ],
      ],
    ],
    'language_id' => [
      'label' =>'Language',
      'type' => [
          'name' =>'select',
          'model' => 'languages',
          'default' => [
              'text' => 'Selecciona un Idioma',
          ],
      ],
    ],
    'city' => [
      'label' =>'Ciudad/Municipio',
    ],
    'district' => [
      'label' =>'Distrito',
    ],
    'nickname' => [
      'label' =>'Apodo',
    ],
    'postal_code' => [
      'label' =>'CP',
    ],
    'sanitary_code' => [
      'label' =>'Código Sanitario',
      'batch' => true,
    ],
    'email_ext' => [
      'label' =>'Extensión Email',
    ],
    'clinic_cloud_id' => [
      'label' =>'Clinic Cloud ID',
    ],
    'oracle_id' => [
      'label' =>'Oracle ID',
    ],
    'clinic_manager_id' => [
      'label' =>'C. Manager',
      'type' => [
        'name' =>'select',
        'model' => 'profiles',
        'scope' => true,
        'text' =>  'name',
        'value' => 'id',
        'default' => [
          'text' => 'Selecciona un Clinic Manager',
        ],
      ],
    ],
    'area_manager_id' => [
      'label' =>'A. Manager',
      'type' => [
        'name' =>'select',
        'model' => 'profiles',
        'scope' => true,
        'text' =>  'name',
        'value' => 'id',
        'default' => [
          'text' => 'Selecciona un Área Manager',
        ],
      ],
    ],
    'cost_center_id' => [
      'label' =>'Centro de Coste',
      'type' => [
        'name' =>'select',
        'model' => 'cost_centers',
        'text' =>  'name',
        'value' => 'id',
        'default' => [
          'text' => 'Selecciona un Centro de Coste',
        ],
      ],
    ],
    'starts_at' => [
      'label' =>'Fecha Inicio',
      'batch' => true,
      'type' => [
          'name' => 'date',
      ],
    ],
    'ends_at' => [
        'label' =>'Fecha Fin',
        'batch' => true,
        'type' => [
            'name' => 'date',
        ]
    ]
  ];
  protected $listFields = [
      'left' => [
          'city' => ['chips'],
      ],
      'main' => [
          'address_real_1' => ['text'],
          'address_real_2' => ['text'],
      ],
      'right' => [
          'county_id' => ['text'],
      ],
  ];
  protected $keyField = 'nickname';
  // END Quasar DATA

  // Tableable DATA
  protected $tableColumns = [
    'nickname' => [
      'label' => 'Stand',
      'linebreak' => [
        'needles' => ['(', 'esq.'],
        'options' => [
          'small' => true
        ]
      ],
    ],
    'open' => [
      'label' => 'Abierto'
    ],
    'active' => [
      'label' => 'Activo'
    ],
    'city' => [
      'label' => 'Ciudad',
    ],
    'district' => [
      'label' => 'Distrito/Zona',
    ],
    'addresses' => [
      'label' => 'Direcciones',
    ],
    'phones' => [
      'label' => 'Teléfonos',
    ],
    'postal_code' => [
      'label' => 'CP',
    ],
    'language.label' => [
      'label' => 'Language',
    ],
    'email_ext' => [
      'label' => 'Email Ext.',
    ],
    'sanitary_code' => [
      'label' => 'Código Sanitario',
    ],
    'area_manager.full_name' => [
      'label' => 'Área Manager',
      'show' => false
    ],
    'clinic_manager.full_name' => [
      'label' => 'Clinic Manager',
      'show' => false
    ],
    'clinic_cloud_id' => [
      'label' => 'Clinic Cloud ID',
      'show' => false
    ],
    'oracle_id' => [
      'label' => 'Oracle ID',
      'show' => false
    ],
    'cost_center.name' => [
      'label' => 'Centro de Coste',
      'show' => false
    ],
    'county.name' => [
      'label' => 'Provincia',
    ],
    'county.state.name' => [
      'label' => 'CCAA',
    ],
    'county.state.country.name' => [
      'label' => 'País',
      'show' => false
    ],
    'starts_at' => [
      'label' => 'Fecha Inicio',
    ],
    'ends_at' => [
        'label' => 'Fecha Fin',
    ],
    'created_at' => [
      'label' => 'Creado',
    ],
    'updated_at' => [
        'label' => 'Modificado',
    ],
    'deleted_at' => [
        'label' => 'Eliminado',
    ]
  ];
  // END Tableable Data
  // Model Views
  // END Model Views

  public function cost_center()
  {
      return $this->belongsTo(CostCenter::class);
  }
  public function language() {
    return $this->belongsTo(Language::class);
  }
  public function county()
  {
      return $this->belongsTo(County::class);
  }

  public function area_manager()
  {
      return $this->belongsTo(Profile::class, 'area_manager_id');
  }

  public function clinic_manager()
  {
      return $this->belongsTo(Profile::class, 'clinic_manager_id');
  }

  public function addresses()
  {
      return $this->morphMany(Address::class, 'addressable');
  }
  public function phones()
  {
      return $this->morphMany(Phone::class, 'phoneable');
  }

  public function getFullNameAttribute()
  {
      $street = $this->cleanStreet;
      if ($street === '') $street = '#' . $this->id;
      return $this->city . ' (' . $street . ')';
  }

  public function getCleanNameAttribute() {
    $cleanName = cleanString($this->fullName);
    return $cleanName;
  }

  public function getCleanStreetAttribute() {
    $street = '';
    if ($this->addresses) if (count($this->addresses) > 0) $street = $this->addresses[0]->cleanStreet;
    return $street;
  }

  public function getPostalCodeAttribute($value)
  {
      while (strlen($value) < 5) {
          $value = '0' . $value;
      }
      return $value;
  }
  
  public function getOpenAttribute()
  {
      if (!$this->ends_at) return true;
      return (Carbon::parse($this->ends_at))->greaterThan(Carbon::now());
  }
  public function getActiveAttribute()
  {
    return (!$this->deleted_at);
  }

  // MUTATORS
  public function setNicknameAttribute($value) {
    if ($value === null) $this->attributes['nickname'] = $this->fullName;
    else $this->attributes['nickname'] = $value;
  }
  // END MUTATORS
}
