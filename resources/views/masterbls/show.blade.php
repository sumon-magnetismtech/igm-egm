@extends('layouts.new-layout')
@section('title', 'Master BL - Details')

@section('breadcrumb-title', 'Master BL-Details')

@section('breadcrumb-button')
    <a href="{{ route('masterbls.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    <a href="{{ route('masterbls.index') }}" class="btn btn-out-dashed btn-sm btn-danger"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    Showing Master BL: {{ $masterbl->mblno }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6">
        <ul>
            <li class="py-2"><strong>IGM No:</strong> {{ $masterbl->id }}</li>
            <li class="py-2"><strong>NOC:</strong> {{ $masterbl->noc ? "NOC" : null}}</li>
            <li class="py-2"><strong>Custom Office:</strong> {{ $masterbl->cooficecode }} {{ $masterbl->cofficename }}</li>
            <li class="py-2"><strong>Master B/L No:</strong> {{$masterbl->mblno}}</li>
            <li class="py-2"><strong>BOL Nature:</strong> {{ $masterbl->blnaturecode }} {{ $masterbl->blnaturetype }}</li>
            <li class="py-2"><strong>BOL Type:</strong> {{ $masterbl->bltypecode }} {{ $masterbl->bltypename }}</li>
            <li class="py-2"><strong>Feeder Vessel:</strong> {{ $masterbl->fvessel }}</li>
            <li class="py-2"><strong>Voyage:</strong> {{ $masterbl->voyage }}</li>
            <li class="py-2"><strong>Principal:</strong> {{ $masterbl->principal }}</li>
            <li class="py-2"><strong>Place of Origin:</strong> {{ $masterbl->pocode }} {{ $masterbl->poname }}</li>
            <li class="py-2"><strong>Place of Unloading:</strong> {{ $masterbl->pucode }} {{ $masterbl->puname }}</li>
            <li class="py-2"><strong>Carrier Name:</strong> {{$masterbl->carrier}}</li>
            <li class="py-2"><strong>Carrier Address:</strong> {{$masterbl->carrieraddress}}</li>
        </ul>
    </div>

    <div class="col-lg-6">
        <ul>
            <li class="py-2"><strong>Depot:</strong> {{$masterbl->depot}}</li>
            <li class="py-2"><strong>Rotation:</strong> {{$masterbl->rotno}}</li>
            <li class="py-2"><strong>Mother Vessel Name:</strong> {{$masterbl->mv}}</li>
            <li class="py-2"><strong>Free Time:</strong> {{$masterbl->freetime ? "$masterbl->freetime Day(s)": null}}</li>
            <li class="py-2"><strong>Departure:</strong> {{$masterbl->departure ? date('d/m/Y', strtotime($masterbl->departure)) : null}}</li>
            <li class="py-2"><strong>Arrival:</strong> {{$masterbl->arrival ? date('d/m/Y', strtotime($masterbl->arrival)) : null}}</li>
            <li class="py-2"><strong>Berthing:</strong> {{$masterbl->berthing ? date('d/m/Y', strtotime($masterbl->berthing)) : null}}</li>
            <li class="py-2"><strong>MLO:</strong> {{$masterbl->mlocode}} {{$masterbl->mloname}}</li>
            <li class="py-2"><strong>MLO Address:</strong> {{$masterbl->mloaddress}}</li>
        </ul>
    </div>
</div>
@endsection