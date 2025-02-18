<?php

namespace App\Http\Controllers\Ctrack;

use App\Ctrack\EmptyContainer;
use App\ExportContainer;
use App\MLO\Blcontainer;
use App\MLO\Deliveryorder;
use App\MLO\Mloblinformation;
use App\MLO\MoneyReceipt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{

    public function searchDoReport(Request $request)
    {
        $dateType = $request->dateType;
        $fromDate = ($request->fromDate ? date('Y-m-d', strtotime($request->fromDate)) : '');
        $tillDate = ($request->tillDate ? date('Y-m-d', strtotime($request->tillDate)) : '');
        if($dateType === 'weekly'){
            $deliveryOrders = Deliveryorder::whereBetween('DO_date', [now()->subDays(7), now()])->get();
        }elseif($dateType === 'monthly'){
            $deliveryOrders = Deliveryorder::whereBetween('DO_date', [now()->subDays(30), now()])->get();
        }elseif($dateType === 'custom'){
            $deliveryOrders = Deliveryorder::whereBetween('DO_date', [$fromDate, $tillDate])->get();
        }
        else{
            $deliveryOrders = Deliveryorder::whereDate('DO_date', now())->get();
        }
        return view('ctrack.reports.doReport', compact('deliveryOrders', 'dateType', 'fromDate', 'tillDate'));
    }

    public function containerReport(Request $request)
    {
        $searchType = $request->searchType;
        $selectedMloName = $request->mloName;
        if( $searchType == 'mlo'){
            $containerList = Blcontainer::with('mloblinformation.mlofeederInformation')
            ->whereHas('mloblinformation', function($q) use ($request){
                $q->where('mloName', 'LIKE', '%'.$request->mloName.'%');
            })
            ->get();
        }
        elseif( $searchType == 'empty'){
            $containerList = Blcontainer::with('mloblinformation.mlofeederInformation')
            ->has('emptyContainers')
            ->whereHas('mloblinformation', function($q) use ($request){
                $q->where('mloName', 'LIKE', '%'.$request->mloName.'%');
            })
            ->get();
        }
        elseif( $searchType == 'laden'){
            $containerList = Blcontainer::with('mloblinformation.mlofeederInformation')
            ->doesntHave('emptyContainers')
            ->whereHas('mloblinformation', function($q) use ($request){
                $q->where('mloName', 'LIKE', '%'.$request->mloName.'%');
            })
            ->get();
        }

        else{
            $containerList = Blcontainer::with('mloblinformation.mlofeederInformation')->get();
        }

        $mloNames = Mloblinformation::pluck('mloname');
        return view('ctrack.reports.containerReport', compact('containerList', 'mloNames', 'searchType', 'selectedMloName'));
    }


    public function containerStatus(Request $request)
    {
        $container = $request->contRef;
        $containers = Blcontainer::distinct()->pluck('contref');

        $importInfo = Blcontainer::with('mloblinformation.mlofeederInformation', 'emptyContainers')->where('contRef', $request->contRef)->first();

        if(!empty($importInfo)) {
            $exportInfo = ExportContainer::with('export')->where('blcontainer_id', $importInfo->id)->first();

            $moneyReceipt = MoneyReceipt::where('bolRef', $importInfo->mloblinformation->bolreference)->first();
            $timeLimit = Carbon::parse($importInfo->mloblinformation->mlofeederInformation->berthingDate)->addDays($moneyReceipt->freeTime-1);
            $clientKept = EmptyContainer::where('blcontainer_id', $importInfo->id)->where('bolreference', $importInfo->mloblinformation->bolreference)->first();
//            dd($clientKept->date);
//            $demurrage = $clientKept ? Carbon::parse($clientKept->date)->diffInDays($timeLimit->toDate()) : '';
        }else{
            $exportInfo = [];
            $moneyReceipt = [];
            $demurrage = '';
        }
        return view('ctrack.reports.containerStatus', compact('container', 'containers', 'importInfo', 'exportInfo', 'moneyReceipt', 'demurrage', 'clientKept'));
    }

    public function containerSummary()
    {
        $blInformations = Mloblinformation::all(['id', 'mloname']);
//        dd($blinformations);
        return view('ctrack.reports.containerSummary', compact('blInformations'));
    }
}
