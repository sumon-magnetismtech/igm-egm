@extends('layouts.new-layout')
@section('title', 'MLO-DO Report')

@section('style')
    <style>
        .table td{
            white-space: normal!important;
        }
    </style>
@endsection

@section('breadcrumb-title', 'MLO-Container Report Against Delivery Order')

@section('breadcrumb-button')

@endsection

@section('sub-title')
    @if($mloblInformations->isNotEmpty())
        Total DO : <strong> {{count($mloblInformations)}}</strong>
    @endif
@endsection

@section('content')
    <form action="{{ route('mloDoContainerReport') }}" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1 my-md-0">
                <select name="requestType" class="form-control form-control-sm ">
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                    <option value="excel"> Excel </option>
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
                <input type="text" id="fromDate" name="fromDate" class="form-control form-control-sm" value="{{$fromDate ? date('d-m-Y', strtotime($fromDate)) : ''}}" placeholder="From Date"  autocomplete="off">
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0" id="tillDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <input id="tillDate" class="form-control form-control-sm" value="{{!empty($tillDate) ? date('d-m-Y', strtotime($tillDate)) : ''}}"  type="text" name="tillDate" placeholder="Till Date" autocomplete="off">
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

    @if($mloblInformations->isNotEmpty())
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th> DO Date </th>
                    <th> Container </th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Upto</th>
                    <th>HBL</th>
                    <th>Vessel Name</th>
                    <th>Voyage</th>
                    <th>Rotation</th>
                    <th>Principal</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th> DO Date </th>
                    <th> Container </th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Upto</th>
                    <th>HBL</th>
                    <th>Vessel Name</th>
                    <th>Voyage</th>
                    <th>Rotation</th>
                    <th>Principal</th>
                </tr>
                </tfoot>
                <tbody>
                    @forelse($mloblInformations as $key => $mloblInformation)
                        @foreach($mloblInformation->blcontainers as $container)
                            <tr class="{{$loop->parent->iteration % 2 == 0 ? "bg-light" : null}}">
                                <td> {{$mloblInformation->mloMoneyReceipt->deliveryOrder->DO_Date}} </td>
                                <td> {{$container->contref}} </td>
                                <td> {{$container->type}} </td>
                                <td> {{$container->status}} </td>
                                <td> {{$mloblInformation->mloMoneyReceipt->uptoDate ? date('d-m-Y', strtotime($mloblInformation->mloMoneyReceipt->uptoDate)) : null}} </td>
                                @if($loop->first)
                                    <td style="vertical-align: middle" rowspan="{{count($mloblInformation->blcontainers)}}"> {{$mloblInformation->bolreference}} </td>
                                    <td style="vertical-align: middle" rowspan="{{count($mloblInformation->blcontainers)}}"> {{$mloblInformation->mlofeederInformation->feederVessel}} </td>
                                    <td style="vertical-align: middle" rowspan="{{count($mloblInformation->blcontainers)}}"> {{$mloblInformation->mlofeederInformation->voyageNumber}} </td>
                                    <td style="vertical-align: middle" rowspan="{{count($mloblInformation->blcontainers)}}"> {{$mloblInformation->mlofeederInformation->rotationNo}} </td>
                                    <td style="vertical-align: middle" rowspan="{{count($mloblInformation->blcontainers)}}"> {{$mloblInformation->principal->name}} </td>
                                @endif
                            </tr>
                        @endforeach
                    @empty

                    @endforelse

                </tbody>
            </table>
        </div> <!-- end table-responsive -->
    @endif

    @if($mloblInformations->isEmpty() || Session::has('noDataFound'))
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
