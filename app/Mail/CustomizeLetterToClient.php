<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomizeLetterToClient extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $CsdLetterMail;
    public function __construct($CsdLetterMail)
    {
        $this->CsdLetterMail = $CsdLetterMail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cc = ['sumon@magnetismtech.com', 'sumonchandrashil@gmail.com'];

        return $this->markdown('emails.customize-letter-to-client')
            ->subject('JUMAIRAH HOLDINGS LTD')
            ->cc($cc);
    }
}
