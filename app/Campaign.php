<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Campaign extends Qmodel
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'starts_at', 'ends_at', 'poster_starts_at', 'poster_ends_at'];
    // protected $with = ['campaign_posters', 'campaign_poster_priorities'];

    // Quasar DATA
    protected $relatedTo = ['campaign_posters', 'campaign_poster_priorities', 'sanitary_codes'];

    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name','description', 'starts_at', 'ends_at', 'poster_starts_at', 'poster_ends_at']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'starts_at', 'ends_at', 'poster_starts_at', 'poster_ends_at']
            ],
        ],
        [
            'title' => 'Carteles',
            'icon' => 'photo_album',
            'fields' => [],
            'relations' => ['campaign_posters']
        ],
        [
            'title' => 'Priorities',
            'icon' => 'shuffle',
            'fields' => [],
            'relations' => ['campaign_poster_priorities']
        ],
        [
            'title' => 'Códigos Sanitarios',
            'icon' => 'spellcheck',
            'fields' => [],
            'relations' => ['sanitary_codes']
        ],
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'description' => [
            'label' =>'Descripción',
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
        'poster_starts_at' => [
            'label' =>'Fecha Inicio Cartelería',
            'type' => [
                'name' => 'date',
            ]
        ],
        'poster_ends_at' => [
            'label' =>'Fecha Fin Cartelería',
            'type' => [
                'name' => 'date',
            ]
        ]
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
            'filtering' => ['search'],
        ],
        'open' => [
            'label' => 'Abierta',
            'filtering' => ['select' => 'clinics'],
        ],
            'active' => [
            'label' => 'Activa',
            'filtering' => ['select' => 'clinics'],
        ],
        'description' => [
            'label' => 'Descripción',
            'filtering' => ['search'],
            'show' => false
        ],
        'starts_at' => [
            'label' => 'Fecha Inicio',
        ],
        'ends_at' => [
            'label' => 'Fecha Fin',
            'show' => false
        ],
        'poster_starts_at' => [
            'label' => 'Inicio Cartelería',
        ],
        'poster_ends_at' => [
            'label' => 'Fin Cartelería',
            'show' => false
        ],
        'sanitary_codes_count' => [
            'label' => 'CCSS'
        ],
        'campaign_poster_priorities_count' => [
            'label' => 'Modelos'
        ],
        'campaign_posters_count' => [
            'label' => 'Carteles'
        ],
        'campaign_facades_count' => [
            'label' => 'PDFs'
        ],
        'actions' => [
            'label' => 'Actions'
        ]
    ];
    protected $tableOptions = [['show', 'edit', 'clone', 'delete'], true, true];
    // END Table Data
    protected static $full = ['campaign_posters', 'campaign_poster_priorities', 'sanitary_codes'];
    protected $appends = ['label', 'value', 'open', 'active'];

    // STATICS
    public static function findOrActive($id=null) {
        if ($id) {
            $campaign = static::find($id);
            if ($campaign) return $campaign;
        }
        $campaigns = static::get();
        $campaigns->map(function($i) {
            $i->append('campaign_posters_count');
        });
        $filtered = $campaigns->filter(function($i) {
            if ($i->open && $i->campaign_posters_count > 1) return $i;
            return false;
        });
        $sorted = $filtered->sortByDesc('starts_at');
        return $sorted->first();
    }
    public static function findOrDefault($id=null) {
        if ($id) {
            $campaign = static::find($id);
            if ($campaign) return $campaign;
        }
        $campaign = static::make([
            'name' => 'Por defecto',
            'description' => 'Sin Camapaña ESpecífica',
            'starts_at' => Carbon::parse('2000-01-01'),
            'ends_at' => Carbon::parse('2999-12-31')
        ]);
        $campaign->id = '';
        return $campaign;
    }
    // END STATICS

    public function children() {
        return $this->hasMany(Campaign,'parent_id');
    }
    public function parent() {
        return $this->belongsTo(Campaign,'parent_id');
    }
    public function campaign_poster_priorities () {
        return $this->hasMany(CampaignPosterPriority::class);
    }
    public function campaign_posters () {
        return $this->hasMany(CampaignPoster::class);
    }
    public function campaign_facades () {
        return $this->hasMany(ClinicCampaignFacade::class);
    }
    public function clinic_poster_priorities () {
        return $this->hasMany(ClinicPosterPriority::class);
    }
    public function clinic_poster_distribution () {
        return $this->hasMany(ClinicPosterDistribution::class);
    }
    public function sanitary_codes () {
        return $this->hasMany(SanitaryCode::class);
    }
    public function getCampaignPostersCountAttribute () {
        return $this->campaign_posters()->count();
    }
    public function getOpenAttribute()
    {
        if (!$this->ends_at) return true;
        return (Carbon::parse($this->ends_at))->greaterThan(Carbon::now());
    }
    public function getPostersMissingAttribute()
    {
        return (!$this->deleted_at);
    }
    public function getActiveAttribute()
    {
        return (!$this->deleted_at);
    }
}
