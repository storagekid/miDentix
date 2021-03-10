<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Qmodel
{
    use SoftDeletes;

    protected $fillable = ['shopping_bag_id','user_id','clinic_id','store_id','product_provider_id','profile_id','details','orderable_id','orderable_type','quantity','priority','state'];
    protected static $full = ['shopping_bag','user','clinic','store','provider', 'product_provider', 'profile','orderable'];
    protected static $permissions = [
        'view' => [
            'Marketing' => ['*'],
            'Clinics' => ['*']
        ]
    ];

    // Quasar DATA
    protected static $relationOptions = [
        'product_provider' => [
          'with' => ['provider']
        ]
      ];
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['shopping_bag_id','user_id','clinic_id','store_id','product_provider_id','profile_id','details','orderable_id','orderable_type','quantity','priority','state']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['shopping_bag_id','user_id','clinic_id','store_id','product_provider_id','profile_id','details','orderable_id','orderable_type','quantity','priority','state']
            ],
        ],
    ];
    protected $quasarFormFields = [
        'shopping_bag_id' => [
            'label' =>'Shopping Bag',
            'type' => [
                'name' =>'select',
                'model' => 'shopping_bags',
                'text' =>  'name',
                'value' => 'id',
                'default' => [
                'text' => 'Selecciona una Cesta',
                ],
            ],
        ],
        'user_id' => [
            'label' =>'User',
            'type' => [
                'name' =>'select',
                'model' => 'users',
                'text' =>  'name',
                'value' => 'id',
                'default' => [
                'text' => 'Selecciona un Usuario',
                ],
            ],
        ],
        'clinic_id' => [
            'label' =>'Clínica',
            'type' => [
                'name' =>'select',
                'model' => 'clinics',
                'text' =>  'name',
                'value' => 'id',
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
                'text' =>  'name',
                'value' => 'id',
                'default' => [
                'text' => 'Selecciona una Oficina',
                ],
            ],
        ],
        'product_provider_id' => [
            'label' =>'Proveedor',
            'type' => [
                'name' =>'select',
                'model' => 'product_providers',
                'text' =>  'name',
                'value' => 'id',
                'default' => [
                'text' => 'Selecciona un Proveedor',
                ],
            ],
        ],
        'profile_id' => [
            'label' =>'Perfil',
            'type' => [
                'name' =>'select',
                'model' => 'profiles',
                'text' =>  'name',
                'value' => 'id',
                'default' => [
                'text' => 'Selecciona un Perfil',
                ],
            ],
        ],
    ];
    protected $listFields = [
        'left' => [
            'type' => ['chips'],
        ],
        'main' => [
            'address_line_1' => ['text'],
            'address_line_2' => ['text'],
            'main' => ['boolean'],
        ],
        'right' => [
            'description' => [],
        ],
    ];
    protected $keyField = 'details';
    // END Quasar DATA
      // Tableable DATA
  protected $tableColumns = [
    'user.name' => [
        'label' => 'Realizado por',
    ],
    'shopping_bag_id' => [
        'label' => 'Cesta',
        'show' => false
    ],
    'clinic.nickname' => [
        'label' => 'Clínica',
    ],
    'store.name' => [
        'label' => 'Oficina',
    ],
    'product_provider.provider.name' => [
        'label' => 'Proveedor',
    ],
    'profile.name' => [
        'label' => 'Personalizado para',
    ],
    'details' => [
        'label' => 'Detalles',
        'show' => false
    ],
    'orderable.description' => [
        'label' => 'Producto',
    ],
    'quantity' => [
        'label' => 'Catidad',
    ],
    'state' => [
        'label' => 'Estado',
        'keyNames' => [
            '1' => 'Placed',
            '2' => 'Recieve',
            '3' => 'Production',
            '4' => 'Sent',
            '5' => 'Delivered',
            '6' => 'Cancel'
        ]
    ],
    'priority' => [
        'label' => 'Prioridad',
        'keyNames' => [
            '1' => 'Urgente',
            '2' => 'Alta',
            '3' => 'Normal'
        ]
    ],
    'created_at' => [
      'label' => 'Creado',
    ],
    'updated_at' => [
        'label' => 'Modificado',
        'show' => false
    ],
    'deleted_at' => [
        'label' => 'Eliminado',
        'show' => false
    ],
  ];

    public function orderable()
    {
        return $this->morphTo();
    }
    public function shopping_bag() {
        return $this->belongsTo(ShoppingBag::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }
    public function store() {
        return $this->belongsTo(Store::class);
    }
    public function provider() {
        return $this->belongsTo(Provider::class);
    }
    public function product_provider() {
        // return $this->belongsTo(ProductProvider::class);
        return $this->belongsTo(ProductProvider::class)->with(static::parseRelationOptions('product_provider'));
    }
    public function profile() {
        return $this->belongsTo(Profile::class);
    }
}
