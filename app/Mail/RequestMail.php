<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userData;
    public $mailData;

    public function __construct($userData, $mailData)
    {
        $this->userData = $userData;
        $this->mailData = $mailData;
    }

    public function build()
    {
        $email = $this->subject($this->mailData['subject'])
                ->view('request.mail');

        return $email;
    }
}
