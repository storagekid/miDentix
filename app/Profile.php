<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use TCPDF;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Qmodel
{
    use SoftDeletes;

    protected $fillable = ['name','lastname1','lastname2','personal_id_number','tutorial_completed','gender','birth_date','country_id','company_id','user_id'];
    protected $guarded = [];
    protected $hidden = [];

    protected $appends = ['full_name', 'value', 'label'];

    protected static $full = ['clinic_schedules', 'phones', 'emails', 'country', 'company', 'stores', 'clinic_profiles', 'store_profiles', 'user'];
    protected static $permissions = [
        'view' => [
            'Marketing' => ['*'],
            'Clinics' => ['*']
        ]
    ];
    // Quasar DATA
    protected $relatedTo = ['emails', 'phones', 'stores', 'clinic_schedules', 'clinic_profiles', 'clinics', 'store_profiles'];

    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name','lastname1','lastname2','gender','personal_id_number','country_id','birth_date','company_id']
            ],
            'relations' => []
        ],
        [
            'title' => 'Clinicas / Oficinas',
            'icon' => 'store_mall_directory',
            'fields' => [],
            'relations' => ['clinics', 'stores']
        ]
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['name','lastname1','lastname2','gender','personal_id_number','country_id','birth_date','company_id']
            ],
            'relations' => ['emails', 'phones']
        ],
        [
            'title' => 'Clinicas / Oficinas',
            'icon' => 'store_mall_directory',
            'fields' => [],
            'relations' => ['clinic_profiles', 'store_profiles']
        ],
        [
            'title' => 'Schedules',
            'icon' => 'schedule',
            'fields' => [],
            'relations' => ['clinic_schedules']
        ],
        [
            'title' => 'User',
            'icon' => 'vpn_key',
            'fields' => [
                ['user_id']
            ],
        ]
    ];
    protected $quasarFormFields = [
        'name' => [
            'label' =>'Nombre',
        ],
        'lastname1' => [
            'label' =>'Apellido',
        ],
        'lastname2' => [
            'label' =>'Segundo apellido',
        ],
        'gender' => [
            'label' =>'Género',
            'type' => [
                'name' =>'array',
                'array' => ['Varón', 'Mujer'],
                'default' => [
                    'text' => 'Selecciona un Género',
                ],
            ],
        ],
        'personal_id_number' => [
            'label' =>'DNI/PASAPORTE',
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
        'user_id' => [
            'label' =>'Usuario',
            'type' => [
                'name' =>'select',
                'model' => 'users',
                'default' => [
                    'text' => 'Selecciona un Usuario',
                ],
            ],
        ],
        'company_id' => [
            'label' =>'Empresa',
            'type' => [
                'name' =>'select',
                'model' => 'companies',
                'default' => [
                    'text' => 'Selecciona una Empresa',
                ],
            ],
        ]
    ];
    protected $keyField = 'full_name';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'user_id' => [
            'label' => 'Usuario',
            'filtering' => ['search'],
        ],
        'name' => [
            'label' => 'Nombre',
            'filtering' => ['search'],
        ],
        'lastname1' => [
            'label' => 'Apellido',
            'filtering' => ['search'],
        ],
        'lastname2' => [
            'label' => 'Apellido2',
            'filtering' => ['search'],
            'show' => false
        ],
        'emails' => [
            'label' => 'Correo Electrónico',
            'filtering' => ['search'],
        ],
        'phones' => [
            'label' => 'Teléfonos',
            'filtering' => ['search'],
        ],
        'personal_id_number' => [
            'label' => 'DNI',
            'filtering' => ['search'],
        ],
        'gender' => [
            'label' => 'Género',
            'filtering' => ['search'],
            'show' => false
        ],
        'clinic_profiles' => [
            'label' => 'Clinicas',
            'filtering' => ['search'],
        ],
        'license_number' => [
            'label' => 'Nº de Colegiado',
            'filtering' => ['search'],
        ],
    ];
    protected $tableOptions = [['show', 'edit', 'clone', 'delete'], true, true];
    // END Table Data

    protected $formModels = ['jobs','job_types'];

    protected $formRelations = [
        'clinics' => [
            'label' => 'Clínicas',
            'header' => 'Nueva Clínica',
            'name' => 'clinics',
            'fields' => [
            'country_id' => [
                'label' => 'País',
                'name' => 'country_id',
                'value' => null,
                'dontRecord' => true,
                'affects' => 'state_id',
                'type' => [
                'name' => 'select',
                'model' => 'countries',
                'text' => 'name',
                'value' => 'id',
                'default' => [
                    'value' => null,
                    'text' => 'Selecciona un País',
                    'disabled' => true,
                ],
                ],
            ],
            'state_id' => [
                'label' => 'CCAA',
                'name' => 'state_id',
                'value' => null,
                'dontRecord' => true,
                'dependsOn' => 'country_id',
                'affects' => 'county_id',
                'type' => [
                'name' => 'select',
                'model' => 'states',
                'text' => 'name',
                'value' => 'id',
                'default' => [
                    'value' => null,
                    'text' => 'Selecciona una CCAA',
                    'disabled' => true,
                ],
                ],
            ],
            'county_id' => [
                'label' => 'Provincia',
                'name' => 'county_id',
                'value' => null,
                'dependsOn' => 'state_id',
                'affects' => 'clinic_id',
                'dontRecord' => true,
                'type' => [
                'name' => 'select',
                'model' => 'counties',
                'text' => 'name',
                'value' => 'id',
                'default' => [
                    'value' => null,
                    'text' => 'Selecciona una Provincia',
                    'disabled' => true,
                ],
                ],
            ],
            'clinic_id' => [
                'label' => 'Clínica',
                'rules' => ['required'],
                'name' => 'clinic_id',
                'value' => null,
                'dontRecord' => false,
                'dependsOn' => 'county_id',
                'type' => [
                'name' => 'select',
                'model' => 'clinics',
                'text' => 'fullName',
                'value' => 'id',
                'default' => [
                    'value' => null,
                    'text' => 'Selecciona una Clínica',
                    'disabled' => true,
                ],
                ],
            ],
            ]
        ]
    ];

    // END Formable DATA

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function company() {
        return $this->belongsTo(Company::class);
    }
    public function country() {
        return $this->belongsTo(Country::class);
    }
    public function experiences() {
        return $this->belongsToMany(Experience::class);
    }
    public function masters() {
    	return $this
    		->belongsToMany(
    			Master_University::class,
    			'master_university_profile',
    			'profile_id',
    			'master_university_id'
    		);
    }
    public function courses() {
        return $this->hasMany(Course::class);
    }
    public function clinics() {
        return $this->belongsToMany(Clinic::class, 'clinic_profiles')->withTrashed();
    }
    public function stores() {
        return $this->belongsToMany(Store::class, 'store_profiles');
    }
    public function addresses()
    {
        return $this->morphToMany(Address::class, 'addressable');
    }
    public function phones()
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }
    public function emails()
    {
        return $this->morphMany(Email::class, 'emailable');
    }
    public function clinic_profiles() {
        return $this->hasMany(ClinicProfile::class, 'profile_id');
    }
    public function store_profiles() {
        return $this->hasMany(StoreProfile::class, 'profile_id');
    }
    public function university() {
        return $this->belongsTo(University::class);
    }
    public function clinic_schedules() {
        return $this->hasManyThrough(ClinicSchedule::class, ClinicProfile::class);
    }
    public function store_schedules() {
        return $this->hasManyThrough(StoreSchedule::class, StoreProfile::class);
    }
    public function requests() {
        return $this->hasMany(Request::class);
    }
    public function extratimes() {
        return $this->hasMany(Extratime::class);
    }
    public function especialties() {
        $ids = [];
        $clinic_schedules = $this->clinic_schedules;
        foreach ($clinic_schedules as $schedule) {
            $especialties = $schedule->especialties;
            if (count($especialties)) {
                // print($especialties);
                for ($i=0; $i < count($especialties); $i++) { 
                    if (!in_array($especialties[$i]->id, $ids)) {
                        // echo $especialties[$i]->id;
                        $ids[] = $especialties[$i]->id;
                    }
                }
            }
        }
        return Especialty::whereIn('id',$ids)->get();
    }

    public function getNameAttribute($value)
    {
        return mb_convert_case(strtolower($value), MB_CASE_TITLE, 'UTF-8');
        // return ucwords(strtolower($value));
    }
    public function getLastname1Attribute($value)
    {
        $str = mb_convert_case(strtolower($value), MB_CASE_TITLE, 'UTF-8');
        return $str = str_replace('De L', 'de l', $str);
    }
    public function getLastname2Attribute($value)
    {
        $str = mb_convert_case(strtolower($value), MB_CASE_TITLE, 'UTF-8');
        return $str = str_replace('De L', 'de l', $str);
    }
    public function getFullNameAttribute() {
        return $this->name . ' ' . $this->lastname1;
    }
    public function getCleanNameAttribute() {
        return cleanString($this->fullName);
    }
    public function getRequestsCountAttribute() {
        return $this->requests->count();
    }
    // CLINIC SCOPE
    public function getClinicsCountAttribute() {
        return $this->clinics ? $this->clinics->count() : 0;
    }
    public function getClinicScopeAttribute() {
        if (request()->user()->isRoot()) return Clinic::fetch(['with'=>['county'], 'orderBy'=>'city', 'withTrashed'=>true]);
        if ($this->clinicsCount) {
            return $this->clinics()->with('county')->get();
        } elseif (array_key_exists('Marketing', $this->user->groupsInfo)) {
            return Clinic::fetch(['with'=>['county'], 'orderBy'=>'city', 'withTrashed'=>true]);
        }
    }
    public function getClinicIdsScopeAttribute() {
        $scope = $this->clinicScope->pluck('id');
        return $scope;
    }
    public function getCountyIdsScopeAttribute() {
        $ids = [];
        foreach ($this->clinicScope as $clinic) {
            if (!in_array($clinic->county_id, $ids)) {
                $ids[] = $clinic->county_id;
            }
        }
        return $ids;
    }
    public function getCountyScopeAttribute() {
        return \App\County::find($this->countyIdsScope);
    }
    public function getCountryIdsScopeAttribute() {
        $ids = [];
        foreach ($this->clinicScope as $clinic) {
            if (!in_array($clinic->country_id, $ids)) {
                $ids[] = $clinic->country_id;
            }
        }
        return $ids;
    }
    public function getCountryScopeAttribute() {
        return \App\Country::find($this->countryIdsScope);
    }
    public function getStateIdsScopeAttribute() {
        $ids = [];
        foreach ($this->clinicScope as $clinic) {
            if (!in_array($clinic->state_id, $ids)) {
                $ids[] = $clinic->state_id;
            }
        }
        return $ids;
    }
    public function getStateScopeAttribute() {
        return \App\State::find($this->stateIdsScope);
    }
    // END CLINIC SCOPE
    //
    // STORE SCOPE
    public function getStoreCountAttribute() {
        return $this->stores ? $this->stores->count() : 0;
    }
    public function getStoreScopeAttribute() {
        if (request()->user()->isRoot()) return Store::fetch(['with'=>['country'], 'orderBy'=>'name', 'withTrashed'=>true]);
        if ($this->storeCount) {
            return $this->stores()->withTrashed()->with('country')->get();
        } elseif (array_key_exists('Marketing', $this->user->groupsInfo)) {
            return Store::fetch(['with'=>['country'], 'orderBy'=>'name', 'withTrashed'=>true]);
        }
    }
    public function getStoreIdsScopeAttribute() {
        $scope = count($this->storeScope) ? $this->storeScope->pluck('id') : [];
        return $scope;
    }
    public function getCountryIdsStoreScopeAttribute() {
        $ids = [];
        foreach ($this->storeScope as $store) {
            if (!in_array($store->country_id, $ids)) {
                $ids[] = $store->country_id;
            }
        }
        return $ids;
    }
    public function getCountryStoreScopeAttribute() {
        return \App\Country::find($this->countryIdsStoreScope);
    }
    // END STORE SCOPE
    public static function makeTags($profiles, $clinic) {
        $pdf = new TCPDF("L","mm","A4",true,"UTF-8",false);

        $pdf->SetAuthor("Dentix® - Dpto. de Desarrollo");
        $pdf->SetCreator("Generador de Identificadores Dentix®.");
        $pdf->SetTitle("Identificadores Dentix®.");
        $pdf->SetKeywords("Dentix Clínicas Identificadores");
        $pdf->SetSubject("Identificadores para los uniformes de clínica.");

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $marginTop = 6;
        $marginLeft = 10;
        $marginRight = 10;
        $marginBottom = 1;

        $width = 68;
        $height = 20;
        $margin = 5;

        $pdf->SetMargins($marginLeft,$marginTop,$marginRight,$marginBottom,true);

        $pdf->SetAutoPageBreak(1,1);


        $pdf->SetDrawColor(0,0,0,60);
        $pdf->SetFillColor(50,90,13,15);
        $pdf->SetTextColor(0,0,0,85);

        $y;$height;$margin;

        $pdf->AddPage();
        $pdf->setEqualColumns(3,68);
        $pdf->selectColumn(0);
        $y = $pdf->GetY();

        $c = 0;
        $i = 0;

        foreach ($profiles as $profile) {

            $name;
            if (strlen($profile->name . ' ' . $profile->lastname1 . ' ' . $profile->lastname2) <= 26) {
                $name = $profile->name . ' ' . $profile->lastname1 . ' ' . $profile->lastname2;
                // dd($name);
                // dd(strlen($name));
            } else if (strlen($profile->name . ' ' . $profile->lastname1) <= 26) {
                // dd(strlen($name));
                $name = $profile->name . ' ' . $profile->lastname1;
            } else {
                // dd(strlen($name));
                return false;
            }
            $puesto = $profile->jobTypeName;

            if ($i > 2) {
                $i = 0;
                $y = $y+$height+$margin;
            }

            $pdf->selectColumn($i);

            $x = $pdf->GetX();
            $pdf->SetY($y);
            $pdf->SetFont('','B',1);
            $pdf->Cell(68,2.5,'',0,1,'C',false,'',0,false,'T','C');
            $pdf->Cell(68,1,'',0,1,'C',true,'',0,false,'T','C');
            $pdf->SetFont('','B',12);
            // ( $w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M' )
            $pdf->Cell(68,7,$name,0,1,'C',false,'',0,false,'T','B');
            $pdf->SetFont('','',10);
            $pdf->Cell(68,5.9,$puesto,0,1,'C',false,'',0,false,'T','T');
            $pdf->SetFont('','B',1);
            $pdf->Cell(68,1,'',0,1,'C',true,'',0,false,'T','C');
            $pdf->Cell(68,2.5,'',0,1,'C',false,'',0,false,'T','C');
            $pdf->Rect($x,$y,68,20,'D');

            $i++;
            $c++;

            if ($c%24 == 0) {
                $i = 0;
                $pdf->AddPage();
                $pdf->setEqualColumns(3,68);
                $pdf->selectColumn(0);
                $y = $pdf->GetY();
                // newPage($pdf);
            }
        }
        $dir = 'personal-tags/';
        $file = 'file.pdf';
        // $path =  storage_path('app/' . $dir . $file);
        $path =  storage_path('app/' . $dir . 'Identificadores ' . $clinic->cleanName . ' - ' . Carbon::now() . '.pdf');

        if (!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }
        
        // $path =  storage_path('app/personal-tags/file.pdf');

        $pdf->Output($path, 'F');
        return $path;

    }
    public static function makeBusinessCard($profile, $clinic) {
        $name;
        if (strlen($profile->name . ' ' . $profile->lastname1 . ' ' . $profile->lastname2) <= 30) {
            $name = $profile->name . ' ' . $profile->lastname1 . ' ' . $profile->lastname2;
            // dd($name);
            // dd(strlen($name));
        } else if (strlen($profile->name . ' ' . $profile->lastname1) <= 30) {
            // dd(strlen($name));
            $name = $profile->name . ' ' . $profile->lastname1;
        } else {
            // dd(strlen($name));
            return false;
        }
        $line1 = $clinic->address_real_1.", ".$clinic->postal_code." ".$clinic->city;
        $line2 = 'Tel.: ' .  $clinic->phone_real;
        if ($profile->phone) {
            $line2 .= ' - Tel.2: ' . $profile->phone;
        }
        $email = false;
        $domain = 'dentix.es';

        if ($profile->job_type_id == 5) {
            $job = $profile->gender == 'Mujer' ? 'Directora' : 'Director';
            $email = 'director';
        } elseif ($profile->job_type_id == 8) {
            $job = $profile->gender == 'Mujer' ? 'Subdirectora' : 'Subdirector';
            $email = 'subdirector';
        }
        if (!$email) {
            return false;
        }

        $pdf = new TCPDF("L","mm","A4",true,"UTF-8",false);

        $pdf->SetAuthor("Dentix® - Dpto. de Desarrollo");
        $pdf->SetCreator("Generador de Identificadores Dentix®.");
        $pdf->SetTitle("Identificadores Dentix®.");
        $pdf->SetKeywords("Dentix Clínicas Identificadores");
        $pdf->SetSubject("Identificadores para los uniformes de clínica.");

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $bleed = 3;
        $slug = 5;

        $marginTop = $bleed+$slug;
        $marginLeft = $bleed+$slug;
        $marginRight = $bleed+$slug;
        $marginBottom = $bleed+$slug;

        $pdf->SetMargins($marginLeft,$marginTop,$marginRight,$marginBottom,true);

        $Color512 = "PANTONE 512 C";
        $Color9C = "PANTONE Cool Grey 9C";

        $pdf->AddSpotColor($Color512,50,90,13,15);

        $pdf->SetDrawSpotColor($Color512,100);
        $pdf->SetFillSpotColor($Color512,100);
        $pdf->SetTextSpotColor($Color512,100);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetAutoPageBreak(1,1);

        $pageWidth = 85+(($bleed+$slug)*2);
        $pageHeight = 55+(($bleed+$slug)*2);
        $size = array($pageWidth,$pageHeight);

        $pdf->AddPage("L",$size);
        
        // $pdf->setY(0);
        $pdf->SetFillSpotColor($Color512,10);
        $pdf->Rect($slug,27.5+$bleed+$slug,$pageWidth-($slug*2),17,'F');

        $pdf->setY(13+$bleed+$slug);
        $text = $name;
        $pdf->SetFont('dentixroman','',14,'',false);
        $pdf->Cell(85,'',$text,0,0,'C',false,'');

        $pdf->setY(19+$bleed+$slug);
        $text = $job;
        $pdf->SetFont('dentixth','',10,'',false);
        $pdf->Cell(85,'',$text,0,0,'C',false,'');

        $lineHeight = 3.2;
        if (!empty($line2)) {
            $y = 31+$bleed+$slug;
        } else {
            $y = 31+$bleed+$slug;
        }
        $pdf->setY($y);
        $text = $line1;
        $pdf->SetFont('dentixth','',8,'',false);
        $pdf->Cell(85,'',$text,0,0,'C',false,'');

        if (!empty($line2)) {
            $y = $y+$lineHeight;
            $pdf->setY($y);
            $text = $line2;
            $pdf->SetFont('dentixth','',8,'',false);
            $pdf->Cell(85,'',$text,0,0,'C',false,'');
        } else {
            $y = $y+($lineHeight*1.2);
            $pdf->setY($y);
            $text = 'Tel.: ' .  $clinic->phone_real;
            $pdf->SetFont('dentixth','',8,'',false);
            $pdf->Cell(85,'',$text,0,0,'C',false,'');
        }

        $y = $y+($lineHeight*1.2);
        $pdf->setY($y);
        $text = $email . '.' . $clinic->email_ext . '@' . $domain;
        $pdf->SetFont('dentixroman','',8,'',false);
        $pdf->Cell(85,'',$text,0,0,'C',false,'');


        $pdf->setY(47.7+$bleed+$slug);
        $text = "www.dentix.com";
        $pdf->SetFont('dentixth','',10,'',false);
        $pdf->Cell(85,'',$text,0,0,'C',false,'');

        if ($bleed > 0) {
            // bleed($pdf,$pageWidth,$pageHeight,$bleed,$slug);
            $pdf->SetLineWidth(0.15);
            $pdf->SetDrawColor(0);
            // Líneas de sangre horizontales
            $pdf->Line(0,$slug+$bleed,$slug,$slug+$bleed);
            $pdf->Line($pageWidth,$slug+$bleed,$pageWidth-($slug),$slug+$bleed);
            $pdf->Line(0,$pageHeight-($slug+$bleed),$slug,$pageHeight-($slug+$bleed));
            $pdf->Line($pageWidth,$pageHeight-($slug+$bleed),$pageWidth-($slug),$pageHeight-($slug+$bleed));
            // / Líneas de sangre horizontales

            // Líneas de sangre verticales

            $pdf->Line($slug+$bleed,0,$slug+$bleed,$slug);
            $pdf->Line($pageWidth-($slug+$bleed),0,$pageWidth-($slug+$bleed),$slug);
            $pdf->Line($slug+$bleed,$pageHeight,$slug+$bleed,$pageHeight-$slug);
            $pdf->Line($pageWidth-($slug+$bleed),$pageHeight,$pageWidth-($slug+$bleed),$pageHeight-$slug);

            // / Líneas de sangre verticales
        }

        $pdf->AddPage();

        $pdf->SetFillSpotColor($Color512,100);
        $pdf->Rect(0+$slug,0+$slug,85+($bleed*2),55+($bleed*2),'F');

        $pdf->SetDrawColor(0,0,0,0);
        $pdf->SetFillColor(0,0,0,0);

        $pdf->ImageEps(asset('img/logo-claim-512.eps'), 22+$bleed+$slug, 24+$bleed+$slug, 43, '', '', true, '', '', 0, false);

        if ($bleed > 0) {
            // bleed($pdf,$pageWidth,$pageHeight,$bleed,$slug);
            $pdf->SetLineWidth(0.15);
            $pdf->SetDrawColor(0);
            // Líneas de sangre horizontales
            $pdf->Line(0,$slug+$bleed,$slug,$slug+$bleed);
            $pdf->Line($pageWidth,$slug+$bleed,$pageWidth-($slug),$slug+$bleed);
            $pdf->Line(0,$pageHeight-($slug+$bleed),$slug,$pageHeight-($slug+$bleed));
            $pdf->Line($pageWidth,$pageHeight-($slug+$bleed),$pageWidth-($slug),$pageHeight-($slug+$bleed));
            // / Líneas de sangre horizontales

            // Líneas de sangre verticales

            $pdf->Line($slug+$bleed,0,$slug+$bleed,$slug);
            $pdf->Line($pageWidth-($slug+$bleed),0,$pageWidth-($slug+$bleed),$slug);
            $pdf->Line($slug+$bleed,$pageHeight,$slug+$bleed,$pageHeight-$slug);
            $pdf->Line($pageWidth-($slug+$bleed),$pageHeight,$pageWidth-($slug+$bleed),$pageHeight-$slug);

            // / Líneas de sangre verticales
        }

        $dir = 'personal-business-cards/';
        $file = 'app/' . $dir . $clinic->cleanName . ' ' . $profile->cleanName . ' Tarjeta de visita 85x55  - ' . Carbon::now()->timestamp . '.pdf';
        $path =  storage_path($file);

        if (!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }
        
        // $path =  storage_path('app/personal-tags/file.pdf');

        $pdf->Output($path, 'F');
        return $path;
        

    }
    public static function makeCharts($profiles, $clinic, $license=false) {

        $needsSN = $license;
        $snType = 'right';
        // dd('Doing Charts');

        $pdf = new TCPDF("L","mm","A4",true,"UTF-8",false);

        $pdf->SetAuthor("Dentix® - Dpto. de Desarrollo");
        $pdf->SetCreator("Generador de Identificadores Dentix®.");
        $pdf->SetTitle("Tiras de Directorio Dentix®.");
        $pdf->SetKeywords("Dentix Clínicas Directorio Médico");
        $pdf->SetSubject("Tiras para el Cuadro Médico Analógico.");

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        $pdf->SetAutoPageBreak(0,1);

        $bleed = 0;
        $slug = 0;

        $marginTop = $bleed+$slug;
        $marginLeft = $bleed+$slug;
        $marginRight = $bleed+$slug;
        $marginBottom = $bleed+$slug;

        $pdf->SetMargins($marginLeft,$marginTop,$marginRight,$marginBottom,true);

        $Color512 = "PANTONE 512 C";
        $Color9C = "PANTONE Cool Grey 9C";

        $pdf->AddSpotColor($Color512,50,90,13,15);
        $pdf->AddSpotColor($Color9C,0,0,0,85);

        $pdf->SetDrawSpotColor($Color512,100);
        $pdf->SetFillSpotColor($Color512,100);
        $pdf->SetTextSpotColor($Color512,100);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetAutoPageBreak(1,1);

        $pageWidth = 600+(($bleed+$slug)*2);
        $pageHeight = (50*count($profiles))+(($bleed+$slug)*2);
        // dd($pageHeight);
        $size = array($pageWidth,$pageHeight);

        if ($pageHeight > $pageWidth) {
            $pdf->AddPage("P",$size);            
        } else {
            $pdf->AddPage("L",$size);
        }
        
        // $pdf->setY(0);
        // $pdf->Rect($slug,27.5+$bleed+$slug,$pageWidth-($slug*2),17,'F');
        $counter = 0;
        foreach ($profiles as $profile) {
            if ($needsSN == false || $snType == 'under') { 
                $pdf->SetTextSpotColor($Color512,100);
                $pdf->setY((11+(50*$counter))+$bleed+$slug);
                $text = $profile->fullName . ' ' . $profile->lastname2;
                $pdf->SetFont('dentixth','',78,'',false);
                $pdf->Cell(0,0,$text,0,0,'C',false,'');
            }
            if ($needsSN) {
                if ($snType == 'right') {
                    $pdf->SetTextSpotColor($Color512,100);
                    $pdf->setY((11+(50*$counter))+$bleed+$slug);
                    $text = '<font>' . $profile->fullName . ' ' . $profile->lastname2 . '</font><font color="rgb(100,100,100)"> - Colegiado: ' . $profile->license_number . '</font>';
                    $pdf->SetFont('dentixth','',68,'',false);
                    $pdf->writeHTMLCell(0,0,0,(13+(50*$counter)),$text,0,0,false,true,'C',false);
                } else if ($snType == 'under') {
                    $pdf->SetTextSpotColor($Color9C,100);
                    $pdf->setY((40+(50*$counter))+$bleed+$slug);
                    $text = 'Número de Colegiado ' . $profile->license_number;
                    $pdf->SetFont('dentixth','',20,'',false);
                    $pdf->Cell(0,0,$text,0,0,'C',false,'');
                }
            }
            // License Number if Needed

            // Líneas de sangre horizontales
            if (count($profiles) > 1 && $counter > 0) {
                $pdf->SetLineWidth(0.3);
                $pdf->SetDrawColor(0.5);
                $pdf->Line(0,(50*$counter),5,(50*$counter));
                $pdf->Line($pageWidth,(50*$counter),$pageWidth-5,(50*$counter));
            }
            $counter++;
        }

        if ($bleed > 0) {
            // bleed($pdf,$pageWidth,$pageHeight,$bleed,$slug);
            $pdf->SetLineWidth(0.15);
            $pdf->SetDrawColor(0);
            // Líneas de sangre horizontales
            $pdf->Line(0,$slug+$bleed,$slug,$slug+$bleed);
            $pdf->Line($pageWidth,$slug+$bleed,$pageWidth-($slug),$slug+$bleed);
            $pdf->Line(0,$pageHeight-($slug+$bleed),$slug,$pageHeight-($slug+$bleed));
            $pdf->Line($pageWidth,$pageHeight-($slug+$bleed),$pageWidth-($slug),$pageHeight-($slug+$bleed));
            // / Líneas de sangre horizontales

            // Líneas de sangre verticales

            $pdf->Line($slug+$bleed,0,$slug+$bleed,$slug);
            $pdf->Line($pageWidth-($slug+$bleed),0,$pageWidth-($slug+$bleed),$slug);
            $pdf->Line($slug+$bleed,$pageHeight,$slug+$bleed,$pageHeight-$slug);
            $pdf->Line($pageWidth-($slug+$bleed),$pageHeight,$pageWidth-($slug+$bleed),$pageHeight-$slug);

            // / Líneas de sangre verticales
        }

        $dir = 'personal-charts/';
        $file = 'app/' . $dir . 'Directorio ' . $clinic->cleanName . ' - ' . Carbon::now()->timestamp . '.pdf';
        $path =  storage_path($file);

        if (!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }
        
        // $path =  storage_path('app/personal-tags/file.pdf');

        $pdf->Output($path, 'F');
        return $file;
        

    }
    public static function makeJobCharts($job) {
        // dd('Doing Charts');
        // dd($job->name);
        $pdf = new TCPDF("L","mm","A4",true,"UTF-8",false);

        $pdf->SetAuthor("Dentix® - Dpto. de Desarrollo");
        $pdf->SetCreator("Generador de Identificadores Dentix®.");
        $pdf->SetTitle("Tiras de Directorio Dentix®.");
        $pdf->SetKeywords("Dentix Clínicas Directorio Médico");
        $pdf->SetSubject("Tiras para el Cuadro Médico Analógico.");

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetAutoPageBreak(0,1);

        $bleed = 3;
        $slug = 5;

        $marginTop = $bleed+$slug;
        $marginLeft = $bleed+$slug;
        $marginRight = $bleed+$slug;
        $marginBottom = $bleed+$slug;

        $pdf->SetMargins($marginLeft,$marginTop,$marginRight,$marginBottom,true);

        $Color512 = "PANTONE 512 C";

        $pdf->AddSpotColor($Color512,50,90,13,15);

        $pdf->SetDrawSpotColor($Color512,100);
        $pdf->SetFillSpotColor($Color512,100);
        $pdf->SetTextSpotColor($Color512,100);

        $pageWidth = 600+(($bleed+$slug)*2);
        $pageHeight = 50+(($bleed+$slug)*2);
        $size = array($pageWidth,$pageHeight);

        $pdf->AddPage("L",$size);
        
        $pdf->setY(0);
        $pdf->Rect($slug,$slug,$pageWidth-($slug*2),$pageHeight-($slug*2),'F');

        $pdf->SetTextColor(255);
        $pdf->setY(11+$bleed+$slug);
        $text = $job->name;
        $pdf->SetFont('dentixth','',78,'',false);
        $pdf->Cell(0,0,$text,0,0,'C',false,'');

        if ($bleed > 0) {
            // bleed($pdf,$pageWidth,$pageHeight,$bleed,$slug);
            $pdf->SetLineWidth(0.15);
            $pdf->SetDrawColor(0);
            // Líneas de sangre horizontales
            $pdf->Line(0,$slug+$bleed,$slug,$slug+$bleed);
            $pdf->Line($pageWidth,$slug+$bleed,$pageWidth-($slug),$slug+$bleed);
            $pdf->Line(0,$pageHeight-($slug+$bleed),$slug,$pageHeight-($slug+$bleed));
            $pdf->Line($pageWidth,$pageHeight-($slug+$bleed),$pageWidth-($slug),$pageHeight-($slug+$bleed));
            // / Líneas de sangre horizontales

            // Líneas de sangre verticales
            $pdf->Line($slug+$bleed,0,$slug+$bleed,$slug);
            $pdf->Line($pageWidth-($slug+$bleed),0,$pageWidth-($slug+$bleed),$slug);
            $pdf->Line($slug+$bleed,$pageHeight,$slug+$bleed,$pageHeight-$slug);
            $pdf->Line($pageWidth-($slug+$bleed),$pageHeight,$pageWidth-($slug+$bleed),$pageHeight-$slug);
            // / Líneas de sangre verticales
        }

        $dir = 'job-charts/';
        $file = 'file.pdf';
        $path =  storage_path('app/job-charts/' . $job->name . '.pdf');

        if (!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }
        
        // $path =  storage_path('app/personal-tags/file.pdf');

        $pdf->Output($path, 'F');
        return $path;
        

    }

    public static function deleteFile($file) {
        try {
                $test = Storage::disk('root')->delete($file);
                if (!$test) {
                    throw new \Exception('Cant Delete ' . $file);
                }
            } catch (\Exception $e) {
                dd($e);
            }
    }

    function bleed($pdf,$pageWidth,$pageHeight,$bleed,$slug) {

        $pdf->SetLineWidth(0.15);
        $pdf->SetDrawColor(0);
        // Líneas de sangre horizontales
        $pdf->Line(0,$slug+$bleed,$slug,$slug+$bleed);
        $pdf->Line($pageWidth,$slug+$bleed,$pageWidth-($slug),$slug+$bleed);
        $pdf->Line(0,$pageHeight-($slug+$bleed),$slug,$pageHeight-($slug+$bleed));
        $pdf->Line($pageWidth,$pageHeight-($slug+$bleed),$pageWidth-($slug),$pageHeight-($slug+$bleed));
        // / Líneas de sangre horizontales

        // Líneas de sangre verticales

        $pdf->Line($slug+$bleed,0,$slug+$bleed,$slug);
        $pdf->Line($pageWidth-($slug+$bleed),0,$pageWidth-($slug+$bleed),$slug);
        $pdf->Line($slug+$bleed,$pageHeight,$slug+$bleed,$pageHeight-$slug);
        $pdf->Line($pageWidth-($slug+$bleed),$pageHeight,$pageWidth-($slug+$bleed),$pageHeight-$slug);

        // / Líneas de sangre verticales

    } 
}
