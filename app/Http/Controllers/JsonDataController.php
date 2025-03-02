<?php

namespace App\Http\Controllers;

use App\Cnfagent;
use App\Container;
use App\Country;
use App\EgmHouseBl;
use App\EgmHouseBlContainers;
use App\EgmMasterBl;
use App\ExporterInfo;
use App\Housebl;
use App\Location;
use App\Masterbl;
use App\MLO\Feederinformation;
use App\MLO\Mloblinformation;
use App\Package;
use App\Principal;
use App\Vatreg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JsonDataController extends Controller
{

    public function loadPortData($portCode)
    {
        $portData = Location::where('portcode', $portCode)->firstOrFail();
        return json_encode([
            'depPortName' => $portData->description,
        ]);
    } // From Location


    public function getBinByBinNo($consigneebin)
    {
        $conbin = Vatreg::where('BIN', '=', $consigneebin)->firstOrFail(['id', 'vatregs.NAME', 'vatregs.ADD1', 'vatregs.ADD2', 'vatregs.ADD3', 'vatregs.ADD4']);
        return json_encode([
            'id' => $conbin->id,
            'binName' => $conbin->NAME,
            'binAddress' => $conbin->ADD1 . " " . $conbin->ADD2 . " " . $conbin->ADD3 . " " . $conbin->ADD4,
        ]);
    }

    public function getBinByName($consigneename)
    {
        $conname = Vatreg::where('NAME', '=', $consigneename)->firstOrFail(['id', 'vatregs.BIN', 'vatregs.ADD1', 'vatregs.ADD2', 'vatregs.ADD3', 'vatregs.ADD4']);
        return json_encode([
            'binNo' => $conname->BIN,
            'binAddress' => $conname->ADD1 . " " . $conname->ADD2 . " " . $conname->ADD3 . " " . $conname->ADD4,
        ]);
    }

    public function getPackageNameByPackageCode($packagecode)
    {

        $packname = Package::where('packagecode', '=', $packagecode)->firstOrFail(['id', 'packages.description']);
        return json_encode([
            'id' => $packname->id,
            'packagename' => $packname->description,
        ]);
    }


    function loadExporterAddress(Request $request)
    {
        $exporterData = Housebl::where('exportername', $request->name)->firstOrFail();
        return json_encode([
            'exporteraddress' => $exporterData->exporteraddress,
        ]);
    }
    function egmLoadExporterAddress(Request $request)
    {
        $exporterData = EgmHouseBl::where('exportername', $request->name)->firstOrFail();
        return json_encode([
            'exporteraddress' => $exporterData->exporteraddress,
        ]);
    }


    public function loadPortDataAutoComplete(Request $request)
    {

        $search = $request->search;

        if ($search == '') {
            $employees = Location::orderby('description', 'asc')->select('portcode', 'description')->limit(5)->get();
        } else {
            $employees = Location::orderby('description', 'asc')->select('portcode', 'description')->where('description', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = array();
        foreach ($employees as $employee) {
            $response[] = array("label" => $employee->description, "value" => $employee->portcode);
        }

        return response()->json($response);
    }
    public function loadCnfClientNameAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $clients = Cnfagent::limit(5)->get(['cnfagent']);
        } else {
            $clients = Cnfagent::where('cnfagent', 'like', '%' . $search . '%')->limit(10)->get(['cnfagent', 'id']);
        }
        $response = array();
        foreach ($clients as $client) {
            $response[] = array("label" => $client->cnfagent, "value" => $client->cnfagent, "id" => $client->id);
        }
        return response()->json($response);
    }

    //get IGM only from housebl table
    public function loadHouseblIgmAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $masterbls = Masterbl::limit(5)->get(['id']);
        } else {
            $masterbls = Masterbl::where('id', 'like', '%' . $search . '%')->limit(10)->get(['id']);
        }
        $response = array();
        foreach ($masterbls as $masterbl) {
            $response[] = array("label" => $masterbl->id, "value" => $masterbl->id);
        }
        return response()->json($response);
    }
    public function egmLoadHouseblIgmAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $masterbls = EgmMasterBl::limit(5)->get(['id']);
        } else {
            $masterbls = EgmMasterBl::where('id', 'like', '%' . $search . '%')->limit(10)->get(['id']);
        }
        $response = array();
        foreach ($masterbls as $masterbl) {
            $response[] = array("label" => $masterbl->id, "value" => $masterbl->id);
        }
        return response()->json($response);
    }

    //get mblno only from housebl
    public function loadHouseblMblNoAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $masterbls = Masterbl::limit(5)->get(['mblno']);
        } else {
            $masterbls = Masterbl::where('mblno', 'like', '%' . $search . '%')->limit(10)->get(['mblno']);
        }
        $response = array();
        foreach ($masterbls as $masterbl) {
            $response[] = array("label" => $masterbl->mblno, "value" => $masterbl->mblno);
        }
        return response()->json($response);
    }
    public function egmLoadHouseblMblNoAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $masterbls = EgmMasterBl::limit(5)->get(['mblno']);
        } else {
            $masterbls = EgmMasterBl::where('mblno', 'like', '%' . $search . '%')->limit(10)->get(['mblno']);
        }
        $response = array();
        foreach ($masterbls as $masterbl) {
            $response[] = array("label" => $masterbl->mblno, "value" => $masterbl->mblno);
        }
        return response()->json($response);
    }

    //get bolreference only from housebl
    public function loadHouseblBolreferenceAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $housebls = Housebl::limit(5)->get(['bolreference']);
        } else {
            $housebls = Housebl::where('bolreference', 'like', '%' . $search . '%')->limit(10)->get(['bolreference']);
        }
        $response = array();
        foreach ($housebls as $housebl) {
            $response[] = array("label" => $housebl->bolreference, "value" => $housebl->bolreference);
        }
        return response()->json($response);
    }
    public function egmLoadHouseblBolreferenceAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $housebls = EgmHouseBl::limit(5)->get(['bolreference']);
        } else {
            $housebls = EgmHouseBl::where('bolreference', 'like', '%' . $search . '%')->limit(10)->get(['bolreference']);
        }
        $response = array();
        foreach ($housebls as $housebl) {
            $response[] = array("label" => $housebl->bolreference, "value" => $housebl->bolreference);
        }
        return response()->json($response);
    }

    //get containers only from housebl containers table
    public function loadHouseblContainerAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $housebls = Container::limit(5)->get(['contref']);
        } else {
            $housebls = Container::where('contref', 'like', '%' . $search . '%')->distinct('contref')->limit(10)->get(['contref']);
        }
        $response = array();
        foreach ($housebls as $housebl) {
            $response[] = array("label" => $housebl->contref, "value" => $housebl->contref);
        }
        return response()->json($response);
    }
    public function egmLoadHouseblContainerAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $housebls = EgmHouseBlContainers::limit(5)->get(['contref']);
        } else {
            $housebls = EgmHouseBlContainers::where('contref', 'like', '%' . $search . '%')->distinct('contref')->limit(10)->get(['contref']);
        }
        $response = array();
        foreach ($housebls as $housebl) {
            $response[] = array("label" => $housebl->contref, "value" => $housebl->contref);
        }
        return response()->json($response);
    }

    //get notifyname only from housebl table
    public function loadHouseblNotifyNameAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $housebls = Housebl::limit(5)->get(['notifyname']);
        } else {
            $housebls = Housebl::where('notifyname', 'like', '%' . $search . '%')->distinct('notifyname')->limit(10)->get(['notifyname']);
        }
        $response = array();
        foreach ($housebls as $housebl) {
            $response[] = array("label" => $housebl->notifyname, "value" => $housebl->notifyname);
        }
        return response()->json($response);
    }
    public function egmLoadHouseblNotifyNameAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $housebls = EgmHouseBl::limit(5)->get(['notifyname']);
        } else {
            $housebls = EgmHouseBl::where('notifyname', 'like', '%' . $search . '%')->distinct('notifyname')->limit(10)->get(['notifyname']);
        }
        $response = array();
        foreach ($housebls as $housebl) {
            $response[] = array("label" => $housebl->notifyname, "value" => $housebl->notifyname);
        }
        return response()->json($response);
    }

    //get description only from housebl table
    public function loadHouseblDescriptionAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $housebls = Housebl::limit(5)->get(['description']);
        } else {
            $housebls = Housebl::where('description', 'like', '%' . $search . '%')->distinct('description')->limit(10)->get(['description']);
        }
        $response = array();
        foreach ($housebls as $housebl) {
            $response[] = array("label" => $housebl->description, "value" => $housebl->description);
        }
        return response()->json($response);
    }
    public function egmLoadHouseblDescriptionAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $housebls = EgmHouseBl::limit(5)->get(['description']);
        } else {
            $housebls = EgmHouseBl::where('description', 'like', '%' . $search . '%')->distinct('description')->limit(10)->get(['description']);
        }
        $response = array();
        foreach ($housebls as $housebl) {
            $response[] = array("label" => $housebl->description, "value" => $housebl->description);
        }
        return response()->json($response);
    }

    //get description only from housebl table
    public function loadHouseblExporternameAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $housebls = Housebl::limit(5)->get(['exportername']);
        } else {
            $housebls = Housebl::where('exportername', 'like', '%' . $search . '%')->distinct('exportername')->limit(10)->get(['exportername']);
        }
        $response = array();
        foreach ($housebls as $housebl) {
            $response[] = array("label" => $housebl->exportername, "value" => $housebl->exportername);
        }
        return response()->json($response);
    }
    public function egmLoadHouseblExporternameAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $housebls = EgmHouseBl::limit(5)->get(['exportername']);
        } else {
            $housebls = EgmHouseBl::where('exportername', 'like', '%' . $search . '%')->distinct('exportername')->limit(10)->get(['exportername']);
        }
        $response = array();
        foreach ($housebls as $housebl) {
            $response[] = array("label" => $housebl->exportername, "value" => $housebl->exportername);
        }
        return response()->json($response);
    }

    //get Vessel name only from housebl table
    public function loadHouseblMotherVesselAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $masterbls = Masterbl::limit(5)->get(['mv']);
        } else {
            $masterbls = Masterbl::where('mv', 'like', '%' . $search . '%')->distinct('mv')->limit(10)->get(['mv']);
        }
        $response = array();
        foreach ($masterbls as $masterbl) {
            $response[] = array("label" => $masterbl->mv, "value" => $masterbl->mv);
        }
        return response()->json($response);
    }
    public function egmLoadHouseblMotherVesselAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $masterbls = EgmMasterBl::limit(5)->get(['mv']);
        } else {
            $masterbls = EgmMasterBl::where('mv', 'like', '%' . $search . '%')->distinct('mv')->limit(10)->get(['mv']);
        }
        $response = array();
        foreach ($masterbls as $masterbl) {
            $response[] = array("label" => $masterbl->mv, "value" => $masterbl->mv);
        }
        return response()->json($response);
    }

    //get Vessel name only from housebl table
    public function loadHouseblFeederVesselAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $masterbls = Masterbl::limit(5)->get(['fvessel']);
        } else {
            $masterbls = Masterbl::where('fvessel', 'like', '%' . $search . '%')->distinct('fvessel')->limit(10)->get(['fvessel']);
        }
        $response = array();
        foreach ($masterbls as $masterbl) {
            $response[] = array("label" => $masterbl->fvessel, "value" => $masterbl->fvessel);
        }
        return response()->json($response);
    }
    public function egmLoadHouseblFeederVesselAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $masterbls = EgmMasterBl::limit(5)->get(['fvessel']);
        } else {
            $masterbls = EgmMasterBl::where('fvessel', 'like', '%' . $search . '%')->distinct('fvessel')->limit(10)->get(['fvessel']);
        }
        $response = array();
        foreach ($masterbls as $masterbl) {
            $response[] = array("label" => $masterbl->fvessel, "value" => $masterbl->fvessel);
        }
        return response()->json($response);
    }

    //get Vessel name only from housebl table
    public function loadMasterPrincipalAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $masterbls = Masterbl::limit(5)->get(['fvessel']);
        } else {
            $masterbls = Masterbl::where('principal', 'like', '%' . $search . '%')->distinct('principal')->limit(10)->get(['principal']);
        }
        $response = array();
        foreach ($masterbls as $masterbl) {
            $response[] = array("label" => $masterbl->principal, "value" => $masterbl->principal);
        }
        return response()->json($response);
    }
    public function egmLoadMasterPrincipalAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $masterbls = EgmMasterBl::limit(5)->get(['fvessel']);
        } else {
            $masterbls = EgmMasterBl::where('principal', 'like', '%' . $search . '%')->distinct('principal')->limit(10)->get(['principal']);
        }
        $response = array();
        foreach ($masterbls as $masterbl) {
            $response[] = array("label" => $masterbl->principal, "value" => $masterbl->principal);
        }
        return response()->json($response);
    }

    //get IGM only from housebl table
    public function binDataByNameAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $vatRegs = Vatreg::limit(5)->get();
        } else {
            $vatRegs = Vatreg::where('NAME', 'like', '%' . $search . '%')->limit(10)->get();
        }
        $response = array();
        foreach ($vatRegs as $vatReg) {
            $response[] = array(
                "label" => "$vatReg->NAME ($vatReg->BIN)",
                "name" => $vatReg->NAME,
                "bin" => $vatReg->BIN,
                "address" => $vatReg->ADD1
            );
        }
        return response()->json($response);
    }

    //get IGM only from housebl table
    public function loadCountryByNameAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $countries = Country::limit(5)->get();
        } else {
            $countries = Country::where('name', 'like', '%' . $search . '%')->limit(10)->get();
        }
        $response = array();
        foreach ($countries as $country) {
            $response[] = array(
                "iso" => "$country->iso",
                "label" => $country->name
            );
        }
        return response()->json($response);
    }

    public function loadCountryByIso($iso)
    {
        $countries = Country::where('iso', $iso)->firstOrFail();
        return response()->json($countries);
    }

    //get description only from housebl table
    public function loadHouseblVoyage($vesselName)
    {
        $housebls = Masterbl::where('fvessel', $vesselName)->distinct('voyage')->get(['voyage']);
        return response()->json($housebls);
    }
    public function egmLoadHouseblVoyage($vesselName)
    {
        $housebls = EgmMasterBl::where('fvessel', $vesselName)->distinct('voyage')->get(['voyage']);
        return response()->json($housebls);
    }

    public function containerExtension($mblno)
    {
        $houseBl = Housebl::where('mblno', 'LIKE', $mblno)->pluck('id');
        $containers = Container::whereIn('housebl_id', $houseBl)->get(['id', 'contref']);
        return $containers;
    }
    public function egmContainerExtension($mblno)
    {
        $houseBl = EgmHouseBl::where('mblno', 'LIKE', $mblno)->pluck('id');
        $containers = EgmHouseBlContainers::whereIn('housebl_id', $houseBl)->get(['id', 'contref']);
        return $containers;
    }

    public function containerExtensionByBolRef($bolref)
    {
        $houseBl = Housebl::where('bolreference', $bolref)->pluck('id');
        $containers = Container::whereIn('housebl_id', $houseBl)->get(['id', 'contref']);
        return $containers;
    }
    public function egmContainerExtensionByBolRef($bolref)
    {
        $houseBl = EgmHouseBl::where('bolreference', $bolref)->pluck('id');
        $containers = EgmHouseBlContainers::whereIn('housebl_id', $houseBl)->get(['id', 'contref']);
        return $containers;
    }

    public function principalAutoComplete(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $principals = Principal::limit(5)->get();
        } else {
            $principals = Principal::where('name', 'like', '%' . $search . '%')->limit(10)->get();
        }
        $response = array();
        foreach ($principals as $principal) {
            $response[] = array("label" => $principal->name, "id" => $principal->id, 'code' => $principal->code);
        }
        return response()->json($response);
    }

    public function getPrincipalDataByName($principalName)
    {
        $principal = Principal::where('name', $principalName)->firstOrFail();
        return $principal;
    }
}
