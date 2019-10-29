<?php

namespace App;

class Language extends Qmodel
{
    protected $fillable = ['iso_name','native_name', '639-1', '639-2/T', '639-2/B', '639-3', 'notes'];
    protected static $full = [];
    protected static $permissions = [
      'view' => ['*']
    ];

    // Quasar DATA
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['iso_name','native_name', '639-1', '639-2/T', '639-2/B', '639-3', 'notes']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['iso_name','native_name', '639-1', '639-2/T', '639-2/B', '639-3', 'notes']
            ],
        ]
    ];
    protected $quasarFormFields = [
        'iso_name' => [
            'label' =>'ISO Name',
        ],
        'native_name' => [
            'label' =>'Native Name',
        ],
        '639-1' => [
            'label' =>'639-1 Code',
        ],
        '639-2/T' => [
            'label' =>'639-2/T Code',
        ],
        '639-2/B' => [
            'label' =>'639-2/B Code',
        ],
        '639-3' => [
            'label' =>'639-3 Code',
        ],
        'notes' => [
            'label' =>'Notes',
        ]
    ];
    protected $listFields = [
        'left' => [],
        'main' => [
            'native_name' => ['text'],
        ],
        'right' => [],
    ];
    protected $keyField = 'native_name';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'iso_name' => [
            'label' =>'ISO Name',
        ],
        'native_name' => [
            'label' =>'Native Name',
        ],
        '639-1' => [
            'label' =>'639-1 Code',
        ],
        '639-2/T' => [
            'label' =>'639-2/T Code',
        ],
        '639-2/B' => [
            'label' =>'639-2/B Code',
        ],
        '639-3' => [
            'label' =>'639-3 Code',
        ],
        'notes' => [
            'label' =>'Notes',
        ]
    ];
    // END Table Data
}
