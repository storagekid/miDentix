<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCPDF;
use Illuminate\Support\Facades\Storage;

class Stationary extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'provider_id', 'price'
    ];

    public function clinics() {
        return $this->belongsToMany(Clinic::class);
    }

    public function orders() {
        return $this->morphMany(Order::class, 'orderable');
    }

    public function regen() {
        // $clinics = Clinic::all();
        // $stationaries = Stationary::get();
        // foreach ($clinics as $clinic) {
        //     $this->makeA4($clinic->address_real_1,$clinic->postal_code, $clinic->city, $clinic->phone_real, true);
        // }
    }

    public function makePdf($stationary, $dirFiscal, $cp, $clinica, $telReal, $force=false) {
        
        $object = $stationary->description; //'Hoja A4 '
        $street = trim(str_replace(['C/', 'c/', 's/n', '/'], ['', '', 's.n.', '-'], $dirFiscal));
        $folder = $clinica . ' (' . $street . ')';
        $dir = 'stationary/' . $folder . '/';
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
                $this->makeA4($dirFiscal, $cp, $clinica, $telReal, $path);
                break;
            case 'recepi':
                $this->makeRecepi($dirFiscal, $cp, $clinica, $telReal, $path);
                break;
            case 'envelope':
                $this->makeSobreAmericano($dirFiscal, $cp, $clinica, $telReal, $path);
                break;
            case 'envelopeBig':
                $this->makeSobreBolsa($dirFiscal, $cp, $clinica, $telReal, $path);
                break;
        }

    }

    public function makeA4($dirFiscal, $cp, $clinica, $telReal, $path, $force=false)
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
        $text = $dirFiscal . '. ' . $cp . ' ' . $clinica . '. ' . $telReal . '.';
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
    function makeRecepi($dirFiscal,$cp,$clinica,$telReal, $path, $force=false) 
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
        $text = $dirFiscal.". ".$cp." ".$clinica.". ".$telReal.".";
        $pdf->SetFont('dentixth','',10,'',false);
        $pdf->Cell(185.6,'',$text,0,0,'C',false,'');
      
        $pdf->setY(133);
        $text = "www.dentix.com";
        $pdf->SetFont('dentixroman','',12,'',false);
        $pdf->Cell(185.6,'',$text,0,0,'C',false,'');
      
        $pdf->Output($path, 'F');
      
        return true;
      
    }

    function makeSobreAmericano($dirFiscal,$cp,$clinica,$telReal, $path, $force=false) 
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
        $text = $dirFiscal.".";
        $pdf->SetFont('dentixlt','',9,'',false);
        $pdf->Cell(131,'',$text,0,0,'L',false,'');
      
        $pdf->setY(90.5);
        $text = $cp." ".$clinica.".";
        $pdf->SetFont('dentixlt','',9,'',false);
        $pdf->Cell(131,'',$text,0,0,'L',false,'');
      
        $pdf->setY(94.5);
        $text = "Tel. ".$telReal.".";
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

    function makeSobreBolsa($dirFiscal,$cp,$clinica,$telReal, $path, $force=false) 
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
        $text = $dirFiscal.".";
        $pdf->SetFont('dentixlt','',13,'',false);
        $pdf->Cell(190,'',$text,0,0,'L',false,'');
      
        $pdf->setXY(14,194);
        $text = $cp." ".$clinica.".";
        $pdf->Cell(190,'',$text,0,0,'L',false,'');
      
        $pdf->setXY(14,200);
        $text = "Tel. ".$telReal.".";
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
