<?php

namespace App\Http\Controllers;

use App\EgmDeliveryorder;
use App\Container;
use App\Deliveryorder;
use App\EgmHouseBl;
use App\EgmHouseBlContainers;
use App\EgmMoneyreceipt;
use App\Exports\DeliveryReportExport;
use App\Housebl;
use App\Http\Requests\DeliveryOrderRequest;
use App\Http\Requests\EgmDeliveryorderRequest;
use App\Moneyreceipt;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;

class EgmDeliveryorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:deliveryorder-create|deliveryorder-edit|deliveryorder-view|deliveryorder-delete', ['only' => ['index','show']]);
        $this->middleware('permission:deliveryorder-create', ['only' => ['create','store']]);
        $this->middleware('permission:deliveryorder-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:deliveryorder-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $Donos = EgmDeliveryorder::with('moneyReceipt.houseBl.containers')
            ->when($request->do_id, function($q){
                $q->where('id', request()->do_id);
            })
            ->when(request()->mr_id, function($q){
                $q->where('moneyrecept_id', request()->mr_id);
            })
            ->when(request()->BE_No, function($q){
                $q->where('BE_No', request()->BE_No);
            })
            ->when($request->bolreference, function($q){
                $q->whereHas('moneyReceipt.houseBl', function($q){
                    $q->where('bolreference', request()->bolreference);
                });
            })
            ->when($request->contref, function($q){
                $q->whereHas('moneyReceipt.houseBl.containers', function($q){
                    $q->where('contref', request()->contref);
                });
            })
            ->latest()
            ->paginate(100);
        return view('egm.deliveryorders.index',compact('Donos', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        $moneyReceipts = EgmMoneyreceipt::with('houseBl:id,bolreference')
            ->doesntHave('deliveryOrder')
            ->whereHas('houseBl.masterbl', function($q){$q->where('noc', false);})
            ->get(['id','hblno']);
        return view('egm.deliveryorders.create',compact('formType', 'moneyReceipts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EgmDeliveryorderRequest $request)
    {
        try{
            $checkNOC = EgmHouseBl::whereHas('masterbl', function($q){$q->where('noc', false);})->where('bolreference', $request->hblno)->first();
            if($checkNOC){
                $DoData=[];
                $DoData['moneyrecept_id'] = $request->moneyrecept_id;
                $DoData['BE_No'] = $request->BE_No;
                $DoData['bl_type'] = $request->bl_type;
                $DoData['BE_Date'] = $request->BE_Date ? date('Y-m-d', strtotime(str_replace('/', '-', $request->BE_Date))) : null;
                $DoData['issue_date'] = $request->issue_date ? date('Y-m-d', strtotime(str_replace('/', '-',$request->issue_date))) : null;
                $DoData['upto_date'] = $request->upto_date ? date('Y-m-d', strtotime(str_replace('/', '-',$request->upto_date))) : null;

                $do = EgmDeliveryorder::create($DoData);
                $doID = $do->id;
                $moneyReceipt = EgmMoneyreceipt::with(
                    'houseBl:id,igm,packagetype,shippingmark,bolreference,packageno,description,grosswt',
                    'houseBl.masterbl:id,fvessel,mblno,rotno,arrival,voyage',
                    'deliveryOrder:id,moneyrecept_id,BE_No,BE_Date,issue_date,upto_date')
                    ->whereHas('deliveryOrder', function($q) use ($doID){
                        $q->where('id', $doID);
                    })->firstOrFail(['id', 'client_name', 'hblno']);
                $containers = EgmHouseBlContainers::where('housebl_id',$moneyReceipt->houseBl->id)->get();
                return PDF::loadView('egm.deliveryorders.doPdf',compact('moneyReceipt','containers'))->stream('doPDF.pdf');
            }else{
                return redirect()->back()->withInput()->withErrors("NOC BL. Can't create Delivery Order.");
            }
        }
        catch (QueryException $exception){
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Deliveryorder  $deliveryorder
     * @return \Illuminate\Http\Response
     */
    public function show(Deliveryorder $deliveryorder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Deliveryorder  $deliveryorder
     * @return \Illuminate\Http\Response
     */
    public function edit(EgmDeliveryorder $egmdeliveryorder)
    {
//        dd($deliveryorder->moneyReceipt->houseBl->toArray());
        $formType = 'edit';
        $moneyReceipts = EgmMoneyreceipt::with('houseBl:id,bolreference')->doesntHave('deliveryOrder')->whereHas('houseBl.masterbl', function($q){$q->where('noc', false);})->get(['id','hblno']);
        return view('egm.deliveryorders.create',compact('formType', 'moneyReceipts', 'egmdeliveryorder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deliveryorder  $deliveryorder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EgmDeliveryorder $egmdeliveryorder)
    {
        try{
            $DoData=[];
            $DoData['moneyrecept_id'] = $request->moneyrecept_id;
            $DoData['BE_No'] = $request->BE_No;
            $DoData['bl_type'] = $request->bl_type;
            $DoData['BE_Date'] = $request->BE_Date ? date('Y-m-d', strtotime(str_replace('/', '-', $request->BE_Date))) : null;
            $DoData['issue_date'] = $request->issue_date ? date('Y-m-d', strtotime(str_replace('/', '-',$request->issue_date))) : null;
            $DoData['upto_date'] = $request->upto_date ? date('Y-m-d', strtotime(str_replace('/', '-',$request->upto_date))) : null;

            $egmdeliveryorder->update($DoData);
            return redirect()->route('egmdeliveryorders.index')->with('message', "DO has been updated successfully.");
        }
        catch (QueryException $exception){
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deliveryorder  $deliveryorder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deliveryorder $deliveryorder)
    {
        //
    }

    public function getHouseBlbyId($hblno){
        $hblInfo = EgmMoneyreceipt::with('houseBl:id,igm,packageno,containernumber,grosswt,consigneebin,consigneename,consigneeaddress,notifybin,notifyname,notifyaddress', 'houseBl.masterbl:id,fvessel,mblno,rotno,arrival')
            ->whereHas('houseBl', function($q) use ($hblno){
                $q->where('bolreference', $hblno);
            })->firstOrFail();
        $specialContainer = EgmHouseBl::where('bolreference',$hblno)
            ->whereHas('containers', function($q){
                $q->where('status', 'PRT')->orWhere('status', "FCL");
            })->first(['id']);

        $arrivalDate = date('d-m-Y', strtotime($hblInfo->houseBl->masterbl->arrival));

        return json_encode([
            'client_name' => $hblInfo->client_name,
            'mblno' => $hblInfo->houseBl->masterbl->mblno,
            'moneyreceipt_id' => $hblInfo->id,
            'fvsl' => $hblInfo->houseBl->masterbl->fvessel,
            'arrival_date' => $arrivalDate,
            'rotation' => $hblInfo->houseBl->masterbl->rotno,
            'consignee' => $hblInfo->houseBl->consigneename.', '.$hblInfo->houseBl->consigneeaddress.' (BIN-'.$hblInfo->houseBl->consigneebin.')',
            'notify' => $hblInfo->houseBl->notifyname.', '.$hblInfo->houseBl->notifyaddress.' (BIN-'.$hblInfo->houseBl->notifybin.')',
            'containernumber' => $hblInfo->houseBl->containernumber,

            'hbl_id' => $hblInfo->houseBl->id,
            'packageno' => $hblInfo->houseBl->packageno,
            'grosswt' => $hblInfo->houseBl->grosswt,
            'specialContainer' => $specialContainer ? True : False,
        ]);
    }

    public function doPdf($doid){
        $moneyReceipt = EgmMoneyreceipt::with(
            'houseBl:id,igm,packagetype,shippingmark,bolreference,packageno,description,grosswt',
            'houseBl.masterbl:id,fvessel,mblno,rotno,arrival,voyage',
            'deliveryOrder:id,moneyrecept_id,BE_No,BE_Date,issue_date,upto_date')
            ->whereHas('deliveryOrder', function($q) use ($doid){
                $q->where('id', $doid);
            })->firstOrFail(['id', 'client_name', 'hblno']);
        $containers = EgmHouseBlContainers::where('housebl_id',$moneyReceipt->houseBl->id)->get();

//        return view('deliveryorders.doPdf',compact('hblInfo','containers'));

        return PDF::loadView('deliveryorders.doPdf',compact('moneyReceipt','containers'))->stream('doPDF.pdf');
    }

    public function doreport(Request $request)
    {
        $requestType = $request->requestType;
        $dateType = $request->dateType;
        $principal = $request->principal;
        $fromDate = $request->fromDate ? Carbon::createFromFormat('d/m/Y', $request->fromDate)->startOfDay() : null;
        $tillDate = $request->tillDate ? Carbon::createFromFormat('d/m/Y', $request->tillDate)->endOfDay() : null;

        if($dateType === 'weekly'){
            $deliveryOrders = EgmDeliveryorder::with('moneyReceipt.houseBl.masterbl')->whereBetween('issue_date', [now()->subDays(7), now()])->whereHas('moneyReceipt.houseBl.masterbl', function($q) use ($principal){$q->where('principal', "LIKE", "%$principal%");})->get();
            $noc = EgmMoneyreceipt::with(['houseBl.masterbl'])
                ->whereBetween('issue_date', [now()->subDays(7), now()])
                ->whereHas('houseBl.masterbl', function($q) use($principal){
                    $q->where('noc', true)
                    ->where('principal', "LIKE", "%$principal%");
                })
                ->get();
        }elseif($dateType === 'monthly'){
            $deliveryOrders = EgmDeliveryorder::with('moneyReceipt.houseBl.masterbl')->whereBetween('issue_date', [now()->subDays(30), now()])->whereHas('moneyReceipt.houseBl.masterbl', function($q) use ($principal){$q->where('principal', "LIKE", "%$principal%");})->get();

            $noc = EgmMoneyreceipt::with(['houseBl.masterbl'])
                ->whereBetween('issue_date', [now()->subDays(30), now()])

                ->whereHas('houseBl.masterbl', function($q) use($principal){
                    $q->where('noc', true)
                    ->where('principal', "LIKE", "%$principal%");
                })

                ->get();

        }elseif($dateType === 'custom'){
            $deliveryOrders = EgmDeliveryorder::with('moneyReceipt.houseBl.masterbl')->whereBetween('issue_date', [$fromDate, $tillDate])->whereHas('moneyReceipt.houseBl.masterbl', function($q) use ($principal){$q->where('principal', "LIKE", "%$principal%");})->get();
            $noc = EgmMoneyreceipt::with(['houseBl.masterbl'])->whereBetween('issue_date', [$fromDate, $tillDate])
                ->whereHas('houseBl.masterbl', function($q) use($principal){
                    $q->where('noc', true)
                    ->where('principal', "LIKE", "%$principal%");
                })
                ->get();
        }

        else{
            $deliveryOrders = EgmDeliveryorder::with('moneyReceipt.houseBl.masterbl')->whereDate('issue_date', now())->whereHas('moneyReceipt.houseBl.masterbl', function($q) use ($principal){$q->where('principal', "LIKE", "%$principal%");})->get();
            $noc = EgmMoneyreceipt::with(['houseBl.masterbl'])->whereDate('issue_date', now())
                ->whereHas('houseBl.masterbl', function($q) use($principal){
                    $q->where('noc', true)
                        ->where('principal', "LIKE", "%$principal%");
                })
                ->get();
        }

        if($requestType == 'pdf'){
            return \Barryvdh\DomPDF\Facade::loadView('egm.deliveryorders.doreportPDF', compact('deliveryOrders', 'noc'))->setPaper('A4', 'landscape')->stream("DO_Report_$dateType".time().".pdf");
        }else{
            return view('egm.deliveryorders.doreport', compact('deliveryOrders', 'dateType', 'fromDate', 'tillDate', 'noc', 'principal'));
        }
    }

}
