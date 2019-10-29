<?php

namespace App;

class PosterModel extends Qmodel
{

    protected $fillable = ['name', 'description'];
    protected static $permissions = [
        'view' => [
            'Marketing' => ['user', 'editor', 'administrator', 'overseeker'],
        ]
    ];
    protected static $full = ['sanitary_codes'];
    // Quasar DATA
    protected $relatedTo = ['sanitary_codes'];

    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description']
            ],
        ],
        [
            'title' => 'Códigos Sanitarios',
            'subtitle' => 'General',
            'icon' => 'spellcheck',
            'fields' => [],
            'relations' => ['sanitary_codes']
        ],
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Name',
        ],
        'description' => [
            'label' => 'Descripción',
            'batch' => true
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
    // Tableable DATA
    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre',
        ],
        'description' => [
            'label' => 'Descripción',
        ],
        'sanitary_codes' => [
            'label' => 'CS Especiales',
        ],
    ];
    // END Table Data

    public function sanitary_codes()
    {
        return $this->morphMany(SanitaryCode::class, 'sanitizable');
    }
}
