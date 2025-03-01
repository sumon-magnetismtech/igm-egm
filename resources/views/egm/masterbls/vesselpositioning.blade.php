@extends('layouts.egm-layout')
@section('title', 'Vessel Positioning')

@section('breadcrumb-title', 'Vessel Positioning')

@section('breadcrumb-button')

@endsection

@section('sub-title')
    Total : {{ $masterbls->total() }}
@endsection

@section('content')
    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-2 px-1 my-1">
                <input type="text" id="mblno" name="mblno" class="form-control form-control-sm" value="{{$mblno ?? null}}" placeholder="Master B/L">
            </div>
            <div class="col-md-3 px-1 my-1">
                <input type="text" id="motherVessel" name="motherVessel" class="form-control form-control-sm text-uppercase" value="{{$motherVessel ?? null}}" placeholder="Mother Vessel">
            </div>
            <div class="col-md-4 px-1 my-1">
                <input type="text" id="vesselname" name="vesselname" class="form-control form-control-sm text-uppercase" value="{{$vessel ?? null}}" placeholder="Feeder Vessel">
            </div>
            <div class="col-md-1 px-1 my-1">
                <input type="text" id="voyage" name="voyage" list="voyageList" class="form-control form-control-sm" value="{{$voy ?? null}}" placeholder="Voyage" autocomplete="off">
                <datalist id="voyageList"></datalist>
            </div>
            <div class="col-md-2 px-1 my-1">
                <input type="text" id="rotno" name="rotno" class="form-control form-control-sm" value="{{$rotno ?? null}}" placeholder="Rotation">
            </div>
            <div class="col-md-2 px-1 my-1">
                <input type="text" id="arrivalFrom" name="arrivalFrom" class="form-control form-control-sm" data-toggle="tooltip" title="dd/mm/yyyy" value="{{$arrivalFrom ? date('d/m/Y', strtotime($arrivalFrom)) : null}}" placeholder="Arrival From">
            </div>
            <div class="col-md-2 px-1 my-1">
                <input type="text" id="arrivalTill" name="arrivalTill" class="form-control form-control-sm" data-toggle="tooltip" title="dd/mm/yyyy" value="{{$arrivalTill ? date('d/m/Y', strtotime($arrivalTill)) : null}}" placeholder="Arrival Till">
            </div>
            <div class="col-md-2 px-1 my-1">
                <input type="text" id="berthingFrom" name="berthingFrom" class="form-control form-control-sm" data-toggle="tooltip" title="dd/mm/yyyy" value="{{$berthingFrom ? date('d/m/Y', strtotime($berthingFrom)) : null}}" placeholder="Berthing From">
            </div>
            <div class="col-md-2 px-1 my-1">
                <input type="text" id="berthingTill" name="berthingTill" class="form-control form-control-sm" data-toggle="tooltip" title="dd/mm/yyyy" value="{{$berthingTill ? date('d/m/Y', strtotime($berthingTill)) : null}}" placeholder="Berthing Till">
            </div>
            <div class="col-md-3 px-1 my-1">
                <input type="text" id="principal" name="principal" class="form-control form-control-sm" data-toggle="tooltip" title="Enter Principal Name" value="{{$principal ?? null}}" placeholder="Principal Name">
            </div>
            <div class="col-md-1 px-1 my-1">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Sl</th>
                    <th>Manifest BL & ID</th>
                    <th>Mother Vessel & Voy</th>
                    <th>Feeder Vessel & Voy</th>
                    <th>NOC</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Berthing</th>
                    <th>IMP. REG</th>
                    <th>Jetty</th>
                    <th>Remarks</th>
                    <th>Carrier D/O </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Sl</th>
                    <th>Manifest BL (ID)</th>
                    <th>Mother Vessel & Voy</th>
                    <th>Feeder Vessel & Voy</th>
                    <th>NOC</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Berthing</th>
                    <th>IMP. REG</th>
                    <th>Jetty</th>
                    <th>Remarks</th>
                    <th>Carrier D/O </th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($masterbls as $key => $masterbl)
                <tr>
                    <td> {{$masterbls->firstItem()+$key}}</td>
                    <td>
                        <strong>{{$masterbl->mblno}}</strong> <br>
                        MBL ID: <strong>{{$masterbl->id}}</strong>
                        <input type="hidden" value="{{$masterbl->id}}" name="igm" class="igm">
                    </td>
                    <td style="white-space: normal">{{$masterbl->mv}}</td>
                    <td>
                        <strong>{{$masterbl->fvessel}}</strong> V.{{$masterbl->voyage}}
                        <br> A/C: {{$masterbl->principal}}
                        <input type="hidden" name="fvessel" class="fvessel" value="{{$masterbl->fvessel ?? null}}">
                        <input type="hidden" name="voyage" class="voyage" value="{{$masterbl->voyage ?? null}}">
                    </td>
                    <td> @if($masterbl->noc) <button class="btn btn-sm bg-dark p-1 m-1" disabled> NOC </button> @endif </td>

                    <td><input type="text" style="width: 80px" class="departure" name="departure" required value="{{$masterbl->departure ? date('d/m/Y', strtotime($masterbl->departure)) : null}}"></td>
                    <td><input type="text" style="width: 80px" class="arrival" name="arrival" required value="{{$masterbl->arrival ? date('d/m/Y', strtotime($masterbl->arrival)) : null}}"></td>
                    <td><input type="text" style="width: 80px" class="berthing" name="berthing" value="{{$masterbl->berthing ? date('d/m/Y', strtotime($masterbl->berthing)) : null}}"></td>
                    <td><input style="width: 80px" type="text" class="rotno" name="rotno" value="{{$masterbl->rotno ?? null}}"></td>
                    <td>
                        <input type="text" class="jetty" name="jetty" style="width: 55px" value="{{$masterbl->jetty}}">
                    </td>
                    <td>
                        <textarea name="remarks" class="remarks" cols="14" rows="2">{{$masterbl->remarks ? $masterbl->remarks : null}}</textarea>
                    </td>
                    <td> ??</td>
                    <td> <button class="btn btn-sm btn-primary updateBtn" data-toggle="tooltip" title="Update"> <i class="fas fa-sync"></i> </button> </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div> <!-- end table-responsive -->

    <div class="float-right">
        {{$masterbls->links()}}
    </div>
