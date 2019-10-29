<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Qmodel
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'description', 'category', 'parent_id'];
    protected static $full = ['service_providers', 'parent', 'children'];
    protected static $permissions = [
        'view' => [
            'Marketing' => ['*'],
        ]
    ];
    // Quasar DATA
    protected $relationOptions = [
        'service_providers' => [
            'with' => ['provider', 'country', 'state', 'county', 'clinic', 'store']
        ]
    ];
    protected $relatedTo = ['service_providers'];
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'category', 'parent_id']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'category', 'parent_id']
            ],
        ],
        [
            'title' => 'Proveedores',
            'subtitle' => '',
            'fields' => [],
            'relations' => ['service_providers']
        ]
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'description' => [
            'label' =>'Descripción',
        ],
        'category' => [
            'label' =>'Categoría',
            'type' => [
                'name' =>'array',
                'array' => ['Stationary', 'Mailing'],
                'default' => [
                    'value' => null,
                    'text' => 'Selecciona un Tipo',
                    'disabled' => true,
                ],
            ],
        ],
        'parent_id' => [
            'label' =>'Servicio Superior',
            'type' => [
                'name' =>'select',
                'model' => 'services',
                'hasFamily' => true,
                'text' =>  'description',
                'value' => 'id',
                'default' => [
                    'text' => 'Selecciona un Servicio Padre',
                ],
            ],
        ]
    ];
    protected $listFields = [
        'left' => [],
        'main' => [
            'name' => ['text'],
        ]
    ];
    protected $keyField = 'name';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre',
        ],
        'description' => [
            'label' => 'Descripción',
        ],
        'category' => [
            'label' =>'Category',
        ],
        'parent.name' => [
            'label' => 'Padre',
        ],
        'children' => [
            'label' => 'Hijos',
        ],
        'service_providers' => [
            'label' => 'Proveedores',
        ]
    ];
    // END Table Data

    public function providers() {
        return $this->belongsToMany(Provider::class, 'service_providers');
    }
    public function service_providers() {
        return $this->hasMany(ServiceProvider::class)->with($this->relationOptions['service_providers']['with']);
    }
    public function parent() {
        return $this->belongsTo(Service::class, 'parent_id');
    }
    public function children() {
        return $this->hasMany(Service::class, 'parent_id');
    }
}
