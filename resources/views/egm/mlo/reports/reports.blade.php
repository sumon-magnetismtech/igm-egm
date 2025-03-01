@extends('layouts.layoutMLO')
@if (\Request::is('searchinbound')) @section('title', 'Search Inbound ') @endif
@section('content')
    <div class="container-fluid">
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="text-center mb-5">
                          <h2 class="h2-responsive font-weight-bold text-primary text-uppercase">
                              @if (\Request::is('searchinbound')) Search INBOUND (LADEN) CONTAINERS @endif
                          </h2>
                    </div>
                </div>
            </div>
            @if ($message = Session::get('success'))
                <div class="col-md-12">
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                </div><br>
            @endif

            @if (\Request::is('searchinbound'))
                <div class="row">
                    <div class="col-lg-12">
                        <form class="form-inline md-form form-sm mt-0" action="{{ route('inboundlist') }}" method="post" target="_blank">
                            @csrf
                            <div class="col-md-4">
                                <div class="md-form">
                                    <input class="form-control w-100"  id="feederVessel" type="text" placeholder="Enter Vessel Name" name="feederVessel" aria-label="Enter Vessel Name" autocomplete="off" required>
                                    <label for="feederVessel">Vessel Name</label>
                                    <div id="feederList"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="md-form">
                                    <input class="form-control w-100" id="rotationNo"  type="text" placeholder="Enter Rotation Number" name="rotationNo" aria-label="Enter Rotation Number">
                                    <label for="rotationNo">Rotation Number</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="md-form">
                                    <input id="departureDate" class="form-control w-100" type="text" placeholder="Arrival Date" name="arrivalDate" aria-label="Arrival Date" autocomplete="off">
                                    <label for="departureDate">Arrival Date</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="md-form">
                                    <select name="punloading" id="punloading" class="form-control w-100" aria-label="Port Unloading" required>
                                        <option value="">Unloading Port </option>
                                        <option value="BDKAM">BDKAM</option>
                                        <option value="BDPNG">BDPNG</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-pink"><i class="fas fa-search" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>


@endsection

@section('footerscripts')
    @parent

    <script>
        
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function () {
            $('#departureDate').datepicker({format: 'dd-mm-yyyy',showOtherMonths: true});
            $('#lclFromDate').datepicker({format: 'dd-mm-yyyy',showOtherMonths: true});
            $('#lclTillDate').datepicker({format: 'dd-mm-yyyy',showOtherMonths: true});

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
                let feederVessel = $(this).val();
                let dataList = $("#voyageList");
                if(feederVessel != null){
                    const url = '{{url('voyageAutoComplete')}}/'+feederVessel;
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

            $( "#bolreference" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('bolreferenceAutoComplete')}}",
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
            });//rotation autocomplete
        });//end document ready
    </script>
@endsection
