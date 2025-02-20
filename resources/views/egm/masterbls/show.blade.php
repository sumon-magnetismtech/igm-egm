@extends('layouts.egm-layout')
@section('title', 'Master BL - Details')

@section('breadcrumb-title', 'Master BL-Details')

@section('breadcrumb-button')
    <a href="{{ route('egmmasterbls.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    <a href="{{ route('egmmasterbls.index') }}" class="btn btn-out-dashed btn-sm btn-danger"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    Showing Master BL: {{ $egmmasterbl->mblno }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6">
        <ul>
            <li class="py-2"><strong>IGM No:</strong> {{ $egmmasterbl->id }}</li>
            <li class="py-2"><strong>NOC:</strong> {{ $egmmasterbl->noc ? "NOC" : null}}</li>
            <li class="py-2"><strong>Custom Office:</strong> {{ $egmmasterbl->cooficecode }} {{ $egmmasterbl->cofficename }}</li>
            <li class="py-2"><strong>Master B/L No:</strong> {{$egmmasterbl->mblno}}</li>
            <li class="py-2"><strong>BOL Nature:</strong> {{ $egmmasterbl->blnaturecode }} {{ $egmmasterbl->blnaturetype }}</li>
            <li class="py-2"><strong>BOL Type:</strong> {{ $egmmasterbl->bltypecode }} {{ $egmmasterbl->bltypename }}</li>
            <li class="py-2"><strong>Feeder Vessel:</strong> {{ $egmmasterbl->fvessel }}</li>
            <li class="py-2"><strong>Voyage:</strong> {{ $egmmasterbl->voyage }}</li>
            <li class="py-2"><strong>Principal:</strong> {{ $egmmasterbl->principal }}</li>
            <li class="py-2"><strong>Place of Origin:</strong> {{ $egmmasterbl->pocode }} {{ $egmmasterbl->poname }}</li>
            <li class="py-2"><strong>Place of Unloading:</strong> {{ $egmmasterbl->pucode }} {{ $egmmasterbl->puname }}</li>
            <li class="py-2"><strong>Carrier Name:</strong> {{$egmmasterbl->carrier}}</li>
            <li class="py-2"><strong>Carrier Address:</strong> {{$egmmasterbl->carrieraddress}}</li>
        </ul>
    </div>

    <div class="col-lg-6">
        <ul>
            <li class="py-2"><strong>Depot:</strong> {{$egmmasterbl->depot}}</li>
            <li class="py-2"><strong>Rotation:</strong> {{$egmmasterbl->rotno}}</li>
            <li class="py-2"><strong>Mother Vessel Name:</strong> {{$egmmasterbl->mv}}</li>
            <li class="py-2"><strong>Free Time:</strong> {{$egmmasterbl->freetime ? "$egmmasterbl->freetime Day(s)": null}}</li>
            <li class="py-2"><strong>Departure:</strong> {{$egmmasterbl->departure ? date('d/m/Y', strtotime($egmmasterbl->departure)) : null}}</li>
            <li class="py-2"><strong>Arrival:</strong> {{$egmmasterbl->arrival ? date('d/m/Y', strtotime($egmmasterbl->arrival)) : null}}</li>
            <li class="py-2"><strong>Berthing:</strong> {{$egmmasterbl->berthing ? date('d/m/Y', strtotime($egmmasterbl->berthing)) : null}}</li>
            <li class="py-2"><strong>MLO:</strong> {{$egmmasterbl->mlocode}} {{$egmmasterbl->mloname}}</li>
            <li class="py-2"><strong>MLO Address:</strong> {{$egmmasterbl->mloaddress}}</li>
        </ul>
    </div>
</div>
@endsection