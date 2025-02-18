<?php

namespace App\Console\Commands;

use App\Http\Controllers\Payroll\AttendanceController;
use Illuminate\Console\Command;
use Rats\Zkteco\Lib\Helper\Attendance;

class ZKTecoAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zktecoattendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $attendanceController = new AttendanceController();
        $attendanceController->attendanceszkteco();
    }
}
