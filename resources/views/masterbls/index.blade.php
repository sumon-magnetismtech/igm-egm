@extends('layouts.new-layout')
@section('title', 'Master BLs')

@section('breadcrumb-title', 'List of Master BL')

@section('breadcrumb-button')
    @can('masterbl-create')
    <a href="{{ route('masterbls.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
    @role('super-admin')
    <a href="{{ route('trashmaster') }}" class="btn btn-out-dashed btn-sm btn-danger"><i class="fas fa-trash"></i> Trash</a>
    @endrole
@endsection

@section('sub-title')
    Total : {{ $masterbls->total() }}
@endsection

@section('content')
    <form action="" method="get" class="col-12">
        <div class="row">
            <div class="col-md-1 pl-md-0 pr-md-1 mb-1">
                <input type="text" id="igm" name="igm" class="form-control form-control-sm" value="{{$igm ? $igm : null}}" onclick="this.select()" placeholder="IGM" autocomplete="off">
            </div>
            <div class="col-md-2 px-md-1 mb-1">
                <input type="text" id="mblno" name="mblno" class="form-control form-control-sm" value="{{$masterbl ?? null}}"  onclick="this.select()" placeholder="Master B/L" autocomplete="off">

            </div>
            <div class="col-md-3 px-md-1 mb-1">
                <input type="text" id="vesselname" name="fvessel" class="form-control form-control-sm" value="{{$vessel ?? null}}" onclick="this.select()" placeholder="Vessel" autocomplete="off">
            </div>
            <div class="col-md-1 px-md-1 mb-1">
                <input type="text" name="voyage" class="form-control form-control-sm" list="voyageList" value="{{$voy ?? null}}" onclick="this.select()" placeholder="Voyage" autocomplete="off">
                <datalist id="voyageList"></datalist>
            </div>
            <div class="col-md-2 px-md-1 mb-1">
                <input type="text" id="contref" name="contref" value="{{$request->contref ?? null}}" class="form-control form-control-sm" placeholder="Container">
            </div>
            <div class="col-md-1 px-md-1 mb-1">
                <select name="pucode" class="form-control form-control-sm" required data-toggle="tooltip" title="Unloading Port">
                    <option value="All" selected> All </option>
                    <option value="BDCGP"> BDCGP </option>
                    <option value="Others"> Others </option>
                </select>
            </div>
            <div class="col-md-1 px-md-1 mb-1">
                <input type="text" name="items" class="form-control form-control-sm" data-toggle="tooltip" title="Items Per Page" value="{{$items ?? 15}}" placeholder="Item" autocomplete="off">
            </div>
            <div class="col-md-1 px-md-1 mb-1">
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
                <th>Schedule</th>
                <th>MLO</th>
                <th>Containers</th>
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
                <th>Schedule</th>
                <th>MLO</th>
                <th>Containers</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @forelse($masterbls as $key => $masterbl)
                <tr>
                    <td>{{$key + $masterbls->firstItem()}}</td>
                    <td><a class="link" data-toggle="tooltip" title="Click for IGM-{{$masterbl->id}} Details" target="_blank" href="{{url('masterbls/'.$masterbl->id)}}">{{$masterbl->id}}</a></td>
                    <td>
                        @if($masterbl->noc)
                            <button class="btn btn-sm bg-primary p-1 m-0" disabled> NOC </button>
                        @endif
                    </td>
                    <td class="text-left">{{$masterbl->mblno}}</td>
                    <td>{{$masterbl->blnaturecode}} {{$masterbl->blnaturetype}}</td>
                    <td>{{$masterbl->bltypecode}}</td>
                    <td>{{$masterbl->fvessel}}</td>
                    <td>{{$masterbl->voyage}}</td>
                    <td>{{$masterbl->rotno}}</td>
                    <td>{{$masterbl->principal}}</td>
                    <td>{{$masterbl->pocode}}</td>
                    <td>{{$masterbl->pucode}}</td>
                    <td class="text-left">
                        <strong> ETD : </strong><nobr>{{$masterbl->departure ? date('d/m/Y', strtotime($masterbl->departure)) : null}}</nobr> <br>
                        <strong> ETA : </strong><nobr>{{$masterbl->arrival ? date('d/m/Y', strtotime($masterbl->arrival)) : null}}</nobr> <br>
                        <strong> ETB : </strong><nobr>{{$masterbl->berthing ? date('d/m/Y', strtotime($masterbl->berthing)) : null}}</nobr>
                    </td>                    
                    <td class="breakWords">{{$masterbl->mlocode}} {{$masterbl->mloname}}</td>
                    <td class="breakWords">
                        {{$masterbl->containers->pluck('contref')->unique()->join(', ', ', ')}}
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{url('masterbls/'.$masterbl->id)}}" data-toggle="tooltip" title="Details" class="btn btn-primary"><i class="fas fa-eye"></i></a>

                                @can('masterbl-edit')
                                <a href="{{ url('masterbls/'.$masterbl->id.'/edit') }}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                @endcan

                                @can('masterbl-delete')
                                <form action="{{ url('masterbls', [$masterbl->id]) }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                </form>
                                @endcan

                                <a href="{{ url('masterbls/unstaffingSheet/'.$masterbl->id) }}" data-toggle="tooltip" title="Unstaffing Sheet" class="btn btn-secondary"><i class="fas fa-box-open"></i></a>

                                <a href="{{ url("masterbls/downloadXml/$masterbl->id") }}" data-toggle="tooltip" title="Download XML" class="btn btn-info"><i class="fas fa-download"></i></a>

                                <a href="{{ url("masterbls/arrivalNotice/$masterbl->id") }}" data-toggle="tooltip" title="Print Arrival Notice" class="btn btn-success"><i class="far fa-envelope"></i></a>

                                <a href="{{ url('masterbls/log/'.$masterbl->id) }}" data-toggle="tooltip" title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
                            </nobr>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="16"> <h5 class="text-muted my-3"> No Data Found Based on your query. </h5> </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="float-right">
        {{$masterbls->links()}}
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