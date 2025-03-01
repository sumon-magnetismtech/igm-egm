<?php

namespace App\Http\Controllers;

use MPDF;
use Carbon\Carbon;
use App\EgmMloBlcontainer;
use App\EgmMloblinformation;
use Illuminate\Http\Request;
use App\EgmFeederinformation;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Exports\FeederContainerListExport;
use PhpOffice\PhpSpreadsheet\Shared\XMLWriter;
use Barryvdh\DomPDF\Facade as PDF;

class EgmMLOReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:mlo-report');
    }

    //Bangla PDF By using mPDF
    public function commitmentPDF()
    {
        $now = now(6);
        $pdf = MPDF::loadView('egm.mlo.reports.commitmentPDF');
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream("commitmentPDF_$now.pdf");
    }

    public function containerList($feeder_id)
    {
        $feederInfo = EgmFeederinformation::with('mloblInformation.blcontainers', 'mloblInformation.blNotify')->where('id', $feeder_id)->firstOrFail();
        //['contref', 'type', 'status']
        $containers = EgmMloBlcontainer::with('mloblinformation:id,bolreference')
            ->whereIn('mloblinformation_id', $feederInfo->mloblInformation->pluck('id'))
            ->get(['mloblinformation_id', 'contref', 'type', 'status']);
        $allContainers = $containers->collect()->unique('contref')->values()->all();

        return Excel::download(new FeederContainerListExport($allContainers), "ContainerList-Feeder-$feeder_id.xlsx");
    }

    public function ioccontainerlist($feeder_id)
    {
        $feederInfo = EgmFeederinformation::with('mloblInformation.blcontainers', 'mloblInformation.blNotify')->where('id', $feeder_id)->firstOrFail();
        $allContainers = EgmMloBlcontainer::whereIn('mloblinformation_id', $feederInfo->mloblInformation->pluck('id'))->get();
        $containerGroups = $allContainers->groupBy('type')->map(function ($item, $key) {
            return collect($item)->count();
        });
        return \Barryvdh\DomPDF\Facade::loadView('egm.mlo.reports.ioccontainerPDF', compact('feederInfo', 'containerGroups'))->setPaper('A4', 'landscape')->stream("ioccontainer_feeder_$feeder_id.pdf");
    }


    public function lclContainerList($feeder_id)
    {
        $blinformations = EgmMloblinformation::with('blcontainers', 'mlofeederInformation')
            ->whereHas('mlofeederInformation', function ($q) use ($feeder_id) {
                $q->where('id', $feeder_id);
            })
            ->whereHas('blcontainers', function ($q) {
                $q->where('status', 'LCL');
            })
            ->get();

        if ($blinformations->isNotEmpty()) {
            //        return view('mlo.reports.lcllist', compact('feederBasedOnStatus'));
            return \Barryvdh\DomPDF\Facade::loadView('egm.mlo.reports.lclContainerListPDF', compact('blinformations'))->setPaper('A4', 'landscape')->stream("lclContainerList_feeder_$feeder_id.pdf");
        } else {
            return redirect()->back()->withErrors('Not found any LCL Containers.');
        }
    }

    public function inboundContainerList($feeder_id)
    {
        $feederinformation = EgmFeederinformation::with('mloblinformation.blcontainers', 'mloblinformation.blNotify', 'mloblinformation.package')
            ->with(['mloblinformation' => function ($q) {
                $q->where('PUloding', '!=', "BDCGP");
            }])
            ->where('id', $feeder_id)->first();
        $unloadingGroups = $feederinformation->mloblinformation->groupBy('PUloding');

        if ($unloadingGroups->isNotEmpty()) {
            return \Barryvdh\DomPDF\Facade::loadView('egm.mlo.reports.inboundContainerListPDF', compact('feederinformation', 'unloadingGroups'))
                ->setPaper('A4', 'landscape')
                ->stream("inboundContainerList_feeder_$feeder_id.pdf");
        } else {
            return redirect()->back()->withErrors('Not found any LCL Containers with Unloading Port BDKAM, BDPNG.');
        }
    }

    public function permissionPDF($feeder_id)
    {
        $blinformationGroups = EgmMloblinformation::whereHas('mlofeederInformation', function ($q) use ($feeder_id) {
            $q->where('id', $feeder_id);
        })->where(function ($q) {
            $q->where('PUloding', "BDKAM")->orWhere('PUloding', "BDPNG");
        })->get(['id', 'feederinformations_id', 'PUloding', 'unloadingName'])->groupBy('PUloding');
        if ($blinformationGroups->isNotEmpty()) {
            return \Barryvdh\DomPDF\Facade::loadView('egm.mlo.reports.permissionPDF', compact('blinformationGroups'))->stream("permissionPDF_feeder_$feeder_id.pdf", array('Attachment' => 0));
        } else {
            return redirect()->back()->withErrors('Not found any BL with Unloading port BDPNG or BDKAM.');
        }
    }

    public function permissionBengaliPDF($feeder_id)
    {
        $blinformationGroups = EgmMloblinformation::whereHas('mlofeederInformation', function ($q) use ($feeder_id) {
            $q->where('id', $feeder_id);
        })->where(function ($q) {
            $q->where('PUloding', "BDKAM")->orWhere('PUloding', "BDPNG");
        })->get(['id', 'feederinformations_id', 'PUloding', 'unloadingName'])->groupBy('PUloding');
        if ($blinformationGroups->isNotEmpty()) {
            $pdf = MPDF::loadView('egm.mlo.reports.permissionBengaliPDF', compact('blinformationGroups'));
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('Bengali_Permission_Letter.pdf');
        } else {
            return redirect()->back()->withErrors('Not found any BL with Unloading port BDPNG or BDKAM.');
        }
    }


    public function arrivalNoticePDF($feeder_id)
    {
        $blInformations = EgmMloblinformation::where('feederinformations_id', $feeder_id)
            ->where('bltypecode', 'hsb')
            ->get();
        if ($blInformations->isNotEmpty()) {
            return \Barryvdh\DomPDF\Facade::loadView('egm.mlo.reports.arrivalNoticePDF', compact('blInformations'))->stream("arrivalNotices_Feeder_$feeder_id.pdf");
        } else {
            return redirect()->back()->withErrors('Not found any BL based on your query.');
        }
    }



    public function searcblforigmxml($feederId)
    {
        $feederInfo = EgmFeederinformation::with('mloblInformation.blcontainers', 'country:id,iso,name')->where('id', $feederId)->first();

        $totalPackages = 0;
        $totalContainers = 0;
        $totalGrossWt = 0;
        foreach ($feederInfo->mloblInformation as $key => $mloblinformation) {
            $totalPackages += $mloblinformation->packageno;
            $totalGrossWt += $mloblinformation->grosswt;
            $totalContainers += $mloblinformation->blcontainers->count();
        }
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(1);
        $xml->startDocument();
        $xml->startElement('Awmds');
        $xml->startElement('General_segment');
        $xml->startElement('General_segment_id');
        $xml->writeElement('Customs_office_code', $feederInfo->COCode);
        $xml->writeElement('Voyage_number', $feederInfo->voyageNumber);
        $xml->writeElement('Date_of_departure', date('Y-m-d', strtotime($feederInfo->departureDate)));
        $xml->writeElement('Date_of_arrival', date('Y-m-d', strtotime($feederInfo->arrivalDate)));
        $xml->endElement();

        $xml->startElement('Totals_segment');
        $xml->writeElement('Total_number_of_bols', $feederInfo->mloblInformation->count());
        $xml->writeElement('Total_number_of_packages', $totalPackages);
        $xml->writeElement('Total_number_of_containers', $totalContainers);
        $xml->writeElement('Total_gross_mass', $totalGrossWt);
        $xml->endElement();

        $xml->startElement('Transport_information');
        $xml->startElement('Carrier');
        $xml->writeElement('Carrier_code', $feederInfo->careerName);
        $xml->writeElement('Carrier_name', 'QC LOGISTICS LIMITED');
        $xml->writeElement('Carrier_address', $feederInfo->careerAddress);
        $xml->endElement();

        $xml->startElement('Shipping_Agent');
        $xml->startElement('Shipping_Agent_code');
        $xml->writeRawData('QCM');
        $xml->endElement();
        $xml->startElement('Shipping_Agent_name');
        $xml->writeRawData('QC MARITIME LIMITED');
        $xml->endElement();
        $xml->endElement();

        $xml->startElement('Mode_of_transport_code');
        $xml->writeRawData($feederInfo->mtCode);
        $xml->endElement();

        $xml->startElement('Identity_of_transporter');
        $xml->writeRawData($feederInfo->mtType);
        $xml->endElement();

        $xml->startElement('Nationality_of_transporter_code');
        $xml->writeRawData($feederInfo->country->iso);
        $xml->endElement();
        $xml->endElement();

        $xml->startElement('Load_unload_place');
        $xml->writeElement('Place_of_departure_code', $feederInfo->depPortCode);
        $xml->writeElement('Place_of_destination_code', $feederInfo->desPortCode);
        $xml->endElement();
        $xml->endElement();

        foreach ($feederInfo->mloblInformation as $mloblinfo) {
            $xml->startElement('Bol_segment');
            $xml->startElement('Bol_id');
            $xml->writeElement('Bol_reference', $mloblinfo->bolreference);
            $xml->writeElement('Line_number', $mloblinfo->line);
            $xml->writeElement('Bol_nature', $mloblinfo->blnaturecode);
            $xml->writeElement('Bol_type_code', $mloblinfo->bltypecode);
            $xml->writeElement('DG_status', $mloblinfo->dg ? "DG" : "");
            $xml->endElement();

            $xml->writeElement('Consolidated_Cargo', $mloblinfo->consolidated ? 1 : 0);

            $xml->startElement('Load_unload_place');
            $xml->writeElement('Port_of_origin_code', $mloblinfo->pOrigin);
            $xml->writeElement('Place_of_unloading_code', $mloblinfo->PUloding);
            $xml->endElement();

            $xml->startElement('Traders_segment');
            $xml->startElement('Carrier');
            $xml->writeElement('Carrier_code', $feederInfo->careerName);
            $xml->writeElement('Carrier_name', 'QC LOGISTICS LIMITED');
            $xml->writeElement('Carrier_address', $feederInfo->careerAddress);
            $xml->endElement();

            $xml->startElement('Shipping_Agent');
            $xml->startElement('Shipping_Agent_code');
            $xml->writeRawData("QCM");
            $xml->endElement();
            $xml->startElement('Shipping_Agent_name');
            $xml->writeRawData("QC MARITIME LIMITED");
            $xml->endElement();
            $xml->endElement();

            $xml->startElement('Exporter');
            $xml->writeElement('Exporter_name', str_replace('&', 'AND', $mloblinfo->exportername));
            $xml->writeElement('Exporter_address', str_replace('&', 'AND', $mloblinfo->exporteraddress));
            $xml->endElement();

            $xml->startElement('Notify');
            $xml->writeElement('Notify_code', $mloblinfo->notify_id);
            $xml->writeElement('Notify_name', str_replace('&', 'AND', strtoupper($mloblinfo->blNotify->NAME)));
            $xml->writeElement('Notify_address', str_replace('&', 'AND', strtoupper($mloblinfo->blNotify->ADD1)));
            $xml->endElement();

            $xml->startElement('Consignee');
            $xml->writeElement('Consignee_code', $mloblinfo->consignee_id);
            $xml->writeElement('Consignee_name', str_replace('&', 'AND', strtoupper($mloblinfo->blConsignee->NAME)));
            $xml->writeElement('Consignee_address', str_replace('&', 'AND', strtoupper($mloblinfo->blConsignee->ADD1)));
            $xml->endElement();
            $xml->endElement();

            //container start
            foreach ($mloblinfo->blcontainers as $blcontainer) {
                $xml->startElement('ctn_segment');
                $xml->writeElement('Ctn_reference', $blcontainer->contref);
                $xml->writeElement('Number_of_packages', $blcontainer->pkgno);
                $xml->writeElement('Type_of_container', $blcontainer->type);
                $xml->writeElement('Status', $blcontainer->status);
                $xml->writeElement('Seal_number', $blcontainer->sealno);
                $xml->writeElement('IMCO', $blcontainer->imco ? $blcontainer->imco : "");
                $xml->writeElement('UN', $blcontainer->un ? $blcontainer->un : "");
                $xml->writeElement('Ctn_location', $blcontainer->location ? $blcontainer->location : "");
                $xml->writeElement('Commodity_code', $blcontainer->commodity);
                $xml->writeElement('Gross_weight', $blcontainer->grosswt);
                $xml->writeElement('Verified_Gross_Mass', $blcontainer->verified_gross_mass);
                $xml->endElement();
            }
            $xml->startElement('Goods_segment');
            $xml->writeElement('Number_of_packages', $mloblinfo->packageno);
            $xml->writeElement('Package_type_code', $mloblinfo->package->packagecode);
            $xml->writeElement('Gross_mass', $mloblinfo->grosswt);
            $xml->writeElement('Shipping_marks', str_replace('&', 'AND', $mloblinfo->shippingmark));
            $xml->writeElement('Goods_description', str_replace('&', 'AND', $mloblinfo->description));
            $xml->writeElement('Volume_in_cubic_meters', $mloblinfo->measurement);
            $xml->writeElement('Num_of_ctn_for_this_bol', $mloblinfo->containernumber);
            $xml->writeElement('Remarks', $mloblinfo->remarks);
            $xml->endElement();

            $xml->startElement('Value_segment');
            $xml->startElement('Freight_segment');
            $xml->writeElement('Freight_value', $mloblinfo->freightvalue ? $mloblinfo->freightvalue : 0);
            $xml->writeElement('Freight_currency', 'ZZZ');
            $xml->endElement();
            $xml->endElement();
            $xml->endElement();
        }
        $xml->endElement();

        $xml->endDocument();
        $content = $xml->outputMemory();
        $xml = null;
        $filename = 'MAN301043125_' . now()->format('dmyHis') . '.xml';
        Storage::put($filename, $content);
        return Storage::download($filename);
    }

    //    public function printAllBLByFeederID($feederId, $status){
    //        if($status == "bdkam"){
    //            $feederinformation =Feederinformation::where('id', $feederId)
    //                ->with(['mloblInformation' => function($q){
    //                    $q->where('PUloding', 'LIKE', "bdkam");
    //                }])
    //                ->whereHas('mloblInformation', function($q){
    //                    $q->where('PUloding', 'bdkam');
    //                })
    //                ->firstOrFail();
    //        }elseif($status == "bdpng"){
    //            $feederinformation =Feederinformation::where('id', $feederId)
    //                ->with(['mloblInformation' => function($q){
    //                    $q->where('PUloding', 'LIKE', "bdpng");
    //                }])
    //                ->whereHas('mloblInformation', function($q){$q->where('PUloding', 'bdpng');})
    //                ->firstOrFail();
    //        }else{
    //            $feederinformation =Feederinformation::where('id', $feederId)->with(['mloblInformation'])->firstOrFail();
    //        }
    //        $feederinformation =Feederinformation::where('id', $feederId)->with(['mloblInformation'])->firstOrFail();
    ////        dd($feederinformation);
    //        return \Barryvdh\DomPDF\Facade::loadView('mlo.reports.mlo-bl-print', compact('feederinformation'))
    //            ->setPaper('A4', 'landscape');
    //
    //    }

    public function printAllBLByFeederID($feederId, $status)
    {
        if ($status == "bdkam") {
            $feederinformation = EgmFeederinformation::where('id', $feederId)
                ->with(['mloblInformation' => function ($q) {
                    $q->where('PUloding', 'LIKE', "bdkam");
                }])
                ->whereHas('mloblInformation', function ($q) {
                    $q->where('PUloding', 'bdkam');
                })
                ->firstOrFail();
        } elseif ($status == "bdpng") {
            $feederinformation = EgmFeederinformation::where('id', $feederId)
                ->with(['mloblInformation' => function ($q) {
                    $q->where('PUloding', 'LIKE', "bdpng");
                }])
                ->whereHas('mloblInformation', function ($q) {
                    $q->where('PUloding', 'bdpng');
                })
                ->firstOrFail();
        } else {
            $feederinformation = EgmFeederinformation::where('id', $feederId)->with(['mloblInformation'])->firstOrFail();
        }
        //        dd($feederinformation);
        return \Barryvdh\DomPDF\Facade::loadView('egm.mlo.reports.mlo-bl-print', compact('feederinformation', 'status'))
            ->setPaper('A4', 'landscape')
            ->stream("IGM_List-Feeder_$feederinformation->id.pdf");
    }


    public function inboundPerformanceReport(Request $request)
    {

        $dateType = $request->dateType;
        $fromDate = $request->fromDate ? Carbon::createFromFormat('d/m/Y', $request->fromDate)->startOfDay() : null;
        $tillDate = $request->tillDate ? Carbon::createFromFormat('d/m/Y', $request->tillDate)->endOfDay() : null;

        $reportType = $request->reportType;

        $mloblinformations = EgmMloblinformation::with('principal', 'mlofeederInformation:id,feederVessel,voyageNumber,rotationNo,berthingDate', 'blcontainers:id,mloblinformation_id,contref,type', 'blcontainers.containerGroup')
            ->when($dateType === 'weekly', function ($q) {
                $q->whereHas('mlofeederInformation', function ($q) {
                    $q->whereBetween('berthingDate', [now()->subDays(7), now()]);
                });
            })
            ->when($dateType === 'monthly', function ($q) {
                $q->whereHas('mlofeederInformation', function ($q) {
                    $q->whereBetween('berthingDate', [now()->subDays(30), now()]);
                });
            })
            ->when($dateType === 'custom', function ($q) use ($fromDate, $tillDate) {
                $q->whereHas('mlofeederInformation', function ($q) use ($fromDate, $tillDate) {
                    $q->whereBetween('berthingDate', [$fromDate, $tillDate]);
                });
            })
            ->when(!$dateType || $dateType === 'today', function ($q) use ($fromDate, $tillDate) {
                $q->whereHas('mlofeederInformation', function ($q) {
                    $q->whereDate('berthingDate', now());
                });
            })
            ->get(['id', 'feederinformations_id', 'PUloding', 'principal_id', 'bolreference']);

        //Grouping All Blinformations by Unloading Port
        $unloadingLocations = $mloblinformations->groupBy('PUloding');

        $locationWiseContTypesWithCount = $unloadingLocations->map(function ($blinformations) {
            $container = EgmMloBlcontainer::with('containerGroup:isocode,group')->whereIn('mloblinformation_id', $blinformations->pluck('id'))->get(['type']);
            return $data = $container->groupBy('containerGroup.group')->map(function ($item) {
                return collect($item)->count();
            });
        });
        if ($reportType == "pdf") {
            return PDF::loadView('egm.mlo.reports.inboundPerformanceReportPDF', compact('mloblinformations', 'unloadingLocations', 'locationWiseContTypesWithCount', 'dateType', 'fromDate', 'tillDate', 'reportType'))
                ->setPaper('A3', 'landscape')->stream("inbound-performance-report" . now()->format('d-m-Y') . ".pdf");
        } else {
            return view('egm.mlo.reports.inboundPerformanceReport', compact('mloblinformations', 'unloadingLocations', 'locationWiseContTypesWithCount', 'dateType', 'fromDate', 'tillDate', 'reportType'));
        }
    }

    public function ladenReport(Request $request)
    {
        $requestType = $request->requestType;
        $duration = $request->duration ?? 30;
        $principal = $request->principal;

        $blInformations = EgmMloblinformation::with('mloMoneyReceipt', 'blNotify', 'mlofeederInformation', 'blcontainers', 'principal')
            ->doesnthave('mloMoneyReceipt')
            ->when($principal, function ($q) use ($principal) {
                $q->whereHas('principal', function ($q) use ($principal) {
                    $q->where('name', 'LIKE', "%$principal%");
                });
            })
            ->whereHas('mlofeederInformation', function ($q) use ($duration) {
                $q->whereDate('berthingDate', '<=', Carbon::today()->subDays($duration)->toDateString());
            })
            ->get();

        //        dd($blInformations->toArray());
        if ($requestType == "pdf") {
            return PDF::loadView('egm.mlo.reports.ladenReport', compact('blInformations', 'principal', 'duration'))
                ->setPaper('A3', 'landscape')->stream("inbound-performance-report" . now()->format('d-m-Y') . ".pdf");
        } else {
            return view('egm.mlo.reports.ladenReport', compact('blInformations', 'principal', 'duration'));
        }
    }
}
