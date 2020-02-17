<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Legal extends Qmodel
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'text', 'starts_at', 'ends_at', 'language_id', 'country_id', 'state_id', 'county_id', 'clinic_id', 'legalizable_id', 'legalizable_type'];
    protected static $full = ['language', 'legalizable', 'county', 'country', 'state'];
    protected $with = ['language', 'legalizable'];
    protected static $permissions = [
        'view' => [
            'Marketing' => ['*'],
        ]
    ];

    // Quasar DATA
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'text', 'starts_at', 'ends_at', 'language_id', 'country_id', 'state_id', 'county_id', 'clinic_id',]
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'text', 'starts_at', 'ends_at', 'language_id', 'country_id', 'state_id', 'county_id', 'clinic_id',]
            ],
        ]
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'description' => [
            'label' =>'Descripción',
        ],
        'text' => [
            'label' =>'Texto',
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
        'clinic_id' => [
            'label' =>'Clínica',
            'type' => [
                'name' =>'select',
                'model' => 'clinics',
                'default' => [
                    'text' => 'Selecciona una Clínica',
                ],
            ],
        ],
    ];
    protected $listFields = [
        'mode' => 'table',
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
            'show' => 'relation'
        ],
        'description' => [
            'label' => 'Descripción',
        ],
        'text' => [
            'label' => 'Texto',
            'show' => 'relation'
        ],
        'starts_at' => [
            'label' => 'Fecha Inicio',
            'show' => 'relation'
        ],
        'ends_at' => [
            'label' => 'Fecha Fin',
            'show' => 'relation'
        ],
        'language.native_name' => [
            'label' => 'Language',
        ],
        'country.name' => [
            'label' => 'País',
        ],
        'state.name' => [
            'label' => 'CCAA',
        ],
        'county.name' => [
            'label' => 'Provincia',
        ],
        'clinic.nickname' => [
            'label' => 'Clínica',
        ],
        'legalizable.label' => [
            'label' =>'Objeto',
        ],
    ];
    // END Table Data
    public function legalizable()
    {
        return $this->morphTo();
    }
    public function language() {
        return $this->belongsTo(Language::class);
    }
    public function country() {
        return $this->belongsTo(Country::class);
    }
    public function county() {
        return $this->belongsTo(County::class);
    }
    public function state() {
        return $this->belongsTo(State::class);
    }
}
