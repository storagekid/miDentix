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
        if ($campaign->poster_starts_at) {
            $postersDate = \Carbon\Carbon::parse($campaign->poster_starts_at);
            $day = $postersDate->dayOfWeekIso;
            if ($day === 7) {
                $day = 1;
                $postersDate->addDay();
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
            $this->postersDate = $dayString . ' ' . $postersDate->day . ' de ' . $postersDate->locale('es')->monthName;
        }
        $this->subject = 'Distribución Cartelería Campaña ' . ucfirst($campaignDate->locale('es')->monthName) . ' ' . $campaignDate->year;
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
            ->subject($this->subject)
            ->attach($this->pdf, [
                'as' => $this->name
                ]);
    }
}
