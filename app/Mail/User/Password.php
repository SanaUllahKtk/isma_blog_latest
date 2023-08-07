<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mailer\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;


class Password extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $otp;
    public function __construct($user, $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }



    public function build()
    {
        return $this->subject('Password reset from ISMA')->view('emails.user.password');
    }
}
