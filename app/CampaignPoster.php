<?php

namespace App;

use App\Traits\Fileable;

class CampaignPoster extends Qmodel
{
    use Fileable;

    protected $with = ['poster', 'posterModel', 'language', 'country', 'state', 'poster_af'];
    protected $appends = ['name'];
    protected $fillable = [
        'campaign_id', 'poster_id', 'poster_model_id', 'language_id', 'country_id', 'state_id', 'county_id', 'clinic_id', 'type', 'file', 'link', 'thumbnail'
    ];
    protected static $permissions = [
        'view' => [
            'Marketing' => ['*'],
        ]
    ];

    // Table Data
    protected $tableColumns = [
        'campaign_id' => [
            'label' => 'Camapaña',
            'onGrid' => 'hide'
        ],
        'poster.name' => [
            'label' => 'Poster Size',
        ],
        'poster_model.name' => [
            'label' => 'Poster Model',
        ],
        'language.native_name' => [
            'label' => 'Language',
        ],
        'country.name' => [
            'label' => 'País',
        ],
        'state.name' => [
            'label' => 'CCAA',
        ],
        'county.name' => [
            'label' => 'Provincia',
        ],
        'clinic.nickname' => [
            'label' => 'Clínica',
        ],
        'type' => [
            'label' => 'Type',
        ],
        'poster_af.thumbnail' => [
            'label' => 'Poster AF',
            'onGrid' => 'footer'
        ]
    ];
    // END Table Data

    // Quasar DATA
    protected $onRelationMode = ['table'];
    
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['campaign_id', 'poster_id', 'poster_model_id', 'language_id', 'country_id', 'state_id', 'county_id', 'clinic_id', 'type', 'file', 'multiFile']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name','description']
            ],
        ]
    ];

    protected $quasarFormFields = [
        'campaign_id' => [
            'label' =>'Campaign',
            'type' => [
                'name' =>'select',
                'model' => 'campaigns',
                'default' => [
                    'text' => 'Selecciona una Campaña',
                ],
            ],
        ],
        'poster_id' => [
            'label' =>'Poster Size',
            'type' => [
                'name' =>'select',
                'model' => 'posters',
                'default' => [
                    'text' => 'Selecciona un Tamaño',
                ],
            ],
        ],
        'poster_model_id' => [
            'label' =>'Poster Model',
            'type' => [
                'name' =>'select',
                'model' => 'poster_models',
                'default' => [
                    'text' => 'Selecciona un Modelo',
                ],
            ],
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
        'state_id' => [
            'label' =>'CCAA',
            'type' => [
                'name' =>'select',
                'model' => 'states',
                'default' => [
                    'text' => 'Selecciona una CCAA',
                ],
            ],
        ],
        'county_id' => [
            'label' =>'Provincia',
            'type' => [
                'name' =>'select',
                'model' => 'counties',
                'default' => [
                    'text' => 'Selecciona una Provincia',
                ],
            ],
        ],
        'clinic_id' => [
            'label' =>'Clínica',
            'type' => [
                'name' =>'select',
                'model' => 'clinics',
                'default' => [
                    'text' => 'Selecciona una Clínica',
                ],
            ],
        ],
        'type' => [
            'label' =>'Tipo',
            'type' => [
                'name' =>'array',
                'array' => ['Int', 'Ext', 'Office', 'Office Int'],
                'default' => [
                    'text' => 'Selecciona un Tipo',
                ],
            ],
        ],
        'file' => [
          'label' =>'Diseño',
          'unreal' => true,
          'type' => [
            'name' => 'file',
          ],
        ],
        'multiFile' => [
            'unreal' => true,
            'label' =>'Diseño',
            'type' => [
              'name' => 'multiFile',
            ],
        ],
    ];
    protected $listFields = [
        'mode' => 'table-grid',
        'left' => [],
        'main' => [
            'thumbnail64' => ['image'],
        ],
        'right' => [
            'file' => ['text']
        ],
    ];
    protected $keyField = 'name';
    // END Quasar DATA

    public function poster() {
        return $this->belongsTo(Poster::class);
    }
    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }
    public function posterModel() {
        return $this->belongsTo(PosterModel::class);
    }
    public function language() {
        return $this->belongsTo(Language::class);
    }
    public function country() {
        return $this->belongsTo(Country::class);
    }
    public function county() {
        return $this->belongsTo(County::class);
    }
    public function state() {
        return $this->belongsTo(State::class);
    }
    public function clinic() {
        return $this->belongsTo(Clinic::class)->withTrashed();
    }
    public function getNameAttribute() {
        return $this->posterModel->name . ' - ' . $this->poster->name . ' - ' . $this->language->native_name;
    }
    public function getPriorityAttribute () {
        $priorities = $this->campaign->campaign_poster_priorities;
        $candidates = [];
        foreach ($priorities as $priority) {
            if ($priority->poster_model_id === $this->poster_model_id) {
                $candidates[] = $priority->priority;
                // return $priority->priority;
            }
        }
        if (count($candidates) === 1) return $candidates[0];
        return $candidates;
    }
    public function satinaryCodesByCampaign () {
        $codes = $this->posterModel->sanitary_codes()->where(["campaign_id" => $this->campaign_id])->get();
        $grouped = $codes->groupBy(['clinic_id', 'county_id', 'state_id']);
        // dd($codes);
        return $codes;
        return $grouped->toArray();
    }
    // public function getThumbnailAttribute($value)
    // {
    //     $base64 = 'data:image/jpeg;base64,';
    //     $thumbnail = new \Imagick(public_path($value));
    //     $blob = $thumbnail->getImageBlob();
    //     return $base64 . base64_encode($blob);
    // }
    public function getThumbnail64Attribute()
    {
        // return null;
        if (file_exists(storage_path('app/' . $this->thumbnail))) {
            $base64 = 'data:image/jpeg;base64,';
            $thumbnail = new \Imagick(storage_path('app/' . $this->thumbnail));
            $blob = $thumbnail->getImageBlob();
            return $base64 . base64_encode($blob);
        }
        return '';
    }
    public function getFileName() {
        $posterModel = \App\PosterModel::find(request('poster_model_id'))->name;
        $size = \App\Poster::find(request('poster_id'))->name;
        $country = \App\Country::find(request('country_id'))->code_a2;
        $lang = strtoupper(\App\Language::find(request('language_id'))['639-1']);
        // $pos = strpos($lang, ',');
        // if ($pos) $lang = substr($lang, 0, $pos);
        $name = $this->campaign->name . ' ' . $posterModel . ' ' . $size . ' ' . request('type') . ' ' . $country;
        if (request('state_id')) {
            $state = \App\State::find(request('state_id'))->name;
            $pos = strpos($state, ',');
            if ($pos) $state = substr($state, 0, $pos);
            $name .= '-' . $state;
        }
        // request('state_id'] ? $name .= '-' . \App\state::find(request('state_id'])->name : '';
        request('county_id') ? $name .= '-' . \App\County::find(request('county_id'))->name : '';
        request('clinic_id') ? $name .= '-' . \App\Clinic::find(request('clinic_id'))->cleanName : '';
        $name .=  ' ' . $lang;
        // $name .=  '.pdf';
        return $name;
    }
}
