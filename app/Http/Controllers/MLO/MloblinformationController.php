<?php

namespace App\Http\Controllers\MLO;

use App\Containerlocation;
use App\ExporterInfo;
use App\Housebl;
use App\Http\Controllers\Controller;
use App\Http\Requests\MLO\BlinformationRequest;
use App\Imports\BlcontainerImport;
use App\MLO\Blcontainer;
use App\MLO\Feederinformation;
use App\MLO\Mloblinformation;
use App\Principal;
use App\Vatreg;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class



MloblinformationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:mlo-mloblinformation-create|mlo-mloblinformation-edit|mlo-mloblinformation-view|mlo-mloblinformation-delete', ['only' => ['index','show']]);
        $this->middleware('permission:mlo-mloblinformation-create', ['only' => ['create','store']]);
        $this->middleware('permission:mlo-mloblinformation-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:mlo-mloblinformation-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $igm = \request()->igm;
        $blref = \request()->bolreference;
        $vessel = \request()->feederVessel;
        $voyage = \request()->voyageNumber;
        $contref = \request()->contref;
        $note = request()->note;
        $dgCheck = request()->dgCheck;
        $notifyId = request()->notify_id;

        $consigneenames = DB::table('vatregs')->orderBy('id')->pluck('NAME', 'BIN');

        $mlobls = Mloblinformation::with('blcontainers', 'mloMoneyReceipt.deliveryOrder', 'mlofeederInformation')
            ->when($blref, function($q)use($blref){
                $q->where('bolreference', 'LIKE', "%$blref%");
            })
            ->when($note, function($q){
                $q->whereNotNull('note');
            })
            ->when($dgCheck, function($q){
                $q->where('dg', true);
            })
            ->when(!empty(request()->description), function($q){
                $q->where('description', 'LIKE', "%".request()->description."%");
            })
            ->when($igm, function($q)use($igm){
                $q->whereHas('mlofeederInformation', function($q)use($igm){
                    $q->where('id', "$igm");
                });
            })
            ->when($vessel, function($q)use($vessel){
                $q->whereHas('mlofeederInformation', function($q)use($vessel){
                    $q->where('feederVessel', 'LIKE', "%$vessel%");
                });
            })
            ->when($voyage, function($q)use($voyage){
                $q->whereHas('mlofeederInformation', function($q)use($voyage){
                    $q->where('voyageNumber', 'LIKE', "%$voyage%");
                });
            })
            ->when($contref, function($q)use($contref){
                $q->whereHas('blcontainers', function($q)use($contref){
                    $q->where('contref', $contref);
                });
            })
            ->when($notifyId, function($q)use($notifyId){
                $q->where('notify_id', $notifyId);
            })
            ->orderBy('id','desc')
            ->paginate(100);


//            ->get();
//        dd($mlobls);
        return view('mlo.blinformations.index', compact('mlobls','vessel','voyage', 'note', 'dgCheck', 'request', 'consigneenames'));
    }

    public function create()
    {
        abort(404);
    }

    public function blEntryByFeeder($feederID)
    {
        $formType = 'create';
        $feederInfo = Feederinformation::where('id', $feederID)->first(['id', 'feederVessel', 'voyageNumber', 'rotationNo', 'departureDate', 'arrivalDate', 'berthingDate', 'COCode']);
        $totalLineNumber = Mloblinformation::where('feederinformations_id', $feederID)->max('line');
        $lineNumber = $totalLineNumber + 1;

        $consigneenames = DB::table('vatregs')->orderBy('id')->pluck('NAME', 'BIN');
        $notifynames = DB::table('vatregs')->orderBy('id')->pluck('NAME', 'BIN');

        $packagecodes = DB::table('packages')->orderBy('id')->pluck('packagecode');
        $containertypes = DB::table('containertypes')->orderBy('id')->pluck('isocode');
        $commoditys= DB::table('commodities')->select('commoditycode','commoditydescription')->get();
        $offdocks= DB::table('offdocks')->select('code','name')->get();

        $mlocodes = DB::table('mloblinformations')->distinct()->pluck('mlocode');

        $containerLocations = Containerlocation::pluck('name','code');
        $exporterInfos = Mloblinformation::orderBy('exportername')->distinct('exportername')->pluck('exportername');
        $principals = Principal::orderBy('name')->pluck('name');
        return view('mlo.blinformations.create', compact('formType','consigneenames', 'mlocodes','notifynames', 'feederInfo', 'lineNumber','packagecodes','containertypes','commoditys','offdocks', 'exporterInfos', 'containerLocations', 'principals'));
    }


    public function store(BlinformationRequest $request)
    {
//        dd($request->all());
        try{
            $consignee = Vatreg::firstOrCreate(['BIN' => $request->consignee_id],['NAME' => $request->consigneename,'ADD1' => $request->consigneeaddress]);
            $notify = Vatreg::firstOrCreate(['BIN' => $request->notify_id],['NAME' => $request->notifyname,'ADD1' => $request->notifyaddress]);
            if(!$request->principal_id){
                $newPrincipal = Principal::create(['name' => $request->principal,'code' => $request->principalCode]);
                $request['principal_id'] = $newPrincipal->id;
            }

            $mloblinformationData = $request->only(['line', 'principal_id', 'pOriginName', 'unloadingName','blnaturecode', 'blnaturetype', 'bltypecode', 'bltypename',
                'shippingmark', 'packageno','package_id', 'description', 'grosswt', 'verified_gross_mass', 'measurement', 'containernumber', 'note', 'feederinformations_id',
                'bolreference','pOrigin','PUloding','exportername','exporteraddress','mlocode','mloname','mloaddress','remarks','freightstatus','freightvalue','coloader']);
            $mloblinformationData['consignee_id'] = $consignee->BIN;
            $mloblinformationData['notify_id'] = $notify->BIN;
            $mloblinformationData['qccontainer'] = $request->qccontainer ? true : false;
            if(empty($request->hasFile('file'))){
                $containersData = $request->addmore;
            }else{
                $container = Excel::toCollection(new BlcontainerImport(),request()->file('file'));
                $containersData = $container->collapse()->toArray();
            }
            if(empty($containersData)){
                return redirect()->back()->withInput()->withErrors("Please Upload Container via given Excel format or add Manually.");
            }

//            dd($containersData);
            Validator::make($containersData, [
                '*.contref'             => 'bail|required|alpha_num|size:11|distinct',
                '*.pkgno'               => ['required','numeric'],
                '*.grosswt'             => 'required|numeric|',
                '*.verified_gross_mass' => 'required|numeric|',
                '*.status'              => 'required|size:3',
            ])->validate();

            if($request->containernumber != count($containersData)){
                return redirect()->back()->withInput()->withErrors("Total Containers Mismatch.");
            }
            $containersPkgno = 0;
            $containersGrossWt = 0;
            foreach ($containersData as $containers) {
                $containersPkgno += $containers['pkgno'];
                $containersGrossWt += $containers['grosswt'];
            }
            if($request->packageno != $containersPkgno){
                return redirect()->back()->withInput()->withErrors("Total Package Mismatch.");
            }
            $grosswtInFloat = number_format($request->grosswt, 2, '.', '');
            $containersGrossWtInFloat = number_format($containersGrossWt, 2, '.', '');
            if($grosswtInFloat != $containersGrossWtInFloat){
                return redirect()->back()->withInput()->withErrors(
                    "Total Gross Weight Mismatch.
                    Gross Weight : $grosswtInFloat, Container Gross Weight : $containersGrossWtInFloat. Difference : ".
                    ($grosswtInFloat != $containersGrossWtInFloat)
                );
            }

            $containersStatus = Arr::pluck($containersData, 'status');
            $containersImco = Arr::pluck($containersData, 'imco');
            $mloblinformationData['consolidated'] = in_array('prt', array_map('strtolower', $containersStatus)) || in_array('lcl', array_map('strtolower', $containersStatus)) ? true : false;
            $mloblinformationData['dg'] = array_filter($containersImco) ? true : false;

            $hbl_addmores = array();
            foreach ($containersData as $addmore){
                $hbl_addmores[]= [
                    'contref' => strtoupper($addmore['contref']),
                    'type' => strtoupper($addmore['type']),
                    'status' => $addmore['status'],
                    'sealno' => strtoupper($addmore['sealno']),
                    'pkgno' => $addmore['pkgno'],
                    'grosswt' => $addmore['grosswt'],
                    'verified_gross_mass' => $addmore['verified_gross_mass'],
                    'imco' => $addmore['imco'],
                    'un' => $addmore['un'],
                    'location' => $addmore['location'],
                    'commodity' => $addmore['commodity'],
                    'containerStatus' => 'laden',
                ];
            }
//            dd($mloblinformationData);
            DB::transaction(function()use($mloblinformationData, $hbl_addmores, $request){
                $mloblinformation = Mloblinformation::create($mloblinformationData);
                $mloblinformation->blcontainers()->createMany($hbl_addmores);
            });
            return redirect()->back()->withInput($request->except('bolreference'))->with('message', 'The House BL Created Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(Mloblinformation $mloblinformation)
    {
        $consignee = DB::table('vatregs')->where('BIN','=',$mloblinformation->consignee_id)->first();
        $notify = DB::table('vatregs')->where('BIN','=',$mloblinformation->notify_id)->first();
        $package = DB::table('packages')->where('id','=',$mloblinformation->package_id)->first();
        $feederInfo = Feederinformation::where('feederinformations.id','=',$mloblinformation->feederinformations_id)->first();
        return view('mlo.blinformations.show',compact('mloblinformation','consignee','notify','package','feederInfo'));
    }
    public function edit(Mloblinformation $mloblinformation){
        $formType = 'edit';
        $packagecodes = DB::table('packages')->orderBy('id')->pluck('packagecode');
        $containertypes = DB::table('containertypes')->orderBy('id')->pluck('isocode');
        $offdocks= DB::table('offdocks')->select('code','name')->get();
        $commoditys= DB::table('commodities')->select('commoditycode','commoditydescription')->get();
        $mlocodes = DB::table('mloblinformations')->distinct()->pluck('mlocode');
        $exporterInfos = ExporterInfo::orderBy('name')->pluck('name');

        $consigneenames = DB::table('vatregs')->orderBy('id')->pluck('NAME', 'BIN');
        $notifynames = DB::table('vatregs')->orderBy('id')->pluck('NAME', 'BIN');

        $package = DB::table('packages')->where('id','=',$mloblinformation->package_id)->first();
        $feederInfo = Feederinformation::where('feederinformations.id','=',$mloblinformation->feederinformations_id)->first();
        $containerLocations = Containerlocation::pluck('name','code');
        $principals = Principal::orderBy('name')->pluck('name');
        return view('mlo.blinformations.create', compact('formType', 'mloblinformation','package','feederInfo','mlocodes', 'exporterInfos','packagecodes','containertypes','offdocks','commoditys', 'consigneenames', 'notifynames', 'principals', 'containerLocations'));
    }

    public function update(BlinformationRequest $request, Mloblinformation $mloblinformation){
//        dd($request->all());
        try{
            $consignee = Vatreg::firstOrCreate(['BIN' => $request->consignee_id],['NAME' => $request->consigneename,'ADD1' => $request->consigneeaddress]);
            $notify = Vatreg::firstOrCreate(['BIN' => $request->notify_id],['NAME' => $request->notifyname,'ADD1' => $request->notifyaddress]);

            if(!$request->principal_id){
                $newPrincipal = Principal::create(['name' => $request->principal,'code' => $request->principalCode]);
                $request->principal_id = $newPrincipal->id;
            }
            $mloblinformationData = $request->only(['line', 'principal_id', 'pOriginName', 'unloadingName','blnaturecode', 'blnaturetype', 'bltypecode', 'bltypename',
                'shippingmark', 'packageno','package_id', 'description', 'grosswt', 'verified_gross_mass' ,'measurement', 'containernumber', 'note', 'feederinformations_id',
                'bolreference','pOrigin','PUloding','exportername','exporteraddress','mlocode','mloname','mloaddress','remarks','freightstatus','freightvalue','coloader']);
            $mloblinformationData['consignee_id'] = $consignee->BIN;
            $mloblinformationData['notify_id'] = $notify->BIN;
            $mloblinformationData['qccontainer'] = $request->qccontainer ? true : false;
            if(empty($request->hasFile('file'))){
                $containersData = $request->addmore;
            }else{
                $container = Excel::toCollection(new BlcontainerImport(),request()->file('file'));
                $containersData = $container->collapse()->toArray();
            }
            if(empty($containersData)){
                return redirect()->back()->withInput()->withErrors("Please Upload Container via given Excel format or add Manually.");
            }

//            dd($containersData);
            Validator::make($containersData, [
                '*.contref'             => 'bail|required|size:11|distinct',
                '*.pkgno'               => ['required','numeric'],
                '*.grosswt'             => 'required|numeric|',
                '*.verified_gross_mass' => 'required|numeric|',
                '*.status'              => 'required|size:3',
            ])->validate();

            if($request->containernumber != count($containersData)){
                return redirect()->back()->withInput()->withErrors("Total Containers Mismatch.");
            }
            $containersPkgno = 0;
            $containersGrossWt = 0;
            foreach ($containersData as $containers) {
                $containersPkgno += $containers['pkgno'];
                $containersGrossWt += $containers['grosswt'];
            }
            if($request->packageno != $containersPkgno){
                return redirect()->back()->withInput()->withErrors("Total Package Mismatch.");
            }

            $grosswtInFloat = number_format($request->grosswt, 2, '.', '');
            $containersGrossWtInFloat = number_format($containersGrossWt, 2, '.', '');
            if($grosswtInFloat != $containersGrossWtInFloat){
                return redirect()->back()->withInput()->withErrors(
                    "Total Gross Weight Mismatch.
                    Gross Weight : $grosswtInFloat, Container Gross Weight : $containersGrossWtInFloat. Difference : ".
                    ($grosswtInFloat != $containersGrossWtInFloat)
                );
            }

            $containersStatus = Arr::pluck($containersData, 'status');
            $containersImco = Arr::pluck($containersData, 'imco');
            $mloblinformationData['consolidated'] = in_array('prt', array_map('strtolower', $containersStatus)) || in_array('lcl', array_map('strtolower', $containersStatus)) ? true : false;
            $mloblinformationData['dg'] = array_filter($containersImco) ? true : false;

            $hbl_addmores = array();
            foreach ($containersData as $addmore){
                $hbl_addmores[]= [
                    'contref' => strtoupper($addmore['contref']),
                    'type' => strtoupper($addmore['type']),
                    'status' => $addmore['status'],
                    'sealno' => strtoupper($addmore['sealno']),
                    'pkgno' => $addmore['pkgno'],
                    'grosswt' => $addmore['grosswt'],
                    'verified_gross_mass' => $addmore['verified_gross_mass'],
                    'imco' => $addmore['imco'],
                    'un' => $addmore['un'],
                    'location' => $addmore['location'],
                    'commodity' => $addmore['commodity'],
                    'containerStatus' => 'laden',
                ];
            }

//            dd($mloblinformationData);
            DB::transaction(function() use($mloblinformation, $mloblinformationData, $hbl_addmores){
                $mloblinformation->update($mloblinformationData);
                $mloblinformation->blcontainers()->delete();
                $mloblinformation->blcontainers()->createMany($hbl_addmores);
            });

            return redirect()->route('mloblinformations.index')->with('message', 'MLO BL Updated Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(Mloblinformation $mloblinformation)
    {
        if($mloblinformation->mloMoneyReceipt()->count()){
            return redirect()->back()->with(['errorMessage'=>"Cannot delete, Bl Ref: $mloblinformation->bolreference has Money Receipts."]);
        }
        try{
            $mloblinformation->delete();
            return redirect(route('mloblinformations.index'))->with('message', 'The B/L Deleted Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function getIgmByIgmNo($vessel, $voyage){
        $igm = DB::table('feederinformations')->select( 'id', 'feederVessel', 'voyageNumber', 'rotationNo','departureDate', 'arrivalDate', 'berthingDate','COCode')->where(['feederVessel'=> $vessel,'voyageNumber' => $voyage,])->first();
        $departureDate = date('d-m-Y',strtotime($igm->departureDate));
        $arrivalDate = date('d-m-Y',strtotime($igm->arrivalDate));
        $berthingDate = date('d-m-Y',strtotime($igm->berthingDate));
        return json_encode([
            'feederID' => $igm->id,
            'rotationNo' => $igm->rotationNo,
            'departureDate' => $departureDate,
            'arrivalDate' => $arrivalDate,
            'berthingDate' => $berthingDate,
            'COCode' => $igm->COCode,
        ]);
    }
    public function getMloNameByMloCode($mlocode){
        $mloname = DB::table('mloblinformations')->select('mloname','mloaddress')->where('mlocode','=',$mlocode)->first();
        return json_encode([
            'mloname' => $mloname->mloname,
            'mloaddress' => $mloname->mloaddress,
        ]);
    }

    public function loadBlInfoByBolRef($bolRef=null)
    {
        $blInfoData = Mloblinformation::with('blcontainers', 'mlofeederInformation', 'blNotify', 'blConsignee', 'package', 'principal')->where('bolreference', $bolRef)->firstOrFail();
        $blInfos = Mloblinformation::where('feederinformations_id', $blInfoData->feederinformations_id)->get(['grosswt', 'packageno', 'line', 'bolreference', 'note']);
        $blInfoData['houseblInfo'] = $blInfos->toArray();
        return $blInfoData;
    }

    public function checkMLOFCLContainer($igm, $contref)
    {
        $housebl = Mloblinformation::with(['blcontainers' => function($q){
            $q->where('status', 'FCL')->select(['id', 'mloblinformation_id', 'contref', 'status']);
        }])
            ->whereHas('blcontainers', function($q) use ($contref){
                $q->where(['status' => 'FCL', 'contref' => $contref]);
            })
            ->where('feederinformations_id', $igm)->firstOrFail(['id', 'feederinformations_id', 'bolreference']);
        return $housebl;
    }
}
