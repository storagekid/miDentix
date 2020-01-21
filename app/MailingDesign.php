<?php

namespace App;
use App\Traits\Fileable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class MailingDesign extends Qmodel
{
    use Fileable;

    protected $fillable = ['name', 'description', 'mailing_id', 'type', 'language_id', 'country_id', 'state_id', 'county_id', 'clinic_id', 'base_af_file_id'];
    protected static $full = ['mailing', 'language', 'country', 'state', 'county', 'clinic', 'clinics', 'counties', 'states', 'promotions', 'claims', 'base_af', 'clinic_mailings'];
    // protected $with = ['language', 'country', 'state', 'county', 'clinic', 'base_af', 'promotions', 'clinic_mailings'];

    protected static $permissions = [
        'view' => [
            'Marketing' => ['*'],
        ]
    ];

    // Quasar DATA
    protected $relatedTo = ['clinics', 'counties', 'states', 'promotions', 'claims', 'clinic_mailings'];
    public static $cascade = ['clinics', 'counties', 'states', 'promotions', 'claims', 'clinic_mailings'];
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'mailing_id', 'type', 'language_id', 'country_id', 'state_id', 'county_id', 'clinic_id', 'base_af_file_id']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name', 'description', 'mailing_id', 'type', 'language_id', 'country_id', 'state_id', 'county_id', 'clinic_id', 'base_af_file_id']
            ],
        ],
        [
            'title' => 'Clinicas/Provincias/CCAA',
            'subtitle' => 'General',
            'icon' => 'store_mall_directory',
            'fields' => [],
            'relations' => ['clinics', 'counties', 'states']
        ],
        [
            'title' => 'Promociones',
            'subtitle' => 'General',
            'icon' => 'attach_money',
            'fields' => [],
            'relations' => ['promotions']
        ],
        [
            'title' => 'Reclamos',
            'subtitle' => 'General',
            'icon' => 'announcement',
            'fields' => [],
            'relations' => ['claims']
        ],
        [
            'title' => 'Diseños Clínica',
            'subtitle' => 'General',
            'icon' => 'photo_album',
            'fields' => [],
            'relations' => ['clinic_mailings']
        ]
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'description' => [
            'label' =>'Descripción',
        ],
        'mailing_id' => [
            'label' =>'Buzoneo',
            'type' => [
                'name' =>'select',
                'model' => 'mailings',
                'default' => [
                    'text' => 'Selecciona un Buzoneo',
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
                'array' => ['Leaflet', 'Flyer'],
                'default' => [
                    'text' => 'Selecciona un Tipo',
                ],
            ],
        ],
        'base_af_file_id' => [
            'label' =>'Diseño',
            'type' => [
                'name' => 'file',
                'thumbnail' => 'multi',
                'public' => false,
                'permissions' => '740'
            ],
        ],
    ];
    protected $onRelationMode = ['table'];
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

    // Tableable DATA
    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre',
        ],
        'description' => [
            'label' => 'Descripción',
        ],
        'mailing.label' => [
            'label' => 'Buzoneo',
        ],
        'promotions' => [
            'label' => 'Promociones'
        ],
        'claims' => [
            'label' => 'Reclamos'
        ],
        'language.native_name' => [
            'label' => 'Language',
            'filtering' => ['search'],
        ],
        'type' => [
            'label' => 'Type',
            'filtering' => ['search'],
        ],
        'clinics' => [
            'label' => 'Clinicas'
        ],
        'country.name' => [
            'label' => 'País',
            'filtering' => ['search'],
        ],
        'state.name' => [
            'label' => 'CCAA',
            'filtering' => ['search'],
        ],
        'county.name' => [
            'label' => 'Provincia',
            'filtering' => ['search'],
        ],
        'clinic.nickname' => [
            'label' => 'Clínica',
            'filtering' => ['search'],
        ],
        'base_af.thumbnail' => [
            'label' => 'Mailing AF',
            'onGrid' => 'footer'
        ]
    ];
    // END Table Data

    public function mailing() {
        return $this->belongsTo(Mailing::class);
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
    public function clinics() {
        return $this->belongsToMany(Clinic::class, 'mailing_design_clinics')->withTrashed();
    }
    public function counties() {
        return $this->belongsToMany(County::class, 'mailing_design_counties');
    }
    public function states() {
        return $this->belongsToMany(State::class, 'mailing_design_states');
    }
    public function promotions () {
        return $this->BelongsToMany(Promotion::class);
    }
    public function claims () {
        return $this->BelongsToMany(Claim::class, 'mailing_design_claims');
    }
    public function clinic_mailings () {
        return $this->hasMany(ClinicMailing::class);
    }

    public function getFilteredClinicsAttribute () {
        return \App\Clinic::withTrashed()
            ->where([['starts_at', '<', $this->mailing->ends_at], ['ends_at', '=', null]])
            // ->orWhere([['starts_at', '<', $this->mailing->ends_at], ['ends_at', '>', $this->mailing->ends_at]])
            // ->with('clinic_siblings')
            ->with(['clinic_siblings' => function ($q) {
                $q->with('sibling')->where([['starts_at', '<', $this->mailing->ends_at], ['ends_at', '>', $this->mailing->starts_at]])
                    ->orWhere([['starts_at', '<', $this->mailing->ends_at], ['ends_at', '=', null]]);
                }])
            ->withCount('clinic_siblings', 'children')
            ->orderBy('city')
            ->find(request('ids'));
    }

    public function getLegalsAttribute () {
        $mailing = $this->mailing;
        $legals = collect();
        $promotions = $this->promotions;
        foreach ($promotions as $promotion) {
            $promoLegals = $promotion->legalsByDates($mailing->starts_at, $mailing->ends_at);
            // dump($promoLegals);
            foreach ($promoLegals as $promoLegal) {
                $legals->push($promoLegal);
            }
        }
        $claims = $this->claims;
        foreach ($claims as $claim) {
            $claimLegals = $claim->legalsByDates($mailing->starts_at, $mailing->ends_at);
            // dump($claimLegals->toArray());
            foreach ($claimLegals as $claimLegal) {
                $legals->push($claimLegal);
            }
        }
        // dump($legals->toArray());
        $scopedLegals = $this->selectByScope($legals, $this);
        // dump($scopedLegals->toArray());
        return $scopedLegals;
    }
    public function getDateStringAttribute () {
        $mailingDate = new Carbon($this->mailing->starts_at);
        $year = $mailingDate->year;
        $month = strlen($mailingDate->month) < 2 ? '0' . $mailingDate->month : $mailingDate->month;
        $date = $year . '_' . $month;
        return $date;
    }

    public function getKeyFieldAttribute() {
        return 'KeyField';
    }
    public function renameFileBuilder() {
        $names = [];
        $clinics = $this->filteredClinics;
        $maxSiblings = $clinics->count() ? $clinics->sortByDesc('clinic_siblings_count')->first()->clinic_siblings_count : 0;
        if ($maxSiblings) $clinics = \App\Clinic::cleanSiblings($clinics);

        $date = new Carbon($this->mailing->starts_at);
        $year = $date->year;
        $content = null;

        foreach ($clinics as $clinic) {
            $id = $clinic->id;
            while (strlen($id) < 4) $id = '0' . $id;
            $name = null;
            $name .= $clinic->fullName . ' ';
            $name .= $this->name . ' ';
            $name .= $year . ' ';
            $name .= '#' . $id;

            $names[] = $name;
        }
        foreach ($names as $name) {
            $content .= $name;
            $content .= "\n";
        }
        return $content;
    }

    public function indesignFileBuilder() {
        $names = [];
        $legals = $this->legals;
        $legals = $legals->concat($this->country->legals);
        $sanitary_codes = $this->mailing->sanitary_codes;
        $columnsInfo = ['columnIndexes' => [], 'columns' => []];

        $clinics = $this->filteredClinics;
        // dd($clinics->toArray());
        // dd($clinics->filter(function ($i) { return $i->id === 6; })->first()->toArray());
        $maxSiblings = $clinics->count() ? $clinics->sortByDesc('clinic_siblings_count')->first()->clinic_siblings_count : 0;
        if ($maxSiblings) $clinics = \App\Clinic::cleanSiblings($clinics);
        $maxChildren = $clinics->count() ? $clinics->sortByDesc('children_count')->first()->children_count : 0;
        // dump($maxChildren);
        $date = new Carbon($this->mailing->starts_at);
        $year = $date->year;
        $content = null;

        $columnsInfo = $this->addColumn('city', 'Clinic1', $columnsInfo);
        $columnsInfo = $this->addColumn('city2', 'Clinic2', $columnsInfo);
        $columnsInfo = $this->addColumn('virtual', 'Tel.Virtual', $columnsInfo);
        $columnsInfo = $this->addColumn('dir1', 'Dir.1', $columnsInfo);
        $columnsInfo = $this->addColumn('dir2', 'Dir.2', $columnsInfo);
        $columnsInfo = $this->addColumn('code1', 'Code1', $columnsInfo);

        $codeRound = 2;
        while ($codeRound <= ($maxChildren + $maxSiblings + 1)) {
            // $clinic['code' . (1+$codeRound)] = '';
            $columnsInfo = $this->addColumn('code' . ($codeRound), 'Code' . ($codeRound), $columnsInfo);
            $codeRound++;
        }
        $dirRound = 3;
        if ($maxSiblings) $columnsInfo = $this->addColumn('separator', 'Separator', $columnsInfo);
        while ($dirRound <= ($maxSiblings + 2)) {
            $columnsInfo = $this->addColumn('dir' . ($dirRound), 'Dir.' . ($dirRound), $columnsInfo);
            // $columnsInfo = $this->addColumn('code' . ($codeRound), 'Code' . ($codeRound), $columnsInfo);
            $dirRound++;
            // $codeRound++;
        }
        // dump($codeRound);
        // dump($dirRound);

        foreach ($clinics as $clinic) {
            $clinic['city2'] = '';
            // Check if Clinic Name is too Long
            if (strlen($clinic->city) > 15) {
                $index = false;
                $round = 0;
                $needles = [' del ', ' de ', ' i '];
                while ($index === false) {
                    $index = strpos($clinic->city, $needles[$round]);
                    $round++;
                    if ($round === count($needles)) break;
                }
                if ($index === false) $index = strpos($clinic->city, ' ');
                $clinic['city2'] = substr($clinic->city, $index);
                $clinic['city'] = substr($clinic->city, 0, $index);
            }
            // Find Virtual Phone Number
            $clinic['virtual'] = $clinic->phones()->where('type', 'Virtual')->first()->number;
            // Find Addresses
            $address = $clinic->addresses()->where('type', 'Comercial')->first();
            if (!$address) $address = $clinic->addresses()->where('type', 'Fiscal')->first();
            $clinic['dir1'] = $address->address_line_1;
            $clinic['dir2'] = $address->address_line_2;
            // Find Sanitary Codes
            $code = $this->findCS($sanitary_codes, $clinic);
            $clinic['code1'] = $code;
            // Find Children Codes
            // $round = 1;
            // Find Sibling Data
            // $round = 1 + $maxChildren;
            $round = 3;
            if ($maxSiblings) $clinic['separator'] = '';
            while ($round <= $dirRound) {
                $clinic['dir' . ($round)] = '';
                $round++;
            }
            $round = 2;
            while ($round <= $codeRound) {
                $clinic['code' . ($round)] = '';
                $round++;
            }
            $ClinicCodeRound = 2;
            if ($clinic->children->count()) {
                foreach ($clinic->children as $child) {
                    $code = $this->findCS($sanitary_codes, $child);
                    $clinic['code' . ($ClinicCodeRound)] = $code === $clinic['code1'] ? '' : $code;
                    $ClinicCodeRound++;
                }
            }
            $CliniDirRound = 3;
            if ($clinic->clinic_siblings->count()) {
                $clinic['separator'] = '.....................';
                foreach ($clinic->clinic_siblings as $clinic_sibling) {
                    $sibling = $clinic_sibling->sibling;
                    // Find Sibling Address
                    $address = $sibling->addresses()->where('type', 'Comercial')->first();
                    if (!$address) $address = $sibling->addresses()->where('type', 'Fiscal')->first();
                    $clinic['dir' . ($CliniDirRound)] = $address->address_line_1 . ' ' . $address->address_line_2;
                    // Find Sibling CS
                    $code = $this->findCS($sanitary_codes, $sibling);
                    $clinic['code' . ($ClinicCodeRound)] = $code === $clinic['code1'] ? '' : $code;
                    $ClinicCodeRound++;
                    if ($sibling->children->count()) {
                        foreach ($sibling->children as $child) {
                            $code = $this->findCS($sanitary_codes, $child);
                            $clinic['code' . ($ClinicCodeRound)] = $code === $clinic['code1'] ? '' : $code;
                            $ClinicCodeRound++;
                        }
                    }
                    $CliniDirRound++;
                }
            }
            // Find Design Legals
            foreach($legals as $legal) {
                $clinic[$legal->name] = $legal->text;
                $columnsInfo = $this->addColumn($legal->name, $legal->name, $columnsInfo);
            }
        }
        $date = $this->date_string;
        $fileName = $this->name . ' ' . $date . '.txt';
        if (!Storage::exists('temp')) {
            Storage::makeDirectory('temp');
        }
        $file = fopen(storage_path('app/temp/') . $fileName,"w");
        foreach ($columnsInfo['columns'] as $column => $label) {
            fwrite($file,iconv("UTF-8","UTF-16LE",$label));
	      	fwrite($file,iconv("UTF-8","UTF-16LE","\t"));
            $content .= iconv("UTF-8","UTF-16LE",$label);
            $content .= iconv("UTF-8","UTF-16LE","\t");
        }
        fwrite($file,iconv("UTF-8","UTF-16LE","\n"));
        $content .= "\n";
        foreach ($clinics as $clinic) {
            foreach ($columnsInfo['columns'] as $column => $label) {
                fwrite($file,iconv("UTF-8","UTF-16LE",$clinic[$column]));
	      	    fwrite($file,iconv("UTF-8","UTF-16LE","\t"));
                $content .= iconv("UTF-8","UTF-16LE",$clinic[$column]);
                $content .= iconv("UTF-8","UTF-16LE","\t");
            }
            fwrite($file,iconv("UTF-8","UTF-16LE","\n"));
            $content .= iconv("UTF-8","UTF-16LE","\n");
        }
        fclose($file);
        return $fileName;
    }


    public function getFileName() {
        $mailing = \App\Mailing::find($this->mailing_id)->name;
        $country = \App\Country::find($this->country_id)->code;
        $state = $this->state_id ? \App\State::find($this->state_id)->name : null;
        $states = $this->states;
        // dump($this->states);
        $county = $this->county_id ? \App\County::find($this->county_id)->name : null;
        $counties = $this->counties;
        $clinic = $this->clinic_id ? \App\Clinic::find($this->clinic_id)->cleanName : null;
        $clinics = $this->clinics;

        $lang = strtoupper(\App\Language::find($this->language_id)['639-1']);

        $name = $mailing . ' ' . $this->type . ' ';
        if ($clinic) $name .= $clinic . ' ';
        elseif (count($clinics) && $this->type === 'Flyer') {
            // dump('trying CLinics');
            $statesClinics = [];
            foreach ($clinics as $clinic) {
                if (!array_key_exists($clinic->county_id, $statesClinics)) {
                    $statesClinics[$clinic->county_id] = ['name' => $clinic->county->name, 'clinics' => 1];
                } else {
                    $statesClinics[$clinic->county_id]['clinics']++;
                }
            }
            foreach ($statesClinics as $id => $data) $name .= $data['name'] . '(' . $data['clinics'] . ')' . ' ';
        }
        elseif ($state) $name .= $state . ' ';
        elseif (count($states)) {
            foreach ($states as $state) {
                // dump($state->name);
                $name .= $state->name . ' ';
            }
        }
        elseif ($county) $name .= $county . ' ';
        elseif (count($counties)) foreach ($counties as $county) $name .= $county->name . ' ';
        else $name .= $country . ' ';
        $name .= $lang;

        return $name;
    }
    public function getFileNames($field) {
        switch ($field) {
            case 'base_af_file_id':
                return $this->getFileName();
                break;
            default:
                abort(301, 'Campo de archivo erróneo');
                break;
        }
    }
    public function getFilePaths($field) {
        switch ($field) {
            case 'base_af_file_id':
                return 'mailing/' . $this->mailing->id . '/designs';
                break;
            default:
                abort(301, 'Campo de archivo erróneo');
                break;
        }
    }
    public function buildName() {
        return $this->getFileName();
    }

    // Helpers
    public function selectByScope($modelsToScope, $scope) {
        $scopedModels = [];
        foreach ($modelsToScope as $source) {
            if ($scope->clinic_id && $source->clinic_id) {
                if ($source->clinic_id === $scope->clinic_id) $scopedModels[] = $source;
                else continue;
            } else if ($scope->county_id && $source->county_id) {
                if ($source->county_id === $scope->county_id) $scopedModels[] = $source;
                else continue;
            } else if ($scope->state_id && $source->state_id) {
                if ($source->state_id === $scope->state_id) $scopedModels[] = $source;
                else continue;
            } else if ($scope->country_id && $source->country_id) {
                if ($source->country_id === $scope->country_id) $scopedModels[] = $source;
            }
        }
        return collect($scopedModels);
    }
    public function addColumn($column, $label, $columnsInfo) {
        if (!in_array($column, $columnsInfo['columnIndexes'])) {
            $columnsInfo['columnIndexes'][] = $column;
            $columnsInfo['columns'][$column] = $label;
        }
        return $columnsInfo;
    }
    public function findCS($codes, $clinic) {
        $code = $clinic->sanitary_code;
        foreach ($codes as $source) {
            if ($source->clinic_id) {
                if ($source->clinic_id === $clinic->id) {
                    $code = $source->code;
                    break;
                } else continue;
            } else if ($source->county_id) {
                if ($source->county_id === $clinic->county_id) {
                    $code = $source->code;
                    break;
                } else continue;
            } else if ($source->state_id) {
                if ($source->state_id === $clinic->county->state_id) {
                    $code = $source->code;
                    break;
                } else continue;
            }
        }
        return $code;
    }
}
