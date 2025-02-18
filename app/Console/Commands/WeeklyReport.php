<?php

namespace App\Console\Commands;

use App\Deliveryorder;
use App\Http\Controllers\DeliveryorderController;
use App\Mail\WeeklyReportMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class WeeklyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For Sending Weekly Report via email to all key persons of the company';

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
        $deliveryOrders =Deliveryorder::with('moneyReceipt.houseBl.masterbl')->whereBetween('created_at', [now()->subDays(7), now()])->get();
        $recipients = ['sumonchandrashil@gmail.com', 'sumonchandrashil@gmail.com'];
        foreach($recipients as $recipient){
            Mail::to($recipient)->send(new WeeklyReportMail($deliveryOrders));
        }
    }
}
