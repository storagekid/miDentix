<?php

namespace App\Printers;

use App\Stationary;
use App\Clinic;
use Illuminate\Support\Facades\Storage;
use App\Profile;

class StationaryCustomizablePrinter extends StationaryPrinter
{    
    public $clinic;
    public $profile;

    private $marginTop = 10;
    private $marginLeft = 10;
    private $marginRight = 10;
    private $marginBottom = 10;

    public function __construct(Stationary $stationary, Clinic $clinic = null, $force = false, Profile $profile = null) {
        parent::__construct($stationary, false);

        $this->clinic = $clinic;

        $this->directoryConstructor();
        $this->fileName = $this->fileNameConstructor();
        $this->pathToFile = storage_path('app/' . $this->directory . '/' . $this->fileName);

    }

    public function jobSelector() {

        switch ($this->stationary->name) {
            case 'a4sheet':
                return $this->makeA4();
                break;
            case 'recepi':
                $this->makeRecepi();
                break;
            case 'envelope':
                $this->makeSobreAmericano();
                break;
            case 'envelopeBig':
                $this->makeSobreBolsa();
                break;
            case 'businessCardClinic':
                $this->makeClinicBusinessCard();
                break;
        }

    }

    public function makeA4()
    {
        $this->pdf->SetTitle('Hoja A4 Dentix®.');
        $this->pdf->SetKeywords('Dentix Clínicas Papelería A4');
        $this->pdf->SetSubject('Hoja A4 corporativa preparada para Imprenta.');

        $this->marginLeft = 12.2;
        $this->marginRight = 12.2;

        $this->pdf->SetMargins($this->marginLeft, $this->marginTop, $this->marginRight, $this->marginBottom, true);

        $this->pdf->SetDrawSpotColor($this->Color512, 100);
        $this->pdf->SetFillSpotColor($this->Color512, 60);
        $this->pdf->SetTextSpotColor($this->Color512, 100);

        $this->pdf->SetAutoPageBreak(1, 1);

        $size = [210, 297];

        $this->pdf->AddPage('P', $size);

        $this->pdf->ImageEps($this->logo, 12.2, 11.1, 55, '', '', true, '', '', 0, false);

        $weight = 0.5;
        $end = 210 - $this->marginRight;

        $this->dotLine($this->pdf, $this->marginLeft, 25, $weight, $end);

        $this->pdf->ImageEps($this->logo10percent, 30.7, 138, 148.7, '', '', true, '', '', 0, false);

        $this->pdf->SetFillSpotColor($this->Color512, 10);
        $this->pdf->RoundedRect($this->marginLeft, 273.5, 185.6, 15, 4, '1111', 'F');

        $this->pdf->setY(277);
        $text = $this->clinic->address_real_1 . '. ' . $this->clinic->postal_code . ' ' . $this->clinic->city . '. Tel. ' . $this->clinic->phone_real . '.';
        $this->pdf->SetFont($this->fontDxThin, '', 10, '', false);
        $this->pdf->Cell(185.6, '', $text, 0, 0, 'C', false, '');

        $this->pdf->setY(281.5);
        $text = $this->web;
        $this->pdf->SetFont($this->fontDxRoman, '', 12, '', false);
        $this->pdf->Cell(185.6, '', $text, 0, 0, 'C', false, '');

        $this->pdf->SetTextSpotColor($this->Color9C, 100);
        $this->pdf->setY(256.5 - $this->marginTop);
        $this->pdf->setX($this->marginLeft - 5);
        $this->pdf->StartTransform();
        $this->pdf->Rotate(90, '', '');
        $text = 'DENTOESTETIC CENTRO DE SALUD Y ESTÉTICA DENTAL SLU. Reg. Mercantil de Madrid Tomo 17.969 Folio 107. Sección 8. Hoja M-310564. Inscripción 1ª. CIF: B-83409797';
        $this->pdf->SetFont($this->fontDxLight, '', 8, '', false);
        $this->pdf->Cell('', '', $text, 0, 0, 'C', false, '');
        $this->pdf->StopTransform();

        
        $this->pdf->Output($this->pathToFile, 'F');

    }

