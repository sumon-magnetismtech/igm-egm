@extends('layouts.egm-layout')
@section('title', 'FRD-DO Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/buttons.dataTables.min.css')}} ">
    {{--<link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/responsive.bootstrap4.min.css')}}">--}}


    <style>
        .table td{
            white-space: normal!important;
        }
    </style>

@endsection

@section('breadcrumb-title', 'FRD-Delivery Order Report')

@section('breadcrumb-button')

@endsection

@section('sub-title')
    @if($deliveryOrders->isNotEmpty() || $noc->isNotEmpty())
        Total DO : <strong> {{count($deliveryOrders)}}</strong>; Total NOC : <strong> {{count($noc)}}</strong>
    @endif
@endsection

@section('content')
    <form action="{{ route('doreport') }}" method="get">
        <div class="row">
            <div class="col-md-1 pr-md-1 my-1 my-md-0" data-toggle="tooltip" title="Output">
                <select name="requestType" class="form-control form-control-sm">
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0">
                <select name="dateType" id="dateType" class="form-control form-control-sm" required>
                    <option value="today" selected> Today </option>
                    <option value="weekly" {{$dateType == "weekly" ? "selected" : ''}}> Last 7 Days </option>
                    <option value="monthly" {{$dateType == "monthly" ? "selected" : ''}}> Last 30 Days </option>
                    <option value="custom" {{$dateType == "custom" ? "selected" : ''}}> Custom </option>
                </select>
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0" id="fromDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <input id="fromDate" class="form-control form-control-sm" value="{{$fromDate ? date('d/m/Y', strtotime($fromDate)) : ''}}"  type="text" name="fromDate" placeholder="From Date" autocomplete="off">
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0" id="tillDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <input id="tillDate" class="form-control form-control-sm" value="{{!empty($tillDate) ? date('d/m/Y', strtotime($tillDate)) : ''}}"  type="text" name="tillDate" placeholder="Till Date" autocomplete="off">
            </div>
            <div class="col-md-3 px-md-1 my-1 my-md-0">
                <input id="principal" class="form-control form-control-sm" value="{{$principal ?? ""}}"  type="text" name="principal" placeholder="Principal Name" autocomplete="off">
            </div>
            <div class="col-md-1 px-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    @if($deliveryOrders->isNotEmpty() || $noc->isNotEmpty())
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th> # </th>
                <th> Type </th>
                <th> Line </th>
                <th>BL Num</th>
                <th>Pkgs</th>
                <th>M/VESSEL & VOY</th>
                <th>FED/ VESSEL & VOY</th>
                <th>ARR. DT</th>
                <th>Principal</th>
                <th>Exporter Name</th>
                <th>Importer Name</th>
                <th>Issue Date</th>
                <th>UpTo Date</th>
                <th>CNF AGENT</th>
                <th>CONTACT NO</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th> # </th>
                <th> Type </th>
                <th> Line </th>
                <th>BL Num</th>
                <th>Pkgs</th>
                <th>M/VESSEL & VOY</th>
                <th>FED/ VESSEL & VOY</th>
                <th>ARR. DT</th>
                <th>Principal</th>
                <th>Exporter Name</th>
                <th>Importer Name</th>
                <th>Issue Date</th>
                <th>UpTo Date</th>
                <th>CNF AGENT</th>
                <th>CONTACT NO</th>
            </tr>
            </tfoot>
            <tbody>
            @if($deliveryOrders->isNotEmpty())
                @foreach($deliveryOrders as $key => $deliveryOrder)
                    <tr>
                        <td> {{$loop->iteration}} </td>
                        <td> DO </td>
                        <td> {{$deliveryOrder->moneyReceipt->houseBl->line}} </td>
                        <td> {{$deliveryOrder->moneyReceipt->houseBl->bolreference}} </td>
                        <td> {{$deliveryOrder->moneyReceipt->houseBl->packageno}} <br> {{$deliveryOrder->moneyReceipt->houseBl->packagetype}} </td>
                        <td style="width: 150px"> {{$deliveryOrder->moneyReceipt->houseBl->masterbl->mv}} </td>
                        <td style="width: 150px"> {{$deliveryOrder->moneyReceipt->houseBl->masterbl->fvessel}} V.{{$deliveryOrder->moneyReceipt->houseBl->masterbl->voyage}} </td>
                        <td style="width: 68px"> <nobr>{{$deliveryOrder->moneyReceipt->houseBl->masterbl->arrival ? date('d-m-Y', strtotime($deliveryOrder->moneyReceipt->houseBl->masterbl->arrival)) : null}}</nobr> </td>
                        <td style="width: 68px"> {{$deliveryOrder->moneyReceipt->houseBl->masterbl->principal}}</td>
                        <td style="width: 150px"> {{$deliveryOrder->moneyReceipt->houseBl->exportername}} </td>
                        <td style="width: 150px"> {{$deliveryOrder->moneyReceipt->houseBl->notifyname}} </td>
                        <td style="width: 68px"> <nobr>{{$deliveryOrder->issue_date ? date('d-m-Y', strtotime($deliveryOrder->issue_date)) : null}}</nobr> </td>
                        <td style="width: 68px"> <nobr>{{$deliveryOrder->upto_date ? date('d-m-Y', strtotime($deliveryOrder->upto_date)) : null}}</nobr> </td>
                        <td style="width: 150px"> {{$deliveryOrder->moneyReceipt->client_name}} </td>
                        <td > {{$deliveryOrder->moneyReceipt->client_mobile}} </td>
                    </tr>
                @endforeach
            @endif

            @if($noc->isNotEmpty())
                @foreach($noc as $key => $singleNoc)
                    <tr>
                        <td> {{$loop->iteration}} </td>
                        <td> NOC </td>
                        <td> {{$singleNoc->houseBl->line}} </td>
                        <td> {{$singleNoc->houseBl->bolreference}} </td>
                        <td> {{$singleNoc->houseBl->packageno}} <br> {{$singleNoc->houseBl->packagetype}} </td>
                        <td style="width: 150px"> {{$singleNoc->houseBl->masterbl->mv}} </td>
                        <td style="width: 150px"> {{$singleNoc->houseBl->masterbl->fvessel}} V.{{$singleNoc->houseBl->masterbl->voyage}} </td>
                        <td style="width: 68px"> <nobr>{{$singleNoc->houseBl->masterbl->arrival ? date('d-m-Y', strtotime($singleNoc->houseBl->masterbl->arrival)) : null}}</nobr> </td>
                        <td style="width: 150px"> {{$singleNoc->houseBl->masterbl->principal}} </td>
                        <td style="width: 150px"> {{$singleNoc->houseBl->exportername}} </td>
                        <td style="width: 150px"> {{$singleNoc->houseBl->notifyname}} </td>
                        <td style="width: 68px"> <nobr>{{$singleNoc->issue_date ? date('d-m-Y', strtotime($singleNoc->issue_date)) : null}}</nobr> </td>
                        <td style="width: 68px"> -- -- -- </td>
                        <td style="width: 150px"> {{$singleNoc->client_name}} </td>
                        <td > {{$singleNoc->client_mobile}} </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div> <!-- end table-responsive -->
    @endif

    @if($deliveryOrders->isEmpty() && $noc->isEmpty() || Session::has('noDataFound'))
    <p class="bg-light py-3 text-center lead"> <strong> No DO Found based on the date/date range.  </strong> </p>
    @endif
@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/Datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/Datatables/jszip.min.js')}}"></script>
    {{--<script src="{{asset('js/Datatables/pdfmake.min.js')}}"></script>--}}
    <script src="{{asset('js/Datatables/vfs_fonts.js')}}"></script>
{{--    <script src="{{asset('js/Datatables/buttons.print.min.js')}}"></script>--}}
    <script src="{{asset('js/Datatables/buttons.html5.min.js')}}"></script>
    {{--<script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>--}}
    {{--<script src="{{asset('js/Datatables/dataTables.responsive.min.js')}}"></script>--}}
    {{--<script src="{{asset('js/Datatables/responsive.bootstrap4.min.js')}}"></script>--}}

    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            $('#fromDate').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});
            $('#tillDate').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});

            $("#dateType").change(function(){
                let type = $(this).val();
                if(type === 'custom'){
                    $("#fromDateArea, #tillDateArea").show('slow');
                    $("#fromDate, #tillDate").attr('required', true);
                }else{
                    $("#fromDateArea, #tillDateArea").hide('slow');
                    $("#fromDate, #tillDate").removeAttr('required');
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

            var table = $('#dataTable').DataTable({
                stateSave: true,
                paging:   false,
                bFilter: false,
                info: false,
                ordering: false,

                dom: 'Bfrtip',
                buttons: ['excel']
            });
        });
    </script>
@endsection
