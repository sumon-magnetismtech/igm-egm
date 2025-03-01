@extends('layouts.egm-layout')
@section('title', 'E-Delivery Request List')

@section('breadcrumb-title', 'List of E-Delivery Request')

@section('breadcrumb-button')

@endsection

@section('sub-title')
    {{--Total :--}}
@endsection

@section('content')
    <form action="" method="get" class="">
        @csrf
        <div class="row px-2">
            <div class="col-md-2 px-1 my-1">
                <input type="text" id="mblno" name="mblno" class="form-control form-control-sm" value="{{$mblno ?? ''}}" placeholder="Master BL" autocomplete="off">
            </div>
            <div class="col-md-1 px-1 my-1">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Sl. No</th>
                <th>MBL No</th>
                <th>Feeder Vessel (Voy) </th>
                <th>Imp Reg No</th>
                <th>MBL Line</th>
                <th>Cargo Description</th>
                <th>Service Mode</th>
                <th>Sent</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl. No</th>
                <th>MBL No</th>
                <th>Feeder Vessel (Voy) </th>
                <th>Imp Reg No</th>
                <th>MBL Line</th>
                <th>Cargo Description</th>
                <th>Service Mode</th>
                <th>Sent</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($masterbls as $key => $masterbl)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$masterbl->mblno}}</td>
                    <td>{{$masterbl->masterbl->fvessel ?? null}} ({{$masterbl->masterbl->voyage ?? null}})</td>
                    <td>{{$masterbl->masterbl->rotno ?? null}}</td>
                    <td>{{$masterbl->mloLineNo}}</td>
                    <td>{{$masterbl->mloCommodity}}</td>
                    <td>{{$masterbl->contMode}}</td>
                    <td>{{$masterbl->to}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="float-right">
        {{$masterbls->links()}}
    </div>
@endsection