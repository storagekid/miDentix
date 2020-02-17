<?php

namespace App;


class ProductProvider extends Qmodel
{
    protected $fillable = [
        'product_id',
        'provider_id',
        'description',
        'price',
        'min_quantity',
        'max_quantity',
        'default_quantity',
        'quantity_steps',
        'delivery_time', // days
        'starts_at',
        'ends_at',
        'details',
        'country_id',
        'state_id',
        'county_id',
        'clinic_id',
        'store_id'
    ];
    protected static $full = ['product', 'provider', 'country', 'state', 'county', 'clinic', 'store'];
    protected $table = 'product_providers';

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
                [
                    'product_id',
                    'provider_id',
                    'description',
                    'price',
                    'min_quantity',
                    'max_quantity',
                    'default_quantity',
                    'quantity_steps',
                    'delivery_time',
                    'starts_at',
                    'ends_at',
                    'details',
                    'country_id',
                    'state_id',
                    'county_id',
                    'clinic_id',
                    'store_id'
                ]
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                [
                    'product_id',
                    'provider_id',
                    'description',
                    'price',
                    'min_quantity',
                    'max_quantity',
                    'default_quantity',
                    'quantity_steps',
                    'delivery_time',
                    'starts_at',
                    'ends_at',
                    'details',
                    'country_id',
                    'state_id',
                    'county_id',
                    'clinic_id',
                    'store_id'
                ]
            ],
        ]
    ];
    protected $quasarFormFields = [
        'product_id' => [
            'label' =>'Producto',
            'type' => [
                'name' =>'select',
                'model' => 'products',
                'default' => [
                    'text' => 'Selecciona un Producto',
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
        'min_quantity' => [
            'label' =>'Cantidad Mínima',
            'batch' => true,
            'type' => [
                'name' =>'number',
                'step' => 1
            ],
        ],
        'max_quantity' => [
            'label' =>'Cantidad Máxima',
            'batch' => true,
            'type' => [
                'name' =>'number',
                'step' => 1
            ],
        ],
        'default_quantity' => [
            'label' =>'Cantidad por Defecto',
            'batch' => true,
            'type' => [
                'name' =>'number',
                'step' => 1
            ],
        ],
        'quantity_steps' => [
            'label' =>'Incrementos',
            'batch' => true,
            'type' => [
                'name' =>'number',
                'step' => 1
            ],
        ],
        'delivery_time' => [
            'label' =>'Tiempo de Entrege Estimado (días)',
            'batch' => true,
            'type' => [
                'name' =>'number',
                'step' => 1
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
        'store_id' => [
            'label' =>'Oficina',
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
            'product_id' => ['text']
        ],
    ];
    protected $keyField = 'description';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'product.name' => [
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
            'type' => [
                'name' => 'currency',
                'options' => []
            ],
            'show' => 'relation'
        ],
        'min_quantity' => [
            'label' =>'Cantidad Mínima',
            'show' => 'relation'
        ],
        'max_quantity' => [
            'label' =>'Cantidad Máxima',
            'show' => 'relation'
        ],
        'default_quantity' => [
            'label' =>'Cantidad por Defecto',
            'show' => 'relation'
        ],
        'quantity_steps' => [
            'label' =>'Incrementos',
            'show' => 'relation'
        ],
        'delivery_time' => [
            'label' =>'Tiempo Entrega (días)',
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

    public function product() {
        return $this->belongsTo(Product::class);
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
