@extends('layouts.new-layout')
@section('title', 'List of Delivery Order')

@section('breadcrumb-title', 'List of Delivery Order')

@section('breadcrumb-button')
    @can('deliveryorder-create')
    <a href="{{ route('deliveryorders.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{$Donos ? $Donos->total() : 0}}
@endsection

@section('content')
    <form action="" method="get">
        <div class="row">
            <div class="col-md-2 pr-md-1 my-1 my-md-0">
                <input type="text" name="do_id" class="form-control form-control-sm" value="{{$request->do_id ?? ""}}" placeholder="DO ID" autocomplete="off">
            </div>
            <div class="col-md-2 pr-md-1 my-1 my-md-0">
                <input type="text" name="mr_id" class="form-control form-control-sm" value="{{$request->mr_id ?? ""}}" placeholder="MR ID" autocomplete="off">
            </div>
            <div class="col-md-2 pr-md-1 my-1 my-md-0">
                <input type="text" name="BE_No" class="form-control form-control-sm" value="{{$request->BE_No ?? ""}}" placeholder="BE NO" autocomplete="off">
            </div>
            <div class="col-md-3 px-md-1 my-1 my-md-0">
                <input type="text" id="bolreference" name="bolreference" class="form-control form-control-sm"  value="{{$request->bolreference ?? ""}}" placeholder="House BL"  autocomplete="off">
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0">
                <input type="text" id="contref" name="contref" class="form-control form-control-sm"  value="{{$request->contref ?? ""}}" placeholder="Enter Container"  autocomplete="off">
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
                <th>Sl. No.</th>
                <th>DO No</th>
                <th>MR No</th>
                <th>HBL </th>
                <th>Container </th>
                <th>BE No</th>
                <th>BE Date</th>
                <th>Issue Date</th>
                <th>Up to Date</th>
                <th>BL Type</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl. No.</th>
                <th>DO No</th>
                <th>MR No</th>
                <th>HBL </th>
                <th>Container </th>
                <th>BE No</th>
                <th>BE Date</th>
                <th>Issue Date</th>
                <th>Up to Date</th>
                <th>BL Type</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @php($i=0)
            @foreach($Donos as $data)
                <tr>
                    <td>{{++$i}}</td>
                    <td>QCLOGFRD-{{$data->id}}</td>
                    <td>
                        <div class="icon-btn">
                            <a target="_blank" href="{{ url('mrPdf/'.$data->moneyrecept_id)}}" data-toggle="tooltip" title="Money Receipt" class="btn btn-success">{{$data->moneyrecept_id}}</a>
                        </div>
                    </td>
                    <td>{{$data->moneyReceipt->houseBl->bolreference}}</td>
                    <td class="breakWords">
                        {{$data->moneyReceipt->houseBl->containers->pluck('contref')->join(', ', ', and ')}}
                    </td>
                    <td>{{$data->BE_No}}</td>
                    <td>{{$data->BE_Date ? date('d-m-Y', strtotime($data->BE_Date)) : null}}</td>
                    <td>{{$data->issue_date ? date('d-m-Y', strtotime($data->issue_date)) : null}}</td>
                    <td>{{$data->upto_date ? date('d-m-Y', strtotime($data->upto_date)) : null}}</td>
                    <td>{{$data->bl_type ?? null}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @can('deliveryorder-edit')
                                <a href="{{ route('deliveryorders.edit',$data->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                                {{--<form action="{{ url('moneyreceipts', [$data->id]) }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">--}}
                                {{--@csrf--}}
                                {{--@method('DELETE')--}}
                                {{--<button type="submit" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></button>--}}
                                {{--</form>--}}
                                <a href="{{ route('doPdf',$data->id) }}" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-success"><i class="fas fa-print"></i></a>
                                <a href="{{ url("deliverorders/log/$data->id")}}" data-toggle="tooltip" title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="float-right">
        {{$Donos->links()}}
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
        $(function(){
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

        });

    </script>
@endsection