<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use App\EgmFeederinformation;
use Illuminate\Database\QueryException;
use App\Http\Requests\EgmFeederVesselRequest;
use App\Http\Requests\MLO\FeederVesselRequest;

class EgmFeederinformationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:mlo-feederinformation-create|mlo-feederinformation-edit|mlo-feederinformation-view|mlo-feederinformation-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:mlo-feederinformation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:mlo-feederinformation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:mlo-feederinformation-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $igm          = request()->igm;
        $contref      = request()->contref;
        $feederVessel = request()->feederVessel;
        $voyage       = request()->voyageNumber;
        $rotationNo   = request()->rotationNo;
        $arrivalDate  = request()->arrivalDate ? date('Y-m-d', strtotime(request()->arrivalDate)) : null;

        $feederInformations = EgmFeederinformation::with('mloblInformation')
            ->when($igm, function ($q) use ($igm) {
                $q->where('id', $igm);
            })
            ->when($contref, function ($q) use ($contref) {
                $q->whereHas('mloblInformation.blcontainers', function ($q) use ($contref) {
                    $q->where('contref', $contref);
                });
            })
            ->where('feederVessel', 'LIKE', "%$feederVessel%")
            ->when($voyage, function ($q) use ($voyage) {
                $q->where('voyageNumber', 'LIKE', "%$voyage%");
            })
            ->when($rotationNo, function ($q) use ($rotationNo) {
                $q->where('rotationNo', 'LIKE', "%$rotationNo%");
            })
            ->when($arrivalDate, function ($q) use ($arrivalDate) {
                $q->where('arrivalDate', 'LIKE', "%$arrivalDate%");
            })
            ->orderBy('id', 'desc')->paginate();

        return view('egm.mlo.feederinformations.index', compact('feederInformations', 'voyage', 'igm'));
    }

    public function trashed()
    {
        $feederVessel       = \request()->feederVessel ? \request()->feederVessel : null;
        $rotationNo         = \request()->rotationNo ? \request()->rotationNo : null;
        $arrivalDate        = \request()->arrivalDate ? date('Y-m-d', strtotime(str_replace('/', '-', request('arrivalDate')))) : null;
        $feederInformations = Feederinformation::onlyTrashed()
            ->where('feederVessel', 'LIKE', "%$feederVessel%")
            ->when($rotationNo, function ($q) use ($rotationNo) {
                $q->where('rotationNo', 'LIKE', "%$rotationNo%");
            })
            ->when($arrivalDate, function ($q) use ($arrivalDate) {
                $q->whereDate('arrivalDate', $arrivalDate);
            })
            ->orderBy('id', 'desc')->paginate(10);

        return view('mlo.feederinformations.trashed', compact('feederInformations', 'feederVessel', 'rotationNo', 'arrivalDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType      = 'create';
        $feederVessels = EgmFeederinformation::pluck('feederVessel');

        return view('egm.mlo.feederinformations.create', compact('feederVessels', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EgmFeederVesselRequest $request)
    {

        try {
            $data                  = $request->except('departureDate', 'arrivalDate', 'berthingDate', 'depPortCode', 'depPortName', 'desPortCode', 'desPortName');
            $data['departureDate'] = date('Y-m-d', strtotime(str_replace('/', '-', request('departureDate'))));
            $data['arrivalDate']   = $request->arrivalDate !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('arrivalDate')))) : null;
            $data['berthingDate']  = $request->berthingDate !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('berthingDate')))) : null;

            $data['depPortCode'] = $request->depPortCode ? strtoupper($request->depPortCode) : null;
            $data['depPortName'] = $request->depPortName ? strtoupper($request->depPortName) : null;
            $data['desPortCode'] = $request->desPortCode ? strtoupper($request->desPortCode) : null;
            $data['desPortName'] = $request->desPortName ? strtoupper($request->desPortName) : null;
            $data['user_id']     = auth()->id();

            EgmFeederinformation::create($data);

            return redirect()->route('egmfeederinformations.index')->with('message', 'Feeder Vessel created successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MLO\Feederinformation  $feederinformation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $feederinformation = EgmFeederinformation::with('mloblInformation')->findOrFail($id);
        return view('egm.mlo.feederinformations.show', compact('feederinformation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MLO\Feederinformation  $feederinformation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $formType      = 'edit';
        $countries     = Country::pluck('name', 'iso');
        $feederVessels = EgmFeederinformation::pluck('feederVessel');
        $feederinformation = EgmFeederinformation::findOrFail($id);

        return view('egm.mlo.feederinformations.create', compact('feederVessels', 'feederinformation', 'formType', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MLO\Feederinformation  $feederinformation
     * @return \Illuminate\Http\Response
     */
    public function update(EgmFeederVesselRequest $request, EgmFeederinformation $feederinformation)
    {
        try {
            $data                  = $request->except('departureDate', 'arrivalDate', 'berthingDate', 'depPortCode', 'depPortName', 'desPortCode', 'desPortName');
            $data['depPortCode']   = $request->depPortCode ? strtoupper($request->depPortCode) : null;
            $data['depPortName']   = $request->depPortName ? strtoupper($request->depPortName) : null;
            $data['desPortCode']   = $request->desPortCode ? strtoupper($request->desPortCode) : null;
            $data['desPortName']   = $request->desPortName ? strtoupper($request->desPortName) : null;
            $data['departureDate'] = date('Y-m-d', strtotime(str_replace('/', '-', request('departureDate'))));
            $data['arrivalDate']   = $request->arrivalDate !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('arrivalDate')))) : null;

            $countMoneyReceipt = 0;
            foreach ($feederinformation->mloblInformation as $mlobinformation) {
                if ($mlobinformation->mloMoneyReceipt) {
                    $moneyReceipt = 1;
                    break;
                }
            }
            if ($countMoneyReceipt == 0) {
                $data['berthingDate'] = $request->berthingDate !== null ? date('Y-m-d', strtotime(str_replace('/', '-', request('berthingDate')))) : null;
            }

            $feederinformation->update($data);

            return redirect()->route('egmfeederinformations.index')->with('message', 'Feeder Vessel updated successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MLO\Feederinformation  $feederinformation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feederinformation = EgmFeederinformation::findOrFail($id);
        if ($feederinformation->mloblInformation()->count()) {
            return redirect()->back()->with(['message' => "Cannot delete, Feeder: $feederinformation->feederVessel (ID: $feederinformation->id) has BL records."]);
        }

        try {
            $feederinformation->delete();

            return redirect()->route('egmfeederinformations.index')->with('message', 'Feeder Vessel Delete Successfully. IGM No: ' . $feederinformation->id);
        } catch (QueryException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * @param $feederinformation
     */
    public function restore($feederinformation)
    {
        $feederInfo = EgmFeederinformation::onlyTrashed()->where('id', $feederinformation)->first();
        $feederInfo->restore();

        return redirect()->back()->with('success', 'Data has been restored successfully');
    }

    /**
     * @param $feederinformation
     */
    public function forceDelete($feederinformation)
    {
        $feederinformation = EgmFeederinformation::onlyTrashed()->where('id', $feederinformation)->first();
        $feederinformation->forceDelete();

        return redirect()->back()->with('message', 'Data has been deleted successfully');
    }
}
