@extends('layouts.new-layout')
@section('title', 'FRD-Money Receipt Report')


@section('breadcrumb-title', 'FRD-Money Receipt Report')

@section('breadcrumb-button')

@endsection

@section('sub-title')
    {{--Total : --}}
@endsection

@section('content')
    <form action="{{ route('mrreport') }}" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1 my-md-0" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf" {{$dateType == "reportType" ? "selected" : ''}}> PDF </option>
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
                <input type="text" id="fromDate" name="fromDate" class="form-control form-control-sm" value="{{$fromDate ? date('d/m/Y', strtotime($fromDate)) : ''}}" placeholder="From Date" autocomplete="off">
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0" id="tillDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <input type="text" id="tillDate" name="tillDate" class="form-control form-control-sm" value="{{!empty($tillDate) ? date('d/m/Y', strtotime($tillDate)) : ''}}" placeholder="Till Date" autocomplete="off">
            </div>
            <div class="col-md-3 px-1 my-1 my-md-0">
                <input type="text" id="principal" name="principal" class="form-control form-control-sm" value="{{$principal ? $principal : null}}" placeholder="Principal Name" autocomplete="off">
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr class="bg-primary">
                    <th>Sl</th>
                    <th>Issue Date</th>
                    <th>H/Bl No</th>
                    <th>Client Name</th>
                    <th>Qty</th>
                    <th>M-Vessel</th>
                    <th>F-Vessel</th>
                    <th>Principal</th>
                    <th>Container</th>
                    <th style="width: 160px">Particulars</th>
                    <th>Amount</th>
                    <th>Amount <br> Principal-wise </th>
                </tr>
            </thead>

            <tbody>
            @php
            $grandtotal = 0;
            $i = 1;
            $principalGrandTotal = 0;
            @endphp

            @forelse($groupByPrincipals as $parentKey => $groupByPrincipal)
                @foreach($groupByPrincipal as $key => $moneyReceipt)
                    <tr class="{{$loop->parent->index % 2 == 0 ? 'bg-info' : 'bg-warning'}}">
                        <td class="align-middle">{{$i++}}</td>
                        <td class="align-middle">{{$moneyReceipt->issue_date ? date('d-m-Y', strtotime($moneyReceipt->issue_date)) : null}}</td>
                        <td class="align-middle">{{$moneyReceipt->houseBl->bolreference}}</td>
                        <td class="align-middle">{{$moneyReceipt->client_name}}</td>
                        <td class="align-middle">{{$moneyReceipt->quantity}}</td>
                        <td class="align-middle">{{$moneyReceipt->houseBl->masterbl->mv}}</td>
                        <td class="align-middle">{{$moneyReceipt->houseBl->masterbl->fvessel}}</td>
                        <td class="align-middle">{{$moneyReceipt->houseBl->masterbl->principal}}</td>
                        <td class="align-middle">{{$moneyReceipt->houseBl->containernumber}}</td>
                        <td style="vertical-align: top">
                            @foreach($moneyReceipt->MoneyreceiptDetail as $mr_dtl)
                                {{$mr_dtl->particular}}<br>
                            @endforeach
                        </td>
                        <td style="text-align: right; vertical-align: top">
                            @php($total = 0)
                            @foreach($moneyReceipt->MoneyreceiptDetail as $receiptDetails)
                                {{number_format($receiptDetails->amount, 2). '/-'}}@if(!$loop->last) <br>@endif
                                @php($total+=$receiptDetails->amount)
                                @php($grandtotal += $receiptDetails->amount)
                            @endforeach

                            @if($total > 0 && count($moneyReceipt->MoneyreceiptDetail) > 1)
                                <hr class="m-0 p-0">
                                <strong>{{number_format($total, 2)}}/-</strong>
                            @endif
                        </td>

                        @if($loop->first && $groupByPrincipal->isNotEmpty())
                            <td class="align-middle text-right" rowspan="{{ $groupByPrincipal->count()}}">
                                <?php $principalSum = \Illuminate\Support\Facades\DB::table('moneyreceipts')
                                        ->join('moneyreceipt_details','moneyreceipt_id','moneyreceipts.id')
                                        ->whereIn('moneyreceipts.id', $groupByPrincipal->flatten()->pluck('id'))
                                        ->get();
                                ?>
                                {{number_format($principal = $principalSum->sum('amount'), 2)}}/-
                                @php($principalGrandTotal += $principal)
                            </td>
                        @endif
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="12"><h5 class="text-muted my-3"> No Data Found Based on your query. </h5></td>
                </tr>
            @endforelse

            </tbody>

            <tfoot>
            <tr class="bg-dark">
                <td colspan="10" class="text-right font-weight-bold"> Grand Total</td>
                <td class="font-weight-bold text-right"> {{number_format($grandtotal, 2)}}/- </td>
                <td class="font-weight-bold text-right"> {{number_format($principalGrandTotal, 2)}}/- </td>
            </tr>
            </tfoot>
        </table>
    </div> <!-- end table-responsive -->
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
        });
    </script>
@endsection
