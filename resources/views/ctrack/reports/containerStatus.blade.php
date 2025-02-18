@extends('layouts.new-layout')
@section('title', 'Container Status')

@section('breadcrumb-title', "Container Status")

@section('breadcrumb-button')
    {{--<a href="{{ route('moneyreceipts.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>--}}
@endsection

@section('sub-title')
    @if(!empty($container))<strong>{{$container}}</strong>@endif
{{--    Total: {{$moneyReceipts ? $moneyReceipts->total() : 0}}--}}
@endsection


@section('style')
    <style>
        #importInfo th{
            width:160px;
        }
        .table-hover tr:hover{
            background: #bfbfbf !important;
            cursor: pointer;
        }

    </style>
@endsection

@section('content')
    <div class="col-12">
        <form class="" action="{{ route('containerStatus') }}" method="get">
            @csrf
            <div class="row">
                <div class="col-md-3 px-md-1 my-1 my-md-0">
                    <input id="contRef" list="contRefList" class="form-control form-control-sm" value="{{!empty($container) ? $container : null}}" placeholder="Enter Container Ref Here" type="text" name="contRef" autocomplete="off">
                    <datalist id="contRefList">
                        @foreach($containers as $container)
                            <option> {{$container}} </option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-md-1 pl-md-1 my-1 my-md-0">
                    <div class="input-group input-group-sm">
                        <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div> <!-- end row -->
        </form>
    </div>

    <div class="row">
        @if(!empty($importInfo))
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header deep-orange lighten-1 white-text"><h5 class="text-center">Import Information</h5></div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm table-hover" id="importInfo">
                            <tbody>
                            <tr>
                                <th> MLO Name </th>
                                <td> {{$importInfo->mloblinformation->mloname}} </td>
                            </tr>
                            <tr>
                                <th> Size </th>
                                <td> {{$importInfo->type}}</td>
                            </tr>
                            <tr>
                                <th> Common Landing Date </th>
                                <td> {{$importInfo->mloblinformation->mlofeederInformation->berthingDate ? date('d-m-Y', strtotime($importInfo->mloblinformation->mlofeederInformation->berthingDate)) : null}} </td>
                            </tr>
                            <tr>
                                <th> Free Time Date</th>
                                <td> {{$moneyReceipt ? $moneyReceipt->freeTime : null}} </td>
                            </tr>
                            <tr>
                                <th> Vessel Code </th>
                                <td> {{$importInfo->mloblinformation->mlofeederInformation->COCode}} </td>
                            </tr>
                            <tr>
                                <th> Vessel Name </th>
                                <td> {{$importInfo->mloblinformation->mlofeederInformation->feederVessel}} </td>
                            </tr>
                            <tr>
                                <th> Voyage </th>
                                <td> {{$importInfo->mloblinformation->mlofeederInformation->voyageNumber}}</td>
                            </tr>
                            <tr>
                                <th> Rot. No </th>
                                <td>{{$importInfo->mloblinformation->mlofeederInformation->rot1001}} </td>
                            </tr>
                            <tr>
                                <th>Seal No</th>
                                <td>{{$importInfo->sealno}}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{$importInfo->status}}</td>
                            </tr>
                            <tr>
                                <th>Gross Weight</th>
                                <td>{{$importInfo->grosswt}}</td>
                            </tr>
                            <tr>
                                <th>Net Weight</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Position</th>
                                <td>MPB</td>
                            </tr>
                            <tr>
                                <th>Port of Origin</th>
                                <td>{{$importInfo->mloblinformation->pOriginName}}({{$importInfo->mloblinformation->pOrigin}})</td>
                            </tr>
                            <tr>
                                <th>Commodity</th>
                                <td>{{$importInfo->commodity}}</td>
                            </tr>
                            <tr>
                                <th> Empty Date </th>
                                <td> {{$clientKept ? date('d-m-Y', $clientKept->emptyDate) : '- - - -'}} </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card -->
            </div>

            @if(!empty($exportInfo))
                <div class="col-md-6 mt-3">
                    <div class="card">
                        <div class="card-header success-color lighten-1 white-text"><h5 class="text-center"> Export Information</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-bordered table-striped table-sm table-hover" id="importInfo">
                                    <tbody>
                                    <tr>
                                        <th> Vessel Code </th>
                                        <td> {{$exportInfo->export->vesselCode}} </td>
                                    </tr>
                                    <tr>
                                        <th>Vessel Name</th>
                                        <td>{{$exportInfo->export->vesselName}}</td>
                                    </tr>
                                    <tr>
                                        <th>Voyage</th>
                                        <td>{{$exportInfo->export->voyageNo}}</td>
                                    </tr>
                                    <tr>
                                        <th>Rot. No.</th>
                                        <td>{{$exportInfo->export->rotationNo}}</td>
                                    </tr>
                                    <tr>
                                        <th>Sailing Date</th>
                                        <td>{{$exportInfo->export->sailingDate ? date('d-m-Y', strtotime($exportInfo->export->sailingDate)) : null}}</td>
                                    </tr>
                                    <tr>
                                        <th>ETA Date</th>
                                        <td>{{$exportInfo->export->etaDate ? date('d-m-Y', strtotime($exportInfo->export->etaDate)) : null}}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{$exportInfo->export->eStatus}}</td>
                                    </tr>
                                    <tr>
                                        <th>Destination</th>
                                        <td>{{$exportInfo->export->destination}}</td>
                                    </tr>
                                    <tr>
                                        <th>Seal No</th>
                                        <td>{{$exportInfo->export->sealNo}}</td>
                                    </tr>
                                    <tr>
                                        <th>Commodity</th>
                                        <td>{{$exportInfo->export->commodity}}</td>
                                    </tr>
                                    <tr>
                                        <th>Transhipment Port</th>
                                        <td>{{$exportInfo->export->transhipmentPort}}</td>
                                    </tr>
                                    <tr>
                                        <th>Remarks</th>
                                        <td>{{$exportInfo->export->remarks}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(count($importInfo->emptyContainers)>0)
                <div class="col-md-6 mt-3">
                    <div class="card">
                        <div class="card-header success-color lighten-1 white-text"><h5 class="text-center"> Movement Information </h5></div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-bordered table-striped table-sm table-hover" id="importInfo">
                                    <thead>
                                    <tr class="text-center bg-info">
                                        <th>#</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Aging</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($importInfo->emptyContainers as $key=>$movement)
                                        <tr class="text-center">
                                            <td> {{$key+1}} </td>
                                            <td> {{Str::title($movement->containerStatus)}} </td>
                                            <td> {{$movement->date}} </td>
                                            <td class="text-left"> {{$movement->location}}{{$movement->depoName ? "($movement->depoName)" : null}} </td>
                                            <td>
                                                @php
                                                $date=\Carbon\Carbon::parse($movement->date);

                                                @endphp
                                                @if(!$loop->last)
                                                    @php
                                                    $outDate =\Carbon\Carbon::parse($importInfo->emptyContainers[$key+1]->date);
                                                    @endphp
                                                    <strong>{{$date->diffInDays($outDate, false)+1}}</strong> Day(s)
                                                    <br>
                                                @endif
                                                @if($loop->last)
                                                    <strong>{{\Carbon\Carbon::now()->diffInDays($date)+1}}</strong> Day(s)
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($importInfo)
                <div class="col-md-6 mt-3">
                    <div class="card">
                        <div class="card-header danger-color lighten-1 white-text"><h5 class="text-center"> Current Status </h5></div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-bordered table-striped table-sm table-hover" id="importInfo">
                                    <tbody>
                                    <tr>
                                        <th> Depot Used </th>
                                        <td> {{$importInfo->mloblinformation->mloname}} </td>
                                    </tr>
                                    <tr>
                                        <th> Present Position </th>
                                        <td> {{ucfirst($importInfo->containerStatus)}} </td>
                                    </tr>
                                    <tr>
                                        <th> Demurrage </th>
                                        <td> {{!empty($demurrage) ? $demurrage : null}} Day(s) </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        @else
            <div class="col-md-12">
                <p class="bg-light py-3 text-center lead"> <strong> No DO Found based on the date/date range.  </strong> </p>
            </div>
        @endif
    </div>
@endsection

@section('script')
    @parent
    <script>
        $(function(){

        });//document.ready

    </script>
@endsection
