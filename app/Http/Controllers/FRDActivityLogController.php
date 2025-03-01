<?php

namespace App\Http\Controllers;

use App\Housebl;
use App\Moneyreceipt;
use App\MoneyreceiptDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class FRDActivityLogController extends Controller
{

    public function userlog($id)
    {
//        $useractivities = User::where('id', $id)->first()->actions;
        $useractivities = Activity::where('causer_id', $id)->latest()->get();
//        dd($useractivities[0]);
        return view('activitylog.userlog', compact('useractivities'));
    }

    public function masterlog($id)
    {
        $masterbls = Activity::with('causer')->where(['subject_type' => 'App\Masterbl', 'subject_id' => $id])->get();
        return view('activitylog.masterblLog', compact('masterbls'));
    }
    public function housebllog($id)
    {
        $housebls = Activity::with('causer')->where(['subject_type' => 'App\Housebl', 'subject_id' => $id])->get();
        return view('activitylog.houseblLog', compact('housebls'));
    }
    public function egmhousebllog($id)
    {
        $housebls = Activity::with('causer')->where(['subject_type' => 'App\EgmHouseBl', 'subject_id' => $id])->get();
        return view('activitylog.egmhouseblLog', compact('housebls'));
    }

    public function moneyreceiptlog($id)
    {
        $moneyreceipts = Activity::with('causer')->where(['subject_type' => 'App\Moneyreceipt', 'subject_id' => $id])->get();
//        dd($moneyreceipts->toArray());
        return view('activitylog.moneyreceiptLog', compact('moneyreceipts'));
    }
    public function egmmoneyreceiptlog($id)
    {
        $moneyreceipts = Activity::with('causer')->where(['subject_type' => 'App\EgmMoneyreceipt', 'subject_id' => $id])->get();
//        dd($moneyreceipts->toArray());
        return view('activitylog.egmmoneyreceiptLog', compact('moneyreceipts'));
    }

    public function deliveryorderlog($id)
    {
        $deliveryorders = Activity::with('causer')->where(['subject_type' => 'App\Deliveryorder', 'subject_id' => $id])->get();
        return view('activitylog.deliveryorderLog', compact('deliveryorders'));
    }



}
