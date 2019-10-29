<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Qmodel
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'description', 'company_id', 'country_id'];
    protected $full = ['country', 'company'];
    protected static $permissions = [
        'view' => [
            'Marketing' => ['*'],
            'Clinics' => ['*'],
        ]
    ];
    // Quasar DATA
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'company_id', 'country_id']
            ],
        ]
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'company_id', 'country_id']
            ],
        ]
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'description' => [
            'label' =>'Descipción',
        ],
        'company_id' => [
            'label' =>'Empresa',
            'type' => [
                'name' =>'select',
                'model' => 'companies',
                'default' => [
                    'text' => 'Selecciona una Empresa',
                ],
            ],
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
        'right' => [
            'description' => ['text'],
        ],
    ];
    protected $keyField = 'name';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre',
        ],
        'description' => [
            'label' =>'Descipción',
        ],
        'company.label' => [
            'label' => 'Empresa',
        ],
        'country.label' => [
            'label' => 'País',
        ],
    ];
    // END Table Data
  
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function getCountryNameAttribute()
    {
        return $this->country ? $this->country->name : '-';
    }
}
