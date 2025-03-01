<?php

namespace App\Http\Controllers;

use App\EgmMoneyreceipt;
use App\Cnfagent;
use App\EgmHouseBl;
use App\EgmMoneyreceiptDetail;
use App\Housebl;
use App\Http\Requests\EgmMoneyreceiptRequest;
use App\Http\Requests\MoneyreceiptRequest;
use App\MLO\MoneyReceiptDetails;
use App\Moneyreceipt;
use App\MoneyreceiptDetail;
use App\MoneyReceiptHead;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class EgmMoneyreceiptController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:moneyreceipt-create|moneyreceipt-edit|moneyreceipt-view|moneyreceipt-delete', ['only' => ['index','show']]);
        $this->middleware('permission:moneyreceipt-create', ['only' => ['create','store']]);
        $this->middleware('permission:moneyreceipt-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:moneyreceipt-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $mrid = \request()->mrid;
        $housebl = \request()->housebl;
        $client =\request()->client;
        $principal =\request()->principal;
        $fromDate = \request()->fromDate ? date('Y-m-d', strtotime(str_replace('/', '-', \request()->fromDate))) : null;
        $tillDate = \request()->tillDate ? date('Y-m-d', strtotime(str_replace('/', '-', \request()->tillDate))) : null;

        $moneyReceipts = EgmMoneyreceipt::with('MoneyreceiptDetail', 'deliveryOrder:id,moneyrecept_id,issue_date', 'houseBl:id,containernumber,igm,bolreference', 'houseBl.masterbl:id,mv,fvessel,principal,noc')
            ->when($mrid, function($q)use($mrid){
                $q->where('id', $mrid);
            })
            ->when($client, function($q)use($client){
                $q->where('client_name', 'LIKE', "%$client%");
            })
            ->when($housebl, function($q)use($housebl){
                $q->whereHas('houseBl', function($q) use ($housebl){
                    $q->where('bolreference', 'LIKE', "%$housebl%");
                });
            })
            ->when($request->contref, function($q){
                $q->whereHas('houseBl.containers', function($q){
                    $q->where('contref', request()->contref);
                });
            })
            ->when($principal, function($q)use($principal){
                $q->whereHas('houseBl.masterbl',function($q) use ($principal){
                    $q->where('principal', 'LIKE', "%$principal%");
                });
            })
            ->when(($fromDate && $tillDate), function($q)use($fromDate, $tillDate){
                $q->whereBetween('issue_date', [$fromDate, $tillDate]);
            })
            ->latest()->paginate(100);
        return view('egm.moneyreceipts.index',compact('moneyReceipts', 'mrid', 'housebl','client','principal','fromDate','tillDate'));
    }

    public function create()
    {
        $formType = 'create';
        $particulars = MoneyReceiptHead::orderBy('name')->pluck('name', 'name');
        $clients = Cnfagent::pluck('cnfagent', 'id');
        $housebls = EgmHouseBl::where('moneyreceiptStatus', 0)->pluck('bolreference');
        return view('egm.moneyreceipts.create',compact('clients','formType', 'housebls', 'particulars'));
    }

    public function store(EgmMoneyreceiptRequest $request){
        //dd($request->all());
        try{
            $clientContact = Cnfagent::where('cnfagent', $request->client_name)->firstOrFail(['contact']);
            $mr_details_data = array_combine($request->particular, $request->amount);

            $moneyReceiptData=$request->only('hblno','client_name','accounts','quantity', 'pay_mode', 'pay_number','duration','free_time','remarks', 'chargeable_days', 'source_name');
            $freeTimeLeft = $request->freeTime - $request->duration;
            $moneyReceiptData['free_time_left']= $freeTimeLeft > 0 ? $freeTimeLeft : 0;
            $moneyReceiptData['issue_date']= $request->issue_date ? date('Y-m-d', strtotime(str_replace('/', '-', request('issue_date')))) : null;
            $moneyReceiptData['upto_date']= $request->upto_date ? date('Y-m-d', strtotime(str_replace('/', '-', request('upto_date')))) : null;
            $moneyReceiptData['from_date']= $request->from_date ? date('Y-m-d', strtotime(str_replace('/', '-', request('from_date')))) : null;
            $moneyReceiptData['dated']= $request->dated ? date('Y-m-d', strtotime(str_replace('/', '-', request('dated')))) : null;

            $moneyReceiptData['client_mobile'] = $clientContact ? $clientContact->contact : null;
            $moneyReceiptData['mr_details'] = $mr_details_data;
            $previousMoneyReceipt= EgmMoneyreceipt::where('hblno', $request->hblno)->latest()->first();
            if($previousMoneyReceipt){
                $moneyReceiptData['extension_no'] = $previousMoneyReceipt->extension_no + 1;
            }

            $moneyReceiptDetails = [];
            foreach($request->particular as $key => $v) {
                $moneyReceiptDetails[] = new EgmMoneyreceiptDetail(
                    array(
                        'particular' => $request->particular[$key],
                        'amount' => $request->amount[$key],
                    )
                );
            }
            $data= EgmMoneyreceipt::create($moneyReceiptData);
            $data->MoneyreceiptDetail()->saveMany($moneyReceiptDetails);

            $createdBy = Activity::with('causer')->where('subject_type', 'App\EgmMoneyreceipt')->where(['subject_id' => $data->id, 'description' => 'created'])->first();
            $data['createdBy'] = $createdBy ? $createdBy->causer->name : null;

            $f = new \NumberFormatter( locale_get_default(), \NumberFormatter::SPELLOUT );
            $total= $data->MoneyreceiptDetail->sum('amount');
            $inWord = $f->format($total);

            $contTypeCount =$data->houseBl->containers->groupBy('type')->map(function($container, $key){
                return $container->count();
            });
            return PDF::loadView('egm.moneyreceipts.mrPdf',compact('data', 'contTypeCount', 'inWord', 'total'))->stream('mrPDF.pdf');
        }
        catch (QueryException $exception){
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function show(Moneyreceipt $moneyreceipt)
    {

    }

    public function edit(EgmMoneyreceipt $egmmoneyreceipt)
    {
        $houseblData = EgmHouseBl::where('id', $egmmoneyreceipt->hblno)->firstOrFail();
        $bolreference = $houseblData->bolreference;
        $containers = $egmmoneyreceipt->houseBl->containers->groupBy('type')->map(function($item){
            return count($item);
        });
        $formType = 'edit';
        $clients = Cnfagent::pluck('cnfagent');
        $housebls = EgmHouseBl::where('moneyreceiptStatus', 0)->pluck('bolreference');
        $particulars = MoneyReceiptHead::orderBy('name')->pluck('name', 'name');
        return view('egm.moneyreceipts.create',compact('clients','egmmoneyreceipt','formType', 'bolreference', 'housebls', 'containers', 'particulars'));
    }

    public function update(EgmMoneyreceiptRequest $request, EgmMoneyreceipt $egmmoneyreceipt)
    {
        try{
            $clientContact = Cnfagent::where('cnfagent', $request->client_name)->firstOrFail(['contact']);
            $mr_details_data = array_combine($request->particular, $request->amount);

            $moneyReceiptData=$request->only('hblno','client_name','accounts','quantity', 'pay_mode', 'pay_number','duration','free_time','remarks', 'chargeable_days', 'source_name');
            $freeTimeLeft = $request->freeTime - $request->duration;
            $moneyReceiptData['free_time_left']= $freeTimeLeft > 0 ? $freeTimeLeft : 0;
            $moneyReceiptData['issue_date']= $request->issue_date ? date('Y-m-d', strtotime(str_replace('/', '-', request('issue_date')))) : null;
            $moneyReceiptData['upto_date']= $request->upto_date ? date('Y-m-d', strtotime(str_replace('/', '-', request('upto_date')))) : null;
            $moneyReceiptData['from_date']= $request->from_date ? date('Y-m-d', strtotime(str_replace('/', '-', request('from_date')))) : null;
            $moneyReceiptData['dated']= $request->dated ? date('Y-m-d', strtotime(str_replace('/', '-', request('dated')))) : null;            
            $moneyReceiptData['client_mobile'] = $clientContact ? $clientContact->contact : null;
            $moneyReceiptData['pay_number'] = $request->pay_mode == "cash" ? null : $request->pay_number;
            $moneyReceiptData['mr_details'] = $mr_details_data;

            $previousMoneyReceipt= EgmMoneyreceipt::where('hblno', $request->hblno)->latest()->first();
            if($previousMoneyReceipt){
                $moneyReceiptData['extension_no'] = $previousMoneyReceipt->extension_no + 1;
            }

            $moneyReceiptDetails = [];
            foreach($request->particular as $key => $v) {
                $moneyReceiptDetails[] = new EgmMoneyreceiptDetail(
                    array(
                        'particular' => $request->particular[$key],
                        'amount' => $request->amount[$key],
                    )
                );
            }
            DB::transaction(function()use($egmmoneyreceipt, $moneyReceiptData, $request, $moneyReceiptDetails){
                $egmmoneyreceipt->MoneyreceiptDetail()->delete();
                $egmmoneyreceipt->update($moneyReceiptData);
                $egmmoneyreceipt->MoneyreceiptDetail()->saveMany($moneyReceiptDetails);
            });

            return redirect()->route('egmmoneyreceipts.index')->with('message', 'Money Receipt Updated Successfully');
        }
        catch (QueryException $exception){
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }






    }

    public function destroy(EgmMoneyreceipt $egmmoneyreceipt)
    {
        $egmmoneyreceipt->delete();
        return redirect()->route('egmmoneyreceipts.index')->with('message', 'Money Receipt Deleted Successfully');
    }

    public function getHouseBlinfo($bolreference){
        $hblInfo = EgmHouseBl::with('masterbl')->where('bolreference', $bolreference)->firstOrFail();
        $moneyReceipt = EgmMoneyreceipt::where('hblno', $hblInfo->id)->latest()->first();

        if($moneyReceipt && $moneyReceipt->upto_date){
            $from_date = Carbon::parse($moneyReceipt->upto_date)->addDay()->format('d/m/Y');
        }else{
            $from_date= $hblInfo->masterbl->berthing ? date('d/m/Y', strtotime($hblInfo->masterbl->berthing)) : null;
        }
        $typeCount = $hblInfo->containers->groupBy('type')->map(function($item, $key){
            return $item->count();
        });

        $blinfoWithMrInfo = [
            'hbl_id' => $hblInfo->id,
            'mv' => $hblInfo->masterbl->mv,
            'vesselname' => $hblInfo->masterbl->fvessel,
            'voyage' => $hblInfo->masterbl->voyage,
            'rotation' => $hblInfo->masterbl->rotno,
            'principal' => $hblInfo->masterbl->principal,
            'noc' => $hblInfo->masterbl->noc ? true : false,
            'packageno' => $hblInfo->packageno,
            'containernumber' => $hblInfo->containernumber,
            'doNote' => $hblInfo->note,
            'typeCount' => $typeCount,

            'berthing_date' => $hblInfo->masterbl->berthing ? date('d/m/Y', strtotime($hblInfo->masterbl->berthing)) : null,
            'from_date' => $from_date,
            'free_time' => $moneyReceipt ? 0 : null,
            'extension' => $moneyReceipt ? $moneyReceipt->extension_no+1 : null,
            'description' => $hblInfo->description,
        ];
        return $blinfoWithMrInfo;
    }

    public function mrPdf($mrid){
        $createdBy = Activity::with('causer')->where('subject_type', 'App\EgmMoneyreceipt')->where(['subject_id' => $mrid, 'description' => 'created'])->first();
        $updatedBy = Activity::with('causer')->where('subject_type', 'App\EgmMoneyreceipt')->where(['subject_id' => $mrid, 'description' => 'updated'])->orderBy('updated_at', 'DESC')->first();

        $data = EgmMoneyreceipt::with('MoneyreceiptDetail', 'houseBl.containers', 'houseBl.masterbl')->where('id',$mrid)->firstOrFail();

        $f = new \NumberFormatter( locale_get_default(), \NumberFormatter::SPELLOUT );
        $total= $data->MoneyreceiptDetail->sum('amount');
        $inWord = $f->format($total);

        $data['createdBy'] = $createdBy->causer->name ?? "";
        $data['updatedBy'] = $updatedBy->causer->name ?? "";

        $contTypeCount =$data->houseBl->containers->groupBy('type')->map(function($container, $key){
            return $container->count();
        });
        return PDF::loadView('egm.moneyreceipts.mrPdf',compact('data','mrid', 'contTypeCount', 'inWord', 'total'))->stream('mrPDF.pdf');
    }

    public function mrreport(Request $request)
    {
        $principal = $request->principal;
        $dateType = $request->dateType;
        $fromDate = $request->fromDate ? Carbon::createFromFormat('d/m/Y', $request->fromDate)->startOfDay() : null;
        $tillDate = $request->tillDate ? Carbon::createFromFormat('d/m/Y', $request->tillDate)->endOfDay() : null;

        $reportType = $request->reportType;

        $moneyReceipts = EgmMoneyreceipt::with('MoneyreceiptDetail', 'houseBl:id,containernumber,igm,bolreference,packageno', 'houseBl.masterbl:id,mv,fvessel,principal')
            ->when($principal, function($q)use($principal){
                $q->whereHas('houseBl.masterbl',function($q) use ($principal){
                    if($principal=='others'){
                        $q->where('principal', '!=', "BRIDGEOCEAN");
                    }else{
                        $q->where('principal', 'LIKE', "%$principal%");
                    }
                });
            })
            ->when($dateType === 'weekly', function($q){
                $q->whereBetween('issue_date', [now()->subDays(7), now()]);
            })
            ->when($dateType === 'monthly', function($q){
                $q->whereBetween('issue_date', [now()->subDays(30), now()]);
            })
            ->when($dateType === 'custom', function($q) use ($fromDate, $tillDate){
                $q->whereBetween('issue_date', [$fromDate, $tillDate]);
            })
            ->when(!$dateType || $dateType === 'today', function($q) use ($fromDate, $tillDate){
                $q->whereDate('issue_date', now());
            })
            ->get();

        $groupByPrincipals = $moneyReceipts->groupBy('houseBl.masterbl.principal');

        if($reportType == "pdf"){
            return PDF::loadView('egm.moneyreceipts.mrReportPdf',compact('groupByPrincipals', 'dateType', 'fromDate', 'tillDate', 'principal'))->setPaper('A4', 'landscape')->stream('mrReport.pdf');
        }else{
            return view('egm.moneyreceipts.mrreport', compact('groupByPrincipals', 'dateType', 'fromDate', 'tillDate', 'principal'));
        }
//        dd($deliveryOrders);
    }

    public function emptyMoneyReceipts()
    {
        $moneyReceipts = Moneyreceipt::with('MoneyreceiptDetail', 'houseBl:id,containernumber,igm,bolreference', 'houseBl.masterbl:id,mv,fvessel,principal')
            ->whereDoesntHave('MoneyreceiptDetail')
            ->paginate(100);
//        dd($moneyReceipts->toArray());

        return view('moneyreceipts.index',compact('moneyReceipts'));
    }
}