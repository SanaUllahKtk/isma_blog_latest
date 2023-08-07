<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $senderEmail;
    public $receiverEmail;
    public $subject;
    public $content;

    public function __construct($senderEmail, $receiverEmail, $subject, $content)
    {
        $this->senderEmail = $senderEmail;
        $this->receiverEmail = $receiverEmail;
        $this->subject = $subject;
        $this->content = $content;
    }

    public function build()
    {
        return $this->subject($this->subject)
            ->view('site.email')
            ->with([
                'senderEmail' => $this->senderEmail,
                'receiverEmail' => $this->receiverEmail,
                'emailContent' => $this->content,
            ]);
    }
}
