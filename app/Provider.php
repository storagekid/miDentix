<?php

namespace App;


class Provider extends Qmodel
{
    protected $fillable = ['name', 'legal_name', 'user_id', 'description', 'CIF', 'CNAE'];
    protected static $full = ['products', 'user'];
    protected static $permissions = [
        'view' => [
            'Marketing' => ['*'],
        ]
    ];
    // Quasar DATA
    // protected $relatedTo = ['products'];
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'legal_name', 'user_id', 'description', 'CIF', 'CNAE']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'legal_name', 'user_id', 'description', 'CIF', 'CNAE']
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
        'CIF' => [
            'label' =>'CIF',
        ],
        'CNAE' => [
            'label' =>'CNAE',
        ],
        'legal_name' => [
            'label' =>'Nombre Legal',
        ],
        'user_id' => [
            'label' =>'Usuario',
            'type' => [
                'name' =>'select',
                'model' => 'users',
                'default' => [
                    'text' => 'Selecciona un Usuario',
                ],
            ],
        ],
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
        'legal_name' => [
            'label' => 'Nombre Legal',
        ],
        'description' => [
            'label' => 'Descripción',
        ],
        'CIF' => [
            'label' => 'CIF',
        ],
        'CNAE' => [
            'label' => 'CNAE',
        ],
        'user.name' => [
            'label' => 'Usuario',
        ]
    ];
    // END Table Data
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function products() {
        return $this->belongsToMany(Product::class, 'product_providers');
    }
}
