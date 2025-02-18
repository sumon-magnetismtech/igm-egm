<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MloNotifyReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $blInformation;
    public function __construct($blInformation)
    {
        return $this->blInformation = $blInformation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cc = ['sumon@magnetismtech.com','jahangir@magnetismtech.com',];
        return $this->markdown('emails.MloNotifyReminderMailTemplate')
            ->subject('Reminder for Undelivered Cargo. B/L:'.$this->blInformation->bolreference)->cc($cc);
    }
}
