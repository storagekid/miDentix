<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCPDF;
use Illuminate\Support\Facades\Storage;
use App\Traits\Tableable;
use App\Traits\Formable;

class Stationary extends Model
{
    use Tableable;
    use Formable;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description','details','customizable','provider_id', 'price', 'file', 'link'
    ];

    protected $appends = ['providerList'];

    protected $with = ['providers'];

    // Tableable DATA
    protected $tableColumns = [
        'name' => [
            'label' => 'Nombre'
        ], 
        'description' => [
            'label' => 'Descripción',
            'filtering' => ['search']
        ], 
        'details' => [
            'label' => 'Detalles'
        ], 
        'customizable' => [
            'label' => 'Personalizable',
            'boolean' => ['Sí','No'],
            'sorting' => ['integer'],
            'filtering' => [
                'off',
                'boolean' => ['No','Sí']
            ],
        ], 
        'price' => [
            'label' => 'Precio'
        ], 
        'providerList' => [
            'label' => 'Proveedores',
            'parse' => true
        ],
        'link' => [
            'label' => 'Diseño',
            'boolean' => ['Sí','No'],
            'sorting' => ['integer'],
            'filtering' => [
                'boolean' => ['No','Sí']
            ],
        ], 
    ];

    protected $tableOptions = [['show','edit','delete'], true, true];

    // END Tableable Data

    // Formable DATA

    protected $formFields = [
        'name' => [
            'label' =>'Nombre',
            'rules' =>['required','min:5','max:64'],
          ],
          'description' => [
            'label' =>'Descripción',
            'rules' =>['required','min:5','max:64'],
          ],
          'price' => [
            'label' =>'Precio',
            'rules' =>['required'],
            'type' => [
              'name' =>'inputDecimal',
            ],
          ],
          'details' => [
            'label' =>'Detalles',
            'rules' =>['required','min:5','max:255'],
          ],
          'customizable' => [
            'label' =>'Personalizable',
            'value' =>false,
            'type' => [
              'name' =>'checkBox',
            ],
          ],
          'file' => [
            'label' =>'Diseño',
            'value' =>false,
            'type' => [
              'name' => 'file',
            ],
          ],
    ];

    protected $formModels = ['countries','counties','states','providers'];

    protected $formRelations = [
        'providers' => [
            'label' => 'Proveedores',
            'header' => 'Nuevo Proveedor',
            'name' => 'providers',
            'fields' => [
              'country_id' => [
                'label' => 'País',
                'rules' => ['required'],
                'name' => 'country_id',
                'value' => null,
                'dontRecord' => false,
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
                'rules' => [],
                'name' => 'state_id',
                'value' => null,
                'dontRecord' => false,
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
                'rules' => [],
                'name' => 'county_id',
                'value' => null,
                'dependsOn' => 'state_id',
                'affects' => 'clinic_id',
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
                'rules' => [],
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
              'provider_id' => [
                'label' => 'Proveedor',
                'rules' => [],
                'name' => 'provider_id',
                'value' => null,
                'dontRecord' => false,
                'type' => [
                  'name' => 'select',
                  'model' => 'providers',
                  'text' => 'name',
                  'value' => 'id',
                  'default' => [
                    'value' => null,
                    'text' => 'Selecciona un Proveedor',
                    'disabled' => true,
                  ],
                ],
              ],
            ]
        ]
    ];

    // END Formable DATA

    public function providers() {
        return $this->hasMany(Provider_Stationary::class, 'product_id');
    }

    public function getProviderListAttribute() {
        // return implode(', ', $this->providers->pluck('name')->toArray());
        return $this->providers->pluck('providerName');
    }

    public function orders() {
        return $this->morphMany(Order::class, 'orderable');
    }

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class)
            ->withPivot(['id', 'file', 'link']);
    }

    public function setCustomizableAttribute($value) {
        $this->attributes['customizable'] = $value == null ? false : true;
    }

    public function regen() {
        // $clinics = Clinic::all();
        // $stationaries = Stationary::get();
        // foreach ($clinics as $clinic) {
        //     $this->makeA4($clinic->address_real_1,$clinic->postal_code, $clinic->city, $clinic->phone_real, true);
        // }
    }

    public function makePdf($directory, $stationary, $clinic, $force=false) {
        
        $object = $stationary->description; //'Hoja A4 '
        $street = trim(str_replace(['C/', 'c/', 's/n', '/'], ['', '', 's.n.', '-'], $clinic->address_real_1));
        $folder = $clinic->cleanName;
        // $dir = 'stationary/' . $folder . '/';
        $dir = $directory . $folder . '/';
        $file = $folder.'.pdf';
        $path =  storage_path('app/'.$dir . $object . ' ' . $file);

        if (!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }

        if (Storage::exists($dir . $object . $file) && !$force) {
            return false;
        }

        switch ($stationary->name) {
            case 'a4sheet':
                $this->makeA4($clinic, $path);
                break;
            case 'recepi':
                $this->makeRecepi($clinic, $path);
                break;
            case 'envelope':
                $this->makeSobreAmericano($clinic, $path);
                break;
            case 'envelopeBig':
                $this->makeSobreBolsa($clinic, $path);
                break;
        }

    }

    public function makeA4($clinic, $path, $force=false)
    {

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetAuthor('Dentix® - Dpto. de Desarrollo');
        $pdf->SetCreator('Impresora de Papelería Dentix®.');
        $pdf->SetTitle('Hoja A4 Dentix®.');
        $pdf->SetKeywords('Dentix Clínicas Papelería A4');
        $pdf->SetSubject('Hoja A4 corporativa preparada para Imprenta.');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $marginTop = 10;
        $marginLeft = 12.2;
        $marginRight = 12.2;
        $marginBottom = 10;

        $pdf->SetMargins($marginLeft, $marginTop, $marginRight, $marginBottom, true);

        $Color512 = 'PANTONE 512 C';
        $Color9C = 'PANTONE Cool Grey 9C';

        $pdf->AddSpotColor($Color512, 50, 90, 13, 15);
        $pdf->AddSpotColor($Color9C, 0, 0, 0, 80);

        $pdf->SetDrawSpotColor($Color512, 100);
        $pdf->SetFillSpotColor($Color512, 60);
        $pdf->SetTextSpotColor($Color512, 100);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetAutoPageBreak(1, 1);

        $size = [210, 297];

        $pdf->AddPage('P', $size);

        $logo = Storage::get('sources/logo.eps');

        // $pdf->ImageEps(Storage::url('app/sources/logo.eps'), 12.2, 11.1, 55, '', '', true, '', '', 0, false);
        $pdf->ImageEps(asset('img/logo.eps'), 12.2, 11.1, 55, '', '', true, '', '', 0, false);

        $weight = 0.5;
        $margin = $weight * 4;
        $start = $marginLeft;
        $end = 210 - $marginRight;

        $this->dotLine($pdf, $start, 25, $weight, $end);

        $pdf->ImageEps(asset('img/logo10.eps'), 30.7, 138, 148.7, '', '', true, '', '', 0, false);

        $pdf->SetFillSpotColor($Color512, 10);
        $pdf->RoundedRect($marginLeft, 273.5, 185.6, 15, 4, '1111', 'F');

        $pdf->setY(277);
        $text = $clinic->address_real_1 . '. ' . $clinic->postal_code . ' ' . $clinic->city . '. ' . $clinic->phone_real . '.';
        $pdf->SetFont('dentixth', '', 10, '', false);
        $pdf->Cell(185.6, '', $text, 0, 0, 'C', false, '');

        $pdf->setY(281.5);
        $text = 'www.dentix.com';
        $pdf->SetFont('dentixroman', '', 12, '', false);
        $pdf->Cell(185.6, '', $text, 0, 0, 'C', false, '');

        $pdf->SetTextSpotColor($Color9C, 100);
        $pdf->setY(256.5 - $marginTop);
        $pdf->setX($marginLeft - 5);
        $pdf->StartTransform();
        $pdf->Rotate(90, '', '');
        $text = 'DENTOESTETIC CENTRO DE SALUD Y ESTÉTICA DENTAL SLU. Reg. Mercantil de Madrid Tomo 17.969 Folio 107. Sección 8. Hoja M-310564. Inscripción 1ª. CIF: B-83409797';
        $pdf->SetFont('dentixlt', '', 8, '', false);
        $pdf->Cell('', '', $text, 0, 0, 'C', false, '');
        $pdf->StopTransform();
        // $pdf->Output('file', 'S');

        // Storage::put('file.pdf', $pdf);
        // $pdf->Output(Storage::url($dir . $object . $file), 'F');
        $pdf->Output($path, 'F');
        // $pdf->Output(public_path($object . $file), 'F');
        // Storage::move('/'.public_path($object . $file), 'storage/app/'.$object . $file);
        // $pdf->Output($dir . $object . $file, 'I');

        return true;
    }
    function makeRecepi($clinic, $path, $force=false) 
    {

        $pdf = new TCPDF("L","mm","A5",true,"UTF-8",false);
      
        $pdf->SetAuthor("Dentix® - Dpto. de Desarrollo");
        $pdf->SetCreator("Impresora de Papelería Dentix®.");
        $pdf->SetTitle("Hoja A4 Dentix®.");
        $pdf->SetKeywords("Dentix Clínicas Papelería A4");
        $pdf->SetSubject("Hoja A4 corporativa preparada para Imprenta.");
      
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
      
        $marginTop = 10;
        $marginLeft = 10;
        $marginRight = 10;
        $marginBottom = 10;
      
      
        $pdf->SetMargins($marginLeft,$marginTop,$marginRight,$marginBottom,true);
      
        $Color512 = "PANTONE 512 C";
        $Color9C = "PANTONE Cool Grey 9C";
      
        $pdf->AddSpotColor($Color512,50,90,13,15);
      
        $pdf->SetDrawSpotColor($Color512,100);
        $pdf->SetFillSpotColor($Color512,60);
        $pdf->SetTextSpotColor($Color512,100);
      
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      
        $pdf->SetAutoPageBreak(1,1);
      
        $size = array(210,148);
      
        $pdf->AddPage("L",$size);
      
        $pdf->ImageEps(asset('img/icon-pencil.eps'), $marginLeft, 16, 10, '', '', true, '', '', 0, false);
        $pdf->SetXY(22,19);
        $text = "D.p./";
        $pdf->SetFont('dentixroman','',14,'',false);
        $pdf->Write('',$text,'',false,'L',false);
      
        $weight = 0.5;
        $margin = $weight*4;
        $start = $marginLeft;
        $end = 210-$marginRight;
      
        $y = 23.5;
        $pdf->SetFillSpotColor($Color512,30);
        $this->dotLine($pdf,35,$y,$weight,$end);
      
        $pdf->ImageEps(asset('img/logo10.eps'), 30.7, 64, 148.7, '', '', true, '', '', 0, false);
      
        $pdf->SetFillSpotColor($Color512,10);
        $pdf->RoundedRect($marginLeft,125,210-$marginRight-$marginLeft,15,4,'1111','F');
      
        $pdf->setY(128.4);
        $text = $clinic->address_real_1.". ".$clinic->postal_code." ".$clinic->city.". ".$clinic->phone_real.".";
        $pdf->SetFont('dentixth','',10,'',false);
        $pdf->Cell(185.6,'',$text,0,0,'C',false,'');
      
        $pdf->setY(133);
        $text = "www.dentix.com";
        $pdf->SetFont('dentixroman','',12,'',false);
        $pdf->Cell(185.6,'',$text,0,0,'C',false,'');
      
        $pdf->Output($path, 'F');
      
        return true;
      
    }

    function makeSobreAmericano($clinic, $path, $force=false) 
    {

        $pdf = new TCPDF("L","mm","A5",true,"UTF-8",false);
      
        $pdf->SetAuthor("Dentix® - Dpto. de Desarrollo");
        $pdf->SetCreator("Impresora de Papelería Dentix®.");
        $pdf->SetTitle("Hoja A4 Dentix®.");
        $pdf->SetKeywords("Dentix Clínicas Papelería A4");
        $pdf->SetSubject("Hoja A4 corporativa preparada para Imprenta.");
      
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
      
        $marginTop = 10;
        $marginLeft = 10;
        $marginRight = 10;
        $marginBottom = 10;
      
        $pdf->SetMargins($marginLeft,$marginTop,$marginRight,$marginBottom,true);
      
        $Color512 = "PANTONE 512 C";
        $Color9C = "PANTONE Cool Grey 9C";
      
        $pdf->AddSpotColor($Color512,50,90,13,15);
      
        $pdf->SetDrawSpotColor($Color512,100);
        $pdf->SetFillSpotColor($Color512,100);
        $pdf->SetTextSpotColor($Color512,100);
      
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      
        $pdf->SetAutoPageBreak(1,1);
      
        $size = array(225,115);
      
        $pdf->AddPage("L",$size);
      
        $pdf->ImageEps(asset('img/logo-claim-512.eps'), 152.7, 93.3, 67.3, '', '', true, '', '', 0, false);
      
        $pdf->SetFillSpotColor($Color512,10);
        $pdf->RoundedRect(5,83,141.6,26.25,4,'1111','F');
      
        $pdf->setY(86.5);
        $text = $clinic->address_real_1.".";
        $pdf->SetFont('dentixlt','',9,'',false);
        $pdf->Cell(131,'',$text,0,0,'L',false,'');
      
        $pdf->setY(90.5);
        $text = $clinic->postal_code." ".$clinic->city.".";
        $pdf->SetFont('dentixlt','',9,'',false);
        $pdf->Cell(131,'',$text,0,0,'L',false,'');
      
        $pdf->setY(94.5);
        $text = "Tel. ".$clinic->phone_real.".";
        $pdf->SetFont('dentixlt','',9,'',false);
        $pdf->Cell(131,'',$text,0,0,'L',false,'');
      
        $pdf->setY(102);
        $text = "www.dentix.com";
        $pdf->SetFont('dentixroman','',12,'',false);
        $pdf->Cell(131,'',$text,0,0,'L',false,'');
      
        $weight = 0.3;
        $margin = $weight*4;
        $start = $marginLeft;
        $end = 141;
      
        $pdf->SetFillSpotColor($Color512,50);
        $this->dotLine($pdf,10,100,$weight,$end);
      
        $pdf->Output($path, 'F');
      
        return true;
      
    }

    function makeSobreBolsa($clinic, $path, $force=false) 
    {

        $pdf = new TCPDF("L","mm","A5",true,"UTF-8",false);
      
        $pdf->SetAuthor("Dentix® - Dpto. de Desarrollo");
        $pdf->SetCreator("Impresora de Papelería Dentix®.");
        $pdf->SetTitle("Hoja A4 Dentix®.");
        $pdf->SetKeywords("Dentix Clínicas Papelería A4");
        $pdf->SetSubject("Hoja A4 corporativa preparada para Imprenta.");
      
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
      
        $marginTop = 10;
        $marginLeft = 10;
        $marginRight = 10;
        $marginBottom = 10;
      
      
        $pdf->SetMargins($marginLeft,$marginTop,$marginRight,$marginBottom,true);
      
        $Color512 = "PANTONE 512 C";
        $Color9C = "PANTONE Cool Grey 9C";
      
        $pdf->AddSpotColor($Color512,50,90,13,15);
      
        $pdf->SetDrawSpotColor($Color512,100);
        $pdf->SetFillSpotColor($Color512,100);
        $pdf->SetTextSpotColor($Color512,100);
      
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      
        $pdf->SetAutoPageBreak(1,1);
      
        $size = array(324,229);
      
        $pdf->AddPage("L",$size);
      
        $pdf->ImageEps(asset('img/logo-claim-512.eps'), 220, 199, 97, '', '', true, '', '', 0, false);
      
        $pdf->SetFillSpotColor($Color512,10);
        $pdf->RoundedRect(7,184,204,38,4,'1111','F');
      
        $pdf->setXY(14,188);
        $text = $clinic->address_real_1.".";
        $pdf->SetFont('dentixlt','',13,'',false);
        $pdf->Cell(190,'',$text,0,0,'L',false,'');
      
        $pdf->setXY(14,194);
        $text = $clinic->postal_code." ".$clinic->city.".";
        $pdf->Cell(190,'',$text,0,0,'L',false,'');
      
        $pdf->setXY(14,200);
        $text = "Tel. ".$clinic->phone_real.".";
        $pdf->Cell(190,'',$text,0,0,'L',false,'');
      
        $pdf->setXY(14,212);
        $text = "www.dentix.com";
        $pdf->SetFont('dentixroman','',17,'',false);
        $pdf->Cell(190,'',$text,0,0,'L',false,'');
      
        $weight = 0.3;
        $margin = $weight*4;
        $start = $marginLeft;
        $end = 203;
      
        $pdf->SetFillSpotColor($Color512,50);
        $this->dotLine($pdf,14,209,$weight,$end);
      
        $pdf->Output($path,"F");
      
        return true;
      
    }

    public function dotLine($object, $start, $y, $weight, $end)
    {
        $margin = $weight * 4;

        while ($start < $end) {
            $object->Circle($start, $y, $weight, 0, 360, 'F');
            $start += $margin;
        }
    }
}
