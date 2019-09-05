<?php

namespace App;


class Poster extends Qmodel
{
    
    // Quasar DATA
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['width', 'height', 'name', 'description', 'material']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['width', 'height', 'name', 'description', 'material']
            ],
        ],
    ];
    protected $quasarFormFields = [
        'width' => [
            'label' =>'Ancho',
        ],
        'height' => [
            'label' =>'Alto',
        ],
        'name' => [
            'label' =>'Name',
        ],
        'description' => [
            'label' =>'Descripción',
        ],
        'material' => [
            'label' =>'Material',
            'type' => [
                'name' =>'array',
                'array' => ['FOAM', 'Translight'],
                'default' => [
                    'text' => 'Selecciona un Material',
                ],
            ],
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
}
