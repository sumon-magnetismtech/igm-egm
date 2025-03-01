@extends('layouts.egm-layout')
@section('title', 'MLO-Money Receipt Report')


@section('breadcrumb-title', 'MLO-Money Receipt Report')

@section('breadcrumb-button')

@endsection

@section('sub-title')
    {{--Total : --}}
@endsection

@section('content')
    <form action="{{ route('egmmlomrreport') }}" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1 my-md-0" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf" {{$dateType == "reportType" ? "selected" : ''}}> PDF </option>
                </select>
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0">
                <select name="dateType" id="dateType" class="form-control  form-control-sm" required>
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
            <div class="col-md-3 px-1 my-1 my-md-0">
                <input type="text" id="principal" name="principal" class="form-control form-control-sm text-uppercase" value="{{$principal ? $principal : null}}"  placeholder="Principal Name" autocomplete="off">
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
    </form>

    @if($principal)
        <p style="margin-bottom: 5px">
            Principal: <strong>{{$principal}}</strong>
        </p>
    @endif

    @if($groupByPrincipals->isNotEmpty())
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Sl</th>
                <th>MR</th>
                <th>Issue Date</th>
                <th>HBL No</th>
                @if(!$principal)
                    <th>Principal</th>
                @endif
                <th>F-Vessel</th>
                <th>Qty</th>
                <th>Client Name</th>
                <th>Container</th>
                <th>Mode</th>
                <th style="width: 160px">Particulars</th>
                <th>Amount</th>
                @if(!$principal)
                    <th>Amount <br> Principal-wise</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @php
            $grandTotal = 0;
            $i = 1;
            $principalGrandTotal = 0;
            @endphp

            @foreach($groupByPrincipals as $parentKey => $groupByPrincipal)
                @foreach($groupByPrincipal as $key => $moneyReceipt)
                    <tr class="{{$loop->parent->index % 2 == 0 ? 'primary-color' : 'secondary-color-dark'}}">
                        <td>{{$i++}}</td>
                        <td><strong><a target="_blank" class="bg-success p-1" href="{{route("mloMoneyReceiptPdf", $moneyReceipt->id)}}">{{$moneyReceipt->id}}</a></strong></td>
                        <td style="text-align: center"><nobr>{{date('d-m-Y', strtotime($moneyReceipt->issueDate))}}</nobr></td>
                        <td>{{$moneyReceipt->molblInformations->bolreference}} {{$moneyReceipt->extensionNo ? "(Ex-$moneyReceipt->extensionNo)" : null}} </td>
                        @if(!$principal)
                            <td>{{$moneyReceipt->molblInformations->principal->name}}</td>
                        @endif
                        <td>{{$moneyReceipt->molblInformations->mlofeederInformation->feederVessel}}</td>
                        <td style="text-align: center">{{$moneyReceipt->molblInformations->packageno}}</td>
                        <td>{{$moneyReceipt->client->cnfagent}}</td>
                        <td style="text-align: center">{{$moneyReceipt->molblInformations->containernumber}}</td>
                        <td style="text-align: center">
                            {{Str::upper($moneyReceipt->pay_mode)}} <br>
                            {{Str::upper($moneyReceipt->pay_number ?? null)}}
                        </td>
                        <td style="vertical-align: top">
                            @foreach($moneyReceipt->mloMoneyReceiptDetails as $mloMoneyReceiptDetails)
                                {{$mloMoneyReceiptDetails->particular}} <br>
                            @endforeach
                        </td>
                        <td style="text-align: right; vertical-align: top">
                            @php($total = 0)
                            @foreach($moneyReceipt->mloMoneyReceiptDetails as $mloMoneyReceiptDetails)
                                {{number_format($mloMoneyReceiptDetails->amount, 2)}}/-  <br>
                                @php($total+=$mloMoneyReceiptDetails->amount)
                                @php($grandTotal +=$mloMoneyReceiptDetails->amount)
                            @endforeach
                            @if($total > 0 && count($moneyReceipt->mloMoneyReceiptDetails) > 1)
                                <p style="border-top: 1px solid #bec2c6; margin: 0"><strong>{{number_format($total, 2)}}/-</strong></p>
                            @endif
                        </td>

                        @if(!$principal && $loop->first && $groupByPrincipal->isNotEmpty())
                            <td class="align-middle textRight" rowspan="{{ $groupByPrincipal->count()}}">
                                <?php
                                $principalSum = \App\MLO\MoneyReceiptDetails::with('moneyReceipt')->whereIn('moneyReceipt_id', $groupByPrincipal->pluck('id'))->get();
                                ?>
                                {{number_format($principalAmount = $principalSum->sum('amount'), 2)}}/-
                                @php($principalGrandTotal += $principalAmount)
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
            {{--<tr>--}}
                {{--<td colspan="{{!$principal ? 11 : 10}}" class="textRight"><strong>Total Amount</strong></td>--}}
                {{--<td style="text-align: right">{{number_format($grandTotal, 2)}}/-</td>--}}
                {{--@if(!$principal)--}}
                    {{--<td style="text-align: right">{{number_format($principalGrandTotal, 2)}}/-</td>--}}
                {{--@endif--}}
            {{--</tr>--}}
            </tbody>

            <tfoot>
            <tr class="rgba-blue-grey-light">
                <td colspan="{{!$principal ? 11 : 10}}" class="text-right font-weight-bold"> Grand Total</td>
                <td class="bg-warning font-weight-bold text-right"> {{number_format($grandTotal, 2)}}/- </td>
                @if(!$principal)
                <td class="bg-warning font-weight-bold text-right"> {{number_format($principalGrandTotal, 2)}}/- </td>
                @endif
            </tr>
            </tfoot>
        </table>
    </div> <!-- end table-responsive -->
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
                        url:"{{route('principalAutoComplete')}}",
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
                    $('#principal').val(ui.item.label); // display the selected text
                    return false;
                }
            });
        });
    </script>
@endsection
