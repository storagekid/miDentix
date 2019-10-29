<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicSibling extends Qmodel
{
    use SoftDeletes;
    
    protected $fillable = ['clinic_id', 'sibling_id', 'starts_at', 'ends_at', 'type'];
    protected static $full = ['clinic', 'sibling'];

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
                ['clinic_id', 'sibling_id', 'starts_at', 'ends_at', 'type']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['clinic_id', 'sibling_id', 'starts_at', 'ends_at', 'type']
            ],
        ]
    ];
    protected $quasarFormFields = [
        'clinic_id' => [
            'label' =>'Clinic',
            'type' => [
                'name' =>'select',
                'model' => 'clinics',
                'default' => [
                    'text' => 'Selecciona una Clínica',
                ],
            ],
        ],
        'sibling_id' => [
            'label' =>'Hermana',
            'type' => [
                'name' =>'select',
                'model' => 'clinics',
                'default' => [
                    'text' => 'Selecciona una Clínica Hermana',
                ],
            ],
        ],
        'starts_at' => [
            'label' =>'Fecha Inicio',
            'type' => [
                'name' => 'date',
            ]
        ],
        'ends_at' => [
            'label' =>'Fecha Fin',
            'type' => [
                'name' => 'date',
            ]
        ],
        'type' => [
            'label' =>'Tipo',
            'type' => [
                'name' =>'array',
                'array' => ['Mailing'],
                'default' => [
                    'value' => null,
                    'text' => 'Selecciona un Tipo',
                    'disabled' => true,
                ],
            ],
        ],
    ];
    protected $listFields = [
        'left' => [
            'clinic_id' => ['text'],
        ],
        'main' => [
            'sibling_id' => ['text'],
        ],
        'right' => [
            'type' => ['text'],
        ],
    ];
    protected $keyField = 'clinic_id';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'clinic.fullName' => [
            'label' => 'Clínica',
        ],
        'sibling.fullName' => [
            'label' => 'Clínica Hermana',
        ],
        'starts_at' => [
            'label' => 'Fecha Inicio',
        ],
        'ends_at' => [
            'label' => 'Fecha Fin',
        ],
        'type' => [
            'label' => 'Relación',
        ]
    ];
    // END Table Data

    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }
    public function sibling () {
        return $this->belongsTo(Clinic::class, 'sibling_id');
    }
}
