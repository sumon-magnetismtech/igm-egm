<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyAttendanceMail extends Mailable
{
    use Queueable, SerializesModels;
    public $dailyAttendance;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dailyAttendance)
    {
        $this->dailyAttendance = $dailyAttendance;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        return $this->view('view.name');
        return $this->markdown('emails.dailyattendancetemplate')->subject("Today Attendance - ".now()->format('l, d-M-Y'));

    }
}
