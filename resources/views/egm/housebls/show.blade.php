@extends('layouts.egm-layout')
@section('title', 'House B/L - Details')

@section('breadcrumb-title', 'House BL-Details')

@section('breadcrumb-button')
    <a href="{{ route('egmhousebls.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    Details of House B/L: {{ $egmhousebl->bolreference }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <ul>
                <li class="py-1"><strong>Consolidated: </strong> {{ $egmhousebl->consolidated ? "Yes" : ""}}</li>
                <li class="py-1"><strong>DG Status: </strong>{{ $egmhousebl->dg ? "Yes" : ""}}</li>
                <li class="py-1"><strong>QC Container: </strong>{{ $egmhousebl->qccontainer ? "Yes" : ""}}</li>
                <li class="py-1"><strong>IGM No: </strong>{{ $egmhousebl->igm }}</li>
                <li class="py-1"><strong>Master B/L No: </strong>{{ $egmhousebl->masterbl->mblno }}</li>
                <li class="py-1"><strong>Feeder Vessel: </strong>{{ $egmhousebl->masterbl->fvessel }}</li>
                <li class="py-1"><strong>Voyage: </strong>{{ $egmhousebl->masterbl->voyage }}</li>
                <li class="py-1"><strong>Rotation: </strong>{{ $egmhousebl->masterbl->rotno }}</li>
                <li class="py-1"><strong>Place of Unloading: </strong>{{ $egmhousebl->masterbl->puname }} ({{ $egmhousebl->masterbl->pucode }})</li>
                <li class="py-1"><strong>Nature: </strong>{{ $egmhousebl->masterbl->blnaturetype }} ({{ $egmhousebl->masterbl->blnaturecode }})</li>
                <li class="py-1"><strong>NOC: </strong> {{ $egmhousebl->masterbl->noc ? "NOC" : null}} </li>
                <li class="py-1"><strong>Date of Departure: </strong>{{ $egmhousebl->masterbl->departure ? date('d-m-Y', strtotime($egmhousebl->masterbl->departure)) : null}}</li>
                <li class="py-1"><strong>Date of Arrival: </strong> {{ $egmhousebl->masterbl->arrival ? date('d-m-Y', strtotime($egmhousebl->masterbl->arrival)) : null}}</li>
                <li class="py-1"><strong>Custom Office Code: </strong>{{ $egmhousebl->cofficecode }}</li>
                <li class="py-1"><strong>Line No: </strong>{{ $egmhousebl->line }}</li>
                <li class="py-1"><strong>House B/L No: </strong>{{ $egmhousebl->bolreference }}</li>
                <li class="py-1"><strong>Exporter Name: </strong>{{ $egmhousebl->exportername }}</li>
                <li class="py-1"><strong>Exporter Address: </strong>{{ $egmhousebl->exporteraddress }}</li>
                <li class="py-1"><strong>Consignee Bin: </strong>{{ $egmhousebl->consigneebin }}</li>
                <li class="py-1"><strong>Consignee Name: </strong>{{ $egmhousebl->consigneename }}</li>
                <li class="py-1"><strong>Consignee Address: </strong>{{ $egmhousebl->consigneeaddress }}</li>
            </ul>
        </div>
        <div class="col-lg-6">
            <ul>
                <li class="py-1"><strong>Notify Bin: </strong>{{ $egmhousebl->notifybin }}</li>
                <li class="py-1"><strong>Notify Name: </strong>{{ $egmhousebl->notifyname }}</li>
                <li class="py-1"><strong>Notify Address: </strong>{{ $egmhousebl->notifyaddress }}</li>
                <li class="py-1"><strong>Shipping Mark: </strong>{{ $egmhousebl->shippingmark }}</li>
                <li class="py-1"><strong>Number of Package: </strong>{{ $egmhousebl->packageno }}</li>
                <li class="py-1"><strong>Package Code: </strong>{{ $egmhousebl->packagecode }}</li>
                <li class="py-1"><strong>Package Type: </strong>{{ $egmhousebl->packagetype }}</li>
                <li class="py-1"><strong>Description: </strong>{{ $egmhousebl->description }}</li>
                <li class="py-1"><strong>Gross Weight: </strong>{{ $egmhousebl->grosswt }}</li>
                <li class="py-1"><strong>Measurement: </strong>{{ $egmhousebl->measurement }}</li>
                <li class="py-1"><strong>Container Number: </strong>{{ $egmhousebl->containernumber }}</li>
                <li class="py-1"><strong>Remarks: </strong>{{ $egmhousebl->remarks }}</li>
                <li class="py-1"><strong>Freight Status: </strong>{{ $egmhousebl->freightstatus }}</li>
                <li class="py-1"><strong>Freight Value: </strong>{{ $egmhousebl->freightvalue }}</li>
                <li class="py-1"><strong>Co-loader: </strong>{{ $egmhousebl->coloader }}</li>
                <li class="py-1"><strong>Note: </strong>{{ $egmhousebl->note }}</li>
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
            @foreach( $egmhousebl->containers as $container)
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
