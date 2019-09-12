<?php

namespace App;


class Phone extends Qmodel
{

    protected $fillable = ['number','type','description','main'];
    protected $casts = ['main' => 'boolean'];
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
                ['number','type','description','main']
            ],
        ],
    ];
    protected $quasarFormFields = [
        'number' => [
            'label' =>'Número',
        ],
        'type' => [
            'label' =>'Tipo',
            'type' => [
                'name' =>'array',
                'array' => ['Móvil', 'Personal', 'Casa', 'Oficina', 'Virtual', 'Comercial'],
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
        'main' => [
            'label' =>'Principal',
            'type' => [
                'name' =>'boolean',
                'default' => [
                    'text' => '¿Es el principal?',
                ],
            ],
        ]
    ];
    protected $listFields = [
        'left' => [
            'type' => ['chips'],
        ],
        'main' => [
            'number' => ['text'],
            'main' => ['boolean'],
        ],
        'right' => [
            'description' => [],
        ],
    ];
    protected $keyField = 'number';
    // END Quasar DATA
    
    public function phoneable()
    {
        return $this->morphTo();
    }
    public function setMainAttribute($value)
    {
        $this->attributes['main'] = (int)($value === 'true');
    }
}
