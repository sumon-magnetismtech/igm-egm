<?php

namespace App\Console\Commands;

use App\Mail\DailyAttendanceMail;
use App\Payroll\Attendance;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DailyAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyattendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will collect attendance report from attendance table and mail to respective persons.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dailyAttendance = Attendance::whereDate('date', Carbon::now()->toDateString())->get();

        $recipients = ['sumon@magnetismtech.com', 'hasanshahriare@gmail.com', 'shahriare@magnetismtech.com'];
        foreach($recipients as $recipient){
            Mail::to($recipient)->send(new DailyAttendanceMail($dailyAttendance));
        }
    }
}
