@extends('layouts.new-layout')
@section('title', 'Export Det')

@section('breadcrumb-title', "Showing Feeder Vessel No: $export->id")

@section('breadcrumb-button')
    <a href="{{ route('stfcontainerlist') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    <a href="{{route('exports.index') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-database"></i></a>
@endsection

@section('sub-title')
    {{--Total: {{$moneyReceipts ? $moneyReceipts->total() : 0}}--}}
@endsection

@section('content')

<div class="container">
    <div class="jumbotron">
        <div class="row">
            <div class="col-lg-6">
                <ul>
                    <li><strong> Vessel Name : </strong> {{$export->vesselName}}</li>
                    <li><strong> Vessel Code : </strong> {{$export->vesselCode}}</li>
                    <li><strong> Export Date : </strong> {{($export->exportDate) ? date('d-m-Y', strtotime($export->exportDate)) : null}}</li>
                    <li><strong> Voyage No : </strong> {{$export->voyageNo}}</li>
                    <li><strong> Rotation No : </strong> {{$export->rotationNo}}</li>
                    <li><strong> Sailing Date : </strong> {{($export->sailingDate) ? date('d-m-Y', strtotime($export->sailingDate)) : null}}</li>
                    <li><strong> ETA Date : </strong> {{($export->etaDate) ? date('d-m-Y', strtotime($export->etaDate)) : null}}</li>
                    <li><strong> E-Status : </strong> {{$export->eStatus}}</li>
                    <li><strong> Commodity : </strong> {{$export->commodity}}</li>
                    <li><strong> Destination : </strong> {{$export->destination}}</li>
                    <li><strong> Seal No : </strong> {{$export->sealNo}}</li>
                    <li><strong> TranshipmentPort : </strong> {{$export->transhipmentPort}}</li>
                    <li><strong> Remarks : </strong> {{$export->remarks}}</li>
                </ul>
            </div> <!-- end col-lg-6 -->

            <div class="col-lg-6 bg-light">
                <div class="py-2">
                    <h3 class="text-center mb-4"><strong>Containers List</strong></h3>
                    @foreach($export->exportContainers as $key => $container)
                        <span class="bafdge badge-pill badge-primary p-2 rounded-0">{{$container->contRef}}</span>
                    @endforeach
                </div>
            </div> <!-- end col-lg-6 -->

        </div> <!-- end row -->
    </div> <!-- end jumbotron -->
</div> <!-- end container -->
@endsection


