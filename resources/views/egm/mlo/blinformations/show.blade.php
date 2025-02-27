@extends('layouts.egm-layout')
@section('title', 'BL Information - Details')

@section('breadcrumb-title', 'BL Information-Details')

@section('breadcrumb-button')
    <a href="{{route('mloblinformations.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    Showing Details of B/L Information: {{ $mloblinformation->bolreference }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <ul>
                <li class="py-1"> <strong>Consolidated: </strong> {{ $mloblinformation->consolidated }}</li>
                <li class="py-1"><strong>DG Status: </strong>{{ $mloblinformation->dg }}</li>
                <li class="py-1"><strong>QC Container: </strong>{{ $mloblinformation->qccontainer }}</li>
                <li class="py-1"><strong>IGM No: </strong>{{ $mloblinformation->mlofeederInformation->id }}</li>
                <li class="py-1"><strong>Feeder Vessel: </strong>{{ $feederInfo->feederVessel }}</li>
                <li class="py-1"><strong>Voyage: </strong>{{ $feederInfo->voyageNumber }}</li>
                <li class="py-1"><strong>Rotation: </strong>{{ $feederInfo->rotationNo }}</li>
                <li class="py-1"><strong>P.Origin Code: </strong>{{ $mloblinformation->pOrigin }}</li>
                <li class="py-1"><strong>P.Origin Name: </strong>{{ $mloblinformation->pOriginName }}</li>
                <li class="py-1"><strong>Date of Departure: </strong>{{$feederInfo->departureDate ? date('d-m-Y', strtotime($feederInfo->departureDate)): null}}</li>
                <li class="py-1"><strong>Date of Arrival: </strong> {{ $feederInfo->arrivalDate ? date('d-m-Y', strtotime($feederInfo->arrivalDate)): null}}</li>
                <li class="py-1"><strong>Date of Berthing: </strong> {{ $feederInfo->berthingDate ? date('d-m-Y', strtotime($feederInfo->berthingDate)): null}}</li>
                <li class="py-1"><strong>Custom Office Code: </strong>{{ $feederInfo->COCode }}</li>
                <li class="py-1"><strong>Line No: </strong>{{ $mloblinformation->line }}</li>
                <li class="py-1"><strong>Exporter Name: </strong>{{ $mloblinformation->exportername }}</li>
                <li class="py-1"><strong>Exporter Address: </strong>{{ $mloblinformation->exporteraddress }}</li>
                <li class="py-1"><strong>Consignee Bin: </strong>{{ $consignee->BIN }}</li>
                <li class="py-1"><strong>Consignee Name: </strong>{{ $consignee->NAME }}</li>
                <li class="py-1"><strong>Consignee Address: </strong>{{ $consignee->ADD1.$consignee->ADD2.$consignee->ADD3.$consignee->ADD4 }}</li>
            </ul>
        </div>
        <div class="col-lg-6">
            <ul>
                <li class="py-1"><strong> B/L No: </strong>{{ $mloblinformation->bolreference }}</li>
                <li class="py-1"><strong>Shipping Mark: </strong>{{ $mloblinformation->shippingmark }}</li>
                <li class="py-1"><strong>Number of Package: </strong>{{ $mloblinformation->packageno }}</li>
                <li class="py-1"><strong>Package Code: </strong>{{ $package->packagecode }}</li>
                <li class="py-1"><strong>Package Type: </strong>{{ $package->description }}</li>
                <li class="py-1"><strong>Description: </strong>{{ $mloblinformation->description }}</li>
                <li class="py-1"><strong>Gross Weight: </strong>{{ $mloblinformation->grosswt }}</li>
                <li class="py-1"><strong>P. Unloading Code: </strong>{{ $mloblinformation->PUloding }}</li>
                <li class="py-1"><strong>P. Unloading Name: </strong>{{ $mloblinformation->unloadingName }}</li>
                <li class="py-1"><strong>Measurement: </strong>{{ $mloblinformation->measurement }}</li>
                <li class="py-1"><strong>Container Number: </strong>{{ $mloblinformation->containernumber }}</li>
                <li class="py-1"><strong>Remarks: </strong>{{ $mloblinformation->remarks }}</li>
                <li class="py-1"><strong>Freight Status: </strong>{{ $mloblinformation->freightstatus }}</li>
                <li class="py-1"><strong>Freight Value: </strong>{{ $mloblinformation->freightvalue }}</li>
                <li class="py-1"><strong>Co-loader: </strong>{{ $mloblinformation->coloader }}</li>
                <li class="py-1"><strong>Note: </strong>{{ $mloblinformation->note }}</li>
                <li class="py-1"><strong>Notify Bin: </strong>{{ $notify->BIN }}</li>
                <li class="py-1"><strong>Notify Name: </strong>{{ $notify->NAME }}</li>
                <li class="py-1"><strong>Notify Address: </strong>{{ $notify->ADD1.$notify->ADD2.$notify->ADD3.$notify->ADD4 }}</li>
            </ul>
        </div>

    </div> <!-- end row -->

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>No.</th>
                <th>Container Ref</th>
                <th>Type</th>
                <th>Status</th>
                <th>Seal No</th>
                <th>Pkgs No</th>
                <th>Gross Weight</th>
                <th>IMCO</th>
                <th>UN</th>
                <th>Ctn Loc</th>
                <th>Commodity</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $mloblinformation->blcontainers as $blcontainer)
                <tr>
                    <td> {{$loop->iteration}} </td>
                    <td> {{$blcontainer->contref}} </td>
                    <td> {{$blcontainer->type}} </td>
                    <td> {{$blcontainer->status}} </td>
                    <td> {{$blcontainer->sealno}} </td>
                    <td> {{$blcontainer->pkgno}} </td>
                    <td> {{$blcontainer->grosswt}} </td>
                    <td> {{$blcontainer->imco}} </td>
                    <td> {{$blcontainer->un}} </td>
                    <td> {{$blcontainer->location}} </td>
                    <td> {{$blcontainer->commodity}} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
