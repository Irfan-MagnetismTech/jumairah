<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SalesCollectionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $salesCollection;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($salesCollection)
    {
        $this->salesCollection = $salesCollection;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cc = ['sumonchandrashil@gmail.com'];
        return $this->markdown('emails.salescollectionmail')->subject("Payment was received.")->cc($cc);
    }
}
