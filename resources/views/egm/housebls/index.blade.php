@extends('layouts.egm-layout')
@section('title', 'List of House BLs')

@section('breadcrumb-title', 'List of House BL')

@section('breadcrumb-button')
    @can('egmhousebl-create')
    <a href="{{ route('egmhousebls.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
    <button type="button" class="btn btn-out-dashed btn-sm btn-warning d-none" id="bulkPrintBtn"> Bulk Print </button>
@endsection

@section('sub-title')
{{--    Total house BL Entries: {{ count($housebls)}};--}}
    @if($grossWeight)
        <span class="text-success">Quantity: {{ $quantity}};</span>
        <span class="text-danger">Gross Weight: {{ $grossWeight}};</span>
    @endif
@endsection

@section('content')
    <form action="" method="get">
        <div class="row">
            <div class="col-md-2 pr-md-1 my-1 my-md-0">
                <input type="text" id="igm" name="igm" class="form-control form-control-sm" value="{{$igm ?? ""}}" placeholder="IGM" autocomplete="off" autofocus>
            </div>
            <div class="col-md-3 px-md-1 my-1 my-md-0">
                <input type="text" id="mblno" name="mblno" class="form-control form-control-sm" value="{{$masterbl ?? ""}}" placeholder="Master B/L" autocomplete="off">
            </div>
            <div class="col-md-3 px-md-1 my-1 my-md-0">
                <input type="text" id="bolreference" name="housebl" class="form-control form-control-sm" value="{{$hbl ?? ""}}" placeholder="House B/L" autocomplete="off">
            </div>
            <div class="col-md-4 pl-md-1 my-1 my-md-0">
                <input type="text" id="contref" name="contref" class="form-control form-control-sm" placeholder="Container" value="{{$contref ?? null}}">
            </div>

            <!-- second row -->
            <div class="col-md-3 pr-md-1 my-1 my-md-0">
                <input type="text" id="notify_id" name="notify_id" list="consigneeBins" value="{{$request->notify_id ?? null}}" class="form-control form-control-sm mt-1" placeholder="Notify BIN" autocomplete="off">
                <datalist id="consigneeBins">
                    @foreach($consigneenames as $key => $consigneename)
                        <option> {{$key}}</option>
                    @endforeach
                </datalist>
            </div>
            <div class="col-md-3 px-md-1 my-1 my-md-0">
                <input type="text" id="notifyname" name="notifyname" value="{{$request->notifyname ?? null}}" class="form-control form-control-sm mt-1" placeholder="Notify Party Name">
            </div>
            <div class="col-md-6 pl-md-1 my-1 my-md-0">
                <input type="text" id="description" name="description" value="{{$request->description ?? null}}" class="form-control form-control-sm mt-1" placeholder="Description" autocomplete="off">
            </div>
            <div class="col-md-4 pr-md-1 my-md-0 d-flex align-items-end mt-1">
                <div class="border-checkbox-section">
                    <div class="border-checkbox-group border-checkbox-group-primary">
                        <input type="checkbox" id="note" name="note" class="border-checkbox" @if($note) checked @endif>
                        <label class="border-checkbox-label pl-4 mx-1 text-primary" for="note">DO Note</label>
                    </div>
                    <div class="border-checkbox-group border-checkbox-group-success">
                        <input type="checkbox" id="blNote" name="blNote" class="border-checkbox" @if($blNote) checked @endif>
                        <label class="border-checkbox-label pl-4 mx-1 text-success" for="blNote">BL Note</label>
                    </div>
                    <div class="border-checkbox-group border-checkbox-group-danger">
                        <input type="checkbox" id="dgCheck" name="dgCheck" class="border-checkbox" @if($dgCheck) checked @endif>
                        <label class="border-checkbox-label pl-4 mx-1 text-danger" for="dgCheck">DG</label>
                    </div>
                    <div class="border-checkbox-group border-checkbox-group-info">
                        <input type="checkbox" id="nocCheck" name="nocCheck" class="border-checkbox" @if($noc) checked @endif >
                        <label class="border-checkbox-label pl-4 mx-1 text-info" for="nocCheck"> NOC </label>
                    </div>
                </div>
            </div>


            <div class="col-md-1 px-md-1 my-1 my-md-0">
                <input type="text" name="items" class="form-control form-control-sm mt-1" data-toggle="tooltip" title="Items Per Page" value="{{$items ?? 15}}" placeholder="Item" autocomplete="off">
            </div>
            <div class="col-md-1 pl-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block mt-1"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end form row -->
    </form> <!-- end search form -->
    <form action="{{url('egmprinthousebl')}}" method="get" id="houseBlForm">
        @csrf
        <div class="table-responsive">
            <table id="containerTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th id="turnOff"> <input type="checkbox" id="bulkEditAll" class="bulkEditAll"> </th>
                    <th>Edit</th>
                    <th>Line</th>
                    <th>IGM</th>
                    <th>Master BL</th>
                    <th>House BL No</th>
                    <th>Pkg</th>
                    <th>Type</th>
                    <th>G. Wt</th>
                    <th>NOC</th>
                    <th>DG</th>
                    <th>BL Note</th>
                    <th>Schedule</th>
                    <th>Description</th>
                    <th>Consignee</th>
                    <th>Notify</th>
                    <th>Cont.</th>
                    <th>Container No</th>
                    <th>Seal</th>
                    <th>Size</th>
                    <th>Mode</th>
                    <th>MR</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                    @forelse($housebls as $housebl)
                    <tr class="{{$housebl->containernumber > 1 ? 'bg-info' : null}}">
                        <td>
                            <input type="hidden" name="igm" value="{{$housebl->igm}}">
                            <input type="checkbox" class="singleCheck" name="id[]" value="{{$housebl->id}}">
                        </td>
                        <td>
                            <div class="icon-btn">
                                @can('egmhousebl-edit')
                                <a href="{{ url('egmhousebls/'.$housebl->id.'/edit') }}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                            </div>
                        </td>
                        <td>{{$housebl->line}}</td>
                        <td>
                            <a class="link" data-toggle="tooltip" title="Click for IGM-{{$housebl->igm}} Details" target="_blank" href="{{url('masterbls/'.$housebl->igm)}}">{{$housebl->igm}}</a>
                        </td>
                        <td>{{$housebl->masterbl->mblno}}</td>
                        <td>{{$housebl->bolreference}}</td>
                        <td>{{$housebl->packageno}}</td>
                        <td>{{$housebl->packagecode}}</td>
                        <td>{{$housebl->grosswt}}</td>
                        <td>
                            @if($housebl->masterbl->noc)
                                <button class="btn btn-sm bg-primary p-1 m-0" disabled> NOC </button>
                            @endif
                        </td>
                        <td>
                            @if($housebl->dg)
                                <button class="btn btn-sm bg-danger p-1 m-0" disabled> DG </button>
                            @endif
                        </td>
                        <td>
                            @if($housebl->blNote)
                                <button class="btn btn-sm bg-warning p-1 m-0" disabled> BL Note </button>
                            @endif
                        </td>
                        <td class="text-left">
                            <nobr><strong>ETD</strong>: {{$housebl->masterbl->departure ? date('d/m/Y', strtotime($housebl->masterbl->departure)) : null}}</nobr> <br>
                            <nobr><strong>ETA</strong>: {{$housebl->masterbl->arrival ? date('d/m/Y', strtotime($housebl->masterbl->arrival)) : null}}</nobr> <br>
                            <nobr><strong>ETB</strong>: {{$housebl->masterbl->berthing ? date('d/m/Y', strtotime($housebl->masterbl->berthing)) : null}}</nobr>
                        </td>
                        <td class="breakWords" style="max-width: 180px; min-width: 180px; font-size:10px">
                            {{$housebl->description}}
                        </td>
                        <td class="breakWords" style="max-width: 120px; min-width: 120px; font-size:10px">
                            <strong>{{$housebl->consigneename}}</strong> <br>
                            {{$housebl->consigneebin}}
                        </td>
                        <td class="breakWords" style="max-width: 120px; min-width: 120px; font-size:10px">
                            <strong>{{$housebl->notifyname}}</strong> <br>
                            {{$housebl->notifybin}}
                        </td>
                        <td>{{$housebl->containernumber}}</td>
                        
                        <td class="text-uppercase">{!! $housebl->containers->pluck('contref')->join("<br>") !!} </td>
                        <td class="text-uppercase">{!! $housebl->containers->pluck('sealno')->join("<br>") !!} </td>
                        <td class="text-uppercase">{!! $housebl->containers->pluck('type')->join("<br>") !!} </td>
                        <td class="text-uppercase">{!! $housebl->containers->pluck('status')->join("<br>") !!} </td>

                        <td>
                            @if($housebl->moneyReceipt)
                                <button class="btn btn-sm bg-success" disabled> <i class="fas fa-check"></i> </button>
                            @endif
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{url('egmhousebls/'.$housebl->id)}}" data-toggle="tooltip" title="Details" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                    @can('housebl-edit')
                                    <a href="{{ url('egmhousebls/'.$housebl->id.'/edit') }}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                    @endcan

                                    @can('housebl-delete')
                                    <form action="{{ route('egmhousebls.destroy', [$housebl->id]) }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                    @endcan
                                    <a href="{{ route('hblPdf',$housebl->id) }}" data-toggle="tooltip" title="Print" class="btn btn-success"><i class="fas fa-print"></i></a>
                                    <a href="{{ url('egmhousebls/log/'.$housebl->id) }}" data-toggle="tooltip" title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
                                </nobr>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="22">
                                <h5 class="text-muted my-3"> No Data Found Based on your query. </h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div> <!-- end table-responsive -->
    </form>
    <div class="float-right">
        @if(empty($igm))
            {!! $housebls->appends(\Illuminate\Support\Facades\Request::except('page'))->render() !!}
        @endif
    </div> <!-- end paginate float-right -->
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


        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(document).ready(function () {
            $('.bulkEditAll').click(function() {
                var checkedStatus = this.checked;
                $('#containerTable').find('.singleCheck').each(function() {
                    $(this).prop('checked', checkedStatus);

                    if($(this).prop("checked") == true){
                        $("#bulkPrintBtn").addClass('d-inline')
                    }
                    else if($(this).prop("checked") == false){
                        $("#bulkPrintBtn").removeClass('d-inline')
                    }
                });
            });

            $('.singleCheck').click(function(){
                let total = $('.singleCheck').length;
                let totalChecked = $('.singleCheck:checked').length;

                if(totalChecked > 0){
                    $("#bulkPrintBtn").addClass('d-inline');
                }else{
                    $("#bulkPrintBtn").removeClass('d-inline');
                }

                if(total == totalChecked){
                    $('#bulkEditAll').prop('checked', true);
                }else{
                    $('#bulkEditAll').prop('checked', false);
                }
            });

            $("#bulkPrintBtn").on('click', function () {
                $("#houseBlForm:first").submit();
            });

            $( "#igm").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('egmLoadHouseblIgmAutoComplete')}}",
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
            $( "#bolreference" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('egmLoadHouseblBolreferenceAutoComplete')}}",
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

            $("#notify_id").change(function(){
                let url ='{{url("getBin")}}/'+$('#notify_id').val();
                fetch(url)
                    .then((resp) => resp.json())
            .then(function(notifybin) {
                    $('#notifyname').val(notifybin.binName);
                })
                    .catch(function () {
                        $('#notifyname').val(null);
                    });
            });

            $("#notifyname").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('binDataByNameAutoComplete')}}",
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
                    $('#notifyname').val(ui.item.name); // display the selected text
                    $('#notify_id').val(ui.item.bin); // display the selected text
                    return false;
                }
            });

        });//document.ready



    </script>
@endsection