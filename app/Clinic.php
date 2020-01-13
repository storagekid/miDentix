<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use function GuzzleHttp\json_decode;
use App\Printers\CampaignFacadeDistributionPrinter;

class Clinic extends Qmodel
{
  use SoftDeletes;

  protected $fillable = ['city', 'language_id', 'district', 'nickname', 'postal_code', 'email_ext', 'sanitary_code', 'county_id', 'parent_id', 'clinic_manager_id', 'area_manager_id', 'clinic_cloud_id', 'oracle_id', 'cost_center_id', 'starts_at', 'ends_at'];
  protected static $full = ['county', 'cost_center', 'clinic_siblings', 'addresses', 'phones', 'area_manager', 'clinic_manager', 'language', 'parent', 'children'];
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
  protected static $permissions = [
      'view' => [
        'Marketing' => ['*'],
        'Clinics' => ['*'],
      ]
  ];
  public static $cascade = ['addresses', 'phones'];
  // Quasar DATA
  protected $relatedTo = ['addresses', 'phones', 'clinic_siblings'];

  protected $quasarFormNewLayout = [
      [
          'title' => 'Información',
          'subtitle' => 'General',
          'fields' => [
            ['language_id', 'city', 'district', 'nickname', 'postal_code', 'email_ext', 'sanitary_code', 'county_id', 'parent_id', 'starts_at', 'clinic_cloud_id', 'oracle_id',]
          ],
          'relations' => []
      ]
  ];
  protected $quasarFormUpdateLayout = [
      [
          'title' => 'Información',
          'subtitle' => 'General',
          'fields' => [
            ['language_id', 'city', 'district', 'nickname', 'postal_code', 'email_ext', 'sanitary_code', 'county_id', 'parent_id', 'starts_at', 'ends_at', 'clinic_cloud_id', 'oracle_id',]
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
        'title' => 'Hermanas',
        'icon' => 'device_hub',
        'fields' => [],
        'relations' => ['clinic_siblings']
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
    'parent_id' => [
        'label' =>'Pertenece a la Clínica',
        'type' => [
            'name' =>'select',
            'model' => 'clinics',
            'hasFamily' => true,
            'text' =>  'nickname',
            'value' => 'id',
            'default' => [
                'text' => 'Selecciona una Clínica Madre',
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
    'parent.nickname' => [
      'label' => 'Pertenece a',
    ],
    'clinic_siblings' => [
      'label' => 'Hermanas',
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
      ],
      'deleted_at' => [
        'label' => 'Activa',
      ],
      'open' => [
        'label' => 'Abierta',
      ],
      'active_posters_count' => [
        'label' => 'Nº Carteles'
      ],
      // 'clinic_posters' => [
      //   'label' => 'Carteles'
      // ],
      'clinic_distributions_by_campaign' => [
        'label' => 'Distribuciones'
      ],
      'actions' => [
        'label' => 'Actions'
      ]
    ],
    'marketingUserHome' => [
      'nickname' => [
        'label' => 'Clínica',
      ],
      'deleted_at' => [
        'label' => 'Activa',
      ],
      'open' => [
        'label' => 'Abierta',
      ],
      'city' => [
        'label' => 'Ciudad'
      ],
      'district' => [
        'label' => 'Zona'
      ],
      'postal_code' => [
        'label' => 'Código Postal'
      ],
      'sanitary_code' => [
        'label' => 'Cód. Sanitario'
      ],
      'email_ext' => [
        'label' => 'Ext. Email'
      ],
      'clinic_cloud_id' => [
        'label' => 'CC ID'
      ],
      'parent_id' => [
        'label' => 'Parent ID'
      ],
      'starts_at' => [
        'label' => 'Inicio'
      ],
      'ends_at' => [
        'label' => 'Fin'
      ]
    ]
  ];
  // END Tableable Data
  // Model Views
  protected static $views = [
    'distributions' => [
      'with' => [
        'county',
        'cost_center',
        'addresses',
        'phones',
        'area_manager',
        'clinic_manager',
        'clinic_posters.poster',
        'clinic_posters.clinic_poster_priorities',
        'clinic_poster_priorities.clinic_poster.poster',
        'poster_distributions.complete_facades',
        'poster_distributions.original_facade'
      ]
      // 'append' => ['posters']
    ],
  ];
  // END Model Views
  public function parent() {
    return $this->belongsTo(Clinic::class, 'parent_id');
  }
  public function children() {
      return $this->hasMany(Clinic::class, 'parent_id');
  }
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
  public function poster_distributions_active () {
    return $this->hasMany(ClinicPosterDistribution::class)->where([['ends_at', null], ['campaign_id', null]]);
  }
  public function cost_center()
  {
      return $this->belongsTo(CostCenter::class);
  }
  public function siblings () {
    return $this->belongsToMany(Clinic::class, 'clinic_siblings', 'clinic_id', 'sibling_id');
  }
  public function clinic_siblings () {
    return $this->hasMany(ClinicSibling::class);
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

  public function getSharesClinicCloudId() {
    if (!$this->siblings()->count()) return false;
  }

  public function getClinicPostersCountAttribute () {
    return $this->clinic_posters()->count();
  }

  public function getClinicDistributionsByCampaignAttribute () {
    $filtered = collect();
    foreach ($this->poster_distributions AS $dist) {
      $design = json_decode($dist->distributions, true);
      if (count($design['posterIds']) < 1) continue;
      $filtered->add($dist);
    }
    return $filtered->groupBy('campaign_id');
  }

  public function active_distributions ($campaign = null) {
    $dists = $this->clinic_distributions_by_campaign;
    // dump($dists->toArray());
    if ($campaign) {
      // dump($campaign->id);
      if ($dists->has($campaign->id)) {
        // dump('HERE');
        $defDists = $dists[$campaign->id];
      }
      else {
        $noCampaignDists = $dists[''];
        $defDists = [];
        $endDate = [];
        $noEndDate = [];
        foreach ($noCampaignDists as $dist) {
          if ($dist->starts_at < $campaign->ends_at || ($dist->starts_at >= $campaign->starts_at && !$campaign->ends_at)) {
            if (!$dist->ends_at) $noEndDate[] = $dist;
            else if ($dist->ends_at >= $campaign->ends_at) $endDate[] = $dist;
          }
          if (count($endDate)) $defDists = $endDate;
          else $defDists = $noEndDate;
        }
      }
    } else {
      $defDists = [];
      foreach ($dists as $dist) {
        if (!$dist->ends_at) $defDists[] = $dist;
      }
    }

    return $defDists;
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
  }
  public function getActivePostersCountAttribute()
  {
      return $this->clinic_posters()->where('ends_at', null)->count();
  }
  
  public function getOpenAttribute()
  {
      if (!$this->ends_at && Carbon::parse($this->starts_at)->lessThan(Carbon::now())) return true;
      return (Carbon::parse($this->ends_at))->greaterThan(Carbon::now());
  }
  public function getActiveAttribute()
  {
    return (!$this->deleted_at);
  }

  public function getShareSiblingsAttribute() {
    return $this->shareSiblings();
  }

  // MUTATORS
  public function setNicknameAttribute($value) {
    if ($value === null) $this->attributes['nickname'] = $this->fullName;
    else $this->attributes['nickname'] = $value;
  }
  // END MUTATORS

  public function createCampaignFacades() {

    if (request('force') == 'true') {
      $campaignFacades = $this->campaign_facades()->where('campaign_id', request('campaign'))->first();
      if ($campaignFacades) $campaignFacades->delete();
    }
    $campaign = \App\Campaign::findOrActive(request('campaign'));
    $pdf = new CampaignFacadeDistributionPrinter($this, $campaign);
    $pdfFile = $pdf->makePdf();

    $path = 'clinics/' . $this->cleanName . '/facadesByCampaign//';
    $file = ClinicCampaignFacade::storeFile($pdfFile->directory . $pdfFile->fileName, $path, $pdfFile->fileName,null,null,null,false,true);
    $completeFacades = $this->campaign_facades()->save(new ClinicCampaignFacade([
        'campaign_id' => $campaign->id,
        'facades_file_id' => $file->id
    ]));

    $completeFacades->files()->save($file);
    return $completeFacades;
  }

  public static function cleanSiblings ($clinics) {
    $clinicsToCheck = [];
    foreach ($clinics as $clinic) {
        if ($clinic->siblings->count()) {
            foreach ($clinic->siblings as $sibling) {
                if (!array_key_exists($sibling->id, $clinicsToCheck)) $clinicsToCheck[$sibling->id] = [$clinic->id];
                else $clinicsToCheck[$sibling->id][] = $clinic->id;
            }
        }
    }
    foreach ($clinics as $key => $clinic) {
        if (array_key_exists($clinic->id, $clinicsToCheck)) {
            $siblingsIds = $clinic->siblings->pluck('id')->all();
            foreach ($clinicsToCheck[$clinic->id] as $siblingId) {
                if (!in_array($siblingId, $siblingsIds)) {
                    $clinics->forget($key);
                    break;
                }
            }
        }
    }
    return $clinics;
  }

  public function shareSiblings () {
    if (!$this->siblings()->count()) return false;
    $clinicsToCheck = [];
      foreach ($this->siblings as $sibling) {
        if (!$sibling->siblings()->count()) return false;
          if (!array_key_exists($sibling->id, $clinicsToCheck)) $clinicsToCheck[$sibling->id] = [$this->id];
          else $clinicsToCheck[$sibling->id][] = $this->id;
          foreach ($sibling->siblings as $relatedSibling) {
            if (!in_array($relatedSibling->id, $clinicsToCheck[$sibling->id])) $clinicsToCheck[$sibling->id][] = $relatedSibling->id;
          }
      }
    foreach ($this->siblings as $sibling) {
        if (array_key_exists($sibling->id, $clinicsToCheck)) {
            $siblingsIds = $sibling->siblings->pluck('id')->all();
            foreach ($clinicsToCheck[$sibling->id] as $siblingId) {
                if (!in_array($siblingId, $siblingsIds)) {
                    return false;
                }
            }
        }
    }
    return true;
  }

  public function cloneDistributions ($placePriorities = false) {
    // dump('cloneDistributions');
    // dump($placePriorities);
    $newDistributions = [];
    $newPPs = [];
    $newPPsEnhanced = [];
    $prioritiesRelation = [];
    if (!request('campaign')) {
      $startDate = request('starts_at') ? Carbon::parse(request('starts_at')) : Carbon::parse(Carbon::now());
      $endDate = request('starts_at') ? Carbon::parse(request('starts_at')) : Carbon::parse(Carbon::now());
      $endDate = $endDate->subDays(1);
    } else {
        $campaign = json_decode(request('campaign'), true);
        $startDate = $campaign['starts_at'] ? $campaign['starts_at'] : Carbon::parse(Carbon::now());
        $endDate = $campaign['ends_at'] ? $campaign['ends_at'] : $campaign['starts_at'] ? Carbon::parse($campaign['starts_at'])->addMonths(3) : Carbon::parse(Carbon::now())->addMonths(3);
        $endDate = $endDate->subDays(1);
    }
    // dump($startDate);
    // dump($endDate);
    // $model = $clinic;
    // if (request()->has('designs')) dump('Request Has Designs');
    // else dump('Finding Active Designs');
    $clinicDistributions = request()->has('designs') ? $this->poster_distributions()->find(request('designs')) : $this->poster_distributions_active;
    // dump(count($clinicDistributions));
    // dd($clinicDistributions->toArray());
    foreach ($clinicDistributions as $clinicposterdistribution) {
        // dump('Original ID: ' . $clinicposterdistribution->id);
        $distribution = json_decode($clinicposterdistribution['distributions'],true);
        $holders = collect($distribution['holders']);
        $ppIds = $distribution['posterIds'];
        // dump($distribution['posterIds']);
        if (count($ppIds)) {
            $posterPriorities = \App\ClinicPosterPriority::find($ppIds);
            foreach ($posterPriorities as $pp) {
                $holder = $holders->filter(function ($i) use ($pp) {
                  return $i['ext'] === $pp->id || $i['int'] === $pp->id;
                })->first();
                $holderExt = $posterPriorities->filter(function ($i) use ($holder) {
                  return $i['id'] === $holder['ext'];
                })->first();
                $holderInt = $posterPriorities->filter(function ($i) use ($holder) {
                  return $i['id'] === $holder['int'];
                })->first();
                // dump($holderExt->priority);
                // dump($holderExt->clinic_poster->type);
                // dump($holderInt->priority);
                // dump($holderInt->clinic_poster->type);
                $newPP = \App\ClinicPosterPriority::create($pp->toArray());
                $newPP->starts_at = $startDate;
                $prioritiesRelation[$pp->id] = $newPP->id;
                if (request('campaign')) {
                    $campaign = json_decode(request('campaign'), true);
                    $newPP->ends_at = $campaign['ends_at'];
                    $newPP->campaign_id = $campaign['id'];
                }
                else {
                    $pp->ends_at = $endDate;
                    $pp->save();
                }
                $newPP->save();
                $newPPs[] = $newPP;
                $newPPEnhanced = [
                  'oldTypeA' => $holderExt ? $holderExt->clinic_poster->type : null,
                  'oldTypeB' => $holderInt ? $holderInt->clinic_poster->type : null,
                  'oldPriorityA' => $holderExt ? $holderExt->priority : null,
                  'oldPriorityB' => $holderInt ? $holderInt->priority : null,
                  'newType' => $newPP ? $newPP->clinic_poster->type : null,
                  'newPriority' => $newPP ? $newPP->priority : null,
                  'model' => $newPP
                ];
                $newPPsEnhanced[] = $newPPEnhanced;
            }
            // dump(count($posterPriorities));
        }
        if (count($distribution['holders'])) {
          if (!$placePriorities) {
            foreach ($distribution['holders'] as $i => $holder ) {
              $distribution['holders'][$i]['ext'] = [];
              $distribution['holders'][$i]['int'] = [];
              $distribution['posterIds'] = [];
            }
          } else {
            foreach ($distribution['holders'] as $i => $holder ) {
              $distribution['holders'][$i]['ext'] = $prioritiesRelation[$distribution['holders'][$i]['ext']];
              $distribution['holders'][$i]['int'] = array_key_exists((int) $distribution['holders'][$i]['int'], $prioritiesRelation) ? $prioritiesRelation[$distribution['holders'][$i]['int']] : [];
            }
            $distribution['posterIds'] = [];
            foreach ($prioritiesRelation as $old => $new) $distribution['posterIds'][] = $new;
          }
        }
        $newDist = \App\ClinicPosterDistribution::create($clinicposterdistribution->toArray());
        $newDist->starts_at = $startDate;
        $newDist->save();
        if (!request('campaign')) {
            $clinicposterdistribution->ends_at = $endDate;
            $clinicposterdistribution->save();
        } else {
            $campaign = json_decode(request('campaign'), true);
            $newDist->ends_at = $campaign['ends_at'];
            $newDist->campaign_id = $campaign['id'];
            $newDist->save();
        }
        $newDist->distributions = json_encode($distribution);
        $newDist->save();
        $newDistributions[] = $newDist;
    }
    return ['newDistributions' => $newDistributions, 'newPPs' => $newPPs, 'newPPsEnhanced' => $newPPsEnhanced];
  }

  public function setDefaultDistributions($dists) {
    $clinicDistributions = $this->poster_distributions()->find($dists);

    foreach ($clinicDistributions as $dist) {
      $distribution = json_decode($dist['distributions'],true);
      $dist->ends_at = null;
      $posterPriorities = \App\ClinicPosterPriority::find($distribution['posterIds']);
      foreach ($posterPriorities as $pp) {
        $pp->ends_at = null;
        $pp->save();
      }
      $dist->save();
    }
  }

  public function posterPrioritiesFixer() {
    $clinicDistributions = request()->has('designs') ? $this->poster_distributions()->find(request('designs')) : $this->poster_distributions_active;
    foreach ($clinicDistributions as $key => $clinicposterdistribution) {
      dump('Clinic Poster Distribution');
      dump($clinicposterdistribution->id);
      $distribution = json_decode($clinicposterdistribution['distributions'],true);
      $holders = collect($distribution['holders']);
      $ppIds = $distribution['posterIds'];
      $newPPIds = [];
      foreach ($holders as $holder) {
        if ($holder['ext']) $newPPIds[] = $holder['ext'];
        if ($holder['int']) $newPPIds[] = $holder['int'];
      }
      if (count($ppIds) !== count($newPPIds)) {
        dump('Dont Match!!!!');
        $distribution['posterIds'] = $newPPIds;
        $clinicDistributions[$key]['distributions'] = json_encode($distribution);
        $clinicposterdistribution->save();
      } else {
        dump('It is a Match. Doing Nothing : )');
      }
    }
    return $clinicDistributions;
  }

  // Helpers
  public function filterScope($modelsToScope) {
    foreach ($modelsToScope as $source) {
      if (!$source->clinic_id) continue;
      if ($source->clinic_id === $this->id) return $source;
    }
    foreach ($modelsToScope as $source) {
      if (!$source->county_id || $source->clinic_id) continue;
      if ($source->county_id === $this->county_id) return $source;
    }
    foreach ($modelsToScope as $source) {
      if (!$source->state_id || $source->county_id || $source->clinic_id) continue;
      if ($source->state_id === $this->county->state_id) return $source;
    }
    foreach ($modelsToScope as $source) {
      if (!$source->country_id || $source->state_id || $source->county_id || $source->clinic_id) continue;
      if ($source->stcountry_idte_id === $this->county->state->country_id) return $source;
    }
  }
}
