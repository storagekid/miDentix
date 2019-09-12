<?php

namespace App;


class Email extends Qmodel
{

    protected $fillable = ['email','type','description','main'];
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
                ['email','type','description','main']
            ],
        ],
    ];
    protected $quasarFormFields = [
        'email' => [
            'label' =>'Email',
        ],
        'type' => [
            'label' =>'Tipo',
            'type' => [
                'name' =>'array',
                'array' => ['Personal', 'Trabajo', 'Comercial'],
                'default' => [
                    'text' => 'Selecciona un Tipo',
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
            'email' => ['text'],
            'main' => ['boolean'],
        ],
        'right' => [
            'description' => ['text'],
        ],
    ];
    protected $keyField = 'email';
    // END Quasar DATA

    public function emailable()
    {
        return $this->morphTo();
    }
    // MUTATORS
    public function setMainAttribute($value)
    {
        $this->attributes['main'] = (int)($value === 'true');
    }
    // END MUTATORS
}
