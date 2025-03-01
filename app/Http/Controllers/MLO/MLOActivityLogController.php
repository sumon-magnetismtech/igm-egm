<?php

namespace App\Http\Controllers\MLO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class MLOActivityLogController extends Controller
{

    public function feederslog($id)
    {
        $feeders = Activity::with('causer')->where(['subject_type' => 'App\MLO\Feederinformation', 'subject_id' => $id])->get();
        return view('activitylog.mloFeederLog', compact('feeders'));
    }

    public function blinformationslog($id)
    {
        $logs = Activity::with('causer')->where(['subject_type' => 'App\MLO\Mloblinformation', 'subject_id' => $id])->get();
        return view('activitylog.mloBlInformationLog', compact('logs'));
    }

    public function egmblinformationslog($id)
    {
        // dd($id);
        $logs = Activity::with('causer')->where(['subject_type' => 'App\EgmMloblinformation', 'subject_id' => $id])->get();
        return view('activitylog.egmmloBlInformationLog', compact('logs'));
    }

    public function mlomoneyreceiptslog($id)
    {
        $logs = Activity::with('causer')->where(['subject_type' => 'App\MLO\MoneyReceipt', 'subject_id' => $id])->get();
        return view('activitylog.mlomoneyreceiptLog', compact('logs'));
    }

    public function egmmlomoneyreceiptslog($id)
    {
        $logs = Activity::with('causer')->where(['subject_type' => 'App\EgmMloMoneyReceipt', 'subject_id' => $id])->get();
        return view('activitylog.mlomoneyreceiptLog', compact('logs'));
    }

    public function mlodeliverorderslog($id)
    {
        $logs = Activity::with('causer')->where(['subject_type' => 'App\MLO\Deliveryorder', 'subject_id' => $id])->get();
        return view('activitylog.mloDeliveryOrderLog', compact('logs'));
    }
}
