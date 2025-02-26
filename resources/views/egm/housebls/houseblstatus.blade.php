@extends('layouts.new-layout')
@section('title', 'HBL Tracking')

@section('breadcrumb-title', 'HBL Tracking')

@section('breadcrumb-button')

@endsection

@section('sub-title')

@endsection

@section('content')

    <form action="{{ route('houseblstatusPDF') }}" method="post">
        @csrf
        <div class="row px-2">
            <div class="col-md-1 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <select name="requestType" class="form-control form-control-sm">
                        <option value="list" selected> List </option>
                        <option value="pdf"> PDF </option>
                    </select>
                </div>
            </div>
            <div class="col-md-1 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input type="text" id="igm" name="igm" class="form-control form-control-sm" placeholder="IGM" autocomplete="off">
                </div>
            </div>
            <div class="col-md-2 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input type="text" id="mblno" name="mblno" class="form-control form-control-sm" placeholder="Master BL" autocomplete="off">
                </div>
            </div>
            <div class="col-md-4 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input id="vesselname" class="form-control form-control-sm text-uppercase" type="text" placeholder="Feeder Vessel Name" name="vesselname" autocomplete="off">
                </div>
            </div>
            <div class="col-md-1 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input id="voyage" name="voyage" list="voyageList" class="form-control form-control-sm" type="text" placeholder="Voyage" autocomplete="off">
                    <datalist id="voyageList"></datalist>
                </div>
            </div>

            <div class="col-md-3 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input id="bolreference" type="text" name="bolreference" class="form-control form-control-sm" placeholder="BOL Reference" autocomplete="off">
                </div>
            </div>
            <div class="col-md-4 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input id="container" type="text" name="container" class="form-control form-control-sm" placeholder="Container Number" autocomplete="off">
                </div>
            </div>
            <div class="col-md-4 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input id="principal" type="text" name="principal" class="form-control form-control-sm" placeholder="Principal" autocomplete="off">
                </div>
            </div>

            <div class="col-md-4 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input id="notifyname" type="text" name="notifyName" class="form-control form-control-sm" placeholder="Notify Name" autocomplete="off">
                </div>
            </div>

            <div class="col-md-4 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input id="exportername" type="text" name="exportername" class="form-control form-control-sm" placeholder="Exporter Name" autocomplete="off">
                </div>
            </div>

            <div class="col-md-8 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input id="description"  type="text" name="description" class="form-control form-control-sm" placeholder="Description" autocomplete="off">
                </div>
            </div>

            <div class="col-md-2 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input id="fromDate"  type="text" name="berthingFromDate" placeholder="Berthing From" data-toggle="tooltip" title="Format (dd/mm/yyyy)" class="form-control form-control-sm" autocomplete="off">
                </div>
            </div>

            <div class="col-md-2 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input id="tillDate"  type="text" name="berthingTillDate" placeholder="Berthing Till" data-toggle="tooltip" title="Format (dd/mm/yyyy)" class="form-control form-control-sm" autocomplete="off">
                </div>
            </div>

            <div class="col-md-2 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input id="etaFromDate"  type="text" name="etaFromDate" placeholder="ETA From" class="form-control form-control-sm" data-toggle="tooltip" title="Format (dd/mm/yyyy)" autocomplete="off">
                </div>
            </div>

            <div class="col-md-2 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input id="etaTillDate"  type="text" name="etaTillDate" placeholder="ETA Till" class="form-control form-control-sm" autocomplete="off">
                </div>
            </div>

            <div class="col-md-2 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <select name="status" class="form-control form-control-sm" data-toggle="tooltip" title="Delivery Status">
                        <option selected> All </option>
                        <option value="delivered"> Delivered </option>
                        <option value="undelivered"> Undelivered </option>
                    </select>
                </div>
            </div>
            <div class="col-md-1 px-md-1 my-1 my-md-0 d-flex align-items-end">
                <div class="border-checkbox-section">
                    <div class="border-checkbox-group border-checkbox-group-info">
                        <input type="checkbox" id="nocCheck" name="nocCheck" class="border-checkbox">
                        <label class="border-checkbox-label" for="nocCheck"> NOC </label>
                    </div>
                </div>
            </div>
            <div class="col-md-1 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <div class="input-group input-group-sm">
                        <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div><!-- end row -->
    </form>
@endsection

@section('script')
    <script>

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(document).ready(function(){
            $('#fromDate').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});
            $('#tillDate').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});
            $('#etaFromDate').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});
            $('#etaTillDate').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});


            $( "#igm").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('loadHouseblIgmAutoComplete')}}",
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
                    $('#igm').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });

            $( "#mblno" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('loadHouseblMblNoAutoComplete')}}",
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
            $( "#bolreference" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('loadHouseblBolreferenceAutoComplete')}}",
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
                    $('#bolreference').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });
            $( "#container" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('loadHouseblContainerAutoComplete')}}",
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
                    $('#container').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });

            $( "#notifyname" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('loadHouseblNotifyNameAutoComplete')}}",
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
                    $('#notifyname').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });

            $( "#description" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('loadHouseblDescriptionAutoComplete')}}",
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
                    $('#description').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });

            $( "#exportername" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('loadHouseblExporternameAutoComplete')}}",
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
                    $('#exportername').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });

            $( "#vesselname" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('loadHouseblFeederVesselAutoComplete')}}",
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
                        url:"{{route('loadMasterPrincipalAutoComplete')}}",
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

        });
    </script>
@endsection