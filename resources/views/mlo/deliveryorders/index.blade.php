@extends('layouts.new-layout')
@section('title', 'MLO Delivery Order')

@section('breadcrumb-title', 'MLO Delivery Orders ')

@section('breadcrumb-button')
    @can('mlo-deliveryorder-create')
    <a href="{{ url('mlodeliveryorders/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{count($deliveryOrders)}}
@endsection

@section('content')

    <form action="" method="get">
        <div class="row">
            <div class="col-md-2 pr-md-1 my-1 my-md-0">
                <input type="text" id="id" name="id" class="form-control form-control-sm" value="{{$request->id ?? null}}"  placeholder="DO ID">
            </div>
            <div class="col-md-2 pr-md-1 my-1 my-md-0">
                <input type="text" id="mr_id" name="mr_id" class="form-control form-control-sm" value="{{$request->mr_id ?? null}}"  placeholder="MR ID">
            </div>
            <div class="col-md-2 pr-md-1 my-1 my-md-0">
                <input type="text" id="be_no" name="be_no" class="form-control form-control-sm" value="{{$request->be_no ?? null}}"  placeholder="BE No">
            </div>
            <div class="col-md-3 pr-md-1 my-1 my-md-0">
                <input type="text" id="bolreference" name="bolreference" value="{{$request->bolreference ?? null}}" class="form-control form-control-sm" placeholder=" B/L">
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0">
                <input type="text" id="contref" name="contref" value="{{$request->contref ?? null}}" class="form-control form-control-sm" placeholder="Enter Container">
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
                <th>B/L No</th>
                <th>Container</th>
                <th>BE No</th>
                <th>BE Date</th>
                <th>DO Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl. No.</th>
                <th>DO No</th>
                <th>MR No</th>
                <th>B/L No</th>
                <th>Container</th>
                <th>BE No</th>
                <th>BE Date</th>
                <th>DO Date</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($deliveryOrders as $key => $deliveryOrder)
                <tr>
                    <td>{{$deliveryOrders->firstItem()+$key}}</td>
                    <td> {{$deliveryOrder->id}} </td>
                    <td>
                        <div class="icon-btn">
                            <a target="_blank" href="{{ url('mloMoneyReceiptPdf/'.$deliveryOrder->moneyReceipt->id)}}" data-toggle="tooltip" title="Money Receipt" class="btn btn-success">{{$deliveryOrder->moneyReceipt->id}}</a>
                        </div>
                    </td>
                    <td class="text-left"> {{$deliveryOrder->moneyReceipt->bolRef}} {{$deliveryOrder->moneyReceipt->extensionNo ? "(Ext-".$deliveryOrder->moneyReceipt->extensionNo.")" : null}} </td>
                    <td class="breakWords">
                        {{$deliveryOrder->moneyReceipt->molblInformations->blcontainers->pluck('contref')->join(', ', ', and ')}}
                    </td>
                    <td>{{$deliveryOrder->BE_No}}</td>
                    <td>{{$deliveryOrder->BE_Date ? date('d-m-Y', strtotime($deliveryOrder->BE_Date)) : null}}</td>
                    <td>{{$deliveryOrder->DO_Date ? date('d-m-Y', strtotime($deliveryOrder->DO_Date)) : null}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @can('mlo-deliveryorder-edit')
                                <a href="{{ url('mlodeliveryorders/'.$deliveryOrder->id.'/edit') }}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                                <a href="{{ url('mloDoPDF/'.$deliveryOrder->id) }}" data-toggle="tooltip" title="Print" class="btn btn-success"><i class="fas fa-print"></i></a>
                                <a href="{{ url('mlodeliverorders/log/'.$deliveryOrder->id) }}" data-toggle="tooltip" title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="float-right">
        {!! $deliveryOrders->links() !!}
    </div>
@endsection

@section('script')
    <script>

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
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
            });//bolreference autocomplete
        });//document.ready
    </script>

@endsection