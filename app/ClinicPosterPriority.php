<?php

namespace App;

class ClinicPosterPriority extends Qmodel
{

    protected $fillable = ['campaign_id', 'clinic_poster_id', 'priority', 'starts_at', 'ends_at'];
    public static $full = ['clinic_poster.clinic.county', 'clinic_poster.poster', 'campaign'];
    protected static $permissions = [
        'view' => [
          'Marketing' => ['*'],
        ]
    ];
    // Quasar DATA
    protected $onRelationMode = ['table'];
    
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['campaign_id', 'clinic_poster_id', 'priority', 'starts_at', 'ends_at']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['campaign_id', 'clinic_poster_id', 'priority', 'starts_at', 'ends_at']
            ],
        ]
    ];

    protected $quasarFormFields = [
        'campaign_id' => [
            'label' =>'Campaign',
            'type' => [
                'name' =>'select',
                'model' => 'campaigns',
                'filterKey' => 'campaign_id',
                'default' => [
                    'text' => 'Selecciona una Campaña',
                ],
            ],
        ],
        'clinic_poster_id' => [
            'label' =>'Clinic Poster',
            'type' => [
                'name' =>'select',
                'model' => 'clinic_posters',
                'default' => [
                    'text' => 'Selecciona un Poster',
                ],
            ],
        ],
        'priority' => [
            'label' =>'Priority',
            'type' => [
                'name' =>'array',
                'array' => [1,2,3,4,5,6,7,8,9,10,11,12],
                'default' => [
                    'text' => 'Selecciona una Prioridad',
                ],
            ],
        ],
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
        'mode' => 'table',
        // 'draggable' => 'priority',
        'left' => [
            'priority' => ['chips']
        ],
        'main' => [
            'campaign.name' => ['object'],
        ],
        'right' => [
            'starts_at' => ['text'],
            'ends_at' => ['text'],
        ],
    ];
    // END Quasar DATA
    // Tableable DATA
    protected $tableColumns = [
        'clinic_poster.clinic.nickname' => [
            'label' => 'Clínica',
        ],
        'clinic_poster.clinic.active' => [
            'label' => 'Activa',
            'type' => [
                'name' => 'boolean'
            ]
        ],
        'clinic_poster.poster.description' => [
            'label' => 'Descripción',
        ],
        'clinic_poster.type' => [
            'label' => 'Type',
        ],
        'priority' => [
            'label' => 'Prioridad',
            'show' => 'relation'
        ],
        'campaign.name' => [
            'label' => 'Campaña',
            'show' => 'relation'
        ],
        'campaign_id' => [
            'label' => 'Campaña',
        ],
        'clinic_poster.clinic.sanitary_code' => [
            'label' => 'Código Sanitario',
        ],
        'clinic_poster.clinic.county.name' => [
            'label' => 'Provincia',
        ],
        'clinic_poster.clinic.county.state.name' => [
            'label' => 'CCAA',
        ],
        'starts_at' => [
            'label' => 'Fecha de Alta',
            'show' => 'relation'
        ],
        'ends_at' => [
            'label' => 'Fecha de Baja',
            'show' => 'relation'
        ],
    ];
    // END Table Data


    public function clinic_poster () {
        return $this->belongsTo(ClinicPoster::class, 'clinic_poster_id');
    }
    public function campaign () {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
    public function getClinicPosterNameAttribute() {
        return $this->clinic_poster->fullName;
    }
    public function getClinicIdAttribute() {
        return $this->clinic_poster->clinic_id;
    }
    public function getPosterTypeAttribute() {
        return $this->clinic_poster->type;
    }
}
