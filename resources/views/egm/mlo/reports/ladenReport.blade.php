@extends('layouts.egm-layout')
@section('title', 'Laden Report')

@section('style')
    <style>
        .table td{
            white-space: normal!important;
        }
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
        .custom_stripe{
            background: rgba(0,0,0,.3);
        }

    </style>
@endsection

@section('breadcrumb-title')
    Laden Container Stock Report (OVER {{$duration ?? null}} DAYS)
@endsection


@section('breadcrumb-button')

@endsection

@section('sub-title')

@endsection

@section('content')

    <form action="{{ route('egmMloladenReport') }}" method="get">
        <div class="row px-2">
            <div class="col-md-2 px-1 my-1 my-md-0">
                <select name="requestType" class="form-control form-control-sm">
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0">
                <input type="number" id="duration" name="duration" value="{{$duration ?? 30}}" min="0" step="1" data-toggle="tooltip" title="Duration In Days" pattern="[0-9]" onkeypress="return !(event.charCode == 46)" class="form-control form-control-sm" placeholder="Duration (In Days)" autocomplete="off">
            </div>
            <div class="col-md-4 px-1 my-1 my-md-0">
                <input type="text" id="principal" name="principal" value="{{$principal ?? ""}}" class="form-control form-control-sm" placeholder="Principal Name" autocomplete="off">
            </div>

            <div class="col-md-1 px-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>


    @if($blInformations->isNotEmpty())
        <div class="table-responsive">
            <table id="miniTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th> # </th>
                    <th> BL NO </th>
                    <th> Container Num</th>
                    <th>TYPE</th>
                    <th>Imp Vessel and Voyage</th>
                    <th>ImpRegNo</th>
                    <th>Berthing</th>
                    <th>Principal</th>
                    <th>DESCRIPTION OF GOODS</th>
                    <th>QUANTITY</th>
                    <th>Current Position</th>
                    <th>Days</th>
                    <th>CONSIGNEE NAME AND ADDRESS</th>
                    <th>RESON OF NONDELIVERY CARGO</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($blInformations as $blInformation)
                    @foreach($blInformation->blcontainers as $container)
                        <tr class="{{$loop->parent->index % 2 == 0 ? "custom_stripe" : null}}">
                            @if($loop->first)
                                @php($totalContainer = $blInformation->blcontainers->count())
                                <td rowspan="{{$totalContainer}}"> {{$loop->parent->iteration}} </td>
                            @endif
                            @if($loop->first)
                                <td rowspan="{{$blInformation->blcontainers->count()}}"> <nobr>{{$blInformation->bolreference}}</nobr> </td>
                            @endif

                            <td >{{$container->contref}} </td>
                            <td >{{$container->type}} </td>
                            @if($loop->first)
                                <td rowspan="{{$totalContainer}}"> <nobr>{{$blInformation->mlofeederInformation->feederVessel}}</nobr><br>V. {{$blInformation->mlofeederInformation->voyageNumber}}</td>
                                <td rowspan="{{$totalContainer}}">{{$blInformation->mlofeederInformation->rotationNo}}</td>
                                <td rowspan="{{$totalContainer}}"><nobr>{{$blInformation->mlofeederInformation->berthingDate ? date('d-m-Y', strtotime($blInformation->mlofeederInformation->berthingDate)) : null}}</nobr></td>
                                <td rowspan="{{$totalContainer}}">{{$blInformation->principal->name}}</td>
                                <td style="width: 16.66%" rowspan="{{$totalContainer}}">{{Str::limit($blInformation->description, 100)}}</td>
                                <td rowspan="{{$totalContainer}}">{{$blInformation->packageno}}</td>
                                <td rowspan="{{$totalContainer}}">{{$blInformation->unloadingName}} <br>({{$blInformation->PUloding}})</td>
                                <td rowspan="{{$totalContainer}}">
                                    @if($blInformation->mlofeederInformation->berthingDate)
                                        <nobr>{{\Illuminate\Support\Carbon::parse($blInformation->mlofeederInformation->berthingDate)->diffInDays()}}</nobr>
                                    @endif
                                </td>
                                <td rowspan="{{$totalContainer}}">
                                    <nobr>{{$blInformation->blNotify->NAME}}</nobr> <br>
                                    {{$blInformation->blNotify->ADD1}}
                                    <nobr><strong>{{$blInformation->blNotify->BIN}}</strong></nobr>
                                </td>
                                <td rowspan="{{$totalContainer}}">??</td>
                                <td rowspan="{{$totalContainer}}">
                                    <nobr>
                                        <a target="_blank" href="{{url("blDelayNote/$blInformation->id")}}" data-toggle="tooltip" title="Add Reason" class="btn btn-success btn-sm px-3"><i class="fa fa-plus"></i></a>
                                        <a target="_blank" href="{{url("delayreasons?bolreference=$blInformation->bolreference")}}" data-toggle="tooltip" title="All Reasons"><button type="button" class="btn btn-warning btn-sm px-3"><i class="fa fa-database"></i> </button></a>
                                    </nobr>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach

                </tbody>
            </table>
        </div> <!-- end col-12 table-responsive text-nowrap -->
    @else
        <p class="bg-light py-3 text-center lead"> <strong> No DO Found based on the date/date range.  </strong> </p>
    @endif
@endsection



@section('script')
    <script>
        var CSRF_TOKEN ="{{csrf_token()}}";
        $(function(){
            $( "#principal").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('principalAutoComplete')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                select: function (event, ui) {
                    $('#principal').val(ui.item.label); // display the selected text
                    return false;
                }
            });

            var table = $('#miniTable').DataTable({
                stateSave: true,
                paging:   false,
                bFilter: false,
                info: false,
                ordering: false,

                dom: 'Bfrtip',
                buttons: ['csv', 'excel']
            });
        });
    </script>
@endsection
