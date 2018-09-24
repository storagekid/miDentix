<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Clinic;

class StationaryOrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $clinic, $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Clinic $clinic, $user)
    {
        $this->clinic = $clinic;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('emails.stationaryOrderPlaced')
                    ->from($this->user->email)
                    ->subject('Pedido para ' . $this->clinic->fullName . ' reaizado con éxito');
    }
}
