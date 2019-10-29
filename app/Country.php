<?php

namespace App;


class Country extends Qmodel
{
    protected $fillable = ['name', 'code_a2', 'code_a3', 'code_un', 'currency_id', 'language_id'];
    // protected $with = ['language'];
    protected static $full = ['language', 'legals', 'states', 'currency'];
    protected static $permissions = [
      'view' => ['*']
    ];

    // Quasar DATA
    protected $relatedTo = ['legals'];
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'code_a2', 'code_a3', 'code_un', 'currency_id', 'language_id']
            ],
        ]
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'code_a2', 'code_a3', 'code_un', 'currency_id', 'language_id']
            ],
        ],
        [
            'title' => 'Legales',
            'subtitle' => 'General',
            'icon' => 'gavel',
            'fields' => [],
            'relations' => ['legals']
        ],
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'code_a2' => [
            'label' =>'Código (ISO Alpha 2)',
        ],
        'code_a3' => [
          'label' =>'Código (ISO Alpha 3)',
        ],
        'code_un' => [
          'label' =>'Código (ISO UN)',
        ],
        'currency_id' => [
            'label' =>'Divisa',
            'type' => [
                'name' =>'select',
                'model' => 'currencies',
                'default' => [
                    'text' => 'Selecciona una Divisa',
                ],
            ],
          ],
        'language_id' => [
          'label' =>'Idioma',
          'type' => [
              'name' =>'select',
              'model' => 'languages',
              'default' => [
                  'text' => 'Selecciona un Idioma',
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
            'code_a2' => ['text'],
        ],
    ];
    protected $keyField = 'name';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre',
        ],
        'code_a2' => [
            'label' => 'Código (ISO Alpha 2)',
        ],
        'code_a3' => [
          'label' => 'Código (ISO Alpha 3)',
        ],
        'code_un' => [
          'label' => 'Código (ISO UN)',
        ],
        'currency.name' => [
            'label' => 'Divisa',
        ],
        'language.label' => [
            'label' => 'Idioma',
        ],
        'current_legal' => [
            'label' => 'Legal Actual'
        ],
        'legals_count' => [
            'label' => 'Legales'
        ],
    ];
    // END Table Data

    public function language() {
      return $this->belongsTo(Language::class);
    }
    public function currency() {
        return $this->belongsTo(Currency::class);
      }
    public function states() {
        return $this->hasMany(State::class);
    }
    public function legals()
    {
        return $this->morphMany(Legal::class, 'legalizable');
    }

    public function getCurrentLegalAttribute() {
        if (!count($this->legals)) return '-';
        else {
            return $this->legals->sortByDesc('starts_at')->first()->text;
        }
    }
}
