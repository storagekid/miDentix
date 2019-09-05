<?php

namespace App\Printers;

use App\ClinicSchedule;
use Illuminate\Support\Facades\View;

class PersonalTagsPrinter extends DentixPdfPrinter
{
    public $fileName, $pathToFile, $path;
    public $clinic_schedules;

    public function __construct($clinic_schedules) {
        parent::__construct();

        $this->clinic_schedules = $clinic_schedules;

        $this->fileName = $this->clinic_schedules[0]->clinic_profile->clinic->nickname . '-identificadores-' . \Carbon\Carbon::now() . '.pdf';
        // dd($this->fileName);
        // $this->pathToFile = storage_path('app/' . $this->directory . '/' . $this->fileName);

    }

    public function makePdf()
    {
      $this->pdf->SetAuthor("Dentix® - Dpto. de Desarrollo");
      $this->pdf->SetCreator("Generador de Identificadores Dentix®.");
      $this->pdf->SetTitle("Identificadores Dentix®.");
      $this->pdf->SetKeywords("Dentix Clínicas Identificadores");
      $this->pdf->SetSubject("Identificadores para los uniformes de clínica.");

      $this->pdf->setPrintHeader(false);
      $this->pdf->setPrintFooter(false);
      $this->pdf->setPageOrientation('L');
      $marginTop = 6;
      $marginLeft = 10;
      $marginRight = 10;
      $marginBottom = 1;

      $width = 68;
      $height = 20;
      $margin = 5;

      $this->pdf->SetMargins($marginLeft,$marginTop,$marginRight,$marginBottom,true);

      $this->pdf->SetAutoPageBreak(1,1);


      $this->pdf->SetDrawColor(0,0,0,60);
      $this->pdf->SetFillColor(50,90,13,15);
      $this->pdf->SetTextColor(0,0,0,85);

      $y;$height;$margin;

      $this->pdf->AddPage();
      $this->pdf->setEqualColumns(3,68);
      $this->pdf->selectColumn(0);
      $y = $this->pdf->GetY();

      $c = 0;
      $i = 0;

      foreach ($this->clinic_schedules as $schedule) {
          $name;
          if (strlen($schedule->clinic_profile->profile->name . ' ' . $schedule->clinic_profile->profile->lastname1 . ' ' . $schedule->clinic_profile->profile->lastname2) <= 26) {
              $name = $schedule->clinic_profile->profile->name . ' ' . $schedule->clinic_profile->profile->lastname1 . ' ' . $schedule->clinic_profile->profile->lastname2;
              // dd($name);
              // dd(strlen($name));
          } else if (strlen($schedule->clinic_profile->profile->name . ' ' . $schedule->clinic_profile->profile->lastname1) <= 26) {
              // dd(strlen($name));
              $name = $schedule->clinic_profile->profile->name . ' ' . $schedule->clinic_profile->profile->lastname1;
          } else {
              // dd(strlen($name));
              return false;
          }
          $puesto = $schedule->job_type->name;

          if ($i > 2) {
              $i = 0;
              $y = $y+$height+$margin;
          }

          $this->pdf->selectColumn($i);

          $x = $this->pdf->GetX();
          $this->pdf->SetY($y);
          $this->pdf->SetFont('','B',1);
          $this->pdf->Cell(68,2.5,'',0,1,'C',false,'',0,false,'T','C');
          $this->pdf->Cell(68,1,'',0,1,'C',true,'',0,false,'T','C');
          $this->pdf->SetFont('','B',12);
          // ( $w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M' )
          $this->pdf->Cell(68,7,$name,0,1,'C',false,'',0,false,'T','B');
          $this->pdf->SetFont('','',10);
          $this->pdf->Cell(68,5.9,$puesto,0,1,'C',false,'',0,false,'T','T');
          $this->pdf->SetFont('','B',1);
          $this->pdf->Cell(68,1,'',0,1,'C',true,'',0,false,'T','C');
          $this->pdf->Cell(68,2.5,'',0,1,'C',false,'',0,false,'T','C');
          $this->pdf->Rect($x,$y,68,20,'D');

          $i++;
          $c++;

          if ($c%24 == 0) {
              $i = 0;
              $this->pdf->AddPage();
              $this->pdf->setEqualColumns(3,68);
              $this->pdf->selectColumn(0);
              $y = $this->pdf->GetY();
              // newPage($this->pdf);
          }
      }

      $this->pathToFile =  storage_path('app/' . $this->directory . $this->fileName);
      
      $this->pdf->Output($this->pathToFile, 'F');
      return $this;
    }
}