@endsection

@section('script')
    <script>


        $(".updateBtn").on('click', function () {
            let rotno= $(this).closest('tr').find('.rotno').val();
            let berthing= $(this).closest('tr').find('.berthing').val();
            let fvessel= $(this).closest('tr').find('.fvessel').val();
            let voyage= $(this).closest('tr').find('.voyage').val();
            let jetty= $(this).closest('tr').find('.jetty').val();
            let remarks= $(this).closest('tr').find('.remarks').val();
            let arrival= $(this).closest('tr').find('.arrival').val();
            let departure= $(this).closest('tr').find('.departure').val();
            let igm= $(this).closest('tr').find('.igm').val();
            $.ajax({
                type: 'post',
                url: '{{url("egmupdateMasterRotBerthing")}}',
                data: {
                        rotno:rotno,
                        berthing:berthing,
                        fvessel:fvessel,
                        jetty:jetty,
                        voyage:voyage,
                        arrival:arrival,
                        departure:departure,
                        igm:igm,
                        remarks:remarks,
                        _token: "{{ csrf_token() }}"},
                dataType:'html',
                success: function (Response) {
                    location.reload();
                }
            });
        });

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            $('#arrivalFrom').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});
            $('#arrivalTill').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});
            $('#berthingFrom').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});
            $('#berthingTill').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});

            $( "#mblno" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('egmLoadHouseblMblNoAutoComplete')}}",
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
                    $('#mblno').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });

            $( "#motherVessel" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('egmLoadHouseblMotherVesselAutoComplete')}}",
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
                    $('#motherVessel').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });



            $( "#vesselname" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('egmLoadHouseblFeederVesselAutoComplete')}}",
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
                    $('#vesselname').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            }).blur(function () {
                let vesselName = $(this).val();
                let dataList = $("#voyageList");
                if(vesselName != null){
                    const url = '{{url('loadHouseblVoyage')}}/'+vesselName;
                    fetch(url)
                            .then((resp) => resp.json())
                .then(function (hblno) {
                        dataList.empty();
                        hblno.forEach(function (data) {
                            dataList.append(`<option value="${data.voyage}"></option>`);
                        });
                    })
                    .catch(function () {
                        $("#voyage").val(null);
                    });
                }
            });

            $( "#principal").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('egmLoadMasterPrincipalAutoComplete')}}",
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
                    $('#principal').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });
        }); //document ready
    </script>


@endsection
