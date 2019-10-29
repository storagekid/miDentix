<?php

namespace App;

use App\Traits\Fileable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Qmodel
{
    Use Fileable;
    Use SoftDeletes;

    protected $fillable = ['name', 'description', 'starts_at', 'ends_at', 'language_id', 'country_id', 'v_design_file_id', 'h_design_file_id', 'v_design_index_coords', 'h_design_index_coords'];
    protected static $full = ['language', 'country', 'v_design', 'h_design', 'legals'];
    // protected $appends = ['label', 'value'];

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
                ['name', 'description', 'starts_at', 'ends_at', 'language_id', 'country_id', 'v_design_file_id', 'h_design_file_id', 'v_design_index_coords', 'h_design_index_coords']
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
        ],
        'v_design_file_id' => [
            'label' =>'Diseño Vertical',
            'unreal' => true,
            'type' => [
              'name' => 'file',
            ],
        ],
        'h_design_file_id' => [
            'label' =>'Diseño Horizontal',
            'unreal' => true,
            'type' => [
              'name' => 'file',
            ],
        ],
        'v_design_index_coords' => [
            'label' =>'V Index Coords',
        ],
        'h_design_index_coords' => [
            'label' =>'H Index Coords',
        ],
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
            'filtering' => ['search'],
        ],
        'country.name' => [
            'label' => 'País',
            'filtering' => ['search'],
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
        ],
        'v_design.thumbnail' => [
            'label' => 'V Design',
            'show' => false,
            'onGrid' => 'footer'
        ],
        'h_design.thumbnail' => [
            'label' => 'H Design',
            'show' => false,
            'onGrid' => 'footer'
        ],
        'v_design_index_coords' => [
            'label' => 'V Index Coords',
            'show' => false,
        ],
        'h_design_index_coords' => [
            'label' => 'H Index Coords',
            'show' => false,
        ],
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
        // dump($start);
        // dump($end);
        $legals = collect();
        foreach ($this->legals as $legal) {
            // dump($legal->name);
            // dump($legal->starts_at);
            // dump($legal->ends_at);
            if ($legal->starts_at > $end) continue;
            if ($legal->ends_at) {
                if ($legal->ends_at < $start) continue;
            }
            $legals->push($legal);
        }
        // dump($legals);
        return $legals;
    }

    public function getCurrentLegalAttribute() {
        if (!count($this->legals)) return '-';
        else {
            return $this->legals->sortByDesc('starts_at')->first()->text;
        }
    }
}
