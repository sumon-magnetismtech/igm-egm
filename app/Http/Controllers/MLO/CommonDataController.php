<?php

namespace App\Http\Controllers\MLO;

use App\EgmFeederinformation;
use App\EgmMloblinformation;
use Illuminate\Http\Request;
use App\MLO\Mloblinformation;
use App\MLO\Feederinformation;
use App\Http\Controllers\Controller;

class CommonDataController extends Controller
{

    function loadMLOExporterInfo(Request $request)
    {
        $exporterData = Mloblinformation::where('exportername', $request->name)->firstOrFail();
        return json_encode([
            'exporteraddress' => $exporterData->exporteraddress,
        ]);
    }


    public function feederNameAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $feederNames = Feederinformation::limit(5)->get(['fvessel']);
        } else {
            $feederNames = Feederinformation::where('feederVessel', 'like', '%' . $search . '%')->distinct('feederVessel')->limit(10)->get(['feederVessel']);
        }
        $response = array();
        foreach ($feederNames as $feederName) {
            $response[] = array("label" => strtoupper($feederName->getOriginal('feederVessel')), "value" => $feederName->getOriginal('feederVessel'));
        }
        return response()->json($response);
    }
    public function egmFeederNameAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $feederNames = EgmFeederinformation::limit(5)->get(['fvessel']);
        } else {
            $feederNames = EgmFeederinformation::where('feederVessel', 'like', '%' . $search . '%')->distinct('feederVessel')->limit(10)->get(['feederVessel']);
        }
        $response = array();
        foreach ($feederNames as $feederName) {
            $response[] = array("label" => strtoupper($feederName->getOriginal('feederVessel')), "value" => $feederName->getOriginal('feederVessel'));
        }
        return response()->json($response);
    }

    public function voyageAutoComplete($vesselName)
    {
        $voyages = Feederinformation::where('feederVessel', $vesselName)->distinct('voyageNumber')->get(['voyageNumber']);
        return response()->json($voyages);
    }
    public function egmVoyageAutoComplete($vesselName)
    {
        $voyages = EgmFeederinformation::where('feederVessel', $vesselName)->distinct('voyageNumber')->get(['voyageNumber']);
        return response()->json($voyages);
    }

    public function rotationNoAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $rotations = Feederinformation::limit(5)->get(['rotationNo']);
        } else {
            $rotations = Feederinformation::where('rotationNo', 'like', '%' . $search . '%')->distinct('rotationNo')->limit(10)->get(['rotationNo']);
        }
        $response = array();
        foreach ($rotations as $rotation) {
            $response[] = array("label" => $rotation->rotationNo, "value" => $rotation->rotationNo);
        }
        return response()->json($response);
    }
    public function egmRotationNoAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $rotations = EgmFeederinformation::limit(5)->get(['rotationNo']);
        } else {
            $rotations = EgmFeederinformation::where('rotationNo', 'like', '%' . $search . '%')->distinct('rotationNo')->limit(10)->get(['rotationNo']);
        }
        $response = array();
        foreach ($rotations as $rotation) {
            $response[] = array("label" => $rotation->rotationNo, "value" => $rotation->rotationNo);
        }
        return response()->json($response);
    }

    public function bolreferenceAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $bolreferences = Mloblinformation::limit(5)->get(['bolreference']);
        } else {
            $bolreferences = Mloblinformation::where('bolreference', 'like', '%' . $search . '%')->distinct('bolreference')->limit(10)->get(['bolreference']);
        }
        $response = array();
        foreach ($bolreferences as $bolreference) {
            $response[] = array("label" => $bolreference->bolreference, "value" => $bolreference->bolreference);
        }
        return response()->json($response);
    }

    public function egmbolreferenceAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $bolreferences = EgmMloblinformation::limit(5)->get(['bolreference']);
        } else {
            $bolreferences = EgmMloblinformation::where('bolreference', 'like', '%' . $search . '%')->distinct('bolreference')->limit(10)->get(['bolreference']);
        }
        $response = array();
        foreach ($bolreferences as $bolreference) {
            $response[] = array("label" => $bolreference->bolreference, "value" => $bolreference->bolreference);
        }
        return response()->json($response);
    }
}
