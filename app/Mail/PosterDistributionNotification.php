<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PosterDistributionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf, $name;
    public $subject, $postersDate;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($file, $name, $campaign)
    {
        $this->pdf = $file;
        $this->name = $name;
        $campaignDate = \Carbon\Carbon::parse($campaign->starts_at);
        $day = $campaignDate->dayOfWeekIso;
        if ($day === 7) {
            $day = 1;
            $campaignDate->addDay();
        }
        $dayString = '';
        switch ($day) {
            case 1:
                $dayString = 'lunes';
                break;
            case 2:
                $dayString = 'martes';
                break;
            case 3:
                $dayString = 'miércoles';
                break;
            case 4:
                $dayString = 'jueves';
                break;
            case 5:
                $dayString = 'viernes';
                break;
            case 6:
                $dayString = 'sábado';
                break;
            default:
                $dayString = 'domingo';
                break;
        }
        $this->subject = 'Distribución Cartelería Campaña ' . ucfirst($campaignDate->locale('es')->monthName) . ' ' . $campaignDate->year;
        $this->postersDate = $dayString . ' ' . $campaignDate->day . ' de ' . $campaignDate->locale('es')->monthName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dump('MAIL REACHED');
        return $this->from(['address' => 'marketing@dentix.es', 'name' => 'Dpto. Marketing Dentix'])
            ->markdown('emails.posterDistributionNotification')
            ->subject('Distribución Cartelería Campaña Septiembre 2019')
            ->attach($this->pdf, [
                'as' => $this->name
                ]);
    }
}
