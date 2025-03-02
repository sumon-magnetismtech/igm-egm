<?php

namespace App\Http\Controllers;

use App\Deliveryorder;
use App\EgmDeliveryorder;
use App\EgmFeederinformation;
use App\EgmHouseBl;
use App\EgmMasterBl;
use App\EgmMloblinformation;
use App\EgmMloDeliveryorder;
use App\EgmMloMoneyReceipt;
use App\EgmMoneyreceipt;
use App\Housebl;
use App\Masterbl;
use App\MLO\Feederinformation;
use App\MLO\Mloblinformation;
use App\Moneyreceipt;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function home()
    {
        //Business Type Selection = IGM / EGM
        return view('auth.login-select');        
    }

    public function igmDashboard()
    {
        $totalMasterbl = Masterbl::all()->count();
        $masterblCurrentMonth = Masterbl::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $totalHousebl = Housebl::all()->count();
        $houseblCurrentMonth = Housebl::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $totalMoneyReceipts = Moneyreceipt::all()->count();
        $moneyReceiptCurrentMonth = Moneyreceipt::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $totalDeliveryOrders = Deliveryorder::all()->count();
        $deliveryOrderCurrentMonth = Deliveryorder::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();


        $totalFeeder = Feederinformation::all()->count();
        $feederCurrentMonth = Feederinformation::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $totalBlInformation = Mloblinformation::all()->count();
        $blInformationCurrentMonth = Mloblinformation::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $totalMloMoneyReceipts = \App\MLO\MoneyReceipt::all()->count();
        $mloMoneyReceiptsCurrentMonth = \App\MLO\MoneyReceipt::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $totalMloDeliveryOrders = \App\MLO\Deliveryorder::all()->count();
        $MloDeliveryOrderCurrentMonth = \App\MLO\Deliveryorder::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        return view('welcome',
compact('totalMasterbl', 'masterblCurrentMonth','totalHousebl', 'houseblCurrentMonth','totalMoneyReceipts', 'moneyReceiptCurrentMonth','totalDeliveryOrders', 'deliveryOrderCurrentMonth',
'totalFeeder','feederCurrentMonth','totalBlInformation','blInformationCurrentMonth','totalMloMoneyReceipts','mloMoneyReceiptsCurrentMonth','totalMloDeliveryOrders','MloDeliveryOrderCurrentMonth'));
    }    
    public function egmDashboard()
    {
        $totalMasterbl = EgmMasterBl::all()->count();
        $masterblCurrentMonth = EgmMasterBl::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $totalHousebl = EgmHouseBl::all()->count();
        $houseblCurrentMonth = EgmHouseBl::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $totalMoneyReceipts = EgmMoneyreceipt::all()->count();
        $moneyReceiptCurrentMonth = EgmMoneyreceipt::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $totalDeliveryOrders = EgmDeliveryorder::all()->count();
        $deliveryOrderCurrentMonth = EgmDeliveryorder::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();


        $totalFeeder = EgmFeederinformation::all()->count();
        $feederCurrentMonth = EgmFeederinformation::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $totalBlInformation = EgmMloblinformation::all()->count();
        $blInformationCurrentMonth = EgmMloblinformation::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $totalMloMoneyReceipts = EgmMloMoneyReceipt::all()->count();
        $mloMoneyReceiptsCurrentMonth = EgmMloMoneyReceipt::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $totalMloDeliveryOrders = EgmMloDeliveryorder::all()->count();
        $MloDeliveryOrderCurrentMonth = EgmMloDeliveryorder::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        return view('egm',
compact('totalMasterbl', 'masterblCurrentMonth','totalHousebl', 'houseblCurrentMonth','totalMoneyReceipts', 'moneyReceiptCurrentMonth','totalDeliveryOrders', 'deliveryOrderCurrentMonth',
'totalFeeder','feederCurrentMonth','totalBlInformation','blInformationCurrentMonth','totalMloMoneyReceipts','mloMoneyReceiptsCurrentMonth','totalMloDeliveryOrders','MloDeliveryOrderCurrentMonth'));
    }    


}