    public function makeRecepi() 
    {
        $this->pdf->SetTitle("Recetario A5 Dentix®.");
        $this->pdf->SetKeywords("Dentix Clínicas Papelería Recetario A5");
        $this->pdf->SetSubject("Recetario corporatio preparado para Imprenta.");
      
        $this->pdf->SetMargins($this->marginLeft,$this->marginTop,$this->marginRight,$this->marginBottom,true);
      
        $this->pdf->SetDrawSpotColor($this->Color512,100);
        $this->pdf->SetFillSpotColor($this->Color512,60);
        $this->pdf->SetTextSpotColor($this->Color512,100);
      
        $this->pdf->SetAutoPageBreak(1,1);
      
        $size = array(210,148);
      
        $this->pdf->AddPage("L",$size);
      
        $this->pdf->ImageEps(storage_path('app/sources/icon-pencil.eps'), $this->marginLeft, 16, 10, '', '', true, '', '', 0, false);
        $this->pdf->SetXY(22,19);
        $text = "D.p./";
        $this->pdf->SetFont($this->fontDxRoman,'',14,'',false);
        $this->pdf->Write('',$text,'',false,'L',false);
      
        $weight = 0.5;
        $end = 210-$this->marginRight;
      
        $y = 23.5;
        $this->pdf->SetFillSpotColor($this->Color512,30);
        $this->dotLine($this->pdf, 35, $y, $weight, $end);
      
        $this->pdf->ImageEps($this->logo10percent, 30.7, 64, 148.7, '', '', true, '', '', 0, false);
      
        $this->pdf->SetFillSpotColor($this->Color512,10);
        $this->pdf->RoundedRect($this->marginLeft,125,210-$this->marginRight-$this->marginLeft,15,4,'1111','F');
      
        $this->pdf->setY(128.4);
        $text = $this->clinic->address_real_1.". ".$this->clinic->postal_code." ".$this->clinic->city.". Tel. ".$this->clinic->phone_real.".";
        $this->pdf->SetFont($this->fontDxThin,'',10,'',false);
        $this->pdf->Cell(185.6,'',$text,0,0,'C',false,'');
      
        $this->pdf->setY(133);
        $text = $this->web;
        $this->pdf->SetFont($this->fontDxRoman,'',12,'',false);
        $this->pdf->Cell(185.6,'',$text,0,0,'C',false,'');
      
        $this->pdf->Output($this->pathToFile, 'F');  
    }

    public function makeSobreAmericano() 
    {
        $this->pdf->SetTitle("Sobre americano Dentix®.");
        $this->pdf->SetKeywords("Dentix Clínicas Papelería Sobre Americano");
        $this->pdf->SetSubject("Sobre americano corporativo preparado para Imprenta.");
      
        $this->pdf->SetMargins($this->marginLeft,$this->marginTop,$this->marginRight,$this->marginBottom,true);
            
        $this->pdf->SetDrawSpotColor($this->Color512,100);
        $this->pdf->SetFillSpotColor($this->Color512,100);
        $this->pdf->SetTextSpotColor($this->Color512,100);
      
        $this->pdf->SetAutoPageBreak(1,1);
      
        $size = array(225,115);
      
        $this->pdf->AddPage("L",$size);
      
        $this->pdf->ImageEps($this->logoClaim512, 152.7, 93.3, 67.3, '', '', true, '', '', 0, false);

        $this->pdf->SetFillSpotColor($this->Color512,10);
        $this->pdf->RoundedRect(5,83,141.6,26.25,4,'1111','F');
      
        $this->pdf->setY(86.5);
        $text = $this->clinic->address_real_1.".";
        $this->pdf->SetFont($this->fontDxLight,'',9,'',false);
        $this->pdf->Cell(131,'',$text,0,0,'L',false,'');
      
        $this->pdf->setY(90.5);
        $text = $this->clinic->postal_code." ".$this->clinic->city.".";
        $this->pdf->SetFont($this->fontDxLight,'',9,'',false);
        $this->pdf->Cell(131,'',$text,0,0,'L',false,'');
      
        $this->pdf->setY(94.5);
        $text = "Tel. ".$this->clinic->phone_real.".";
        $this->pdf->SetFont($this->fontDxLight,'',9,'',false);
        $this->pdf->Cell(131,'',$text,0,0,'L',false,'');
      
        $this->pdf->setY(102);
        $text = $this->web;
        $this->pdf->SetFont($this->fontDxRoman,'',12,'',false);
        $this->pdf->Cell(131,'',$text,0,0,'L',false,'');
      
        $weight = 0.3;
        $end = 141;
      
        $this->pdf->SetFillSpotColor($this->Color512,50);
        $this->dotLine($this->pdf,10,100,$weight,$end);
      
        $this->pdf->Output($this->pathToFile, 'F');      
    }

    public function makeSobreBolsa() 
    {
        $this->pdf->SetTitle("Sobre bolsa Dentix®.");
        $this->pdf->SetKeywords("Dentix Clínicas Papelería Sobre Bolsa");
        $this->pdf->SetSubject("Sobre bolsa corporativo preparado para Imprenta.");
      
        $this->pdf->SetMargins($this->marginLeft, $this->marginTop, $this->marginRight, $this->marginBottom, true);
      
        $this->pdf->SetDrawSpotColor($this->Color512,100);
        $this->pdf->SetFillSpotColor($this->Color512,100);
        $this->pdf->SetTextSpotColor($this->Color512,100);
      
        $this->pdf->SetAutoPageBreak(1,1);
      
        $size = array(324,229);
      
        $this->pdf->AddPage("L",$size);
      
        $this->pdf->ImageEps($this->logoClaim512, 220, 199, 97, '', '', true, '', '', 0, false);
      
        $this->pdf->SetFillSpotColor($this->Color512,10);
        $this->pdf->RoundedRect(7,184,204,38,4,'1111','F');
      
        $this->pdf->setXY(14,188);
        $text = $this->clinic->address_real_1.".";
        $this->pdf->SetFont($this->fontDxLight,'',13,'',false);
        $this->pdf->Cell(190,'',$text,0,0,'L',false,'');
      
        $this->pdf->setXY(14,194);
        $text = $this->clinic->postal_code." ".$this->clinic->city.".";
        $this->pdf->Cell(190,'',$text,0,0,'L',false,'');
      
        $this->pdf->setXY(14,200);
        $text = "Tel. ".$this->clinic->phone_real.".";
        $this->pdf->Cell(190,'',$text,0,0,'L',false,'');
      
        $this->pdf->setXY(14,212);
        $text = $this->web;
        $this->pdf->SetFont($this->fontDxRoman,'',17,'',false);
        $this->pdf->Cell(190,'',$text,0,0,'L',false,'');
      
        $weight = 0.3;
        $end = 203;
        $this->pdf->SetFillSpotColor($this->Color512,50);
        $this->dotLine($this->pdf, 14, 209, $weight, $end);
      
        $this->pdf->Output($this->pathToFile, "F");
    }

