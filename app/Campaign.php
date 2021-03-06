<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Campaign extends Qmodel
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'parent_id', 'starts_at', 'ends_at', 'poster_starts_at', 'poster_ends_at'];
    protected static $permissions = [
        'view' => [
            'Marketing' => ['*'],
        ]
    ];
    protected static $full = ['campaign_posters', 'campaign_poster_priorities', 'sanitary_codes', 'parent', 'children'];
    protected $appends = ['label', 'value', 'open', 'active'];

    // Quasar DATA
    protected $relatedTo = ['campaign_posters', 'campaign_poster_priorities', 'sanitary_codes'];

    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name','description', 'parent_id', 'starts_at', 'ends_at', 'poster_starts_at', 'poster_ends_at']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'parent_id', 'starts_at', 'ends_at', 'poster_starts_at', 'poster_ends_at']
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
        'parent_id' => [
            'label' =>'Campaña Origen',
            'type' => [
                'name' =>'select',
                'model' => 'campaigns',
                'hasFamily' => true,
                'text' =>  'name',
                'value' => 'id',
                'default' => [
                    'text' => 'Selecciona una Campaña de Origen',
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
        ],
        'open' => [
            'label' => 'Abierta',
            'type' => [
                'name' => 'boolean'
            ]
        ],
        'active' => [
            'label' => 'Activa',
            'type' => [
                'name' => 'boolean'
            ]
        ],
        'description' => [
            'label' => 'Descripción',
            'show' => false
        ],
        'parent.name' => [
            'label' => 'Campaña Origen',
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
    // END Table Data

    // STATICS
    public static function findOrActive($id=null) {
        if ($id) {
            $campaign = static::find($id);
            if ($campaign) return $campaign;
        }
        $campaigns = static::get();
        $filtered = $campaigns->filter(function($i) {
            if ($i->open) return $i;
            return false;
        });
        // $campaigns->map(function($i) {
        //     $i->append('campaign_posters_count');
        // });
        // $filtered = $campaigns->filter(function($i) {
        //     if ($i->open && $i->campaign_posters_count > 1) return $i;
        //     return false;
        // });
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
        return $this->hasMany(Campaign::class,'parent_id');
    }
    public function parent() {
        return $this->belongsTo(Campaign::class,'parent_id');
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
        return $this->morphMany(SanitaryCode::class, 'sanitizable');
    }
    public function getCampaignPostersCountAttribute () {
        return $this->campaign_posters()->count();
    }
    public function getOpenAttribute()
    {
        if ((Carbon::parse($this->starts_at))->greaterThan(Carbon::now())) return false;
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

    public function legalsCSVFileBuilder($language) {
        $legals = \App\Legal::where([['language_id', $language->id], ['ends_at', null]])->get();
        $content = null;
        $fileName = $this->name . ' legals-' . strtoupper($language['639-1']) . '.txt';
        $file = fopen(storage_path('app/temp/') . $fileName,"w");
        
        foreach ($legals as $legal) {
            fwrite($file,iconv("UTF-8","UTF-16LE",$legal->name));
	      	fwrite($file,iconv("UTF-8","UTF-16LE","\t"));
            $content .= iconv("UTF-8","UTF-16LE",$legal->name);
            $content .= iconv("UTF-8","UTF-16LE","\t");
        }
        fwrite($file,iconv("UTF-8","UTF-16LE","\n"));
        $content .= "\n";
        foreach ($legals as $legal) {
            fwrite($file,iconv("UTF-8","UTF-16LE",$legal->text));
	      	fwrite($file,iconv("UTF-8","UTF-16LE","\t"));
            $content .= iconv("UTF-8","UTF-16LE",$legal->text);
            $content .= iconv("UTF-8","UTF-16LE","\t");
        }
        fwrite($file,iconv("UTF-8","UTF-16LE","\n"));
        fclose($file);
        return $fileName;
    }
}
