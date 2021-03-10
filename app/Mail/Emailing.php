<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Emailing extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $view, $html;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $html = null)
    {
        $this->name = $name;
        $this->view = 'emailings.' . $this->name;
        $this->html = $html;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->from(['address' => 'jgvillalba@mozodealmacen.com', 'name' => 'JG Villalba'])
            ->view($this->view)
            ->subject('Test from JG');
    }
}
