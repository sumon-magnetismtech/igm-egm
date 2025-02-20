<?php

namespace App\Http\Controllers;

use App\Container;
use App\Http\Requests\EgmMasterBlRequest;
use App\EgmMasterBl;
use App\Principal;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EgmMasterBlController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:egmmasterbl-create|egmmasterbl-edit|egmmasterbl-view|egmmasterbl-delete', ['only' => ['index','show']]);
        $this->middleware('permission:egmmasterbl-create', ['only' => ['create','store']]);
        $this->middleware('permission:egmmasterbl-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:egmmasterbl-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $igm=\request()->igm;
        $masterbl = request()->mblno;
        $vessel=\request()->fvessel;
        $voy=\request()->voyage;
        $pucode=\request()->pucode;
        $items = request('items') ? request('items') : 15 ;


        $url = \request()->fullUrl();
        Session::put('searchedUrl', $url);

        $masterbls = EgmMasterBl::with('housebls.containers')->where('mblno', 'LIKE', "%$masterbl%")->where('fvessel', 'LIKE', "%$vessel%")->where('voyage', 'LIKE', "%$voy%")
            ->when($igm, function($q)use($igm){
                $q->where('id', $igm);
            })
            ->when($pucode == "BDCGP", function($query) use($pucode){
                return $query->where('pucode', "BDCGP");
            })
            ->when($request->contref, function($query){
                $query->whereHas('containers', function($q){
                    $q->where('contref', request()->contref);
                });
            })
            ->when($pucode == "Others", function($query) use($pucode){
                return $query->where('pucode', '!=' , "BDCGP");
            })
            ->latest()->paginate($items);
        $mblcount = count($masterbls);
        return view('egm.masterbls.index', compact('masterbls', 'mblcount', 'masterbl', 'vessel', 'voy', 'igm', 'items'));
    }

    public function create()
    {
        $formType = 'formType';
//        $locations = Location::all();
        $pocodes = DB::table('locations')->orderBy('id')->pluck('portcode');
        $mlocodes = DB::table('masterbls')->distinct()->pluck('mlocode');
        $bltypecodes =['HSB'=>'HSB','MSB'=>'MSB','AWB'=>'AWB','MAB'=>'MAB'];
        $blnaturecodes = [23,22,24,28];
        $principals = EgmMasterBl::orderBy('principal')->distinct()->pluck('principal');
//        $principals = [];
        return view('egm.masterbls.create', compact('pocodes', 'mlocodes', 'formType', 'bltypecodes', 'blnaturecodes', 'principals'));
    }

    public function store(EgmMasterBlRequest $request)
    {
//        dd($request->all());
        $data = $request->except('departure', 'arrival', 'berthing');
        $data['departure'] = date('Y-m-d', strtotime(str_replace('/', '-', request('departure'))));
        $data['arrival'] = date('Y-m-d', strtotime(str_replace('/', '-', request('arrival'))));
        $data['berthing']= $request->berthing !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('berthing')))) : null;
        $data['fvessel']= strtoupper($request->fvessel);
        $data['mblno']= strtoupper($request->mblno);
        $data['mv']= strtoupper($request->mv);
        $data['voyage']= strtoupper($request->voyage);
        $data['noc']= $request->noc ? 1 : 0;

        $latestIgmNo = EgmMasterBl::create($data);

        return redirect()->route('egmmasterbls.create')->withInput($request->except('mblno'))->with('message','Master B/L created successfully with IGM: '.$latestIgmNo->id);

    }

    public function show(Egmmasterbl $egmmasterbl)
    {
        return view('egm.masterbls.show', compact('egmmasterbl', $egmmasterbl));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Masterbl  $masterbl
     * @return \Illuminate\Http\Response
     */
    public function edit(Egmmasterbl $egmmasterbl)
    {
        $formType = 'edit';
        $pocodes = DB::table('locations')->orderBy('id')->pluck('portcode');
        $mlocodes = DB::table('egm_master_bls')->distinct()->pluck('mlocode');
        $bltypecodes =['HSB'=>'HSB','MSB'=>'MSB','AWB'=>'AWB','MAB'=>'MAB'];
        $blnaturecodes = [23,22,24,28];
        $principals = Principal::orderBy('name')->pluck('name');
        return view('egm.masterbls.create', compact('pocodes', 'mlocodes', 'egmmasterbl', 'formType', 'bltypecodes', 'blnaturecodes', 'principals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MasterblRequest $request
     * @param  \App\Masterbl $masterbl
     * @return void
     */
    public function update(EgmMasterBlRequest $request, Egmmasterbl $egmmasterbl)
    {
        try{
            $data = $request->except('departure', 'arrival', 'berthing');
            $data['departure'] = date('Y-m-d', strtotime(str_replace('/', '-', request('departure'))));
            $data['arrival'] = date('Y-m-d', strtotime(str_replace('/', '-', request('arrival'))));
            $data['berthing']= $request->berthing !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('berthing')))) : null;
            $data['fvessel']= strtoupper($request->fvessel);
            $data['mblno']= strtoupper($request->mblno);
            $data['mv']= strtoupper($request->mv);
            $data['voyage']= strtoupper($request->voyage);
            $data['noc']= $request->noc ? 1 : 0;
            $commonMaster = EgmMasterBl::where('fvessel', $egmmasterbl->fvessel)->where('voyage', $egmmasterbl->voyage)->update(['rotno' => $request->rotno]);
            $egmmasterbl->update($data);
            return redirect()->to(Session::get('searchedUrl'))->with('message', 'Data Updated Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(Egmmasterbl $egmmasterbl)
    {
        $egmmasterbl->delete();
        return redirect()->to(Session::get('searchedUrl'))->with('message', 'Deleted Successfully Masterbl No: ' . $egmmasterbl->mblno);
    }

    public function mblTrash(){
        $masterbls = EgmMasterBl::onlyTrashed()->paginate();
        return view('egm.masterbls.trash', compact('masterbls', $masterbls));
    }

    public function mblRestore($id){
        $data = EgmMasterBl::onlyTrashed()->findOrFail($id);
        $data->restore();
        return redirect('trashmaster');
    }

    public function getMloNameByMloCode($mlocode){
//        $mloname = DB::table('masterbls')->select('masterbls.mloname','masterbls.mloaddress')->where('mlocode','=',$mlocode)->firstOrFail();
        $mloname = EgmMasterBl::where('mlocode','=',$mlocode)->firstOrFail(['mloname', 'mloaddress']);
        return json_encode([
            'mloname' => $mloname->mloname,
            'mloaddress' => $mloname->mloaddress,
        ]);
    }

    public function vesselpositioning()
    {
        $vessel=\request()->vesselname;
        $voy=\request()->voyage;
        $rotno=\request()->rotno;
        $motherVessel = \request()->motherVessel;
        $mblno = \request()->mblno;
        $principal = request()->principal;

        $arrivalFrom = request()->arrivalFrom ? date('Y-m-d', strtotime(str_replace('/', '-', request()->arrivalFrom))) : null;
        $arrivalTill = request()->arrivalTill ? date('Y-m-d', strtotime(str_replace('/', '-', request()->arrivalTill))) : null;

        $berthingFrom = request()->berthingFrom ? date('Y-m-d', strtotime(str_replace('/', '-', request()->berthingFrom))) : null;
        $berthingTill = request()->berthingTill ? date('Y-m-d', strtotime(str_replace('/', '-', request()->berthingTill))) : null;

        $masterbls = EgmMasterBl::with('housebls')
            ->when($principal, function ($query) use ($principal) {
                return $query->where('principal', "LIKE", "%$principal%");
            })
            ->when($vessel, function ($query) use ($vessel) {
                return $query->where('fvessel', "LIKE", "%$vessel%");
            })
            ->when($mblno, function ($query) use ($mblno) {
                return $query->where('mblno', $mblno);
            })
            ->when($voy, function ($query) use ($voy) {
                return $query->where('voyage', "LIKE", "%$voy%");
            })
            ->when($rotno, function ($query) use ($rotno) {
                return $query->where('rotno', $rotno);
            })
            ->when($motherVessel, function ($query) use ($motherVessel) {
                return $query->where('mv', $motherVessel);
            })
            ->when($arrivalFrom && $arrivalTill, function($query)use($arrivalFrom, $arrivalTill){
                return $query->whereBetween('arrival', [$arrivalFrom, $arrivalTill]);
            })
            ->when($berthingFrom && $berthingTill, function($query)use($berthingFrom, $berthingTill){
                return $query->whereBetween('berthing', [$berthingFrom, $berthingTill]);
            })
            ->select(['id', 'mv', 'fvessel', 'voyage', 'rotno', 'arrival', 'berthing', 'mblno', 'jetty', 'remarks', 'noc', 'principal', 'departure'])
//            ->latest()
            ->orderBy('arrival', 'desc')
            ->paginate(100);
        return view('egm.masterbls.vesselpositioning',
            compact('masterbls','vessel','voy','rotno','motherVessel', 'mblno', 'arrivalFrom', 'arrivalTill', 'principal','berthingFrom', 'berthingTill'));
    }

    public function updateMasterRotBerthing(Request $request)
    {
        $arrival = $request->arrival !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('arrival')))) : null;
        $departure = $request->departure !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('departure')))) : null;
        $berthing = $request->berthing !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('berthing')))) : null;

        $masterbl = EgmMasterBl::where(['fvessel'=> $request->fvessel, 'voyage' => $request->voyage])
            ->update([
                'rotno'=> $request->rotno,
                'arrival' => $arrival,
                'berthing' => $berthing,
                'departure' => $departure,
                'jetty' => $request->jetty,
            ]);
        if($request->remarks){
            EgmMasterBl::where('id', $request->igm)->update([
                'remarks' => $request->remarks
            ]);
        }
    }

    public function unstaffingSheet($id)
    {
        $masterbl = EgmMasterBl::where('id', $id)->firstOrFail();
        $containerGroups = Container::
            with('housebl.masterbl')
            ->with(['housebl' => function($q){
                $q->orderBy('line', 'DESC');
            }])
        ->where('status', "LCL")
        ->orderBy('housebl_id')
        ->whereHas('housebl.masterbl', function($q)use($id){
            $q->where('id', $id);
        })
        ->get()
        ->groupBy('contref');

        return \Barryvdh\DomPDF\Facade::loadView('egm.masterbls.unstaffingSheet',compact('containerGroups', 'masterbl'))->stream("unStaffingSheet_IGM_$id.pdf");
    }

    public function cloneMasterblById($id)
    {
        $masterbl = EgmMasterBl::where('id', $id)->firstorFail();
        $masterbl['departureDate']=$masterbl->departure ? date('d/m/Y', strtotime($masterbl->departure)) : null;
        $masterbl['arrivalDate'] = $masterbl->arrival ? date('d/m/Y', strtotime($masterbl->arrival)) : null;
        $masterbl['berthingDate'] = $masterbl->berthing ? date('d/m/Y', strtotime($masterbl->berthing)) : null;

        return $masterbl;
    }
}
