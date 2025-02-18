@extends('layouts.new-layout')
@section('title', 'Feeder Trashed List')


@section('breadcrumb-title', 'Feeder Trashed List')

@section('breadcrumb-button')
    @role('super-admin')
    <a href="{{ route('feederinformations.index') }}" class="btn btn-sm btn-warning"><i class="fas fa-database"></i> Main List</a>
    @endcan
@endsection

@section('sub-title')
    Total: {{$feederInformations->total()}}
@endsection


@section('content')
    <form action="" method="get">
        <div class="row">
            <div class="col-md-3 pr-md-1 my-1 my-md-0">
                <input type="text" id="feederVessel" name="feederVessel" class="form-control form-control-sm text-uppercase" placeholder="Vessel" autocomplete="off" >
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0">
                <input type="text" id="voyageNumber" name="voyageNumber" class="form-control form-control-sm text-uppercase" list="voyageList" placeholder="Voyage No" autocomplete="off" >
                <datalist id="voyageList"></datalist>
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0">
                <input type="text" id="rotationNo" name="rotationNo" class="form-control form-control-sm text-uppercase" placeholder="Registration No" autocomplete="off" >
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0">
                <input type="text" id="arrivalDate" name="arrivalDate" class="form-control form-control-sm" placeholder="Arrival Date" autocomplete="off">
            </div>
            <div class="col-md-1 pl-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end form row -->
    </form>
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th> SL </th>
                <th> IGM No </th>
                <th> Feeder Vessel</th>
                <th> Voyage </th>
                <th> Rotation No</th>
                <th> Departure Port (Code)</th>
                <th> Destination Port (Code)</th>
                <th> Departure Date</th>
                <th> Arrival Date</th>
                <th> Actions </th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th> SL </th>
                <th> IGM No </th>
                <th> Feeder Vessel</th>
                <th> Voyage </th>
                <th> Rotation No</th>
                <th> Departure Port (Code)</th>
                <th> Destination Port (Code)</th>
                <th> Departure Date</th>
                <th> Arrival Date</th>
                <th> Actions </th>
            </tr>
            </tfoot>

            <tbody>
                @forelse($feederInformations as $key => $feederInfo)
                    <tr>
                        <td>{{$feederInformations->firstItem()+$key}}</td>
                        <td><a href="{{url('feederinformations/'.$feederInfo->id)}}" class="btn btn-sm btn-dark-green">{{$feederInfo->id}} </a></td>
                        <td class="text-left"> {{$feederInfo->feederVessel}} </td>
                        <td class="text-left"> {{$feederInfo->voyageNumber}} </td>
                        <td> {{$feederInfo->rotationNo}} </td>
                        <td class="text-left"> {{$feederInfo->depPortName}} {{!empty($feederInfo->depPortCode) ? "($feederInfo->depPortCode)" : null}}</td>
                        <td class="text-left"> {{$feederInfo->desPortName}} {{!empty($feederInfo->desPortCode) ? "($feederInfo->desPortCode)" : null}}</td>
                        <td>{{date('d/m/Y',strtotime($feederInfo->departureDate))}}</td>
                        <td>
                            @if(!empty($feederInfo->arrivalDate))
                                {{ date('d/m/Y',strtotime($feederInfo->arrivalDate)) }}
                            @endif
                        </td>
                        <td style="text-align: left">
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{url('feederinformations/'.$feederInfo->id)}}" data-toggle="tooltip" title="Details" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ url('feederinformations/'.$feederInfo->id.'/restore') }}" class="btn btn-success">Restore</a>
                                    <a href="{{ url('feederinformations/'.$feederInfo->id.'/forceDelete') }}" class="btn btn-danger">Delete</a>
                                </nobr>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">
                            <h5 class="text-muted my-3"> No Data Found Based on your query. </h5>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="float-right">
        {{$feederInformations->links()}}
    </div>
@endsection

@section('script')
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(document).ready(function () {
            //feeder first item bl button auto focus
            $( ".addBlBtn").first().focus().addClass('bg-dark');
            $('#arrivalDate').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});

            $( "#feederVessel" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('feederNameAutoComplete')}}",
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
                    $('#feederVessel').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            }).blur(function () {
                let vesselName = $(this).val();
                let dataList = $("#voyageList");
                if(vesselName != null){
                    const url = '{{url('voyageAutoComplete')}}/'+vesselName;
                    fetch(url)
                            .then((resp) => resp.json())
                .then(function (hblno) {
                        dataList.empty();
                        hblno.forEach(function (data) {
                            dataList.append(`<option value="${data.voyageNumber}"></option>`);
                        });
                    })
                            .catch(function () {
                                $("#voyageNumber").val(null);
                            });
                }
            });//vessel autocomplete

            $( "#rotationNo" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('rotationNoAutoComplete')}}",
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
                    $('#rotationNo').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });//rotation autocomplete

            $(".moreButtonsSwitch").on('click', function(){
                $(this).parents('td').find('.fa-chevron-down').toggleClass('fa-chevron-up');
                $(this).parents('td').find('.moreButtons').toggleClass('d-none');
            });


        }); //document.ready


    </script>

@endsection