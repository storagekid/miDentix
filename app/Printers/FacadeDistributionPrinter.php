<?php

namespace App\Printers;

use App\ClinicPosterDistribution;
use Illuminate\Support\Facades\View;

class FacadeDistributionPrinter extends DentixPdfPrinter
{
    public $fileName, $pathToFile, $path;
    public $design, $campaign, $composedFacade;
    protected $hasFoam;
    public $force;

    public function __construct(ClinicPosterDistribution $clinicposterdistribution, $campaign) {
        parent::__construct();

        $this->design = $clinicposterdistribution;
        $this->composedFacade = $this->design->composed_facade()->first();
        $this->campaign = $campaign;
        $this->hasFoam = $clinicposterdistribution->clinic->clinic_posters()->first()->poster->material === 'FOAM' ? true : false;

        $this->fileName = $clinicposterdistribution->address->cleanStreet . '-' . $this->campaign->name . '-facade-complete.pdf';
        $this->pathToFile = storage_path('app/' . $this->directory . '/' . $this->fileName);

    }

    public function makePdf()
    {
        $this->pdf->SetTitle('Distribución Cartelería Dentix®.');
        $this->pdf->SetKeywords('Dentix Clínicas Cartelería');
        $this->pdf->SetSubject('Dossier Cartelería de Clínica para la Campaña Actual');

        $this->marginLeft = 12.2;
        $this->marginRight = 12.2;

        $this->pdf->SetMargins(10, 10, 10, 10, true);

        $this->pdf->SetDrawSpotColor($this->Color512, 100);
        $this->pdf->SetFillSpotColor($this->Color512, 60);
        $this->pdf->SetTextSpotColor($this->Color512, 100);

        $this->pdf->SetAutoPageBreak(1, 1);

        $size = [210, 297];

        $this->pdf->AddPage('P', $size);

        $ultimatePosters = $this->design->getCampaignPostersGrouped($this->campaign);
        $distribution = json_decode($this->design->distributions, true);

        $holders = $this->design->findDistributionsPosters($ultimatePosters);

        if (count($holders) < 6) {
            $html = (string)View::make('exports.facadePdf', ['campaign' => $this->campaign, 'design' => $this->design, 'distribution' => $distribution, 'holders' => $holders, 'composed' => $this->composedFacade, 'hasFoam' => $this->hasFoam]);
            $this->pdf->setY(11, true);
            $this->pdf->writeHTML($html, true, false, true, false, '');
        } else {
            $pages = ceil(count($holders) / 5);
            $round = 1;
            while (count($holders) > 5) {
                $pieces = array_splice($holders, 0, 5);
                $html = (string)View::make('exports.facadePdf', ['campaign' => $this->campaign, 'design' => $this->design, 'distribution' => $distribution, 'holders' => $pieces, 'composed' => $this->composedFacade, 'hasFoam' => $this->hasFoam, 'pages' => $pages, 'round' => $round]);
                $this->pdf->setY(11, true);
                $this->pdf->writeHTML($html, true, false, true, false, '');
                $this->pdf->AddPage('P', $size);
                $round++;
            }
            $html = (string)View::make('exports.facadePdf', ['campaign' => $this->campaign, 'design' => $this->design, 'distribution' => $distribution, 'holders' => $holders, 'composed' => $this->composedFacade, 'hasFoam' => $this->hasFoam, 'pages' => $pages, 'round' => $round]);
            $this->pdf->setY(11, true);
            $this->pdf->writeHTML($html, true, false, true, false, '');
        }
        $this->pdf->Output($this->pathToFile, 'F');
        return $this;
    }
}