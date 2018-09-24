<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCPDF;
use Illuminate\Support\Facades\Storage;
use App\Traits\Tableable;
use App\Traits\Formable;

class Stationary extends Model
{
    use Tableable;
    use Formable;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description','details','customizable','provider_id', 'price', 'file', 'link'
    ];

    protected $appends = ['providerList'];

    protected $with = ['providers'];

    // Tableable DATA
    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre'
        ], 
        'description' => [
            'label' => 'Descripción',
            'filtering' => ['search']
        ], 
        'details' => [
            'label' => 'Detalles'
        ], 
        'customizable' => [
            'label' => 'Personalizable',
            'boolean' => ['Sí','No'],
            'sorting' => ['integer'],
            'filtering' => [
                'off',
                'boolean' => ['No','Sí']
            ],
            'multiEdit' => true,
        ], 
        'price' => [
            'label' => 'Precio',
            'multiEdit' => true,
        ], 
        'providerList' => [
            'label' => 'Proveedores',
            'parse' => true
        ],
        'link' => [
            'label' => 'Diseño',
            'boolean' => ['Sí','No'],
            'sorting' => ['integer'],
            'filtering' => [
                'boolean' => ['No','Sí']
            ],
        ], 
    ];

    protected $tableOptions = [['show','edit','delete'], true, true];

    // END Tableable Data

    // Formable DATA

    protected $formFields = [
        'name' => [
            'label' =>'Nombre',
            'rules' =>['required','min:5','max:64'],
          ],
          'description' => [
            'label' =>'Descripción',
            'rules' =>['required','min:5','max:64'],
          ],
          'price' => [
            'label' =>'Precio',
            'rules' =>['required'],
            'type' => [
              'name' =>'inputDecimal',
            ],
          ],
          'details' => [
            'label' =>'Detalles',
            'rules' =>['required','min:5','max:255'],
          ],
          'customizable' => [
            'label' =>'Personalizable',
            'value' =>false,
            'type' => [
              'name' =>'checkBox',
            ],
            'batch' => true,
          ],
          'file' => [
            'label' =>'Diseño',
            'value' =>false,
            'type' => [
              'name' => 'file',
            ],
          ],
    ];

    protected $formModels = ['countries','counties','states','providers'];

    protected $formRelations = [
        'providers' => [
            'label' => 'Proveedores',
            'header' => 'Nuevo Proveedor',
            'name' => 'providers',
            'fields' => [
              'country_id' => [
                'label' => 'País',
                'rules' => ['required'],
                'name' => 'country_id',
                'value' => null,
                'dontRecord' => false,
                'affects' => 'state_id',
                'type' => [
                  'name' => 'select',
                  'model' => 'countries',
                  'text' => 'name',
                  'value' => 'id',
                  'default' => [
                    'value' => null,
                    'text' => 'Selecciona un País',
                    'disabled' => true,
                  ],
                ],
              ],
              'state_id' => [
                'label' => 'CCAA',
                'rules' => [],
                'name' => 'state_id',
                'value' => null,
                'dontRecord' => false,
                'dependsOn' => 'country_id',
                'affects' => 'county_id',
                'type' => [
                  'name' => 'select',
                  'model' => 'states',
                  'text' => 'name',
                  'value' => 'id',
                  'default' => [
                    'value' => null,
                    'text' => 'Selecciona una CCAA',
                    'disabled' => true,
                  ],
                ],
              ],
              'county_id' => [
                'label' => 'Provincia',
                'rules' => [],
                'name' => 'county_id',
                'value' => null,
                'dependsOn' => 'state_id',
                'affects' => 'clinic_id',
                'type' => [
                  'name' => 'select',
                  'model' => 'counties',
                  'text' => 'name',
                  'value' => 'id',
                  'default' => [
                    'value' => null,
                    'text' => 'Selecciona una Provincia',
                    'disabled' => true,
                  ],
                ],
              ],
              'clinic_id' => [
                'label' => 'Clínica',
                'rules' => [],
                'name' => 'clinic_id',
                'value' => null,
                'dontRecord' => false,
                'dependsOn' => 'county_id',
                'type' => [
                  'name' => 'select',
                  'model' => 'clinics',
                  'text' => 'fullName',
                  'value' => 'id',
                  'default' => [
                    'value' => null,
                    'text' => 'Selecciona una Clínica',
                    'disabled' => true,
                  ],
                ],
              ],
              'provider_id' => [
                'label' => 'Proveedor',
                'rules' => [],
                'name' => 'provider_id',
                'value' => null,
                'dontRecord' => false,
                'type' => [
                  'name' => 'select',
                  'model' => 'providers',
                  'text' => 'name',
                  'value' => 'id',
                  'default' => [
                    'value' => null,
                    'text' => 'Selecciona un Proveedor',
                    'disabled' => true,
                  ],
                ],
              ],
            ]
        ]
    ];

    // END Formable DATA

    public function providers() {
        return $this->hasMany(Provider_Stationary::class, 'product_id');
    }

    public function getProviderListAttribute() {
        // return implode(', ', $this->providers->pluck('name')->toArray());
        return $this->providers->pluck('providerName');
    }

    public function orders() {
        return $this->morphMany(Order::class, 'orderable');
    }

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class)
            ->withPivot(['id', 'file', 'link']);
    }

    public function getCleanDescriptionAttribute() {
        return cleanString($this->description);
    }

    public function setCustomizableAttribute($value) {
        $this->attributes['customizable'] = $value == null ? false : true;
    }
}