    public function makeClinicBusinessCard() {

        $line1 = $this->clinic->address_real_1.", ".$this->clinic->postal_code." ".$this->clinic->city;
        $line2 = "";
        $email = false;
        $domain = 'dentix.es';

        $this->pdf->SetTitle("Tarjeta de Visita Genérica Dentix®.");
        $this->pdf->SetKeywords("Dentix Clínicas Tarjeta de Visita Genérica");
        $this->pdf->SetSubject("Tarjeta de Visita Genérica preparada para imprenta.");

        $bleed = 3;
        $slug = 5;

        $marginTop = $bleed+$slug;
        $marginLeft = $bleed+$slug;
        $marginRight = $bleed+$slug;
        $marginBottom = $bleed+$slug;

        $this->pdf->SetMargins($marginLeft,$marginTop,$marginRight,$marginBottom,true);

        $this->pdf->SetDrawSpotColor($this->Color512,100);
        $this->pdf->SetFillSpotColor($this->Color512,100);
        $this->pdf->SetTextSpotColor($this->Color512,100);

        $this->pdf->SetAutoPageBreak(1,1);

        $pageWidth = 85+(($bleed+$slug)*2);
        $pageHeight = 55+(($bleed+$slug)*2);
        $size = array($pageWidth,$pageHeight);

        $this->pdf->AddPage("L",$size);
        
        $this->pdf->SetFillSpotColor($this->Color512,10);
        $this->pdf->Rect($slug,27.5+$bleed+$slug,$pageWidth-($slug*2),17,'F');

        $this->pdf->setY(16+$bleed+$slug);
        $text = 'Dentix ' . $this->clinic->city;
        $this->pdf->SetFont($this->fontDxRoman,'',14,'',false);
        $this->pdf->Cell(85,'',$text,0,0,'C',false,'');

        $lineHeight = 3.2;
        if (!empty($line2)) {
            $y = 29.5+$bleed+$slug;
        } else {
            $y = 31+$bleed+$slug;
        }
        $this->pdf->setY($y);
        $text = $line1;
        $this->pdf->SetFont($this->fontDxThin,'',8,'',false);
        $this->pdf->Cell(85,'',$text,0,0,'C',false,'');

        if (!empty($line2)) {
            $y = $y+$lineHeight;
            $this->pdf->setY($y);
            $text = $line2;
            $this->pdf->SetFont($this->fontDxThin,'',8,'',false);
            $this->pdf->Cell(85,'',$text,0,0,'C',false,'');
        } else {
            $y = $y+($lineHeight*1.2);
            $this->pdf->setY($y);
            $text = 'Tel.: ' .  $this->clinic->phone_real;
            $this->pdf->SetFont($this->fontDxThin,'',8,'',false);
            $this->pdf->Cell(85,'',$text,0,0,'C',false,'');
        }

        $y = $y+($lineHeight*1.2);
        $this->pdf->setY($y);
        $text = 'info.' . $this->clinic->email_ext . '@' . $domain;
        $this->pdf->SetFont($this->fontDxRoman,'',8,'',false);
        $this->pdf->Cell(85,'',$text,0,0,'C',false,'');


        $this->pdf->setY(47.7+$bleed+$slug);
        $text = $this->web;
        $this->pdf->SetFont($this->fontDxThin,'',10,'',false);
        $this->pdf->Cell(85,'',$text,0,0,'C',false,'');

        if ($bleed > 0) {
            $this->bleedLines($this->pdf, $pageWidth, $pageHeight, $bleed, $slug);
        }

        $this->pdf->AddPage();

        $this->pdf->SetFillSpotColor($this->Color512,100);
        $this->pdf->Rect(0+$slug,0+$slug,85+($bleed*2),55+($bleed*2),'F');

        // Without this lines EPS will appear in black 
        $this->pdf->SetDrawColor(0,0,0,0);
        $this->pdf->SetFillColor(0,0,0,0);

        $this->pdf->ImageEps($this->logoClaim512, 22+$bleed+$slug, 24+$bleed+$slug, 43, '', '', true, '', '', 0, false);

        if ($bleed > 0) {
            $this->bleedLines($this->pdf, $pageWidth, $pageHeight, $bleed, $slug);
        }

        $this->pdf->Output($this->pathToFile,"F");
    }

}