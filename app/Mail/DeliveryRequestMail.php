<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeliveryRequestMail extends Mailable
{
    use Queueable, SerializesModels;
    public $masterbl, $countContTypes;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($masterbl, $countContTypes)
    {
        $this->masterbl = $masterbl;
        $this->countContTypes = $countContTypes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        $cc = ['sumon@magnetismtech.com', 'julia@qclogistics.com'];
        $cc = ['sumon@magnetismtech.com'];
        $mlobl = $this->masterbl->mblno;
        return $this->markdown('emails.e-delivery-request-form')->subject("Request for issuing E-Delivery Order B/L: $mlobl.")->cc($cc);
    }
}
