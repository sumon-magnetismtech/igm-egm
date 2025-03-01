<?php

namespace App\Http\Controllers;

use App\Cnfagent;
use App\Container;
use App\Description;
use App\ForwardingRecords;
use App\Housebl;
use App\Http\Requests\HouseblRequest;
use App\Http\Services\HouseblService;
use App\Imports\ContainerDetailsImport;
use App\Mail\DeliveryRequestMail;
use App\Masterbl;
use App\Vatreg;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\XMLWriter;

class HouseblController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:housebl-create|housebl-edit|housebl-view|housebl-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:housebl-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:housebl-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:housebl-delete', ['only' => ['destroy']]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $masterbl = \request()->mblno;
        $contref  = \request()->contref;
        $igm      = \request()->igm;
        $hbl      = \request()->housebl;
        $note     = \request()->note;
        $blNote   = \request()->blNote;
        $dgCheck  = \request()->dgCheck;
        $noc      = request()->nocCheck;
        $items    = request('items') ? request('items') : 15;
        $notifyId = request()->notify_id;

        $url = \request()->fullUrl();
        Session::put('searchedUrl', $url);
        $consigneenames = DB::table('vatregs')->orderBy('id')->pluck('NAME', 'BIN');

        $query = Housebl::query()->with('masterbl', 'moneyReceipt', 'containers')->orderBy('igm', 'DESC')->orderBy('line');
        $query->whereHas('masterbl', function ($q) use ($masterbl)
        {
            $q->where('mblno', 'LIKE', "%$masterbl%");
        });
        $query->when($contref, function ($q) use ($contref)
        {
            $q->whereHas('containers', function ($q) use ($contref)
            {
                $q->where('contref', $contref);
            });
        });
        $query->when($noc, function ($q)
        {
            return $q->whereHas('masterbl', function ($q)
            {
                $q->where('noc', true);
            });
        });
        $query->when($note, function ($q)
        {
            $q->whereNotNull('note');
        });
        $query->when($blNote, function ($q)
        {
            $q->whereNotNull('blNote');
        });
        $query->when($dgCheck, function ($q)
        {
            $q->where('dg', true);
        });
        $query->when(!empty(request()->description), function($q){
            $q->where('description', 'LIKE', "%".request()->description."%");
        });
        $query->when($hbl, function ($q) use ($hbl)
        {
            $q->where('bolreference', $hbl);
        });
        $query->when($igm, function ($q) use ($igm)
        {
            $q->where('igm', $igm);
        });
        $query->when($notifyId, function ($q) use ($notifyId)
        {
            $q->where('notifybin', $notifyId);
        });

        if (!empty($igm))
        {
            $housebls = $query->get();
        }
        else
        {
            $housebls = $query->paginate($items);
        }

        if ($masterbl || $igm || $hbl)
        {
            $grossWeight = $housebls->sum('grosswt');
            $quantity    = $housebls->sum('packageno');

        }
        else
        {
            $grossWeight = 0;
            $quantity    = 0;
        }

        return view('housebls.index', compact('housebls', 'blNote', 'masterbl', 'igm', 'hbl', 'grossWeight', 'quantity', 'dgCheck', 'note', 'items', 'noc', 'contref', 'consigneenames', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType       = 'create';
        $consigneenames = DB::table('vatregs')->orderBy('NAME')->pluck('NAME');
        $notifynames    = DB::table('vatregs')->orderBy('NAME')->pluck('NAME');
        $packagecodes   = DB::table('packages')->orderBy('id')->pluck('description', 'packagecode');
        $containertypes = DB::table('containertypes')->orderBy('id')->pluck('isocode');
        $commoditys     = DB::table('commodities')->select('commoditycode', 'commoditydescription')->get();
        $offdocks       = DB::table('offdocks')->select('code', 'name')->get();
        $descriptions   = Description::orderBy('description')->pluck('description');
        $vatRegBins     = DB::table('vatregs')->orderBy('BIN')->pluck('BIN', 'NAME');
        $exporterInfos  = Housebl::orderBy('exportername')->distinct('exportername')->pluck('exportername');

        return view('housebls.create', compact('formType', 'consigneenames', 'notifynames', 'descriptions', 'vatRegBins', 'exporterInfos', 'packagecodes', 'containertypes', 'commoditys', 'offdocks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(HouseblRequest $request)
    {
        try {
            $house_bl_service = (new HouseblService())->handleHousebl($request);
            $request = $house_bl_service['request'];

            DB::transaction(function () use ($house_bl_service)
            {
                $houseBl = Housebl::create($house_bl_service['blInformationData']);
                $houseBl->containers()->createMany($house_bl_service['hbl_addmores']);
            });

            $houseblInfo = Housebl::where('igm', $house_bl_service['request']->igm)
            ->get(['grosswt', 'packageno', 'line', 'bolreference', 'blNote']);

            $request['igmTotalLine']    = count($houseblInfo);
            $request['igmGrossWeight']  = $houseblInfo->sum('grosswt');
            $request['igmTotalPackage'] = $houseblInfo->sum('packageno');

            return redirect()->route('housebls.create')->withInput($request->except('blNote', 'note', 'dg'))
                ->with('message', 'The House BL Created Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Housebl  $housebl
     * @return \Illuminate\Http\Response
     */
    public function show(Housebl $housebl)
    {
        return view('housebls.show', compact('housebl'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Housebl  $housebl
     * @return \Illuminate\Http\Response
     */
    public function edit(Housebl $housebl)
    {
        $formType = 'edit';

        if (!$housebl->moneyreceiptStatus)
        {
            $houseblInfo      = Housebl::where('igm', $housebl->igm)->get(['grosswt', 'packageno']);
            $totalGrossWeight = $houseblInfo->sum('grosswt');
            $totalPackage     = $houseblInfo->sum('packageno');
            $totalLine        = count($houseblInfo);

            $consigneenames = DB::table('vatregs')->orderBy('NAME')->pluck('NAME');
            $packagecodes   = DB::table('packages')->orderBy('id')->pluck('description', 'packagecode');
            $containertypes = DB::table('containertypes')->orderBy('id')->pluck('isocode');
            $offdocks       = DB::table('offdocks')->select('code', 'name')->get();
            $commoditys     = DB::table('commodities')->select('commoditycode', 'commoditydescription')->get();
            $descriptions   = Description::orderBy('description')->pluck('description');
            $vatRegBins     = DB::table('vatregs')->orderBy('BIN')->pluck('BIN');
            $exporterInfos  = Housebl::orderBy('exportername')->distinct('exportername')->pluck('exportername');

            return view('housebls.create', compact('formType', 'housebl', 'descriptions', 'vatRegBins', 'exporterInfos', 'vatRegBins', 'exporterInfos', 'consigneenames', 'totalGrossWeight', 'totalPackage', 'totalLine', 'packagecodes', 'containertypes', 'offdocks', 'commoditys'));
        }
        else
        {
            return redirect()->route('housebls.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Housebl  $housebl
     * @return \Illuminate\Http\Response
     */
    public function update(HouseblRequest $request, Housebl $housebl)
    {

        try {
            $house_bl_service = (new HouseblService())->handleHousebl($request);

            DB::transaction(function () use ($housebl, $house_bl_service)
            {
                $housebl->update($house_bl_service['blInformationData']);
                $housebl->containers()->delete();
                $housebl->containers()->createMany($house_bl_service['hbl_addmores']);
            });

            return redirect()->to(Session::get('searchedUrl'))
                ->with('message', "House BL- $housebl->id Updated Successfully");
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Housebl $housebl
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Housebl $housebl)
    {
        try {
            $housebl->delete();

            return redirect()->to(Session::get('searchedUrl'))->with('message', 'The B/L Deleted Successfully');
        }
        catch (QueryException $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

    }

    /**
     * @param $igmno
     */
    public function getIgmByIgmNo($igmno)
    {
        $igm              = Masterbl::where('id', '=', $igmno)->first();
        $houseblInfo      = Housebl::where('igm', $igmno)->get(['grosswt', 'packageno', 'line', 'bolreference', 'blNote']);
        $totalGrossWeight = number_format($houseblInfo->sum('grosswt'), 2);
        $totalPackage     = $houseblInfo->sum('packageno');
        $totalLine        = count($houseblInfo);

//        dd($houseblInfo->toArray());

        return json_encode([
            'mblno'            => $igm->mblno,
            'fvessel'          => $igm->fvessel,
            'voyage'           => $igm->voyage,
            'rotno'            => $igm->rotno,
            'blnaturecode'     => $igm->blnaturecode,
            'pucode'           => $igm->pucode,
            'noc'              => $igm->noc,
            'departure'        => $igm->departure ? date('d-m-Y', strtotime($igm->departure)) : null,
            'arrival'          => $igm->arrival ? date('d-m-Y', strtotime($igm->arrival)) : null,
            'berthing'         => $igm->berthing ? date('d-m-Y', strtotime($igm->berthing)) : null,
            'cofficecode'      => $igm->cofficecode,
            'totalGrossWeight' => $totalGrossWeight,
            'totalPackage'     => $totalPackage,
            'totalLine'        => $totalLine,
            'houseblInfo'      => $houseblInfo,
        ]);
    }

    /**
     * @param $mblno
     */
    public function getIgmByMblNo($mblno)
    {
        $igmmbl           = Masterbl::where('mblno', '=', $mblno)->firstOrFail();
        $houseblInfo      = Housebl::where('igm', $igmmbl->id)->get(['grosswt', 'packageno', 'line', 'bolreference', 'note']);
        $totalGrossWeight = $houseblInfo->sum('grosswt');
        $totalPackage     = $houseblInfo->sum('packageno');
        $totalLine        = count($houseblInfo);

        return json_encode([
            'id'               => $igmmbl->id,
            'fvessel'          => $igmmbl->fvessel,
            'voyage'           => $igmmbl->voyage,
            'rotno'            => $igmmbl->rotno,
            'blnaturecode'     => $igmmbl->blnaturecode,
            'pucode'           => $igmmbl->pucode,
            'noc'              => $igmmbl->noc,
            'departure'        => $igmmbl->departure ? date('d-m-Y', strtotime($igmmbl->departure)) : null,
            'arrival'          => $igmmbl->arrival ? date('d-m-Y', strtotime($igmmbl->arrival)) : null,
            'berthing'         => $igmmbl->berthing ? date('d-m-Y', strtotime($igmmbl->berthing)) : null,
            'cofficecode'      => $igmmbl->cofficecode,
            'houseblInfo'      => $houseblInfo,
            'mloLineNo'        => $igmmbl->mloLineNo,
            'mloCommodity'     => $igmmbl->mloCommodity,
            'contMode'         => $igmmbl->contMode,
            'totalGrossWeight' => number_format($totalGrossWeight, 2),
            'totalPackage'     => $totalPackage,
            'totalLine'        => $totalLine,
        ]);
    }

    /**
     * @param $bolRef
     * @return mixed
     */
    public function loadHouseByBolRef($bolRef = null)
    {
        if ($bolRef)
        {
            $houseblData                     = Housebl::with('containers', 'masterbl')->where('bolreference', $bolRef)->firstOrFail();
            $houseblInfo                     = Housebl::where('igm', $houseblData->igm)->get(['grosswt', 'packageno', 'line', 'bolreference', 'note']);
            $totalGrossWeight                = $houseblInfo->sum('grosswt');
            $totalPackage                    = $houseblInfo->sum('packageno');
            $houseblData['departure']        = $houseblData->masterbl->departure ? date('d-m-Y', strtotime($houseblData->masterbl->departure)) : null;
            $houseblData['arrival']          = $houseblData->masterbl->arrival ? date('d-m-Y', strtotime($houseblData->masterbl->arrival)) : null;
            $houseblData['berthing']         = $houseblData->masterbl->berthing ? date('d-m-Y', strtotime($houseblData->masterbl->berthing)) : null;
            $houseblData['totalGrossWeight'] = number_format($totalGrossWeight, 2);
            $houseblData['totalPackage']     = $totalPackage;
            $houseblData['houseblInfo']      = $houseblInfo;
            $houseblData['totalPackage']     = count($houseblInfo);

            return $houseblData;
        }
    }

    /**
     * @param $packagecode
     */
    public function getPackageNameByPackageCode($packagecode)
    {
        $packname = DB::table('packages')->select('id', 'packages.description')->where('packagecode', '=', $packagecode)->firstOrFail();

        return json_encode([
            'id'          => $packname->id,
            'packagename' => $packname->description,
        ]);
    }

    public function downloadReports()
    {

//        $igm = \request()->igm;
//        $mbl = \request()->masterbl;
//
//        $houseblquerys = Housebl::with('containers')->where('igm','LIKE', "%$igm%")->where('mblno', 'LIKE', "%$mbl%")->paginate();
//        $hblmblquerys = DB::table('housebls')
//            ->rightJoin('masterbls', 'housebls.mblno','=', 'masterbls.mblno')
//            ->where('igm', 'LIKE', 3)
//            ->where('housebls.mblno', 'LIKE', "%$mbl%")
//            ->get();
//
//        foreach ($hblmblquerys as $hblmblquery){
//
//            echo $hblmblquery->bltypecode .'<br>';
//
//        }
//
//
//        view()->share('houseblquerys', $houseblquerys);

        return view('housebls.reports');

    }

    /**
     * @param $igm
     */
    public function downloadXml($igm)
    {
        $masterbl = Masterbl::with('housebls')->where('id', $igm)->firstOrFail();
        $xml      = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(1);
        $xml->startDocument();
        $xml->startElement('Awbolds');
        $xml->startElement('Master_bol');
        $xml->writeElement('Customs_office_code', $masterbl->cofficecode);
        $xml->writeElement('Voyage_number', $masterbl->voyage);
        $xml->writeElement('Date_of_departure', date('Y-m-d', strtotime($masterbl->departure)));
        $xml->writeElement('Reference_number', $masterbl->mblno);
        $xml->endElement();

        foreach ($masterbl->housebls as $housebl)
        {
            $xml->startElement('Bol_segment');

            $xml->startElement('Bol_id');
            $xml->writeElement('Bol_reference', $housebl->bolreference);
            $xml->writeElement('Line_number', $housebl->line);
            $xml->writeElement('Bol_nature', $masterbl->blnaturecode);
            $xml->writeElement('Bol_type_code', $masterbl->bltypecode);
            $xml->writeElement('DG_status', $housebl->dg ? 'DG' : '');
            $xml->endElement();

            $xml->writeElement('Consolidated_Cargo', $housebl->consolidated ? 1 : 0);

            $xml->startElement('Load_unload_place');
            $xml->writeElement('Port_of_origin_code', $masterbl->pocode);
            $xml->writeElement('Place_of_unloading_code', $masterbl->pucode);
            $xml->endElement();

            $xml->startElement('Traders_segment');
            $xml->startElement('Carrier');
            $xml->writeElement('Carrier_code', $masterbl->carrier);
            $xml->writeElement('Carrier_name', 'Magnetism Tech Ltd');
            $xml->writeElement('Carrier_address', $masterbl->carrieraddress);
            $xml->endElement();

            $xml->startElement('Shipping_Agent');
            $xml->startElement('Shipping_Agent_code');
            $xml->writeRawData(null);
            $xml->endElement();

            $xml->startElement('Shipping_Agent_name');
            $xml->writeRawData(null);
            $xml->endElement();
            $xml->endElement();

            $xml->startElement('Exporter');
            $xml->writeElement('Exporter_name', str_replace('&', 'AND', $housebl->exportername));
            $xml->writeElement('Exporter_address', str_replace('&', 'AND', $housebl->exporteraddress));
            $xml->endElement();

            $xml->startElement('Notify');
            $xml->writeElement('Notify_code', $housebl->notifybin);
            $xml->writeElement('Notify_name', str_replace('&', 'AND', $housebl->notifyname));
            $xml->writeElement('Notify_address', str_replace('&', 'AND', $housebl->notifyaddress));
            $xml->endElement();

            $xml->startElement('Consignee');
            $xml->writeElement('Consignee_code', $housebl->consigneebin);
            $xml->writeElement('Consignee_name', str_replace('&', 'AND', $housebl->consigneename));
            $xml->writeElement('Consignee_address', str_replace('&', 'AND', $housebl->consigneeaddress));
            $xml->endElement();

            $xml->endElement(); // end traders_segment

            foreach ($housebl->containers as $container)
            {
                $xml->startElement('ctn_segment');
                $xml->writeElement('Ctn_reference', $container->contref);
                $xml->writeElement('Number_of_packages', $container->pkgno);
                $xml->writeElement('Type_of_container', $container->type);
                $xml->writeElement('Status', $container->status);
                $xml->writeElement('Seal_number', $container->sealno);
                $xml->startElement('IMCO');
                $xml->writeRawData($container->imco);
                $xml->endElement();
                $xml->startElement('UN');
                $xml->writeRawData($container->un);
                $xml->endElement();
                $xml->startElement('Ctn_location');
                $xml->writeRawData($container->location);
                $xml->endElement();
                $xml->writeElement('Commodity_code', $container->commodity);
                $xml->writeElement('Gross_weight', $container->grosswt);
                $xml->endElement(); //end ctn_segment
            }
            $xml->startElement('Goods_segment');
            $xml->writeElement('Number_of_packages', $housebl->packageno);
            $xml->writeElement('Package_type_code', $housebl->packagecode);
            $xml->writeElement('Gross_mass', $housebl->grosswt);
            $xml->writeElement('Shipping_marks', str_replace('&', 'AND', $housebl->shippingmark));
            $xml->writeElement('Goods_description', str_replace('&', 'AND', $housebl->description));
            $xml->writeElement('Volume_in_cubic_meters', $housebl->measurement);
            $xml->writeElement('Num_of_ctn_for_this_bol', $housebl->containernumber);
            $xml->startElement('Remarks');
            $xml->writeRawData($housebl->remarks);
            $xml->endElement();
            $xml->endElement(); // end Goods_segment

            $xml->startElement('Value_segment');
            $xml->startElement('Freight_segment');
            $xml->writeElement('Freight_value', 0);
            $xml->writeElement('Freight_currency', 'zzz');
            $xml->endElement();
            $xml->endElement();

            $xml->endElement();
        } //end house bl foreach loop

        $xml->endDocument();
        $content = $xml->outputMemory();
        $xml     = null;

        $filename = 'DEG301080083_' . date('dmyHis', strtotime(now())) . '.xml';

        Storage::put($filename, $content);

        return Storage::download($filename);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function searchresultforigmpdf(Request $request)
    {
        $searchigm = $request->input('igm');
        $searchmbl = $request->input('masterbl');

        $houseblquery  = Housebl::with('containers')->where('igm', 'LIKE', "%$searchigm%")->where('mblno', 'LIKE', "%$searchmbl%")->firstOrFail();
        $houseblquerys = Housebl::with('containers')->where('igm', 'LIKE', "%$searchigm%")->where('mblno', 'LIKE', "%$searchmbl%")->get();

        $hblmblquerys = DB::table('housebls')
            ->rightJoin('masterbls', 'housebls.mblno', '=', 'masterbls.mblno')
            ->where('igm', 'LIKE', "%$searchigm%")
            ->where('housebls.mblno', 'LIKE', "%$searchmbl%")
            ->get();

        foreach ($hblmblquerys as $hblmblquery)
        {

            $bltypecode     = $hblmblquery->bltypecode;
            $pocode         = $hblmblquery->pocode;
            $carrier        = $hblmblquery->carrier;
            $carrieraddress = $hblmblquery->carrieraddress;
        }

        view()->share('houseblquery', $houseblquery);
        view()->share('houseblquerys', $houseblquerys);

        $pdf = PDF::loadview('housebls.hblpdf');
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('QCLL_' . time() . '.pdf');
    }

    /**
     * @param $hblid
     */
    public function hblPdf($hblid)
    {
        $hblInfo    = Housebl::with('masterbl')->where('id', $hblid)->firstOrFail();
        $containers = Container::where('housebl_id', $hblid)->select('contref', 'status', 'type')->get();

        return \Barryvdh\DomPDF\Facade::loadView('housebls.arrivalPdf', compact('hblInfo', 'containers'))->stream("arrival_$hblInfo->bolreference.pdf");
    }

    /**
     * @param $igm
     */
    public function arrivalNoticepdf($igm)
    {
        $housebls = Housebl::with('masterbl')->where('igm', $igm)->get();
        if (count($housebls))
        {
            return \Barryvdh\DomPDF\Facade::loadView('housebls.arrivalNotice', compact('housebls'))->stream("arrivalNotices_IGM_$igm.pdf");
        }
        else
        {
            return redirect()->back()->withInput()->with('message', 'Data Not Found.');
        }
    }

    public function searchFrdLetter()
    {
        $clients = Cnfagent::pluck('cnfagent');

        return view('housebls.reports', compact('clients'));
    }

    public function extensionLetter()
    {
        $clients = Cnfagent::pluck('cnfagent');

        return view('housebls.reports', compact('clients'));
    }

    public function onChassisLetter()
    {
        $clients = Cnfagent::pluck('cnfagent');

        return view('housebls.reports', compact('clients'));
    }

    /**
     * @param Request $request
     */
    public function frdLetter(Request $request)
    {
        //    dd($request->all());
        $letterType         = 'forwarding';
        $frdData            = $request->except('withPad');
        $frdData['user_id'] = auth()->id();
        $masterBlData       = $request->only('mloLineNo', 'mloCommodity', 'contMode');
        $withPad            = $request->withPad;

        Masterbl::where('mblno', $request->mblno)->update($masterBlData);
        $masterBl = Masterbl::where('mblno', $request->mblno)->with('housebls.containers')->firstOrFail();
        if (!empty($masterBl))
        {
            $houseBl    = Housebl::where('igm', $masterBl->id)->pluck('id');
            $containers = Container::whereIn('housebl_id', $houseBl)->get();
            ForwardingRecords::create($frdData);

            return \Barryvdh\DomPDF\Facade::loadView('housebls.frdLetter', compact('masterBl', 'containers', 'frdData', 'letterType', 'withPad'))->stream('frdLetter.pdf');
        }
        else
        {
            return redirect()->back()->withInput()->with('message', 'Data Not Found.');
        }

    }

    /**
     * @param Request $request
     */
    public function extensionLetterData(Request $request)
    {
        $letterType = 'extension';
        $frdData    = $request->except('withPad');
        $withPad    = $request->withPad;

        $frdRecordData            = $request->except('extensionContainer', 'withPad');
        $frdRecordData['contref'] = implode(', ', $request->extensionContainer);
        $frdRecordData['user_id'] = auth()->id();

        $bolreference        = $request->bolreference;
        $extensionContainers = $request->extensionContainer;

        $masterBl = [];
        if (!empty($request->bolreference))
        {
            $masterBl = Masterbl::whereHas('housebls', function ($q) use ($bolreference)
            {
                $q->where('bolreference', $bolreference);
            })->firstOrFail(['id', 'mblno', 'rotno', 'fvessel', 'voyage', 'mloCommodity', 'contMode', 'mloname', 'mloaddress']);
        }
        if (!empty($request->mblno))
        {
            $masterBl = Masterbl::with('housebls')->where('mblno', $request->mblno)
                ->firstOrFail(['id', 'mblno', 'rotno', 'fvessel', 'voyage', 'mloCommodity', 'contMode', 'mloname', 'mloaddress']);
        }

        $containers = Container::whereIn('id', $extensionContainers)->get();

        ForwardingRecords::create($frdRecordData);

        return \Barryvdh\DomPDF\Facade::loadView('housebls.frdLetter', compact('masterBl', 'containers', 'frdData', 'letterType', 'withPad'))->stream('frdLetter.pdf');
    }

    /**
     * @param Request $request
     */
    public function eDeliveryData(Request $request)
    {
        $frdRecordData = $request->all();

//        $frdRecordData['user_id'] = auth()->id();
//
//        $masterBlData = $request->only('mloLineNo', 'mloCommodity', 'contMode');
//        Masterbl::where('mblno', $request->mblno)->update($masterBlData);

        $masterbl = Masterbl::where('mblno', $request->mblno)->firstOrFail();

        if (!empty($masterbl))
        {
            $houseBl    = Housebl::where('igm', $masterbl->id)->pluck('id');
            $containers = Container::whereIn('housebl_id', $houseBl)->get()->unique('contref');

            $countContTypes = $containers->groupBy('type')->map(function ($item)
            {
                return count($item);
            });

            if ($request->to)
            {
                Mail::to($request->to)->send(new DeliveryRequestMail($masterbl, $countContTypes));
                ForwardingRecords::create($frdRecordData);

                return redirect()->route('mailList')->with('message', 'Email has been sent successfully.');
            }
            else
            {
                return view('housebls.eDeliveryData', compact('countContTypes', 'masterbl'))->with('message', 'Data Not Found.');
            }
        }
        else
        {
            return redirect()->back()->withInput()->with('message', 'Data Not Found.');
        }
    }

    /**
     * @param Request $request
     */
    public function onChassisLetterData(Request $request)
    {
        $onChassisData            = $request->all();
        $onChassisData['user_id'] = auth()->id();
        $bolreference             = $request->bolreference;

        $housebl = Housebl::with(['masterbl:id,mblno,rotno,fvessel,voyage,mloCommodity,contMode,mloname,mloaddress',
            'containers' => function ($q)
            {
                $q->where('status', 'FCL')
                    ->orWhere('status', 'PRT')
                ;
            }])
            ->where('bolreference', $request->bolreference)
            ->firstOrFail(['id', 'igm', 'notifyname', 'notifyaddress', 'bolreference', 'consigneename', 'consigneeaddress']);
        if ($housebl)
        {
            if (count($housebl->containers))
            {
                $countContTypes = $housebl->containers->groupBy('type')->map(function ($item)
                {
                    return count($item);
                });
                ForwardingRecords::create($onChassisData);

                return \Barryvdh\DomPDF\Facade::loadView('housebls.onChassisLetter', compact('housebl', 'onChassisData', 'countContTypes'))->stream("onchassis_HBL-$bolreference.pdf");
            }
            else
            {
                return redirect()->back()->withInput()->with('message', 'No FCL Container Found Based on your query.');
            }
        }
        else
        {
            return redirect()->back()->withInput()->with('message', 'No FCL Container Found Based on your query.');
        }
    }

    /**
     * @param Request $request
     */
    public function printhousebl(Request $request)
    {
        $houseblID = $request->id;
        $masterbl  = Masterbl::where('id', $request->igm)->with(['housebls.containers', 'housebls' => function ($q) use ($houseblID)
        {
            $q->whereIn('id', $houseblID);
        }])->firstOrFail();

//        $pdf = app('dompdf.wrapper');
//        $pdf->getDomPDF()->set_option("enable_php", true);
//        return $pdf->loadView('housebls.printhousebl', compact('masterbl'))->setPaper('A4', 'landscape')->stream('houseblchecklist.pdf');

        return \Barryvdh\DomPDF\Facade::loadView('housebls.printhousebl', compact('masterbl'))->setPaper('a4', 'landscape')->stream('frdLetter.pdf');
    }

    /**
     * @param $igm
     * @return mixed
     */
    public function containerListBasedOnIGM($igm)
    {
        $containerInfo = Housebl::join('containers', 'housebls.id', 'housebl_id')->where('igm', $igm)->distinct('contref')->get(['contref']);

        return $containerInfo;

//        dd($containerInfo->toArray());

    }

    /**
     * @param Request $request
     */
    public function searchHouseblContainersForm(Request $request)
    {
        $showType       = 'no';
        $seachedIgm     = '';
        $seachedContref = '';

        return view('housebls/houseblcontainers', compact('showType', 'seachedIgm', 'seachedContref'));
    }

    /**
     * @param Request $request
     */
    public function searchHouseblContainers(Request $request)
    {
        $showType       = 'yes';
        $seachedIgm     = $request->igm;
        $containertypes = DB::table('containertypes')->orderBy('id')->pluck('isocode');

        $masterbl = Masterbl::where('id', $request->igm)->firstOrFail();

        $containers = Housebl::join('containers', 'housebls.id', 'housebl_id')
            ->where('igm', $request->igm)->distinct('contref')
            ->select('containers.contref', 'igm', 'containers.type', 'containers.status', 'containers.sealno', 'housebl_id')->get();
        $allContainers = $containers->unique('contref');
//        dd($allContainers);

        $typeCount = $allContainers->groupBy('type')->map(function ($item, $key)
        {
            return collect($item)->count();
        });

        return view('housebls/houseblcontainers', compact('allContainers', 'seachedIgm', 'showType', 'containertypes', 'typeCount', 'masterbl'));
    }

    /**
     * @param Request $request
     */
    public function containersBulkUpdate(Request $request)
    {
//        dd($request->all());

        Housebl::join('containers', 'housebls.id', 'housebl_id')
            ->where('igm', $request->igm)
            ->where('contref', $request->oldContref)
            ->update([
                'contref' => $request->newContref,
                'type'    => $request->type,
                'status'  => $request->status,
                'sealno'  => $request->sealno,
            ]);

        return redirect()->back()->with('message', 'Updated successfully!');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function houseblstatusPDF(Request $request)
    {
        $requestType = $request->requestType;
        $contref     = $request->container;
        $vesselname  = $request->vesselname;
        $voyage      = $request->voyage;
        $mblno       = $request->mblno;
        $mrStatus    = $request->status;
        $principal   = $request->principal;
        $noc         = $request->nocCheck;

        $berthingFromDate = $request->berthingFromDate ? Carbon::createFromFormat('d/m/Y', $request->berthingFromDate)->startOfDay() : null;
        $berthingTillDate = $request->berthingTillDate ? Carbon::createFromFormat('d/m/Y', $request->berthingTillDate)->endOfDay() : null;

        $etaFromDate = $request->etaFromDate ? Carbon::createFromFormat('d/m/Y', $request->etaFromDate)->startOfDay() : null;
        $etaTillDate = $request->etaTillDate ? Carbon::createFromFormat('d/m/Y', $request->etaTillDate)->endOfDay() : null;

        $housebls = Housebl::with('masterbl', 'moneyReceipt', 'moneyReceipt.deliveryOrder')
            ->with([
                'containers' => function ($q) use ($contref)
            {
                    $q->where('contref', 'LIKE', $contref);
                },
            ])
            ->whereHas('masterbl', function ($q) use ($vesselname, $voyage, $mblno, $principal)
        {
                $q->where('fvessel', 'LIKE', $vesselname)
                    ->where('voyage', 'LIKE', $voyage)
                    ->where('mblno', 'LIKE', $mblno)
                    ->where('principal', 'LIKE', $principal);
            })
            ->when($berthingFromDate && $berthingTillDate, function ($q) use ($berthingFromDate, $berthingTillDate)
        {
                $q->whereHas('masterbl', function ($masterQuery) use ($berthingFromDate, $berthingTillDate)
            {
                    $masterQuery->whereBetween('berthing', [$berthingFromDate, $berthingTillDate]);
                });
            })
            ->when($etaFromDate && $etaTillDate, function ($q) use ($etaFromDate, $etaTillDate)
        {
                $q->whereHas('masterbl', function ($masterQuery) use ($etaFromDate, $etaTillDate)
            {
                    $masterQuery->whereBetween('berthing', [$etaFromDate, $etaTillDate]);
                });
            })
            ->when($noc, function ($q)
        {
                return $q->whereHas('masterbl', function ($q)
            {
                    $q->where('noc', true);
                });
            })
            ->where('igm', 'LIKE', $request->igm)
            ->where('bolreference', 'LIKE', $request->bolreference)
            ->where('notifyName', 'LIKE', $request->notifyName)
            ->where('description', 'LIKE', $request->description)
            ->where('exportername', 'LIKE', $request->exportername)

            ->when($mrStatus === 'delivered', function ($q)
        {
                $q->whereHas('moneyReceipt');
            })

            ->when($mrStatus === 'undelivered', function ($q)
        {
                $q->doesnthave('moneyReceipt');
            })
            ->get();
//        dd($berthingFromDate,$berthingTillDate);
        if ($requestType == 'pdf')
        {
            return \Barryvdh\DomPDF\Facade::loadView('housebls.houseblstatusPDF', compact('housebls'))->setPaper('A4', 'landscape')->stream('houseblstatusPDF.pdf');
        }
        else
        {
            return view('housebls.trackindex', compact('housebls'));
        }
    }

    /**
     * @param $igm
     * @param $contref
     * @return mixed
     */
    public function checkFCLContainer($igm, $contref)
    {
        $housebl = Housebl::with(['containers' => function ($q)
        {
            $q->where('status', 'FCL')->select(['id', 'housebl_id', 'contref', 'status']);
        }])
            ->whereHas('containers', function ($q) use ($contref)
        {
                $q->where(['status' => 'FCL', 'contref' => $contref]);
            })
            ->where('igm', $igm)->firstOrFail(['id', 'igm', 'bolreference']);

//        dd($housebl->toArray());

        return $housebl;
    }

    public function mailList()
    {
        $mblno = \request()->mblno;

        $masterbls = ForwardingRecords::with('masterbl')->where('mblno', 'LIKE', "%$mblno%")->where('type', 'e-frd')->latest()->paginate();
//        dd($masterbls);

        return view('housebls.mailList', compact('masterbls', 'mblno'));
    }

}
