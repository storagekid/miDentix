<?php

namespace App;

class Mailing extends Qmodel
{
    protected $fillable = ['name', 'description', 'starts_at', 'ends_at', 'campaign_id'];
    protected static $full = ['campaign', 'mailing_designs', 'sanitary_codes', 'clinic_mailings'];

    protected static $permissions = [
        'view' => [
            'Marketing' => ['*'],
        ]
    ];

    // Quasar DATA
    protected $relatedTo = ['mailing_designs', 'sanitary_codes'];
    protected $relationOptions = [
        'mailing_designs' => [
            'with' => ['language', 'country', 'state', 'county', 'clinic', 'clinics', 'base_af', 'clinic_mailings']
        ]
    ];
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'starts_at', 'ends_at', 'campaign_id']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'starts_at', 'ends_at', 'campaign_id']
            ],
        ],
        [
            'title' => 'Diseños',
            'icon' => 'photo_album',
            'fields' => [],
            'relations' => ['mailing_designs']
        ],
        [
            'title' => 'Códigos Sanitarios',
            'subtitle' => 'General',
            'icon' => 'spellcheck',
            'fields' => [],
            'relations' => ['sanitary_codes']
        ],
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'description' => [
            'label' =>'Descripción',
        ],
        'starts_at' => [
            'label' =>'Fecha Inicio',
            'type' => [
                'name' => 'date',
            ]
        ],
        'ends_at' => [
            'label' =>'Fecha Fin',
            'type' => [
                'name' => 'date',
            ]
        ],
        'campaign_id' => [
            'label' =>'Campaña',
            'type' => [
                'name' =>'select',
                'model' => 'campaigns',
                'default' => [
                    'text' => 'Selecciona una Campaña',
                ],
            ],
          ],
    ];
    protected $listFields = [
        'left' => [],
        'main' => [
            'name' => ['text'],
        ],
        'right' => [
            'description' => ['text'],
        ],
    ];
    protected $keyField = 'name';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre',
        ],
        'description' => [
            'label' => 'Descripción',
        ],
        'starts_at' => [
            'label' => 'Fecha Inicio',
        ],
        'ends_at' => [
            'label' => 'Fecha Fin',
        ],
        'campaign.label' => [
            'label' => 'Campaña',
        ],
        'mailing_designs_count' => [
            'label' => 'Diseños',
        ],
        'sanitary_codes_count' => [
            'label' => 'CS Especiales',
        ],
        'actions' => [
            'label' => 'Actions'
        ]
    ];
    // END Table Data

    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }
    public function mailing_designs () {
        return $this->hasMany(MailingDesign::class)->with($this->relationOptions['mailing_designs']['with']);
    }
    public function clinic_mailings() {
        return $this->hasManyThrough(ClinicMailing::class, MailingDesign::class);
      }
    public function sanitary_codes()
    {
        return $this->morphMany(SanitaryCode::class, 'sanitizable');
    }

    public function getDesignClinicsAttribute() {
        $groupedDesigns = [];
        $usedClinics = [];
        $ignoredClinics = [];
        $usedCounties = [];
        $usedStates = [];
        // $designs = \App\MailingDesign::withCount('clinics')->get();
        $designs = $this->mailing_designs()->withCount('clinics')->orderBy('type', 'desc')->orderBy('clinic_id', 'desc')->orderBy('clinics_count', 'desc')->orderBy('county_id', 'desc')->orderBy('state_id', 'desc')->orderBy('country_id', 'desc')->get();
        // $designs = $this->mailing_designs()->withCount('clinics')->get();
        // $sortedDesigns = $designs->groupBy(['clinic_id', 'clinics_count', 'county_id', 'state_id']);
        // return $sortedDesigns->toArray();
        foreach ($designs as $key => $design) {
            $groupedDesigns[$design->id] = [];
            if ($design->clinic_id) {
                if ($design->clinic->parent_id) $usedClinics[] = $design->clinic_id;
                else {
                    $groupedDesigns[$design->id][] = $design->clinic_id;
                    $usedClinics[] = $design->clinic_id;
                }
            } else if ($design->clinics_count) {
                $clinics = $design->clinics;
                foreach($clinics as $clinic) {
                    if (in_array($clinic->id, $usedClinics)) continue;
                    else if ($clinic->parent_id) $usedClinics[] = $clinic->id;
                    else {
                        $groupedDesigns[$design->id][] = $clinic->id;
                        $usedClinics[] = $clinic->id;
                    }
                }
            } else if ($design->county_id) {
                $clinics = $this->countyOpenActiveClinics($design->county, $usedClinics);
                $groupedDesigns[$design->id][] = $clinics;
                $usedCounties[] = $design->county_id;
            } else if ($design->state_id) {
                // dump('HERE');
                $groupedDesigns[$design->id] = [];
                $usedStates[] = $design->state_id;
                $counties = count($usedCounties) ? $design->state->counties()->whereNotIn('id', $usedCounties)->get() : $design->state->counties;
                foreach($counties as $county) {
                    // dump($county->name);
                    $clinics = $this->countyOpenActiveClinics($county, $usedClinics);
                    // dump($clinics);
                    $groupedDesigns[$design->id] = array_merge($groupedDesigns[$design->id], $clinics);
                }
                $usedClinics = array_merge($usedClinics, $groupedDesigns[$design->id]);
            } else if ($design->country_id) {
                $groupedDesigns[$design->id] = [];
                $states = count($usedStates) ? $design->country->states()->whereNotIn('id', $usedStates)->get() : $design->country->states;
                foreach($states as $state) {
                    // dump($state->name);
                    foreach ($state->counties as $county) {
                        $clinics = $this->countyOpenActiveClinics($county, $usedClinics);
                        $groupedDesigns[$design->id] = array_merge($groupedDesigns[$design->id], $clinics);
                    }
                }
                $usedClinics = array_merge($usedClinics, $groupedDesigns[$design->id]);
            }
        }
        return $groupedDesigns;
    }
    public function countyOpenActiveClinics($county, $usedClinics) {
        $clinics = $county->clinics()->whereNotIn('id', $usedClinics)->get();
        $filteredClinics = $clinics->filter(function ($i) { return ($i->open && $i->active); })->pluck('id')->all();
        return $filteredClinics;
    }
}
