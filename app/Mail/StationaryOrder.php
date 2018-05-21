<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Stationary;
use App\Clinic;

class StationaryOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $stationaries;
    public $clinic;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($stationaries)
    {
        $this->stationaries = $stationaries;
        $this->clinic = $stationaries[0]->clinic;
        $this->user = $stationaries[0]->user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.stationaryOrder')
                    ->from($this->user->email)
                    ->subject('Pedido para ' . $this->clinic->fullName);
    }
}
