<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PosterDistributionForClinic extends Mailable
{
    use Queueable, SerializesModels;

    public $campaign;
    public $clinic;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($campaign, $clinic)
    {
        $this->campaign = $campaign;
        $this->clinic = $clinic;
        $clinicPosters = $this->clinic->clinic_posters;
        foreach ($clinicPosters as $clinicPoster) {
          $clinicPoster->campaignPriority = $clinicPoster->getCampaignPriority($this->campaign !== '' ? $this->campaign['id'] : null);
        }
        // dd($clinicPosters->toArray());
        $clinicPosterIds = $this->clinic->clinic_posters->groupBy('poster_id');
        // dd($clinicPosterIds->toArray());
        // $posters = $this->campaign !== '' ? $this->campaign->campaign_posters : \App\Campaign::orderByDesc('created_at')->first()->campaign_posters;
        $posters = 
          \App\CampaignPoster::where('campaign_id', $this->campaign !== '' ? $this->campaign['id'] : \App\Campaign::orderBy('created_at')->first()->id)
          ->where('language_id', $this->clinic->language_id)
          ->whereIn('poster_id', $clinicPosterIds->keys())
          ->get();
        // dd($posters);
        foreach ($posters as $poster) {
          $poster->append('priority');
        }
        $grouped = $posters->groupBy(['clinic_id', 'county_id', 'state_id']);
        // $posters->append('priority');
        $posterClinics = $grouped->keys()->toArray();
        $posterCounties = $grouped['']->keys()->toArray();
        $posterStates = $grouped['']['']->keys()->toArray();
        $defPosters = [];
        if (in_array($this->clinic->id, $posterClinics)) $defPosters = $grouped[$this->clinic->id];
        else if (in_array($this->clinic->county_id, $posterCounties)) $defPosters = $grouped[''][$this->clinic->county_id];
        else if (in_array($this->clinic->county->state_id, $posterStates)) $defPosters = $grouped[''][''][$this->clinic->county->state_id];
        else $defPosters = $grouped[''][''][''];
        // dd($defPosters->toArray());
        $ultimatePosters = $defPosters->filter(function($i) use ($clinicPosterIds) {
          if (in_array($i->poster_id, $clinicPosterIds->keys()->toArray())) {
            foreach ($clinicPosterIds[$i->poster_id] as $item) {
              if ($i->priority === $item->priority) return $i;
            }
          }
        });
        // dd($ultimatePosters->toArray());
        // $this->clinic->poster_distributions->holders = [];
        foreach ($this->clinic->poster_distributions as $designIndex => $design) {
            $distribution = json_decode($design->distributions, true);
            $holders = $distribution['holders'];
            foreach ($holders as $i => $holder) {
                foreach ($holders[$i]['ext'] as $campaign => $clinicPosterPriority) {
                    $def = \App\ClinicPosterPriority::with('clinic_poster')->find($clinicPosterPriority)->toArray();
                    $image = $ultimatePosters->filter(function($i) use ($def) {
                    if ($i->poster_id === $def['clinic_poster']['poster_id'] && $i->priority === $def['priority']) return $i->thumbnail;
                    })->first();
                    $holders[$i]['ext'][$campaign] = $def;
                    $holders[$i]['ext'][$campaign]['image'] = $image->thumbnail;
                }
                foreach ($holders[$i]['int'] as $campaign => $clinicPosterPriority) {
                    $def = \App\ClinicPosterPriority::with('clinic_poster')->find($clinicPosterPriority)->toArray();
                    $image = $ultimatePosters->filter(function($i) use ($def) {
                        if ($i->poster_id === $def['clinic_poster']['poster_id'] && $i->priority === $def['priority']) return $i->thumbnail;
                    })->first();
                    $holders[$i]['int'][$campaign] = $def;
                    $holders[$i]['int'][$campaign]['image'] = $image->thumbnail;
                }
            }
            $this->clinic->poster_distributions[$designIndex]['holders'] = [];
            $this->clinic->poster_distributions[$designIndex]['holders'] = $holders;
        }
        // dd($this->clinic->poster_distributions->toArray());
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(['address' => 'jgvillalba@dentix.es', 'name' => 'JG Villalba'])->markdown('emails.posterDistributionForClinic');
    }
}
