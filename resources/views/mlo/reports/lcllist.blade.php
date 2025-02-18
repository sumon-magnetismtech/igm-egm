@extends('layouts.layoutMLO')
@section('title','LCL Container List')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="float-left">
                <h2 class="h2-responsive font-weight-bold text-primary"> List of LCL Containers </h2>
            </div>
        </div>
    </div> <!-- end row -->
    @if (Session::has('success'))
        <div class="alert alert-danger">{{ Session::get('success') }}</div>
        @endif

        <div class="row">
            <div class="col-4">
            <h6 class="h6 blue-text"> Total LCL: <strong>{{ count($feederBasedOnStatus) }}</strong></h6>
        </div>
    </div>

    <div class="row">
        <div class="col-12 table-responsive text-nowrap">
            <table class="table table-striped table-bordered">
                <thead class="indigo white-text text-center">
                    <tr>
                        <th> SL </th>
                        <th> IGM No </th>
                        <th> BOL </th>
                        <th> Feeder Vessel</th>
                        <th> Arrival Date </th>
                        <th> Actions </th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @php $i = 1; @endphp
                    @if(count($feederBasedOnStatus) > 0)
                    @foreach($feederBasedOnStatus as $key => $feederInfo)
                        <tr>
                            <td>{{$i++}}</td>
                            <td> {{$feederInfo->mlofeederInformation->id}} </td>
                            <td> {{$feederInfo->bolreference}} </td>
                            <td> {{$feederInfo->mlofeederInformation->feederVessel}} </td>
                            <td>
                                @if(!empty($feederInfo->mlofeederInformation->arrivalDate))
                                    {{date('d-m-yy', strtotime($feederInfo->mlofeederInformation->arrivalDate))}}
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                    <a href="{{url('lclcontainer/'.$feederInfo->id)}}"> <button type="button" class="btn btn-primary btn-sm">Show</button></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="6">
                                {{"Sorry no data found based on the information given."}}
                            </td>
                        </tr>
                    @endif
                </tbody>
                <thead class="indigo white-text text-center">
                <tr>
                    <th> SL </th>
                    <th> IGM No </th>
                    <th> BOL </th>
                    <th> Feeder Vessel</th>
                    <th> Arrival Date </th>
                    <th> Actions </th>
                </tr>
                </thead>
            </table>
        </div> <!-- end col-12 table-responsive text-nowrap -->
    </div> <!-- end row -->
</div> <!-- end container -->

@endsection

