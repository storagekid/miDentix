<?php

namespace App;


class Company extends Qmodel
{
    protected $with = ['stores'];
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
                ['name','type','description','CIF']
            ],
        ],
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'type' => [
            'label' =>'Tipo',
            'type' => [
                'name' =>'array',
                'array' => ['Matrix', 'Sister', 'Subsidiary', 'Provider', 'Client'],
                'default' => [
                    'value' => null,
                    'text' => 'Selecciona un Tipo',
                    'disabled' => true,
                ],
            ],
        ],
        'description' => [
            'label' =>'Descripción',
        ],
        'CIF' => [
          'label' =>'CIF',
        ],
    ];
    protected $listFields = [
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

    public function stores() {
        return $this->hasMany(Store::class);
    }
}
