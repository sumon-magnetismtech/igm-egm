@extends('layouts.egm-layout')
@section('title', 'MLO Money Receipts')

@section('breadcrumb-title', 'List of MLO Money Receipts')

@section('breadcrumb-button')
    @can('mlo-moneyreceipt-create')
        <a href="{{ route('egmmlomoneyreceipts.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i
                class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($moneyReceipts) }}
@endsection

@section('content')
    <form action="" method="get">
        <div class="row">
            <div class="col-md-2 pr-md-1 my-1 my-md-0">
                <input type="text" id="id" name="id" class="form-control form-control-sm"
                    value="{{ $request->id ?? null }}" placeholder="Money Receipt ID">
            </div>
            <div class="col-md-3 pr-md-1 my-1 my-md-0">
                <input type="text" id="bolreference" name="bolreference" value="{{ $request->bolreference ?? null }}"
                    class="form-control form-control-sm" placeholder=" B/L">
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0">
                <input type="text" id="contref" name="contref" value="{{ $request->contref ?? null }}"
                    class="form-control form-control-sm" placeholder="Enter Container">
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
                    <th> Sl </th>
                    <th> Receipt ID </th>
                    <th> Bol Ref </th>
                    <th> Container </th>
                    <th> Client Name </th>
                    <th> Issue Date </th>
                    <th> Pay Mode </th>
                    <th> Particular </th>
                    <th> Amount (BDT)</th>
                    <th>DO No <br> DO Date</th>
                    <th> Actions </th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th> Sl </th>
                    <th> Receipt ID </th>
                    <th> Bol Ref </th>
                    <th> Container </th>
                    <th> Client Name </th>
                    <th> Issue Date </th>
                    <th> Pay Mode </th>
                    <th> Particular </th>
                    <th> Amount (BDT)</th>
                    <th>DO No <br> DO Date</th>
                    <th> Actions </th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($moneyReceipts as $key => $moneyReceipt)
                    @php($countContainers = count($moneyReceipt->molblInformations->blcontainers))
                    <tr>
                        @foreach ($moneyReceipt->molblInformations->blcontainers as $blcontainer)
                            @if ($loop->first)
                                <td rowspan="{{ $countContainers }}">{{ $moneyReceipts->firstItem() + $key }}</td>
                                <td rowspan="{{ $countContainers }}"><a
                                        href="{{ url('feederinformations/' . $moneyReceipt->id) }}"
                                        class="btn btn-sm btn-dark-green">{{ $moneyReceipt->id }} </a></td>
                                <td rowspan="{{ $countContainers }}" class="text-left"> {{ $moneyReceipt->bolRef ?? '' }}
                                    {{ $moneyReceipt->extensionNo ? "(Ext-$moneyReceipt->extensionNo)" : null }}</td>
                            @endif
                            <td> {{ $blcontainer->contref }}</td>
                            @if ($loop->first)
                                <td rowspan="{{ $countContainers }}" class="text-left">
                                    {{ $moneyReceipt->client->cnfagent }} </td>
                                <td rowspan="{{ $countContainers }}">
                                    @if (!empty($moneyReceipt->issueDate))
                                        {{ date('d-m-Y', strtotime($moneyReceipt->issueDate)) }}
                                    @endif
                                </td>
                                <td rowspan="{{ $countContainers }}"> {{ $moneyReceipt->payMode }} </td>
                                <td rowspan="{{ $countContainers }}" style="text-align: left; vertical-align: top">
                                    @foreach ($moneyReceipt->mloMoneyReceiptDetails as $receiptDetails)
                                        {{ $receiptDetails->particular }}<br>
                                    @endforeach
                                </td>
                                <td rowspan="{{ $countContainers }}" style="text-align: right; vertical-align: top">
                                    @php($total = 0)
                                    @foreach ($moneyReceipt->mloMoneyReceiptDetails as $receiptDetails)
                                        {{ $receiptDetails->amount . '/-' }}@if (!$loop->last)
                                            <br>
                                        @endif
                                        @php($total += $receiptDetails->amount)
                                    @endforeach
                                    @if ($total > 0)
                                        <hr class="m-0 p-0">
                                        <strong>{{ $total }}/-</strong>
                                    @endif
                                </td>
                                <td rowspan="{{ $countContainers }}">
                                    @if ($moneyReceipt->deliveryOrder)
                                        @if ($moneyReceipt->deliveryOrder->id)
                                            <a target="_blank" class="btn btn-sm bg-success p-1 m-1"
                                                href="{{ route('mloDoPDF', $moneyReceipt->deliveryOrder->id) }}">DO-{{ $moneyReceipt->deliveryOrder->id }}</a>
                                            <br>
                                            <strong>{{ $moneyReceipt->deliveryOrder->DO_Date ? date('d/m/Y', strtotime($moneyReceipt->deliveryOrder->DO_Date)) : null }}</strong>
                                        @endif
                                    @endif
                                </td>
                                <td rowspan="{{ $countContainers }}">
                                    <div class="icon-btn">
                                        <nobr>
                                            @can('mlo-moneyreceipt-edit')
                                                <a href="{{ url('egmmlomoneyreceipts/' . $moneyReceipt->id . '/edit') }}"
                                                    data-toggle="tooltip" title="Edit" class="btn btn-warning"><i
                                                        class="fas fa-pen"></i></a>
                                            @endcan

                                            <a href="{{ url('mloMoneyReceiptPdf/' . $moneyReceipt->id) }}"
                                                data-toggle="tooltip" title="Print" class="btn btn-success"><i
                                                    class="fas fa-print"></i></a>

                                            @can('mlo-moneyreceipt-delete')
                                                <form action="{{ url('egmmlomoneyreceipts', [$moneyReceipt->id]) }}"
                                                    method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete"><i
                                                            class="fas fa-trash"></i></button>
                                                </form>
                                            @endcan
                                            <a href="{{ url('egmmlomoneyreceipts/log/' . $moneyReceipt->id) }}"
                                                data-toggle="tooltip" title="Log" class="btn btn-dark"><i
                                                    class="fas fa-history"></i></a>
                                        </nobr>
                                    </div>
                                </td>
                            @endif
                    </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="float-right">
        {!! $moneyReceipts->links() !!}
    </div>
@endsection

@section('script')
    <script>
        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            $("#bolreference").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('bolreferenceAutoComplete') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#bolreference').val(ui.item.value); // display the selected text
                    //                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            }); //bolreference autocomplete
        }); //document.ready
    </script>

@endsection
