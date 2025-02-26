@extends('layouts.egm-layout')
@section('title', 'Trashed Master BL')

@section('breadcrumb-title', 'Trashed Master BL')

@section('breadcrumb-button')
    <a href="{{ route('egmmasterbls.index') }}" class="btn btn-sm btn-warning"><i class="fas fa-database"></i> Main List</a>
@endsection

@section('sub-title')
    Total : {{ $masterbls->total() }}
@endsection

@section('content')
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Sl. No</th>
                <th>IGM </th>
                <th>NOC</th>
                <th>Master B/L No</th>
                <th>BL Nature</th>
                <th>Type</th>
                <th>Feeder Vessel</th>
                <th>Voyage</th>
                <th>Rotation</th>
                <th>Principal</th>
                <th>Origin</th>
                <th>Unloading</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>MLO</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl. No</th>
                <th>IGM </th>
                <th>NOC</th>
                <th>Master B/L No</th>
                <th>BL Nature</th>
                <th>Type</th>
                <th>Feeder Vessel</th>
                <th>Voyage</th>
                <th>Rotation</th>
                <th>Principal</th>
                <th>Origin</th>
                <th>Unloading</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>MLO</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody class="text-center">
            @foreach($masterbls as $key => $masterbl)
                <tr>
                    <td>{{$key + $masterbls->firstItem()}}</td>
                    <td><a class="btn btn-sm btn-success" href="{{url('masterbls/'.$masterbl->id)}}">{{$masterbl->id}} </a></td>
                    <td>
                        @if($masterbl->noc)
                            <button class="btn btn-sm bg-secondary text-white m-1 p-2" disabled> NOC </button>
                        @endif
                    </td>
                    <td>{{$masterbl->mblno}}</td>
                    <td>{{$masterbl->blnaturecode}} {{$masterbl->blnaturetype}}</td>
                    <td>{{$masterbl->bltypecode}}</td>
                    <td>{{$masterbl->fvessel}}</td>
                    <td>{{$masterbl->voyage}}</td>
                    <td>{{$masterbl->rotno}}</td>
                    <td>{{$masterbl->principal}}</td>
                    <td>{{$masterbl->pocode}}</td>
                    <td>{{$masterbl->pucode}}</td>
                    <td><nobr>{{$masterbl->departure ? date('d/m/Y', strtotime($masterbl->departure)) : null}}</nobr></td>
                    <td><nobr>{{$masterbl->arrival ? date('d/m/Y', strtotime($masterbl->arrival)) : null}}</nobr></td>
                    <td class="breakWords">{{$masterbl->mlocode}} {{$masterbl->mloname}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ route('mblrestore', $masterbl->id) }}" data-toggle="tooltip" title="Restore" class="btn btn-outline-primary"><i class="fas fa-trash-restore"></i></a>
                                <form action="{{ url('masterbls', [$masterbl->id]) }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="float-right">
        {!! $masterbls->links() !!}
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


        $(document).ready(function () {
            $( "#mblno" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('loadHouseblMblNoAutoComplete')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: "{{ csrf_token() }}",
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
            $( "#vesselname" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('loadHouseblFeederVesselAutoComplete')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: "{{ csrf_token() }}",
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
        });
    </script>
@endsection