<?php

namespace App\Console;

use App\Console\Commands\DailyAttendance;
use App\Console\Commands\WeeklyReport;
use App\Console\Commands\ZKTecoAttendance;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        WeeklyReport::class,
        ZKTecoAttendance::class,
        DailyAttendance::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
//        $schedule->command(WeeklyReport::class)->everyMinute();
        $schedule->command(ZKTecoAttendance::class)->everyMinute();
//        $schedule->command('backup:run --only-db');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
