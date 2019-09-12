<?php

namespace App;


class Store extends Qmodel
{
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
            ['name', 'description']
            ],
        ],
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'description' => [
            'label' =>'Descripción',
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
  
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function getCountryNameAttribute()
    {
        return $this->country ? $this->country->name : '-';
    }
}
