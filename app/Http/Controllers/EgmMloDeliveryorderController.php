<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\EgmMloMoneyReceipt;
use App\EgmMloblinformation;
use App\EgmMloDeliveryorder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Exports\MloDoContainerReport;
use Illuminate\Database\QueryException;
use Spatie\Activitylog\Models\Activity;
use App\Http\Requests\EgmMloDeliveryOrderRequest;
use Maatwebsite\Excel\Facades\Excel;

class EgmMloDeliveryorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:mlo-deliveryorder-create|mlo-deliveryorder-edit|mlo-deliveryorder-view|mlo-deliveryorder-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:mlo-deliveryorder-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:mlo-deliveryorder-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:mlo-deliveryorder-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        //        dd($request->all());
        $deliveryOrders = EgmMloDeliveryorder::with('moneyReceipt.molblInformations.blcontainers')
            ->orderBy('id', 'desc')
            ->when(request()->id, function ($q) {
                $q->where('id', request()->id);
            })
            ->when(request()->be_no, function ($q) {
                $q->where('be_no', request()->be_no);
            })
            ->when(request()->mr_id, function ($q) {
                $q->whereHas('moneyReceipt', function ($q) {
                    $q->where('id', request()->mr_id);
                });
            })
            ->when(request()->bolreference, function ($q) {
                $q->whereHas('moneyReceipt', function ($q) {
                    $q->where('bolRef', request()->bolreference);
                });
            })
            ->when(request()->contref, function ($q) {
                $q->whereHas('moneyReceipt.molblInformations.blcontainers', function ($q) {
                    $q->where('contref', request()->contref);
                });
            })
            ->paginate(100);
            //            ->get()
            //            ->dd()
        ;


        return view('egm.mlo.deliveryorders.index', compact('deliveryOrders', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        $bolNos = EgmMloMoneyReceipt::distinct('bolRef')->pluck('bolRef');
        return view('egm.mlo.deliveryorders.create', compact('formType', 'bolNos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EgmMloDeliveryOrderRequest $request)
    {
        try {
            $doData = $request->only('mlo_money_receipt_id');
            $doData['BE_No'] = $request->BE_No ? strtoupper($request->BE_No) : null;
            $doData['DO_Date'] = Carbon::createFromFormat('d/m/Y', $request->DO_Date)->toDateString();
            $doData['BE_Date'] = Carbon::createFromFormat('d/m/Y', $request->BE_Date)->toDateString();
            $deliveryInfo = EgmMLODeliveryorder::create($doData);
            $createdAt = Activity::with('causer')->where('subject_type', 'App\Deliveryorder')->where(['subject_id' => $deliveryInfo->id, 'description' => 'created'])->first();
            $deliveryInfo['createdBy'] = $createdAt ? $createdAt->causer->name : null;
            return PDF::loadView('egm.mlo.deliveryorders.mloDoPdf', compact('deliveryInfo'))->stream('mlodoPDF' . $deliveryInfo->moneyReceipt->bolRef . '.pdf');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $formType = 'edit';
        $deliveryOrder = EgmMloDeliveryorder::with('moneyReceipt.molblInformations')->where('id', $id)->firstOrFail();
        $bolNos = EgmMloMoneyReceipt::distinct('bolRef')->pluck('bolRef');
        return view('egm.mlo.deliveryorders.create', compact('formType', 'bolNos', 'deliveryOrder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EgmMloDeliveryOrderRequest $request, $id)
    {
        try {
            $deliveryOrder = EgmMloDeliveryorder::with('moneyReceipt.molblInformations')->where('id', $id)->firstOrFail();
            $doData = $request->only('mlo_money_receipt_id');
            $doData['BE_No'] = $request->BE_No ? strtoupper($request->BE_No) : null;
            $doData['DO_Date'] = Carbon::createFromFormat('d/m/Y', $request->DO_Date)->toDateString();
            $doData['BE_Date'] = Carbon::createFromFormat('d/m/Y', $request->BE_Date)->toDateString();
            $deliveryOrder->update($doData);
            return redirect()->route('egmmlodeliveryorders.index')->with('message', 'DO Updated successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getMloBlInfoByBolref($bolRef)
    {
        $moneyReceiptInfo = EgmMloMoneyReceipt::with('molblInformations.mlofeederInformation', 'molblInformations.package', 'molblInformations.principal')
            ->whereHas('molblInformations', function ($q) use ($bolRef) {
                $q->where('bolreference', $bolRef);
            })->latest()->first();
        //        dd($moneyReceiptInfo->toArray());

        return json_encode([
            //            'bolRef' => $moneyReceiptInfo->bolRef . " (Ex-$moneyReceiptInfo->extensionNo)",
            'clientName' => $moneyReceiptInfo->client->cnfagent,
            'packageno' => $moneyReceiptInfo->molblInformations->packageno,
            'packagecode' => $moneyReceiptInfo->molblInformations->package->packagecode,
            'grosswt' => $moneyReceiptInfo->molblInformations->grosswt,
            'shippingmark' => $moneyReceiptInfo->molblInformations->shippingmark,
            'berthingDate' => $moneyReceiptInfo->molblInformations->mlofeederInformation->berthingDate ? date('d/m/Y', strtotime($moneyReceiptInfo->molblInformations->mlofeederInformation->berthingDate)) : null,
            'fromDate' => $moneyReceiptInfo->fromDate ? date('d/m/Y', strtotime($moneyReceiptInfo->fromDate)) : null,
            'uptoDate' => $moneyReceiptInfo->uptoDate ? date('d/m/Y', strtotime($moneyReceiptInfo->uptoDate)) : null,
            'description' => $moneyReceiptInfo->molblInformations->description,
            'mlo_money_receipt_id' => $moneyReceiptInfo->id
        ]);
    }


    public function mloDoPDF($id)
    {
        $deliveryInfo = EgmMloDeliveryorder::with(
            'moneyReceipt:id,bolRef,uptoDate,client_id',
            'moneyReceipt.client:id,cnfagent',
            'moneyReceipt.molblInformations:id,feederinformations_id,bolreference,shippingmark,packageno,package_id,description,grosswt',
            'moneyReceipt.molblInformations.package:id,description',
            'moneyReceipt.molblInformations.blcontainers:id,egm_mloblinformation_id,contref,type,status',
            'moneyReceipt.molblInformations.mlofeederInformation:id,feederVessel,voyageNumber,arrivalDate,rotationNo'
        )->where('id', $id)->first();
        // return $deliveryInfo;
        $createdAt = Activity::with('causer')->where('subject_type', 'App\EgmMloDeliveryorder')->where(['subject_id' => $deliveryInfo->id, 'description' => 'created'])->first();
        $updatedAt = Activity::with('causer')->where('subject_type', 'App\EgmMloDeliveryorder')->where(['subject_id' => $deliveryInfo->id, 'description' => 'updated'])->first();
        $deliveryInfo['createdBy'] = $createdAt ? $createdAt->causer->name : null;
        $deliveryInfo['updatedBy'] = $updatedAt ? $updatedAt->causer->name : null;
        return PDF::loadView('egm.mlo.deliveryorders.mloDoPdf', compact('deliveryInfo'))->stream('mlodoPDF' . $deliveryInfo->moneyReceipt->bolRef . '.pdf');
    }

    public function mloDoReport(Request $request)
    {
        $requestType = $request->requestType;
        $dateType = $request->dateType;
        $principal = $request->principal;
        $fromDate = $request->fromDate ? Carbon::createFromFormat('d/m/Y', $request->fromDate)->startOfDay() : null;
        $tillDate = $request->tillDate ? Carbon::createFromFormat('d/m/Y', $request->tillDate)->endOfDay() : null;

        //        dd($request->all());

        $deliveryOrders = EgmMloDeliveryorder::with(
            'moneyReceipt.molblInformations.mlofeederInformation',
            'moneyReceipt.molblInformations.blcontainers',
            'moneyReceipt.client',
            'moneyReceipt.molblInformations.package',
            'moneyReceipt.molblInformations.principal',
            'moneyReceipt.molblInformations.blNotify'
        )
            ->when($dateType === 'weekly', function ($q) {
                return $q->whereBetween('DO_Date', [now()->subDays(7), now()]);
            })
            ->when($dateType === 'monthly', function ($q) {
                return $q->whereBetween('DO_Date', [now()->subDays(30), now()]);
            })
            ->when($dateType === 'custom', function ($q) use ($fromDate, $tillDate) {
                return $q->whereBetween('DO_Date', [$fromDate, $tillDate]);
            })
            ->when(!$dateType || $dateType === 'today', function ($q) use ($fromDate, $tillDate) {
                $q->whereDate('DO_Date', now());
            })
            ->whereHas('moneyReceipt.molblInformations.principal', function ($q) use ($principal) {
                $q->where('name', "LIKE", "%$principal%");
            })
            ->when(request()->contref, function ($q) {
                $q->whereHas('moneyReceipt.molblInformations.blcontainers', function ($q) {
                    $q->where('contref', request()->contref);
                });
            })
            ->get();

        if ($requestType == 'pdf') {
            return \Barryvdh\DomPDF\Facade::loadView('egm.mlo.deliveryorders.doreportPDF', compact('deliveryOrders'))->setPaper('A4', 'landscape')->stream("DO_Report_$dateType" . time() . ".pdf");
        } else {
            return view('egm.mlo.deliveryorders.doreport', compact('deliveryOrders', 'dateType', 'fromDate', 'tillDate', 'principal'));
        }
    }

    public function egmMloDoContainerReport(Request $request)
    {
        $requestType = $request->requestType;
        $dateType = $request->dateType;
        $principal = $request->principal;
        $fromDate = ($request->fromDate ? date('Y-m-d', strtotime($request->fromDate)) : '');
        $tillDate = ($request->tillDate ? date('Y-m-d', strtotime($request->tillDate)) : '');

        $deliveryOrders = EgmMloDeliveryorder::with('moneyReceipt.molblInformations.mlofeederInformation', 'moneyReceipt.molblInformations.principal')
            ->when($dateType === 'weekly', function ($q) {
                return $q->whereBetween('DO_Date', [now()->subDays(7), now()]);
            })
            ->when($dateType === 'monthly', function ($q) {
                return $q->whereBetween('DO_Date', [now()->subDays(30), now()]);
            })
            ->when($dateType === 'custom', function ($q) use ($fromDate, $tillDate) {
                return $q->whereBetween('DO_Date', [$fromDate, $tillDate]);
            })
            ->when($dateType === 'today' || empty($dateType), function ($q) {
                return $q->whereDate('DO_Date', now());
            })
            ->whereHas('moneyReceipt.molblInformations.principal', function ($q) use ($principal) {
                $q->where('name', "LIKE", "%$principal%");
            })
            ->get();
        $mloblInformations = EgmMloblinformation::with('blcontainers', 'mlofeederInformation', 'mloMoneyReceipt.deliveryOrder', 'principal')->whereHas('mloMoneyReceipt', function ($q) use ($deliveryOrders) {
            $q->whereIn('id', $deliveryOrders->pluck('mlo_money_receipt_id'));
        })->get();


        //         dd($mloblInformations->toArray());
        if ($requestType == 'pdf') {
            return \Barryvdh\DomPDF\Facade::loadView('mlo.deliveryorders.containerreportPDF', compact('dateType', 'fromDate', 'tillDate', 'principal', 'mloblInformations'))->stream("MLO_Container_Report_$dateType" . time() . ".pdf");
        } elseif ($requestType == 'excel') {
            return Excel::download(new MloDoContainerReport($mloblInformations, $dateType, $fromDate, $tillDate), "containerreportPDF_" . now()->format('Y-m-d H:i:s') . ".xls");
        } else {
            return view('egm.mlo.deliveryorders.containerreport', compact('dateType', 'fromDate', 'tillDate', 'principal', 'mloblInformations'));
        }
    }
}
