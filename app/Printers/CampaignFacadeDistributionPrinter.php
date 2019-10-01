<?php

namespace App\Printers;

use App\Printers\DentixPdfPrinter;
use App\Clinic;
use Illuminate\Support\Facades\View;

class CampaignFacadeDistributionPrinter extends DentixPdfPrinter
{
    protected $clinic, $campaign;
    protected $foamImage, $translightImage;
    protected $hasFoam;
    protected $dateString;

    public function __construct(Clinic $clinic, $campaign) {

        parent::__construct();

        $this->clinic = $clinic;
        $this->campaign = $campaign;
        $this->foamImage = public_path('storage/img/foam.jpg');
        $this->translightImage = public_path('storage/img/translight.jpg');
        $this->hasFoam = $this->clinic->clinic_posters()->first()->poster->material === 'FOAM' ? true : false;
        $campaignDate = \Carbon\Carbon::parse($this->campaign->starts_at);
        $this->dateString = ucfirst($campaignDate->locale('es')->monthName) . ' ' . $campaignDate->year;

        $clinicDists = $clinic->active_distributions($this->campaign);

        foreach ($clinicDists as $dist) {
          if (!$dist->composed_facade) {
            $dist->composeFacadeBuilder();
          }
          $completeFacade = $dist->complete_facades()->where('campaign_id', request('campaign'))->first();
          if (!$completeFacade || request('force') == 'true') {
            $completeFacade = $dist->completeFacadeBuilder();
          }
          $this->files[] = $completeFacade->complete_facade()->first();
        }
        $this->fileName = $this->clinic->cleanName . '-' . $this->campaign->name . '-posters.pdf';
        $this->pathToFile = storage_path('app/' . $this->directory . '/' . $this->fileName);
    }

    public function makePdf()
    {
      $size = array(210,297);
      $marginRight = 50;
      $this->pdf->AddPage("P",$size);
      $this->pdf->SetFillColor(50, 90, 13, 15);
      $this->pdf->Rect(0,0,210,297,'F');

      $this->pdf->SetDrawColor(0,0,0,0);
      $this->pdf->SetFillColor(0,0,0,0);
      $this->pdf->SetTextColor(0,0,0,0);

      $this->pdf->setY(120);
      $this->pdf->SetFont($this->fontDxLight,'',18,'',false);
      $text = "Distribución de Carteles";
      $this->pdf->MultiCell('','',$text,0,'L',0,1,$marginRight,'',false,0,false,true,0,'T',false);

      $this->pdf->SetFont($this->fontDxLight,'',27,'',false);
      // $text = $this->campaign->name;
      $text = 'Campaña ' . $this->dateString;
      $this->pdf->MultiCell('','',$text,0,'L',0,1,$marginRight,'',false,0,false,true,0,'T',false);

      $this->dotLine($this->pdf, $marginRight, $this->pdf->getY() + 5, 0.3, 210);

      $this->pdf->setY($this->pdf->getY() + 10);
      
      $this->pdf->SetFont($this->fontDxLight,'',18,'',false);
      $text = $this->clinic->fullName;
      $this->pdf->MultiCell('','',$text,0,'L',0,1,$marginRight,'',false,0,false,true,0,'T',false);

      $logoHeight = 8;
      $this->pdf->ImageEps($this->logoWhite, $marginRight, $this->pdf->getY(), '', $logoHeight, '', true, 'L', '', 0, false);

      // INSTRUCTIONS
      $this->pdf->AddPage("P",$size);

      $this->pdf->SetDrawColor(0,0,0,0);
      $this->pdf->SetFillColor(0,0,0,0);
      $this->pdf->SetTextColor(0,0,0,100);

      $marginLeft = 20;

      $this->pdf->setY(10, true);
      $this->pdf->SetFont($this->fontDxLight,'',18,'',false);
      $html = (string)View::make('exports.distributionGuide', ['hasFoam' => $this->hasFoam, 'clinic' => $this->clinic, 'image' => $this->hasFoam ? $this->foamImage : $this->translightImage]);
      $this->pdf->setX(10);
      $this->pdf->writeHTML($html, true, false, true, false, '');
      // END INSTRUCTIONS

      $this->concat();

      $this->pdf->AddPage("P",$size);

      $logoHeight = 20;
      $this->pdf->ImageEps($this->logoClaim512,0, ($size[1]-$logoHeight) / 2, '', $logoHeight, '', true, 'M', 'C', 0, false);

      $this->pdf->Output($this->pathToFile, 'F');
      return $this;
    }
}