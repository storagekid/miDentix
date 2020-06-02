<?php

namespace App;

class ProductCategory extends Qmodel
{
    protected $fillable = ['name', 'description'];
    protected static $permissions = [
        'view' => ['*']
    ];
    // Quasar DATA

    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description']
            ],
        ]
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' => 'Nombre',
        ],
        'description' => [
            'label' => 'Descripción',
        ]
    ];
    protected $listFields = [
        'left' => [],
        'main' => [
            'name' => ['text'],
        ],
        'right' => [],
    ];
    protected $keyField = 'name';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre'
        ],
        'description' => [
            'label' => 'Descripción'
        ]
    ];
    // END Tableable Data

    public function products() {
    	return $this->hasMany(Product::class);
    }
}
