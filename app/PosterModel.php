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
            'title' => 'Información',
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
            'filtering' => ['select' => 'clinics'],
        ],
        'description' => [
            'label' => 'Descripción',
            'filtering' => ['search'],
        ],
        'sanitary_codes' => [
            'label' => 'CS Especiales',
            'filtering' => ['search'],
          ],
    ];
    protected $tableOptions = [['show', 'edit', 'clone', 'delete'], true, true];
    // END Table Data

    public function sanitary_codes()
    {
        return $this->morphMany(SanitaryCode::class, 'sanitizable');
    }
}
