<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PosterDistributionExceptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $campaign, $clinic, $clinicPoster, $computedType, $campaignPriority;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($campaign, $clinic, $clinicPoster, $computedType, $campaignPriority)
    {
        $this->campaign = $campaign;
        $this->clinic = $clinic;
        $this->clinicPoster = $clinicPoster;
        $this->computedType = $computedType;
        $this->campaignPriority = $campaignPriority;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(['address' => 'jgvillalba@dentix.es', 'name' => 'Marketing Development'])
            ->markdown('emails.exceptions.posterDistributionException')
            ->subject('Poster Distribution Error');
    }
}
