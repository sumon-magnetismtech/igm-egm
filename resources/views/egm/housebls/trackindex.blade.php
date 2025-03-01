@extends('layouts.egm-layout')
@section('title', 'HBL Track')

@section('breadcrumb-title', 'House BL Tracking')

@section('style')
    <style>
        .table td{
            text-wrap: normal!important;
            white-space: normal;
        }
    </style>
@endsection

@section('breadcrumb-button')

@endsection

@section('sub-title')
    Total : {{count($housebls)}}
@endsection

@section('content')
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th > SL </th>
                <th > IGM </th>
                <th> MBL </th>
                <th > Line </th>
                <th> HBL </th>
                <th > NOC </th>
                <th> Feeder Ves. </th>
                <th > Quantity </th>
                <th > Arrival </th>
                <th > Berthing </th>
                <th> Rotation </th>
                <th> MLO </th>
                <th> Shipper Name </th>
                <th> Consignee Name </th>
                <th> Notify Name </th>
                <th> Container </th>
                <th > Type </th>
                <th > Sta </th>
                <th> Seal No </th>
                <th > Do No </th>
                <th > DO Date </th>
                <th > MR No </th>
                <th> Client Details </th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th> SL </th>
                <th > IGM </th>
                <th> MBL </th>
                <th > Line </th>
                <th> HBL </th>
                <th > NOC </th>
                <th> Feeder Ves. </th>
                <th > Quantity </th>
                <th > Arrival </th>
                <th > Berthing </th>
                <th> Rotation </th>
                <th> MLO </th>
                <th> Shipper Name </th>
                <th> Consignee Name </th>
                <th> Notify Name </th>
                <th> Container </th>
                <th > Type </th>
                <th > Sta </th>
                <th> Seal No </th>
                <th > Do No </th>
                <th > DO Date </th>
                <th > MR No </th>
                <th> Client Details </th>
            </tr>
            </tfoot>
            <tbody>
            @php($i=1)
            @forelse($housebls as $key => $housebl)
                @foreach($housebl->containers as $key => $container)
                    <tr class="{{$loop->parent->index % 2 == 0 ? "custom_stripe" : null}}">
                        @if($loop->first)
                            @php($totalContainer=$housebl->containers->count())
                            <td rowspan="{{$totalContainer}}"> {{$loop->parent->iteration}} </td>
                            <td rowspan="{{$totalContainer}}"> {{$housebl->masterbl->id}} </td>
                            <td rowspan="{{$totalContainer}}"> {{$housebl->masterbl->mblno}} </td>
                            <td rowspan="{{$totalContainer}}"> {{$housebl->line}} </td>
                            <td rowspan="{{$totalContainer}}"> {{$housebl->bolreference}} </td>
                            <td rowspan="{{$totalContainer}}">{{$housebl->masterbl->noc ? "NOC" : null}}</td>
                            <td rowspan="{{$totalContainer}}"> {{$housebl->masterbl->fvessel}} <br> V.{{$housebl->masterbl->voyage}} </td>
                            <td rowspan="{{$totalContainer}}"> {{$housebl->packageno}} <br>  {{$housebl->packagetype}} </td>
                            <td rowspan="{{$totalContainer}}"> {{$housebl->masterbl->arrival ? date('d/m/y', strtotime($housebl->masterbl->arrival)) : null}} </td>
                            <td rowspan="{{$totalContainer}}"> {{$housebl->masterbl->berthing ? date('d/m/y', strtotime($housebl->masterbl->berthing)) : null}} </td>
                            <td rowspan="{{$totalContainer}}"> {{$housebl->masterbl->rotno}} </td>
                            <td rowspan="{{$totalContainer}}"> {{$housebl->masterbl->mlocode}} </td>
                            <td rowspan="{{$totalContainer}}"> {{$housebl->exportername}} </td>
                            <td rowspan="{{$totalContainer}}"> {{$housebl->consigneename}} </td>
                            <td rowspan="{{$totalContainer}}"> {{$housebl->notifyname}} </td>
                        @endif

                        <td>{{$container->contref}}</td>
                        <td>{{$container->type}}</td>
                        <td>{{$container->status}}</td>
                        <td>{{$container->sealno}}</td>

                        @if($loop->first)
                            <td rowspan="{{$totalContainer}}">{{($housebl->moneyReceipt && $housebl->moneyReceipt->deliveryOrder) ? $housebl->moneyReceipt->deliveryOrder->id : "--"}}</td>
                            <td rowspan="{{$totalContainer}}">
                                <nobr>{{($housebl->moneyReceipt && $housebl->moneyReceipt->deliveryOrder) ? date('d-m-y', strtotime($housebl->moneyReceipt->deliveryOrder->issue_date)) : "--"}}</nobr>
                            </td>
                            <td rowspan="{{$totalContainer}}">
                                {{$housebl->moneyReceipt ? $housebl->moneyReceipt->id : null}}
                                <nobr>{{$housebl->moneyReceipt ? date('d-m-y', strtotime($housebl->moneyReceipt->issue_date)) : null}}</nobr>
                            </td>
                            <td rowspan="{{$totalContainer}}">{{$housebl->moneyReceipt ? $housebl->moneyReceipt->client_name ."; " .$housebl->moneyReceipt->client_mobile : "--"}}</td>
                        @endif
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="23"><h5 class="text-muted my-3"> No Data Found Based on your query. </h5></td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div> <!-- end table-responsive -->
@endsection