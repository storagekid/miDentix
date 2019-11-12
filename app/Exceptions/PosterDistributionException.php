<?php

namespace App\Exceptions;

use App\Mail\PosterDistributionExceptionMail;
use Exception;
use Illuminate\Support\Facades\Mail;

class PosterDistributionException extends Exception
{
    protected $campaign, $clinic, $clinicPoster, $computedType, $campaignPriority;

    public function __construct($campaign, $clinic, $clinicPoster, $computedType)
    {
        $this->campaign = $campaign;
        $this->clinic = $clinic;
        $this->clinicPoster = $clinicPoster;
        $this->computedType = $computedType;
        $this->campaignPriority = $campaign->campaign_poster_priorities->filter(function ($i) { return $i->priority === $this->clinicPoster->priority; })->first()->poster->name;
    }

    public function render()
    {
        try {
            // $e = FlattenException::create($e);
            // $handler = new SymfonyExceptionHandler();
            // $html = $handler->getHtml($e);

            // Backup your default mailer
            $backup = Mail::getSwiftMailer();
            // Setup your office365 mailer
            $transport = new \Swift_SmtpTransport('smtp.office365.com', 587, 'TLS');
            $transport->setUsername('jgvillalba@dentix.es');
            $transport->setPassword('Gomez%01');
            // Any other mailer configuration stuff needed...
            $office365 = new \Swift_Mailer($transport);
            // Set the mailer as office365
            Mail::setSwiftMailer($office365);

            // Mail::to('')->send(new ExceptionOccured($html));
            Mail::to('jgvillalba@dentix.es')
                ->send(new PosterDistributionExceptionMail($this->campaign, $this->clinic, $this->clinicPoster, $this->computedType, $this->campaignPriority));

            // Restore your original mailer
            Mail::setSwiftMailer($backup);

        } catch (Exception $ex) {
            dd($ex);
        }
    }
}
