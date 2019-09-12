<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use function GuzzleHttp\json_decode;
use App\Printers\CampaignFacadeDistributionPrinter;

class Clinic extends Qmodel
{
  use SoftDeletes;

  protected $fillable = ['city', 'language_id', 'district', 'nickname', 'postal_code', 'email_ext', 'sanitary_code', 'county_id', 'clinic_manager_id', 'area_manager_id', 'cost_center_id', 'starts_at', 'ends_at'];
  protected static $full = ['county', 'cost_center', 'addresses', 'phones', 'area_manager', 'clinic_manager', 'language'];
  protected static $show = [
    'county',
    'cost_center',
    'addresses',
    'phones',
    'area_manager',
    'clinic_manager',
    'clinic_poster_priorities',
    'poster_distributions'
  ];
  protected $appends = ['label', 'value', 'open', 'active'];
  protected $casts = ['postal_code' => 'string'];
  protected $stationary = [];
  protected static $permissions = [
      'view' => [
        'Marketing' => ['*'],
      ]
  ];
  // Quasar DATA
  protected $relatedTo = ['addresses', 'phones'];

  protected $quasarFormNewLayout = [
      [
          'title' => 'Información',
          'subtitle' => 'General',
          'fields' => [
            ['language_id', 'city', 'district', 'nickname', 'postal_code', 'email_ext', 'sanitary_code', 'county_id', 'starts_at']
          ],
          'relations' => []
      ]
  ];
  protected $quasarFormUpdateLayout = [
      [
          'title' => 'Información',
          'subtitle' => 'General',
          'fields' => [
            ['city', 'district', 'nickname', 'postal_code', 'email_ext', 'sanitary_code', 'county_id', 'starts_at', 'ends_at']
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
      'label' => 'Clínica',
      'filtering' => ['search'],
      'linebreak' => [
        'needles' => ['(', 'esq.'],
        'options' => [
          'small' => true
        ]
      ],
    ],
    'open' => [
      'label' => 'Abierta',
      'filtering' => ['select' => 'clinics'],
    ],
    'active' => [
      'label' => 'Activa',
      'filtering' => ['select' => 'clinics'],
    ],
    'city' => [
      'label' => 'Ciudad',
      'filtering' => ['search'],
    ],
    'district' => [
      'label' => 'Distrito/Zona',
      'filtering' => ['search'],
    ],
    'addresses' => [
      'label' => 'Direcciones',
      'filtering' => ['search'],
    ],
    'phones' => [
      'label' => 'Teléfonos',
      'filtering' => ['search'],
    ],
    'postal_code' => [
      'label' => 'CP',
      'filtering' => ['search'],
    ],
    'language.label' => [
      'label' => 'Language',
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
    'area_manager.full_name' => [
      'label' => 'Área Manager',
      'filtering' => ['search'],
      'show' => false
    ],
    'clinic_manager.full_name' => [
      'label' => 'Clinic Manager',
      'filtering' => ['search'],
      'show' => false
    ],
    'cost_center.name' => [
      'label' => 'Centro de Coste',
      'filtering' => ['search'],
      'show' => false
    ],
    'county.name' => [
      'label' => 'Provincia',
      'filtering' => ['search'],
    ],
    'county.state.name' => [
      'label' => 'CCAA',
      'filtering' => ['search'],
    ],
    'county.state.country.name' => [
      'label' => 'País',
      'filtering' => ['search'],
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
    ],
    // 'actions' => [
    //   'label' => 'Actions'
    // ]
  ];
  protected $tableViews = [
    'PosterDistributionDashBoard' => [
      'nickname' => [
        'label' => 'Clínica',
        'filtering' => ['search'],
      ],
      'deleted_at' => [
        'label' => 'Activa',
        'filtering' => ['select' => 'clinics'],
      ],
      'open' => [
        'label' => 'Abierta',
        'filtering' => ['select' => 'clinics'],
      ],
      'clinic_posters' => [
        'label' => 'Carteles'
      ],
      // 'poster_distributions' => [
      //   'label' => 'Distribuciones'
      // ],
      'clinic_distributions_by_campaign' => [
        'label' => 'Distribuciones'
      ],
      'actions' => [
        'label' => 'Actions'
      ]
    ]
  ];
  protected $tableOptions = [['show','edit','delete'], true, true];
  // END Tableable Data

  public function clinic_posters () {
      return $this->hasMany(ClinicPoster::class);
  }
  public function campaign_facades () {
    return $this->hasMany(ClinicCampaignFacade::class);
  }
  public function clinic_poster_priorities() {
    return $this->hasManyThrough(ClinicPosterPriority::class, ClinicPoster::class);
  }
  public function poster_distributions () {
    return $this->hasMany(ClinicPosterDistribution::class);
}
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

  public function profiles()
  {
      return $this->belongsToMany(Profile::class, 'clinic_profiles');
  }
  public function addresses()
  {
      return $this->morphMany(Address::class, 'addressable');
  }
  public function phones()
  {
      return $this->morphMany(Phone::class, 'phoneable');
  }
  public function schedules() {
    return $this->hasManyThrough(ClinicSchedule::class, ClinicProfile::class);
}

  public function orders()
  {
      return $this->hasMany(Order::class);
  }

  public function clinicStationaries()
  {
      return $this->HasMany(ClinicStationary::class);
  }

  public function stationaries()
  {
      return $this->belongsToMany(Stationary::class)
          ->withPivot(['id', 'file', 'thumbnail']);
  }

  public static function cacheClinics() {
    return Cache::rememberForever('clinics', function() {
      return Clinic::with(['county', 'cost_center'])
                  ->orderBy('city')
                  ->orderBy('address_real_1')
                  ->get()
                  ->each
                  ->append(['countyName', 'state_id', 'stateName', 'country_id', 'countryName', 'costCenterName']);
    });
  }

  public function getClinicPostersCountAttribute () {
    return $this->clinic_posters()->count();
  }

  public function getClinicDistributionsByCampaignAttribute () {
    $activePosters = $this->active_posters;
    // $dists = $this->poster_distributions()->get();
    // $filtered = $dists->filter(function ($i) {
    //   if (!$i->ends_at) {
    //     $design = json_decode($i->distributions, true);
    //     if(count($design['posterIds']) > 0) {
    //       return $i;
    //     }
    //   }
    // });
    $filtered = collect();
    $postersUsed = 0;
    foreach ($this->poster_distributions AS $dist) {
      if ($dist->ends_at) continue;
      $design = json_decode($dist->distributions, true);
      if (count($design['posterIds']) < 1) continue;
      // $dist['distributions_array'] = $design;
      $filtered->add($dist);
      $postersUsed += count($design['posterIds']);
    }
    return $filtered->groupBy('campaign_id');
    if ($postersUsed === count($activePosters)) return $filtered->groupBy('campaign_id');
    return [];
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
    // return 'patata';
    $street = '';
    if ($this->addresses) {
        if (count($this->addresses) > 0) {
            $street = $this->addresses[0]->cleanStreet;
        }
    }
    return $street;
    // $street = str_replace(['C/', 'c/', 'Rúa', 'Pl.', 'Pl ', 'Av.', 'P.º', 'Pg.', 'Rbla.', 'C.º', 'Ctra.', 'Ptge.'], '', $street);
    // $street = str_replace(['s/n', '/'], ['s.n.', '-'], $street);
    // return trim($street);
    // return trim(str_replace(['C/', 'c/', 's/n', '/'], ['', '', 's.n.', '-'], $street));
  }

  public function getCostCenterNameAttribute()
  {
      return $this->cost_center ? $this->cost_center->name : '-';
  }

  public function getCountyNameAttribute()
  {
      return $this->county ? $this->county->name : '-';
  }

  public function getStateIdAttribute()
  {
      return $this->county ? $this->county->state->id : null;
  }
  
  public function getStateNameAttribute()
  {
      return $this->county ? $this->county->state->name : '-';
  }

  public function getCountryIdAttribute()
  {
      return $this->county ? $this->county->state->country->id : null;
  }
  
  public function getCountryNameAttribute()
  {
      return $this->county ? $this->county->state->country->name : '-';
  }

  public function getPostalCodeAttribute($value)
  {
      while (strlen($value) < 5) {
          $value = '0' . $value;
      }
      return $value;
  }
  public function getPostersAttribute()
  {
      return $this->clinic_poster_priorities->load(['clinic_poster' => function($q) { return $q->with(['poster']);}])->groupBy('campaign_id');
  }
  public function getActivePostersAttribute()
  {
      return $this->clinic_posters()->where('ends_at', null)->get();
      // return $this->clinic_posters->filter(function($i) { return !$i->ends_at; });
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

  public function createCampaignFacades() {
    // $campaign = \App\Campaign::findOrDefault(request('campaign'));
    // $pdf = new CampaignFacadeDistributionPrinter($clinic, $campaign);
    // $pdf->makePdf();

    if (request('force') == 'true') {
      // dd('WTF');
      $campaignFacades = $this->campaign_facades()->where('campaign_id', request('campaign'))->first();
      if ($campaignFacades) $campaignFacades->delete();
    }
    $campaign = \App\Campaign::findOrActive(request('campaign'));
    // dd($campaign);
    // $campaign = request('campaign') ? \App\Campaign::with(['sanitary_codes'])->find(request('campaign')) : '';
    $pdf = new CampaignFacadeDistributionPrinter($this, $campaign);
    // $pdf = new FacadeDistributionPrinter($this, $campaign);
    $pdfFile = $pdf->makePdf();

    // $file = $this->original_facade()->first();
    // $path = $file->url;
    // if ($file->is_public) $path = 'public/' . $path;

    // $fileName = $file->getBaseName() . '-facade-complete.pdf';
    // $filePath = $file->path;
    // if ($file->is_public) $filePath = 'public/' . $filePath;
    // $cleanFacade->writeImage(storage_path('app/' . $filePath . '/' . $fileName));
    // $file = $this::storeFile($file->path . '/' . $fileName, $file->path,$fileName,null,1,6,true); // TEST WITH USER AND GROUP HARDCODED
    $path = 'clinics/' . $this->cleanName . '/facadesByCampaign//';
    $file = ClinicCampaignFacade::storeFile($pdfFile->directory . $pdfFile->fileName, $path, $pdfFile->fileName,null,null,null,false,true);
    $completeFacades = $this->campaign_facades()->save(new ClinicCampaignFacade([
        'campaign_id' => $campaign->id,
        'facades_file_id' => $file->id
    ]));
    // $completeFacade->complete_facade_file_id = $file->id;
    $completeFacades->files()->save($file);
    return $completeFacades;
  }
}
