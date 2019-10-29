<?php

namespace App;


class County extends Qmodel
{
    protected $fillable = ['name', 'state_id'];
    protected $with = ['state'];
    protected static $permissions = [
        'view' => ['*']
    ];
    // Quasar DATA
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'state_id']
            ],
        ]
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'state_id']
            ],
        ]
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'state_id' => [
            'label' =>'CCAA',
            'type' => [
                'name' =>'select',
                'model' => 'states',
                'default' => [
                    'text' => 'Selecciona una CCAA',
                ],
            ],
        ],
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
            'label' => 'Nombre',
        ],
        'state.label' => [
            'label' => 'CCAA',
        ],
    ];
    // END Table Data
    public function state() {
    	return $this->belongsTo(State::class);
    }
    public function clinics() {
        return $this->hasMany(Clinic::class);
    }
}
