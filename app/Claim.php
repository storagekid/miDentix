<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Claim extends Qmodel
{
    Use SoftDeletes;

    protected $fillable = ['name', 'description', 'starts_at', 'ends_at', 'language_id', 'country_id'];
    protected static $full = ['language', 'country', 'legals'];

    protected static $permissions = [
        'view' => [
            'Marketing' => ['*'],
        ]
    ];

    // Quasar DATA
  protected $relatedTo = ['legals'];
  protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'starts_at', 'ends_at', 'language_id', 'country_id']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'starts_at', 'ends_at', 'language_id', 'country_id']
            ],
        ],
        [
            'title' => 'Legales',
            'icon' => 'gavel',
            'fields' => [],
            'relations' => ['legals']
        ],
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'description' => [
            'label' =>'Descripción',
        ],
        'language_id' => [
            'label' =>'Language',
            'type' => [
                'name' =>'select',
                'model' => 'languages',
                'default' => [
                    'text' => 'Selecciona un Idioma',
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
        ]
    ];
    protected $onRelationMode = ['table'];
    protected $listFields = [
        'left' => [],
        'main' => [
            'name' => ['text'],
        ],
        'right' => [
            'description' => ['text']
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
            'label' => 'Descripción',
        ],
        'language.native_name' => [
            'label' => 'Language',
        ],
        'country.name' => [
            'label' => 'País',
        ],
        'starts_at' => [
            'label' => 'Fecha Inicio',
        ],
        'ends_at' => [
            'label' => 'Fecha Fin',
        ],
        'legals_count' => [
            'label' => 'Legales'
        ],
        'current_legal' => [
            'label' => 'Legal Actual'
        ]
    ];
    // END Table Data

    public function language() {
        return $this->belongsTo(Language::class);
    }
    public function country() {
        return $this->belongsTo(Country::class);
    }
    public function legals()
    {
        return $this->morphMany(Legal::class, 'legalizable');
    }

    public function legalsByDates($start, $end) {
        $legals = collect();
        foreach ($this->legals as $legal) {
            if ($legal->starts_at > $end) continue;
            if ($legal->ends_at) {
                if ($legal->ends_at < $start) continue;
            }
            $legals->push($legal);
        }
        return $legals;
    }

    public function getCurrentLegalAttribute() {
        if (!count($this->legals)) return '-';
        else {
            return $this->legals->sortByDesc('starts_at')->first()->text;
        }
    }
}
