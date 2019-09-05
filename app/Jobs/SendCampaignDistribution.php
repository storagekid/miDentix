<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\PosterDistributionNotification;

class SendCampaignDistribution implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $clinic, $campaign, $pdf, $name, $fake;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($clinic, $campaign, $fake)
    {
        $clinicCampaignPdf = $clinic->campaign_facades()->where('campaign_id',$campaign->id)->first();
        $campaignDate = \Carbon\Carbon::parse($campaign->starts_at);
        $fileName = $clinic->nickname . '-Carteleria-' . ucfirst($campaignDate->locale('es')->shortMonthName) . '-' . $campaignDate->year . '.pdf';
        $pdf = storage_path('app/' . $clinicCampaignPdf->facades()->first()->url);
        $this->pdf = $pdf;
        $this->name = $fileName;
        $this->fake = $fake;
        $this->campaign = $campaign;
        $this->clinic = $clinic;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $mailTo = ['director.' . $this->clinic->email_ext . '@dentix.es', 'subdirector.' . $this->clinic->email_ext . '@dentix.es', 'info.' . $this->clinic->email_ext . '@dentix.es'];
        // $mailCC = [];
        $mailTo = 'jgvillalba@mozodealmacen.com';
        $mailCC = ['jgvillalba@dentix.es'];
        if ($this->fake === false) {
            // $mailTo = 'jgvillalba@mozodealmacen.com';
            // $mailCC = ['jgvillalba@dentix.es', 'acruz@dentix.es', 'dhernandez@dentix.es'];
            $mailTo = ['director.' . $this->clinic->email_ext . '@dentix.es', 'subdirector.' . $this->clinic->email_ext . '@dentix.es', 'info.' . $this->clinic->email_ext . '@dentix.es'];
            $mailCC = [];
            // dump('HERE');
            $backup = Mail::getSwiftMailer();
            // Setup your office365 mailer
            $transport = new \Swift_SmtpTransport('smtp.office365.com', 587, 'TLS');
            $transport->setUsername('marketing@dentix.es');
            $transport->setPassword('Jow73441');
            $office365 = new \Swift_Mailer($transport);

            Mail::setSwiftMailer($office365);
        }

        $mail = Mail::to($mailTo)
            ->cc($mailCC)
            ->send(new PosterDistributionNotification($this->pdf, $this->name, $this->campaign));
        if ($this->fake === false) Mail::setSwiftMailer($backup);
        return $mail;
    }
}
