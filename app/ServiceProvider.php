<?php

namespace App;


class ServiceProvider extends Qmodel
{
    protected $fillable = ['service_id', 'provider_id', 'description', 'price', 'starts_at', 'ends_at', 'details', 'country_id', 'state_id', 'county_id', 'clinic_id', 'store_id'];
    protected static $full = ['service', 'provider', 'country', 'state', 'county', 'clinic', 'store'];
    protected $table = 'service_providers';
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
                ['service_id', 'provider_id', 'description', 'price', 'starts_at', 'ends_at', 'details', 'country_id', 'state_id', 'county_id', 'clinic_id', 'store_id']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['service_id', 'provider_id', 'description', 'price', 'starts_at', 'ends_at', 'details', 'country_id', 'state_id', 'county_id', 'clinic_id', 'store_id']
            ],
        ]
    ];
    protected $quasarFormFields = [
        'service_id' => [
            'label' =>'Servicio',
            'type' => [
                'name' =>'select',
                'model' => 'services',
                'default' => [
                    'text' => 'Selecciona un Servicio',
                ],
            ],
        ],
        'provider_id' => [
            'label' =>'Proveedor',
            'type' => [
                'name' =>'select',
                'model' => 'providers',
                'default' => [
                    'text' => 'Selecciona un Proveedor',
                ],
            ],
        ],
        'description' => [
            'label' =>'Descripción',
            'batch' => true,
        ],
        'price' => [
            'label' =>'Precio',
            'batch' => true,
            'type' => [
                'name' =>'number',
                'step' => 0.0000000000000001
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
        ],
        'details' => [
            'label' =>'Detalles',
            'batch' => true,
        ],
        'country_id' => [
            'label' =>'País',
            'batch' => true,
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
            'batch' => true,
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
            'batch' => true,
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
            'batch' => true,
            'type' => [
                'name' =>'select',
                'model' => 'clinics',
                'default' => [
                    'text' => 'Selecciona una Clínica',
                ],
            ],
        ],
        'store_id' => [
            'label' =>'Oficina',
            'batch' => true,
            'type' => [
                'name' =>'select',
                'model' => 'stores',
                'default' => [
                    'text' => 'Selecciona una Oficina',
                ],
            ],
        ]
    ];
    protected $onRelationMode = ['table'];
    protected $listFields = [
        'mode' => 'table',
        'left' => [],
        'main' => [
            'provider_id' => ['text'],
        ],
        'right' => [
            'service_id' => ['text']
        ],
    ];
    protected $keyField = 'description';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'service.name' => [
            'label' => 'Servicio',
        ],
        'provider.name' => [
            'label' => 'Proveedor',
            'show' => 'relation'
        ],
        'description' => [
            'label' =>'Descripción',
            'show' => 'relation'
        ],
        'price' => [
            'label' =>'Precio',
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
        'details' => [
            'label' =>'Detalles',
            'show' => 'relation'
        ],
        'country.name' => [
            'label' => 'País',
            'show' => 'relation'
        ],
        'state.name' => [
            'label' => 'CCAA',
            'show' => 'relation'
        ],
        'county.name' => [
            'label' => 'Provincia',
            'show' => 'relation'
        ],
        'clinic.nickname' => [
            'label' => 'Clínica',
            'show' => 'relation'
        ],
        'store.name' => [
            'label' => 'Oficina',
            'show' => 'relation'
        ]
    ];
    // END Table Data

    public function service() {
        return $this->belongsTo(Service::class);
    }
    public function provider() {
        return $this->belongsTo(Provider::class);
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
    public function clinic() {
        return $this->belongsTo(Clinic::class)->withTrashed();
    }
    public function store() {
        return $this->belongsTo(Store::class)->withTrashed();
    }
}
