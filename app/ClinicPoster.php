<?php

namespace App;


class ClinicPoster extends Qmodel
{

    // Quasar DATA
    protected $relatedTo = ['clinic_poster_priorities'];

    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['clinic_id', 'poster_id', 'type', 'starts_at', 'ends_at']
            ],
            'relations' => ['clinic_poster_priorities']
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
            // 'onObject' => 'clinic_poster',
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
            // 'onObject' => 'clinic_poster',
            'type' => [
                'name' =>'array',
                'array' => ['Int', 'Ext', 'Office', 'Office Int'],
                'default' => [
                    'text' => 'Selecciona un Tipo',
                ],
            ],
        ],
        // 'priority' => [
        //     'ignoreTable' => true,
        //     'label' =>'Priority',
        //     'batch' => true,
        //     'type' => [
        //         'name' =>'array',
        //         'array' => [1,2,3,4,5,6,7,8],
        //         'default' => [
        //             'text' => 'Selecciona una Prioridad',
        //         ],
        //     ],
        // ],
        'starts_at' => [
            'label' =>'Fecha Inicio',
            'batch' => true,
            // 'onObject' => 'clinic_poster',
            'type' => [
                'name' => 'date',
            ]
        ],
        'ends_at' => [
            'label' =>'Fecha Fin',
            'batch' => true,
            // 'onObject' => 'clinic_poster',
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
    // protected $keyField = 'id';

    public static $full = ['clinic.county', 'poster', 'clinic_poster_priorities.campaign'];
    // END Quasar DATA
    

    // Tableable DATA
    protected $tableColumns = [
        'id' => [
            'label' => 'ID',
        ],
        'clinic.nickname' => [
            'label' => 'Clínica',
            'filtering' => ['select' => 'clinics'],
        ],
        'clinic.active' => [
            'label' => 'Activa',
            'filtering' => ['select' => 'clinics'],
        ],
        'poster.description' => [
            'label' => 'Descripción',
            'filtering' => ['search'],
        ],
        'type' => [
            'label' => 'Type',
            'filtering' => ['search'],
        ],
        'clinic_poster_priorities_count' => [
            'label' => 'Prioridades',
            'filtering' => ['search'],
        ],
        'clinic.county.name' => [
            'label' => 'Provincia',
            'filtering' => ['search'],
        ],
        'clinic.county.state.name' => [
            'label' => 'CCAA',
            'filtering' => ['search'],
        ],
        'starts_at' => [
            'label' => 'Fecha de Alta',
            'filtering' => ['search'],
        ],
        'ends_at' => [
            'label' => 'Fecha de Baja',
            'filtering' => ['search'],
        ],
    ];
    protected $tableOptions = [['show', 'edit', 'clone', 'delete'], true, true];
    // END Table Data
    protected $fillable = ['clinic_id', 'poster_id', 'type', 'starts_at', 'ends_at'];

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
    public function getDefaultPriorityAttribute($campaignId) {
        return $this->clinic_poster_priorities()->where('campaign_id', $campaignId ? $campaignId : null)->value('priority');
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
