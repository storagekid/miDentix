<?php

namespace App;

use App\Country;

class State extends Qmodel
{
    protected $fillable = ['name', 'country_id'];
    protected $with = ['country'];
    protected static $permissions = [
        'view' => ['*'],
    ];
    // Quasar DATA
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'country_id']
            ],
        ]
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'country_id']
            ],
        ]
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'country_id' => [
            'label' =>'País',
            'type' => [
                'name' =>'select',
                'model' => 'countries',
                'default' => [
                    'text' => 'Selecciona un País',
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
        'country.label' => [
            'label' => 'País',
        ],
    ];
    // END Table Data
    
    public function country() {
    	return $this->belongsTo(Country::class);
    }
    public function counties() {
        return $this->hasMany(County::class);
    }
}
