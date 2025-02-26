@extends('layouts.layout')
@section('title','E Delivery Data')
@section('content')
<div class="container-fluid">
    <div class="jumbotron py-3">
        <h2 class="font-weight-bold text-primary text-center">
            Send Request for E-Delivery
        </h2>
        @if (Session::has('message'))
            <div class="alert alert-success alert-block mb-0 text-center message" id="messageForUser">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <h4 class="alert-heading font-weight-bold"> {{ Session::get('message') }}  </h4>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="dynamicTable">
                        <tr>
                            <td>Feeder Vessel (Voy)</td>
                            <td class="{{$masterbl->fvessel ? null : "bg-warning"}}">{{$masterbl->fvessel}} ({{$masterbl->voyage}})</td>
                        </tr>
                        <tr>
                            <td>Imp Reg No</td>
                            <td class="{{$masterbl->rotno ? null : "bg-warning"}}">{{$masterbl->rotno}}</td>
                        </tr>
                        <tr>
                            <td>MBL Line No</td>
                            <td class="{{$masterbl->mloLineNo ? null : "bg-warning"}}">{{$masterbl->mloLineNo}}</td>
                        </tr>
                        <tr>
                            <td>Cargo Description</td>
                            <td class="{{$masterbl->mloCommodity ? null : "bg-warning"}}">{{$masterbl->mloCommodity}}</td>
                        </tr>
                        <tr>
                            <td>Container No</td>
                            <td>
                                @foreach($countContTypes as $key=> $countContType)
                                    {{$key}}<strong>({{($countContType)}})</strong>{{$loop->last ? null : ", "}}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>Detention Charges Upto</td>
                            <td class="{{$masterbl->freetime ? null : "bg-warning"}}">{{$masterbl->freetime}}</td>
                        </tr>
                        <tr>
                            <td>Service Mode</td>
                            <td class="{{$masterbl->contMode ? null : "bg-warning"}}">{{$masterbl->contMode}}</td>
                        </tr>
                        <tr>
                            <td>House Bill of Lading No (optional)</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>HBL Line No (optional)</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <form action="{{ route('eDeliveryData') }}" method="get">
                    @csrf
                    <div class="md-form pt-2">
                        <label for="to" class="font-weight-bold"> To </label>
                        <input id="to" class="form-control" type="text" name="to" value="sumon@magnetismtech.com" required autocomplete="off">
                    </div>
                    <input type="hidden" name="mblno" value="{{$masterbl->mblno}}">
                    <input type="hidden" name="type" value="e-frd">
                    <input type="hidden" name="freeTime" value="{{$masterbl->freeTime}}">
                    <input type="hidden" name="mloLineNo" value="{{$masterbl->mloLineNo}}">
                    <input type="hidden" name="mloCommodity" value="{{$masterbl->mloCommodity}}">
                    <input type="hidden" name="contMode" value="{{$masterbl->contMode}}">
                    <button type="submit" class="btn btn-success btn-block">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection