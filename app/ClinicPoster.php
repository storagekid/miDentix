<?php

namespace App;


class ClinicPoster extends Qmodel
{
    protected $fillable = ['clinic_id', 'poster_id', 'type', 'starts_at', 'ends_at'];
    public static $full = ['clinic.county', 'poster', 'clinic_poster_priorities.campaign'];
    protected static $permissions = [
        'view' => [
          'Marketing' => ['*'],
        ]
    ];
    public static $cascade = ['clinic_poster_priorities'];
    // Quasar DATA
    protected $relatedTo = ['clinic_poster_priorities'];

    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['clinic_id', 'poster_id', 'type', 'starts_at', 'ends_at']
            ]
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Clinic',
            'icon' => 'shuffle',
            'fields' => [
                ['clinic_id', 'poster_id', 'type', 'starts_at', 'ends_at']
            ],
            'relations' => ['clinic_poster_priorities']
        ],
    ];
    protected $quasarFormFields = [
        'clinic_id' => [
            'label' =>'Clínica',
            'batch' => true,
            'type' => [
              'name' =>'select',
              'model' => 'clinics',
              'text' =>  'name',
              'value' => 'id',
              'filterKey' => 'clinic_id',
              'default' => [
                'text' => 'Selecciona una de tus Clínicas',
              ],
            ],
        ],
        'poster_id' => [
            'label' =>'Poster Size',
            'type' => [
                'name' =>'select',
                'model' => 'posters',
                'text' =>  'name',
                'value' => 'id',
                'filterKey' => 'poster_id',
                'default' => [
                    'text' => 'Selecciona un Tamaño de Cartel',
                ],
            ],
        ],
        'type' => [
            'label' =>'Tipo',
            'type' => [
                'name' =>'array',
                'array' => ['Int', 'Ext', 'Office', 'Office Int'],
                'default' => [
                    'text' => 'Selecciona un Tipo',
                ],
            ],
        ],
        'starts_at' => [
            'label' =>'Fecha Inicio',
            'batch' => true,
            'type' => [
                'name' => 'date',
            ]
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
        'left' => [],
        'main' => [
          'fullName' => ['text']
        ],
        'right' => [],
    ];

    // END Quasar DATA
    

    // Tableable DATA
    protected $tableColumns = [
        // 'id' => [
        //     'label' => 'ID',
        // ],
        'clinic.nickname' => [
            'label' => 'Clínica',
        ],
        'clinic.active' => [
            'label' => 'Activa',
            'type' => [
                'name' => 'boolean'
            ],
            'filtering' => ['select' => 'clinics'],
        ],
        'poster.description' => [
            'label' => 'Descripción',
        ],
        'type' => [
            'label' => 'Type',
        ],
        'clinic_poster_priorities_count' => [
            'label' => 'Prioridades',
        ],
        'clinic.county.name' => [
            'label' => 'Provincia',
        ],
        'clinic.county.state.name' => [
            'label' => 'CCAA',
        ],
        'starts_at' => [
            'label' => 'Fecha de Alta',
        ],
        'ends_at' => [
            'label' => 'Fecha de Baja',
        ],
    ];
    protected $tableViews = [
        'marketingUserHome' => [
            'clinic.nickname' => [
                'label' => 'Clínica',
                'model' => 'clinic'
            ],
            'poster.name' => [
                'label' => 'Soporte',
                'model' => 'poster'
            ],
            'poster.material' => [
                'label' => 'Material',
                'model' => 'poster'
            ],
            'type' => [
                'label' => 'Tipo',
            ],
            'default_priority' => [
                'label' => 'Prioridad',
                'append' => 'default_priority'
            ],
            'starts_at' => [
                'label' => 'Inicio'
            ],
            'ends_at' => [
                'label' => 'Fin'
            ]
        ]
      ];
    // END Table Data

    public function clinic() {
        return $this->belongsTo(Clinic::class)->withTrashed();
    }
    public function poster() {
        return $this->belongsTo(Poster::class);
    }
    public function clinic_poster_priorities () {
        return $this->hasMany(ClinicPosterPriority::class, 'clinic_poster_id');
    }
    public function getClinicNameAttribute() {
        return $this->clinic ? $this->clinic->cleanName : null;
    }
    public function getPosterNameAttribute() {
        return $this->poster ? $this->poster->description : null;
    }
    public function getFullNameAttribute() {
        return $this->poster ? $this->poster->name . (' - ') . $this->poster->material : null;
    }
    public function getCampaignPriority($campaignId) {
        $priority = $this->clinic_poster_priorities()->where('campaign_id', $campaignId)->value('priority');
        if (!$priority) $priority = $this->clinic_poster_priorities()->where('campaign_id', null)->value('priority');
        return $priority;
    }
    public function getDefaultPriorityAttribute($campaignId = null) {
        return $this->clinic_poster_priorities()->where('campaign_id', $campaignId ? $campaignId : null)->value('priority');
    }
    public function getClinicActiveAttribute() {
        return $this->clinic->active;
    }
    public static function postersNeededByCampaign ($campaign) {
        // return ()->greaterThan(Carbon::now());
        // $date = Carbon::parse($date);
        $seed = static::where('ends_at', null)->orWhere('ends_at', '<', $campaign->ends_at)->get();
        $filtered = $seed->filter(function($i) use ($campaign) { return $i->starts_at < $campaign->ends_at; });
        $filtered->map(function($i) use($campaign) {
            $i['size'] = $i->poster->name;
            $i['priority'] = $i->getCampaignPriority($campaign->id);
        });
        $grouped = $filtered->groupBy(['priority', 'size', 'type']);
        // $ids = $filtered->pluck('id');
        return $grouped;
        // dd($ids);
    }
}
