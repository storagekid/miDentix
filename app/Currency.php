<?php

namespace App;


class Currency extends Qmodel
{
    protected $fillable = ['name','code_alpha', 'code_num', 'decimals', 'notes'];
    protected static $full = ['countries'];
    protected static $permissions = [
      'view' => ['*']
    ];

    // Quasar DATA
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name','code_alpha', 'code_num', 'decimals', 'notes']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name','code_alpha', 'code_num', 'decimals', 'notes']
            ],
        ]
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'ISO Name',
        ],
        'code_alpha' => [
            'label' =>'Alpha Code',
        ],
        'code_num' => [
            'label' =>'Numeric Code',
        ],
        'decimals' => [
            'label' =>'Decimals',
            'type' => [
                'name' =>'number',
            ],
        ],
        'notes' => [
            'label' =>'Notes',
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
            'label' =>'ISO Name',
        ],
        'code_alpha' => [
            'label' =>'Alpha Code',
        ],
        'code_num' => [
            'label' =>'Numeric Code',
        ],
        'decimals' => [
            'label' =>'Decimals',
        ],
        'countries' => [
            'label' =>'Países',
        ],
        'notes' => [
            'label' =>'Notes',
        ]
    ];
    // END Table Data

    public function countries() {
        return $this->hasMany(Country::class);
    }
}
