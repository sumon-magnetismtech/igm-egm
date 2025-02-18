<?php

namespace App\Http\Controllers\MLO;

use App\Cnfagent;
use App\Http\Requests\MLO\MoneyReceiptRequest;
use App\MLO\Blcontainer;
use App\MLO\Feederinformation;
use App\MLO\Mloblinformation;
use App\MLO\MoneyReceipt;
use App\MLO\MoneyReceiptContainer;
use App\MLO\MoneyReceiptDetails;
use App\MoneyReceiptHead;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Spatie\Activitylog\Models\Activity;

class MoneyReceiptController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:mlo-moneyreceipt-create|mlo-moneyreceipt-edit|mlo-moneyreceipt-view|mlo-moneyreceipt-delete', ['only' => ['index','show']]);
        $this->middleware('permission:mlo-moneyreceipt-create', ['only' => ['create','store']]);
        $this->middleware('permission:mlo-moneyreceipt-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:mlo-moneyreceipt-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $moneyReceipts = MoneyReceipt::with('mloMoneyReceiptDetails', 'deliveryOrder:id,mlo_money_receipt_id,DO_Date', 'molblInformations.mlofeederInformation')
            ->orderBy('id', 'desc')
            ->when(request()->id, function($q){
                $q->where('id', request()->id);
            })
            ->when(request()->bolreference, function($q){
                $q->where('bolRef', request()->bolreference);
            })
            ->when(request()->contref, function($q){
                $q->whereHas('molblInformations.blcontainers', function($q){
                   $q->where('contref', request()->contref);
                });
            })
            ->paginate(100);
        return view('mlo.moneyreceipts.index',compact('moneyReceipts', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        $particulars = MoneyReceiptHead::orderBy('name')->pluck('name');
        return view('mlo.moneyreceipts.create',compact('particulars', 'formType'));
    }


    public function store(MoneyReceiptRequest $request){
        try{
//            dd($request->all());
            $moneyReceiptDetails = array_combine($request->particular, $request->amount);
            $moneyReceiptData = $request->only('client_id','payMode','bolRef','doNote','duration','freeTime','remarks', 'chargeableDays', 'moneyReceiptDetails', 'rotationNo', 'payNumber', 'source_name');

            $freeTimeLeft = $request->freeTime - $request->duration;
            $moneyReceiptData['freeTimeLeft']= $freeTimeLeft > 0 ? $freeTimeLeft : 0;
            $moneyReceiptData['issueDate']= $request->issueDate !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('issueDate')))) : null;
            $moneyReceiptData['uptoDate']= $request->uptoDate !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('uptoDate')))) : null;
            $moneyReceiptData['fromDate']= $request->fromDate !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('fromDate')))) : null;
            $moneyReceiptData['dated']= $request->dated !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('dated')))) : null;            

            $previousMoneyReceipt= MoneyReceipt::where('bolRef', $request->bolRef)->latest()->first();
            if($previousMoneyReceipt){
                $moneyReceiptData['extensionNo'] = $previousMoneyReceipt->extensionNo + 1;
            }
            $moneyReceiptData['moneyReceiptDetails'] = $moneyReceiptDetails;

            $moneyReceiptDetails = [];
            foreach($request->particular as $key => $v) {
                $moneyReceiptDetails[] = new MoneyReceiptDetails(
                    array(
                        'particular' => $request->particular[$key],
                        'amount' => $request->amount[$key],
                    )
                );
            }
            $moneyReceipt = DB::transaction(function() use ($moneyReceiptData, $moneyReceiptDetails, $request){
                $moneyReceipt = MoneyReceipt::create($moneyReceiptData);
                $moneyReceipt->mloMoneyReceiptDetails()->saveMany($moneyReceiptDetails);
                return $moneyReceipt;
            });

            $contTypeCount =$moneyReceipt->molblInformations->blcontainers->groupBy('type')->map(function($container, $key){
                return $container->count();
            });

            $createdAt = Activity::with('causer')->where('subject_type', 'App\MLO\MoneyReceipt')->where(['subject_id' => $moneyReceipt->id, 'description' => 'created'])->first();
            $moneyReceipt['createdBy'] = $createdAt ? $createdAt->causer->name : null;

            return PDF::loadView('mlo/moneyreceipts.mloMoneyReceiptPdf',compact('moneyReceipt','contTypeCount'))->stream('mloMoneyReceiptPdf.pdf');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MoneyReceipt $mlomoneyreceipt)
    {
//        return view('mlo.moneyreceipts.show', compact('mlomoneyreceipt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MoneyReceipt $mlomoneyreceipt)
    {
        $formType = 'edit';
        $mlomoneyreceipt = MoneyReceipt::with('mloMoneyReceiptDetails','molblInformations.mlofeederInformation', 'molblInformations.blcontainers')->where('id', $mlomoneyreceipt->id)->first();

        $containers = $mlomoneyreceipt->molblInformations->blcontainers->groupBy('type')->map(function($item){
            return count($item);
        });

        $clients = Cnfagent::pluck('cnfagent');
        $particulars = MoneyReceiptHead::orderBy('name')->pluck('name');
        return view('mlo.moneyreceipts.create',compact('clients', 'mlomoneyreceipt', 'particulars', 'formType', 'containers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MoneyReceiptRequest $request, MoneyReceipt $mlomoneyreceipt)
    {
        try{
            $moneyReceiptDetails = array_combine($request->particular, $request->amount);
            $moneyReceiptData = $request->only('client_id','payMode','bolRef','doNote','duration','freeTime','remarks', 'chargeableDays', 'moneyReceiptDetails', 'rotationNo', 'payNumber', 'source_name');
            $freeTimeLeft = $request->freeTime - $request->duration;
            $moneyReceiptData['freeTimeLeft']= $freeTimeLeft > 0 ? $freeTimeLeft : 0;
            if($request->bolRef != $mlomoneyreceipt->bolRef){
                $existingMoneyReceipt = MoneyReceipt::where('bolRef', $request->bolRef)->latest()->first();
                $moneyReceiptData['extensionNo']= $existingMoneyReceipt ? $existingMoneyReceipt->extensionNo+1 : null;
            }
            $moneyReceiptData['issueDate']= $request->issueDate !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('issueDate')))) : null;
            $moneyReceiptData['uptoDate']= $request->uptoDate !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('uptoDate')))) : null;
            $moneyReceiptData['fromDate']= $request->fromDate !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('fromDate')))) : null;
            $moneyReceiptData['dated']= $request->dated !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('dated')))) : null;

            $moneyReceiptData['moneyReceiptDetails'] = $moneyReceiptDetails;

            $moneyReceiptDetails = [];
            foreach($request->particular as $key => $v) {
                $moneyReceiptDetails[] = new MoneyReceiptDetails(
                    array(
                        'particular' => $request->particular[$key],
                        'amount' => $request->amount[$key],
                    )
                );
            }

            DB::transaction(function()use($mlomoneyreceipt, $request, $moneyReceiptData, $moneyReceiptDetails){
                $mlomoneyreceipt->update($moneyReceiptData);
                MoneyReceiptDetails::whereIn('moneyReceipt_id',$mlomoneyreceipt)->delete();
                $mlomoneyreceipt->mloMoneyReceiptDetails()->saveMany($moneyReceiptDetails);
            });
            return redirect()->route('mlomoneyreceipts.index')->with('message','Money Receipt updated successfully.');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MoneyReceipt $mlomoneyreceipt)
    {
//        if($mlomoneyreceipt->deliveryOrder){
//            return redirect()->back()->withErrors(["Cannot delete, Money Receipt ID: $mlomoneyreceipt->id has Delivery Order Record."]);
//        }

        try{
            $mlomoneyreceipt->delete();
            return redirect()->route('mlomoneyreceipts.index')->with('message','Money Receipt created successfully.');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function mloMoneyReceiptPdf($mrid){
        $moneyReceipt = MoneyReceipt::with('mloMoneyReceiptDetails', 'molblInformations.blcontainers', 'molblInformations.mlofeederInformation')->where('id',$mrid)->firstOrFail();
        $contTypeCount =$moneyReceipt->molblInformations->blcontainers->groupBy('type')->map(function($container, $key){
            return $container->count();
        });

        $createdAt = Activity::with('causer')->where('subject_type', 'App\MLO\MoneyReceipt')->where(['subject_id' => $moneyReceipt->id, 'description' => 'created'])->first();
        $updatedAt = Activity::with('causer')->where('subject_type', 'App\MLO\MoneyReceipt')->where(['subject_id' => $moneyReceipt->id, 'description' => 'updated'])->first();

        $moneyReceipt['createdBy'] = $createdAt ? $createdAt->causer->name : null;
        $moneyReceipt['updatedBy'] = $updatedAt ? $updatedAt->causer->name : null;

        return PDF::loadView('mlo/moneyreceipts.mloMoneyReceiptPdf',compact('moneyReceipt','contTypeCount'))
            ->stream('mloMoneyReceiptPdf.pdf');
    }

    public function getBLInfo($blRef){
        $blInfo = Mloblinformation::with('mlofeederInformation')->where('bolreference', $blRef)->first();
        $blInfoFromMoneyReceipt = MoneyReceipt::where('bolRef',$blRef)->latest()->first();

        if($blInfoFromMoneyReceipt){
            $fromDate = $blInfoFromMoneyReceipt ? Carbon::parse($blInfoFromMoneyReceipt->uptoDate)->addDay()->format('d/m/Y') : null;
        }else{
            $fromDate= $blInfo->mlofeederInformation->berthingDate ? date('d/m/Y', strtotime($blInfo->mlofeederInformation->berthingDate)) : null;
        }

        $blContainers = Blcontainer::where('mloblinformation_id', $blInfo->id)->get(['type', 'contref']);

        $typeCount = $blContainers->groupBy('type')->map(function($item, $key){
            return $item->count();
        });

//        dd($blInfo->toArray());
        return json_encode([
            'feederVessel' => $blInfo->mlofeederInformation->feederVessel,
            'voyageNumber' => $blInfo->mlofeederInformation->voyageNumber,
            'rotationNo' => $blInfo->mlofeederInformation->rotationNo,
            'principal' => $blInfo->principal->name,
            'fromDate' => $fromDate,
            'containernumber' => $blInfo->containernumber,
            'description' => $blInfo->description,
            'note' => $blInfo->note,
            'total' =>  $blInfo->containernumber,
            'containersInfo' => $blContainers,
            'typeCount' => $typeCount,
            'freeTime' => $blInfoFromMoneyReceipt ? 0 : null,
            'extension' => $blInfoFromMoneyReceipt ? $blInfoFromMoneyReceipt->extensionNo+1 : null,
            'client_id' => $blInfoFromMoneyReceipt ? $blInfoFromMoneyReceipt->client_id : null,
            'clientName' => $blInfoFromMoneyReceipt ? $blInfoFromMoneyReceipt->client->cnfagent : null,
        ]);
    }

    public function mlomrreport(Request $request)
    {
        $principal  = $request->principal;
        $dateType   = $request->dateType;
        $fromDate   = $request->fromDate !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('fromDate')))) : null;
        $tillDate   = $request->tillDate !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('tillDate')))) : null;
        $reportType = $request->reportType;

        // dd($fromDate, $tillDate, $request->all()); 

        $moneyReceipts = Moneyreceipt::with('mloMoneyReceiptDetails','client','molblInformations.mlofeederInformation', 'molblInformations.principal')
            ->when($principal, function($q)use($principal){
                $q->whereHas('molblInformations.principal', function($q) use ($principal){
                    $q->where('name', 'LIKE', "%$principal%");
                });
            })
            ->when(!$dateType || $dateType === 'today', function($q) {
                $q->whereDate('issueDate', now());
            })
            ->when($dateType === 'weekly', function($q){
                $q->whereBetween('issueDate', [now()->subDays(7), now()]);
            })
            ->when($dateType === 'monthly', function($q){
                $q->whereBetween('issueDate', [now()->subDays(30), now()]);
            })
            ->when($dateType === 'custom', function($q) use ($fromDate, $tillDate){
                $q->whereBetween('issueDate', [$fromDate, $tillDate]);
            })
            ->get();

        // dd($moneyReceipts); 

        $groupByPrincipals = $moneyReceipts->groupBy('molblInformations.principal.name');

        if($reportType == "pdf"){
            return PDF::loadView('mlo.moneyreceipts.mloMrReportPdf',compact('groupByPrincipals', 'dateType', 'fromDate', 'tillDate', 'principal'))->setPaper('A4', 'landscape')->stream("mlo-money-receipt".now()->format('d-m-Y').".pdf");
        }else{
            return view('mlo.moneyreceipts.mloMrReport', compact('groupByPrincipals', 'dateType', 'fromDate', 'tillDate', 'principal'));
        }

    }


    public function feederListForCustomUpdate()
    {
        $feederVessel = \request()->feederVessel;
        $voyage = \request()->voyageNumber;
        $rotationNo = \request()->rotationNo;

        $feederInformations = Feederinformation::
        where('feederVessel', 'LIKE', "%$feederVessel%")
            ->whereNull('berthingDate')
            ->when($voyage, function($q) use ($voyage){
                $q->where('voyageNumber', 'LIKE', "%$voyage%");
            })
            ->when($rotationNo, function($q) use ($rotationNo) {
                $q->where('rotationNo', 'LIKE', "%$rotationNo%");
            })
            ->orderBy('id','desc')->paginate();

        return view('mlo.feederinformations.feederCustomUpdate', compact('feederInformations', 'voyage'));
    }

    public function feederCustomUpdate(Request $request)
    {
        $id = $request->id;
        $berthingDate = $request->berthingDate !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('berthingDate')))) : null;
        $rotationNo = $request->rotationNo;

        Feederinformation::where('id', $id)->update([
            'berthingDate' => $berthingDate,
            'rotationNo' => $rotationNo
        ]);
    }
}
