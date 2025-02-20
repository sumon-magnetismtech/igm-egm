@extends('layouts.new-layout')
@section('title', 'House B/L - Details')

@section('breadcrumb-title', 'House BL-Details')

@section('breadcrumb-button')
    <a href="{{ route('housebls.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    Details of House B/L: {{ $housebl->bolreference }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <ul>
                <li class="py-1"><strong>Consolidated: </strong> {{ $housebl->consolidated ? "Yes" : ""}}</li>
                <li class="py-1"><strong>DG Status: </strong>{{ $housebl->dg ? "Yes" : ""}}</li>
                <li class="py-1"><strong>QC Container: </strong>{{ $housebl->qccontainer ? "Yes" : ""}}</li>
                <li class="py-1"><strong>IGM No: </strong>{{ $housebl->igm }}</li>
                <li class="py-1"><strong>Master B/L No: </strong>{{ $housebl->masterbl->mblno }}</li>
                <li class="py-1"><strong>Feeder Vessel: </strong>{{ $housebl->masterbl->fvessel }}</li>
                <li class="py-1"><strong>Voyage: </strong>{{ $housebl->masterbl->voyage }}</li>
                <li class="py-1"><strong>Rotation: </strong>{{ $housebl->masterbl->rotno }}</li>
                <li class="py-1"><strong>Place of Unloading: </strong>{{ $housebl->masterbl->puname }} ({{ $housebl->masterbl->pucode }})</li>
                <li class="py-1"><strong>Nature: </strong>{{ $housebl->masterbl->blnaturetype }} ({{ $housebl->masterbl->blnaturecode }})</li>
                <li class="py-1"><strong>NOC: </strong> {{ $housebl->masterbl->noc ? "NOC" : null}} </li>
                <li class="py-1"><strong>Date of Departure: </strong>{{ $housebl->masterbl->departure ? date('d-m-Y', strtotime($housebl->masterbl->departure)) : null}}</li>
                <li class="py-1"><strong>Date of Arrival: </strong> {{ $housebl->masterbl->arrival ? date('d-m-Y', strtotime($housebl->masterbl->arrival)) : null}}</li>
                <li class="py-1"><strong>Custom Office Code: </strong>{{ $housebl->cofficecode }}</li>
                <li class="py-1"><strong>Line No: </strong>{{ $housebl->line }}</li>
                <li class="py-1"><strong>House B/L No: </strong>{{ $housebl->bolreference }}</li>
                <li class="py-1"><strong>Exporter Name: </strong>{{ $housebl->exportername }}</li>
                <li class="py-1"><strong>Exporter Address: </strong>{{ $housebl->exporteraddress }}</li>
                <li class="py-1"><strong>Consignee Bin: </strong>{{ $housebl->consigneebin }}</li>
                <li class="py-1"><strong>Consignee Name: </strong>{{ $housebl->consigneename }}</li>
                <li class="py-1"><strong>Consignee Address: </strong>{{ $housebl->consigneeaddress }}</li>
            </ul>
        </div>
        <div class="col-lg-6">
            <ul>
                <li class="py-1"><strong>Notify Bin: </strong>{{ $housebl->notifybin }}</li>
                <li class="py-1"><strong>Notify Name: </strong>{{ $housebl->notifyname }}</li>
                <li class="py-1"><strong>Notify Address: </strong>{{ $housebl->notifyaddress }}</li>
                <li class="py-1"><strong>Shipping Mark: </strong>{{ $housebl->shippingmark }}</li>
                <li class="py-1"><strong>Number of Package: </strong>{{ $housebl->packageno }}</li>
                <li class="py-1"><strong>Package Code: </strong>{{ $housebl->packagecode }}</li>
                <li class="py-1"><strong>Package Type: </strong>{{ $housebl->packagetype }}</li>
                <li class="py-1"><strong>Description: </strong>{{ $housebl->description }}</li>
                <li class="py-1"><strong>Gross Weight: </strong>{{ $housebl->grosswt }}</li>
                <li class="py-1"><strong>Measurement: </strong>{{ $housebl->measurement }}</li>
                <li class="py-1"><strong>Container Number: </strong>{{ $housebl->containernumber }}</li>
                <li class="py-1"><strong>Remarks: </strong>{{ $housebl->remarks }}</li>
                <li class="py-1"><strong>Freight Status: </strong>{{ $housebl->freightstatus }}</li>
                <li class="py-1"><strong>Freight Value: </strong>{{ $housebl->freightvalue }}</li>
                <li class="py-1"><strong>Co-loader: </strong>{{ $housebl->coloader }}</li>
                <li class="py-1"><strong>Note: </strong>{{ $housebl->note }}</li>
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
            @foreach( $housebl->containers as $container)
                <tr>
                    <td> {{$loop->iteration}} </td>
                    <td> {{$container->contref}} </td>
                    <td> {{$container->type}} </td>
                    <td> {{$container->status}} </td>
                    <td> {{$container->sealno}} </td>
                    <td> {{$container->pkgno}} </td>
                    <td> {{$container->grosswt}} </td>
                    <td> {{$container->imco}} </td>
                    <td> {{$container->un}} </td>
                    <td> {{$container->location}} </td>
                    <td> {{$container->commodity}} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
