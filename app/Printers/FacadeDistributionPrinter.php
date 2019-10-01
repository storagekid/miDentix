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

        $distribution = json_decode($this->design->distributions, true);
        $clinicPostersPriorities = \App\ClinicPosterPriority::find($distribution['posterIds']);
        $clinicPosters = collect();
        foreach ($clinicPostersPriorities as $item) {
            $temp = $item->clinic_poster;
            $temp['priority'] = $item->priority;
            $clinicPosters[] = $temp;
        }

        $clinicPosterIds = $clinicPosters->groupBy('poster_id')->keys()->toArray();

        $posters =
            \App\CampaignPoster::where('campaign_id', $this->campaign->id)
            ->where('language_id', $this->design->clinic->language_id)
            ->whereIn('poster_id', $clinicPosterIds)
            ->get();
        if ($this->campaign->parent_id) {
            $campaignPosterPriorities = $this->campaign->campaign_poster_priorities->pluck('poster_model_id')->all();
            foreach ($campaignPosterPriorities as $key => $posterModel) {
                $campaignPosters =
                    \App\CampaignPoster::where('campaign_id', $this->campaign->id)
                    ->where('poster_model_id', $posterModel)
                    ->get();
                if (!count($campaignPosters)) {
                    $parentPosters = \App\CampaignPoster::where('campaign_id', $this->campaign->parent_id)
                    ->where('poster_model_id', $posterModel)
                    ->whereIn('poster_id', $clinicPosterIds)
                    ->get();
                    $posters = $posters->merge($parentPosters);
                }
            }
        }
        foreach ($posters as $poster) {
            $poster->append('priority');
            $poster->load('poster_af');
        }
        $postersGrouped = $posters->groupBy(['poster_id', 'type', 'priority']);

        $defPosters = [];
        // dd($postersGrouped->toArray());
        foreach ($clinicPosters as $clinicPoster) {
            $type = $clinicPoster->type;
            // dump($type);
            if ($type === 'Office' && $clinicPoster->poster->material === 'Translight') {
                $type = 'Ext';
                // dump('Office Translight Found');
            }
            else if ($type === 'Int' && !$postersGrouped[$clinicPoster->poster_id]->has('Int')) $type = 'Ext';
            else if ($type === 'Office Int' && $clinicPoster->priority !== 5) {
                // dump('HEre');
                $type = $clinicPoster->poster->material === 'FOAM' ? 'Office' : 'Ext';
            }
            // dump($type);
            // dump($clinicPoster->priority);
            $posterCandidates =
                $postersGrouped[$clinicPoster->poster_id][$type]->has($clinicPoster->priority) ?
                $postersGrouped[$clinicPoster->poster_id][$type][$clinicPoster->priority] :
                $postersGrouped[$clinicPoster->poster_id][$type === 'Office Int' ? 'Office' : 'Ext'][$clinicPoster->priority];
            // if (!$posterCandidates && $this->campaign->parent_id) {
            //     $posterCandidates = $parentPostersGrouped[$clinicPoster->poster_id][$type]->has($clinicPoster->priority) ? $parentPostersGrouped[$clinicPoster->poster_id][$type][$clinicPoster->priority] : $parentPostersGrouped[$clinicPoster->poster_id][$type === 'Office Int' ? 'Office' : 'Ext'][$clinicPoster->priority];
            // }
            // dump($type);
            // dump($clinicPoster->priority);
            // dump($postersGrouped[$clinicPoster->poster_id][$type]->has($clinicPoster->priority));
            // dump($parentPostersGrouped[$clinicPoster->poster_id][$type]->has($clinicPoster->priority));
            // dd($this->campaign->parent_id);
            // dd($postersGrouped[10]['Office'][2]->toArray());
            // $posterCandidates = array_key_exists($clinicPoster->priority, $postersGrouped[$clinicPoster->poster_id][$type]->toArray()) ? $postersGrouped[$clinicPoster->poster_id][$type][$clinicPoster->priority] : $postersGrouped[$clinicPoster->poster_id][$type === 'Int' ? 'Ext' : 'Office'][$clinicPoster->priority];
            if (count($posterCandidates) > 1) {
                $grouped = $posterCandidates->groupBy(['clinic_id', 'county_id', 'state_id']);

                if ($grouped->has($this->design->clinic_id)) {
                    $defPosters[] = $grouped[$this->design->clinic_id][0];
                } elseif ($grouped['']->has($this->design->clinic->county_id)) {
                    $defPosters[] = $grouped[''][$this->design->clinic->county_id][0];
                } elseif ($grouped['']['']->has($this->design->clinic->county->state_id)) {
                    $defPosters[] = $grouped[''][''][$this->design->clinic->county->state_id][0];
                } else {
                    $defPosters[] = $grouped[''][''][''][0];
                }
            } else {
                $defPosters[] = $posterCandidates[0];
            }
        }
        foreach ($defPosters as $poster) {
            $poster['codes'] = $poster->satinaryCodesByCampaign();
        }

        $ultimatePosters = collect($defPosters);
        // foreach ($ultimatePosters as $poster) dump($poster->toArray()['poster_af']['name']);
        // dd('Exit');
        // dd($ultimatePosters->toArray());
        $holders = $this->design->findDistributionsPosters($ultimatePosters);
        // $holders = $distribution['holders'];
        // dd('Checking');
        // dd($holders);

        // $campaign = \App\Campaign::with(['sanitary_codes'])->find(12);
        // dump(public_path('storage/' . $this->composedFacade->url));
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