@extends('layouts.new-layout')
@section('title', 'Master BL - Details')

@section('breadcrumb-title', 'Master BL-Details')

@section('breadcrumb-button')
    <a href="{{route('feederinformations.index') }}" class="btn btn-out-dashed btn-sm btn-danger"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    Showing Feeder Information: {{ $feederinformation->id }}
@endsection


@section('content')
    <div class="row">
        <div class="col-lg-6">
            <ul>
                <li class="py-2"><strong> ID : </strong> {{ $feederinformation->id }} </li>
                <li class="py-2"><strong> Feeder Vessel : </strong> {{ $feederinformation->feederVessel }} </li>
                <li class="py-2"><strong> Voyage Number : </strong> {{ $feederinformation->voyageNumber }} </li>
                <li class="py-2"><strong> Custom Office Code : </strong> {{ $feederinformation->COCode }} </li>
                <li class="py-2"><strong> Custom Office Name : </strong> {{ $feederinformation->COName }} </li>
                <li class="py-2"><strong> Departure Date : </strong> {{ date('d-m-Y',strtotime($feederinformation->departureDate ))}} </li>
                <li class="py-2"><strong> Arrival Date : </strong>
                    @if(!empty($feederinformation->arrivalDate))
                        {{ date('d-m-Y',strtotime($feederinformation->arrivalDate)) }}
                    @endif
                </li>
                <li class="py-2"><strong> Berthing Date : </strong>
                    @if(!empty($feederinformation->berthingDate))
                        {{ date('d-m-Y',strtotime($feederinformation->berthingDate)) }}
                    @endif
                </li>
                <li class="py-2"><strong> Rotation No : </strong> {{ $feederinformation->rotationNo }} </li>
                <li class="py-2"><strong> Career Name : </strong> {{ $feederinformation->careerName }} </li>
                <li class="py-2"><strong> Career Address : </strong> {{ $feederinformation->careerAddress }} </li>
            </ul>
        </div> <!-- end col-lg-6 -->
        <div class="col-lg-6">
            <ul>
                <li class="py-2"><strong> Departure Port Code : </strong> {{ $feederinformation->depPortCode }} </li>
                <li class="py-2"><strong> Departure Port Name : </strong> {{ $feederinformation->depPortName }} </li>
                <li class="py-2"><strong> Destination Port Code : </strong> {{ $feederinformation->desPortCode }} </li>
                <li class="py-2"><strong> Destination Port Name : </strong> {{ $feederinformation->desPortName }} </li>
                <li class="py-2"><strong> Mode of Transport Code : </strong> {{ $feederinformation->mtCode }} </li>
                <li class="py-2"><strong> Mode of Transport Type : </strong> {{ $feederinformation->mtType }} </li>
                <li class="py-2"><strong> Nationality of Transport: </strong> {{ $feederinformation->transportNationality }} </li>
                <li class="py-2"><strong> Depot : </strong> {{ $feederinformation->depot }} </li>
                <li class="py-2"><strong> Created at : </strong> {{date('d-m-Y h:i:s',strtotime($feederinformation->created_at ))}} </li>
                <li class="py-2"><strong> Updated at : </strong> {{date('d-m-Y h:i:s',strtotime($feederinformation->updated_at)) }} </li>
            </ul>
        </div> <!-- end col-lg-6 -->
    </div>
@endsection