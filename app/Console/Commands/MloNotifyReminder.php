<?php

namespace App\Console\Commands;

use App\Mail\MloNotifyReminderMail;
use App\MLO\Mloblinformation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MloNotifyReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:MloNotifyReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description =
        '
            Collect all bl where DO not issued and bl created_at date is more than 15 days.
        ';

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
        $blInformations = Mloblinformation::with('mloMoneyReceipt', 'blNotify', 'mlofeederInformation', 'blcontainers')
        ->doesnthave('mloMoneyReceipt')
        ->whereHas('mlofeederInformation', function($q){
            $q->whereDate('berthingDate', Carbon::now()->subDays(15)->toDateString())
                ->OrwhereDate('berthingDate', Carbon::now()->subDays(30)->toDateString())
                ->OrwhereDate('berthingDate', Carbon::now()->subDays(45)->toDateString())
                ->OrwhereDate('berthingDate', Carbon::now()->subDays(60)->toDateString())
                ->OrwhereDate('berthingDate', Carbon::now()->subDays(75)->toDateString())
                ->OrwhereDate('berthingDate', Carbon::now()->subDays(90)->toDateString())
                ->OrwhereDate('berthingDate', Carbon::now()->subDays(105)->toDateString())
                ->OrwhereDate('berthingDate', Carbon::now()->subDays(120)->toDateString())
                ->OrwhereDate('berthingDate', Carbon::now()->subDays(135)->toDateString())
                ->OrwhereDate('berthingDate', Carbon::now()->subDays(150)->toDateString())
                ->OrwhereDate('berthingDate', Carbon::now()->subDays(165)->toDateString())
                ->OrwhereDate('berthingDate', Carbon::now()->subDays(180)->toDateString());
        })
        ->get();

//dd($blInformations->count());

        foreach($blInformations as $blInformation){
            if($blInformation->blNotify->EMAIL){
                Mail::to($blInformation->blNotify->EMAIL)->send(new MloNotifyReminderMail($blInformation));
            }
        }
    }
}
