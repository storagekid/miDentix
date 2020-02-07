<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Qmodel
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'description', 'category', 'parent_id'];
    protected static $full = ['product_providers', 'parent', 'children'];
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
                ['name', 'description', 'category', 'parent_id']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'category', 'parent_id']
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
        'category' => [
            'label' =>'Categoría',
            'type' => [
                'name' =>'array',
                'array' => ['Stationary', 'Mailing'],
                'default' => [
                    'value' => null,
                    'text' => 'Selecciona un Tipo',
                    'disabled' => true,
                ],
            ],
        ],
        'parent_id' => [
            'label' =>'Producto Superior',
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
        'category' => [
            'label' =>'Category',
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
    public function parent() {
        return $this->belongsTo(Product::class, 'parent_id');
    }
    public function children() {
        return $this->hasMany(Product::class, 'parent_id');
    }
}
