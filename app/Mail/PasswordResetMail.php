<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $link;

    /**
     * Create a new message instance.
     */
    public function __construct($link)
    {
        $this->link = $link;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('Réinitialisation de mot de passe')
            ->view('emails.reset_password')
            ->with(['link' => $this->link]);
    }
}
