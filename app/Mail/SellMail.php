<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellMail extends Mailable
{
    use Queueable, SerializesModels;
    public $sell;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sell)
    {
        return $this->sell = $sell;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cc = ['sumon@magnetismtech.com', 'sumonchandrashil@gmail.com'];
        return $this->markdown('emails.sellmail')->subject('Intimacy Letter.')->cc($cc);
    }
}
