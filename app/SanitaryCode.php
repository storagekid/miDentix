<?php

namespace App;

class SanitaryCode extends Qmodel
{

    protected $fillable = ['code', 'description', 'clinic_id', 'county_id', 'state_id', 'country_id', 'campaign_id'];
    protected static $full = ['clinic', 'county', 'state', 'country', 'campaign', 'sanitizable'];

    // Quasar DATA
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['code', 'description', 'clinic_id', 'county_id', 'state_id', 'country_id', 'campaign_id']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['code', 'description', 'clinic_id', 'county_id', 'state_id', 'country_id', 'campaign_id']
            ],
        ],
    ];
    protected $quasarFormFields = [
        'code' => [
            'label' =>'Código',
            'batch' => true
        ],
        'description' => [
            'label' =>'Descipción',
            'batch' => true
        ],
        'clinic_id' => [
            'label' =>'Clínic',
            'type' => [
                'name' =>'select',
                'model' => 'clinics',
                'default' => [
                    'text' => 'Selecciona una Clínica',
                ],
            ],
        ],
        'county_id' => [
            'label' =>'Provincia',
            'type' => [
                'name' =>'select',
                'model' => 'counties',
                'default' => [
                    'text' => 'Selecciona una Provincia',
                ],
            ],
        ],
        'state_id' => [
            'label' =>'CCAA',
            'type' => [
                'name' =>'select',
                'model' => 'states',
                'default' => [
                    'text' => 'Selecciona una CCAA',
                ],
            ],
        ],
        'country_id' => [
            'label' =>'País',
            'type' => [
                'name' =>'select',
                'model' => 'countries',
                'default' => [
                    'text' => 'Selecciona un País',
                ],
            ],
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
        ]
    ];
    protected $listFields = [
        'left' => [
            'type' => ['chips'],
        ],
        'main' => [
            'code' => ['text']
        ],
        'right' => [
            'description' => [],
        ],
    ];
    protected $keyField = 'code';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'code' => [
            'label' => 'Código',
            'filtering' => ['select' => 'clinics'],
        ],
        'description' => [
            'label' => 'Descripción',
            'filtering' => ['search'],
        ],
        'sanitizable_type' => [
            'label' => 'Objeto',
            'filtering' => ['search'],
        ],
        'sanitizable.label' => [
            'label' => 'Modelo',
            'filtering' => ['search'],
        ],
        'campaign.name' => [
            'label' => 'Campaña',
            'filtering' => ['search'],
        ],
        'clinic.nickname' => [
            'label' => 'Clínica',
            'filtering' => ['search'],
        ],
        'county.name' => [
            'label' => 'Provincia',
            'filtering' => ['search'],
        ],
        'state.name' => [
            'label' => 'CCAA',
            'filtering' => ['search'],
        ],
        'country.name' => [
            'label' => 'País',
            'filtering' => ['search'],
        ],
    ];
    protected $tableOptions = [['show', 'edit', 'clone', 'delete'], true, true];
    // END Table Data

    public function sanitizable()
    {
        return $this->morphTo();
    }
    public function clinic()
    {
        return $this->belongsTo(Clinic::class)->withTrashed();
    }
    public function county()
    {
        return $this->belongsTo(County::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
