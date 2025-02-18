@extends('layouts.new-layout')
@section('title', 'MLO-DO Report')

@section('style')
    <style>
        .table td{
            white-space: normal!important;
        }
    </style>
@endsection

@section('breadcrumb-title', 'MLO-Delivery Order Report')

@section('breadcrumb-button')

@endsection

@section('sub-title')
    @if($deliveryOrders->isNotEmpty())
        Total DO : <strong> {{count($deliveryOrders)}}</strong>
    @endif
@endsection

@section('content')
    <form action="{{ route('mloDoReport') }}" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1 my-md-0">
                <select name="requestType" class="form-control form-control-sm ">
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0">
                <select name="dateType" id="dateType" class="form-control form-control-sm" required>
                    <option value="today" selected> Today </option>
                    <option value="weekly" {{$dateType == "weekly" ? "selected" : ''}}> Last 7 Days </option>
                    <option value="monthly" {{$dateType == "monthly" ? "selected" : ''}}> Last 30 Days </option>
                    <option value="custom" {{$dateType == "custom" ? "selected" : ''}}> Custom </option>
                </select>
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0" id="fromDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <input type="text" id="fromDate" name="fromDate" class="form-control form-control-sm" value="{{$fromDate ? date('d/m/Y', strtotime($fromDate)) : ''}}" placeholder="From Date"  autocomplete="off">
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0" id="tillDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <input id="tillDate" class="form-control form-control-sm" value="{{!empty($tillDate) ? date('d/m/Y', strtotime($tillDate)) : ''}}"  type="text" name="tillDate" placeholder="Till Date" autocomplete="off">
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0">
                <input type="text" id="contref" name="contref" class="form-control form-control-sm" placeholder="Enter Container">
            </div>
            <div class="col-md-3 px-1 my-1 my-md-0">
                <input type="text" id="principal" name="principal" class="form-control form-control-sm" value="{{$principal ?? ""}}" placeholder="Principal Name" autocomplete="off">
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    @if($deliveryOrders->isNotEmpty())
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th> # </th>
                    <th> Line </th>
                    <th>BL Num</th>
                    <th>Container</th>
                    <th>Pkgs</th>
                    <th>FED/ VESSEL & VOY</th>
                    <th>ARR. DT</th>
                    <th>Principal</th>
                    <th>Exporter Name</th>
                    <th>Importer Name</th>
                    <th>DO Date</th>
                    <th>UpTo Date</th>
                    <th>CNF AGENT</th>
                    <th>CONTACT NO</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th> # </th>
                    <th> Line </th>
                    <th>BL Num</th>
                    <th>Container</th>
                    <th>Pkgs</th>
                    <th>FED/ VESSEL & VOY</th>
                    <th>ARR. DT</th>
                    <th>Principal</th>
                    <th>Exporter Name</th>
                    <th>Importer Name</th>
                    <th>DO Date</th>
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
                            <td> {{$deliveryOrder->moneyReceipt->molblInformations->line}} </td>
                            <td> {{$deliveryOrder->moneyReceipt->molblInformations->bolreference}} </td>

                            <td>
                                @foreach($deliveryOrder->moneyReceipt->molblInformations->blcontainers as $container)
                                    {{$container->contref}} <br>
                                @endforeach
                            </td>
                            <td> {{$deliveryOrder->moneyReceipt->molblInformations->packageno}} <br> {{$deliveryOrder->moneyReceipt->molblInformations->packagetype}} </td>
                            <td style="width: 150px"> {{$deliveryOrder->moneyReceipt->molblInformations->mlofeederInformation->feederVessel}} V.{{$deliveryOrder->moneyReceipt->molblInformations->mlofeederInformation->voyageNumber}} </td>
                            <td style="width: 68px"> <nobr>{{$deliveryOrder->moneyReceipt->molblInformations->mlofeederInformation->arrivalDate ? date('d-m-Y', strtotime($deliveryOrder->moneyReceipt->molblInformations->mlofeederInformation->arrivalDate)) : null}}</nobr> </td>
                            <td style="width: 68px"> {{$deliveryOrder->moneyReceipt->molblInformations->principal->name}}</td>
                            <td style="width: 150px"> {{$deliveryOrder->moneyReceipt->molblInformations->exportername}} </td>
                            <td style="width: 150px"> {{$deliveryOrder->moneyReceipt->molblInformations->blNotify->NAME}} </td>
                            <td style="width: 68px"> <nobr>{{$deliveryOrder->DO_Date ? date('d-m-Y', strtotime($deliveryOrder->DO_Date)) : null}}</nobr> </td>
                            <td style="width: 68px"> <nobr>{{$deliveryOrder->moneyReceipt->uptoDate ? date('d-m-Y', strtotime($deliveryOrder->moneyReceipt->uptoDate)) : null}}</nobr> </td>
                            <td style="width: 150px"> {{$deliveryOrder->moneyReceipt->client->cnfagent}} </td>
                            <td > {{$deliveryOrder->moneyReceipt->client->contact}} </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div> <!-- end table-responsive -->
    @endif

    @if($deliveryOrders->isEmpty() || Session::has('noDataFound'))
        <p class="bg-light py-3 text-center lead"> <strong> No DO Found based on the date/date range.  </strong> </p>
    @endif
@endsection




@section('script')
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

            var table = $('#miniTable').DataTable({
                stateSave: true,
                paging:   false,
                bFilter: false,
                info: false,
                ordering: false,

                dom: 'Bfrtip',
                buttons: ['csv', 'excel']
            });
        });
    </script>
@endsection
