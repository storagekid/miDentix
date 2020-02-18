<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Qmodel
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'description', 'storeable', 'profileable', 'customizable', 'product_category_id', 'parent_id'];
    protected static $full = ['product_providers', 'product_category', 'parent', 'children'];
    protected static $permissions = [
        'view' => [
            'Marketing' => ['*'],
        ]
    ];
    // Quasar DATA
    protected $relatedTo = ['product_providers'];
    protected static $relationOptions = [
        'product_providers' => [
            'with' => 'full'
        ]
        // 'ProductProvider' => [
        //     'with' => 'full'
        // ]
    ];
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'storeable', 'profileable', 'customizable', 'product_category_id', 'parent_id']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'storeable', 'profileable', 'customizable', 'product_category_id', 'parent_id']
            ],
        ],
        [
            'title' => 'Proveedores',
            'subtitle' => '',
            'fields' => [],
            'relations' => ['product_providers']
        ]
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'description' => [
            'label' =>'Descripción',
        ],
        'storeable' => [
            'label' =>'Personalizable (Clínica/Oficina)',
            'batch' => true,
            'type' => [
                'name' =>'boolean',
            ],
        ],
        'profileable' => [
            'label' =>'Personalizable (Empleado)',
            'batch' => true,
            'type' => [
                'name' =>'boolean',
            ],
        ],
        'customizable' => [
            'label' =>'Personalizable (Otros)',
            'batch' => true,
            'type' => [
                'name' =>'boolean',
            ],
        ],
        'product_category_id' => [
            'label' =>'Categoría',
            'batch' => true,
            'type' => [
                'name' =>'select',
                'model' => 'product_categories',
                'text' =>  'name',
                'value' => 'id',
                'default' => [
                    'text' => 'Selecciona una Categoria',
                ],
            ],
        ],
        'parent_id' => [
            'label' =>'Producto Superior',
            'batch' => true,
            'type' => [
                'name' =>'select',
                'model' => 'products',
                'hasFamily' => true,
                'text' =>  'description',
                'value' => 'id',
                'default' => [
                    'text' => 'Selecciona un Producto Padre',
                ],
            ],
        ]
    ];
    protected $listFields = [
        'left' => [],
        'main' => [
            'name' => ['text'],
        ]
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
        'storeable' => [
            'label' => 'Personalizable (Clínica/Oficina)',
            'type' => [
                'name' => 'boolean'
            ]
        ],
        'profileable' => [
            'label' => 'Personalizable (Empleado)',
            'type' => [
                'name' => 'boolean'
            ]
        ],
        'customizable' => [
            'label' => 'Personalizable (Otros)',
            'type' => [
                'name' => 'boolean'
            ]
        ],
        'product_category.name' => [
            'label' =>'Product Category',
        ],
        'parent.name' => [
            'label' => 'Padre',
        ],
        'children' => [
            'label' => 'Hijos',
        ],
        'product_providers' => [
            'label' => 'Proveedores',
        ]
    ];
    // END Table Data

    public function providers() {
        return $this->belongsToMany(Provider::class, 'product_providers');
    }
    public function product_providers() {
        // return $this->hasMany(ProductProvider::class)->with($this->relationOptions['product_providers']['with']);
        return $this->hasMany(ProductProvider::class)->with(static::parseRelationOptions('product_providers'));
    }
    public function product_category() {
        return $this->belongsTo(ProductCategory::class);
    }
    public function parent() {
        return $this->belongsTo(Product::class, 'parent_id');
    }
    public function children() {
        return $this->hasMany(Product::class, 'parent_id');
    }
}
