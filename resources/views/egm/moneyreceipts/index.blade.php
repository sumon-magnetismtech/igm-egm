@extends('layouts.egm-layout')
@section('title', 'List of Money Receipt')

@section('breadcrumb-title', 'List of Money Receipt')

@section('breadcrumb-button')
    @can('moneyreceipt-create')
        <a target="_blank" href="{{ route('egmmoneyreceipts.create') }}" class="btn btn-out-dashed btn-sm btn-success">
            <i class="fa fa-plus"></i>
        </a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ $moneyReceipts ? $moneyReceipts->total() : 0 }}
@endsection

@section('content')
    <form action="" method="get" class="col-12">
        <div class="row">
            <div class="col-md-1 p-0 pr-1 mb-1">
                <input type="text" name="mrid" class="form-control form-control-sm" value="{{ $mrid ?? '' }}"
                    placeholder="MR ID" autocomplete="off">
            </div>
            <div class="col-md-2 p-0 pr-1 mb-1">
                <input type="text" id="bolreference" name="housebl" class="form-control form-control-sm"
                    value="{{ $housebl ?? '' }}" placeholder="House BL" autocomplete="off">
            </div>
            <div class="col-md-3 p-0 pr-1 mb-1">
                <input type="text" id="client" name="client" class="form-control form-control-sm"
                    value="{{ $client ?? '' }}" placeholder="Client Name" autocomplete="off">
            </div>
            <div class="col-md-2 p-0 pr-1 mb-1">
                <input type="text" id="principal" name="principal" class="form-control form-control-sm"
                    value="{{ $principal ?? '' }}" placeholder="Principal Name" autocomplete="off">
            </div>
            <div class="col-md-2 p-0 pr-1 mb-1">
                <input type="text" id="fromDate" name="fromDate" class="form-control form-control-sm"
                    value="{{ $fromDate ?? '' }}" placeholder="From (dd/mm/yyyy)" autocomplete="off">
            </div>
            <div class="col-md-2 p-0 pr-1 mb-1">
                <input type="text" id="tillDate" name="tillDate" class="form-control form-control-sm"
                    value="{{ $tillDate ?? '' }}" placeholder="Till (dd/mm/yyyy)" autocomplete="off">
            </div>
            <div class="col-md-2 p-0 pr-1 mb-1">
                <input type="text" id="contref" name="contref" value="{{ $request->contref ?? null }}"
                    class="form-control form-control-sm" placeholder="Enter Container">
            </div>
            <div class="col-md-1 p-0 pr-1 my-1 my-md-0">
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
                    <th>Sl</th>
                    <th>Edit</th>
                    <th>Issue Date</th>
                    <th>H/Bl No</th>
                    <th>Client Name</th>
                    <th>Qty</th>
                    <th>M-Vessel</th>
                    <th>F-Vessel</th>
                    <th>Principal</th>
                    <th>Containers</th>
                    <th>NOC</th>
                    <th>Particulars</th>
                    <th>Amount</th>
                    <th>DO No <br> DO Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Sl</th>
                    <th>Edit</th>
                    <th>Issue Date</th>
                    <th>H/Bl No</th>
                    <th>Client Name</th>
                    <th>Qty</th>
                    <th>M-Vessel</th>
                    <th>F-Vessel</th>
                    <th>Principal</th>
                    <th>Containers</th>
                    <th>NOC</th>
                    <th>Particulars</th>
                    <th>Amount</th>
                    <th>DO No <br> DO Date</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @forelse($moneyReceipts as $key => $data)
                    <tr>
                        <td>{{ $moneyReceipts->firstItem() + $key }}</td>
                        <td>
                            <div class="icon-btn">
                                @can('moneyreceipt-edit')
                                    <a href="{{ url('egmmoneyreceipts/' . $data->id . '/edit') }}" data-toggle="tooltip"
                                        title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                            </div>
                        </td>
                        <td>{{ $data->issue_date ? date('d-m-Y', strtotime($data->issue_date)) : null }}</td>
                        <td class="text-left">
                            <a class="link" data-toggle="tooltip" title="Click for HBL Details" target="_blank"
                                href="{{ url('egmhousebls/' . $data->houseBl->id) }}">{{ $data->houseBl->bolreference }}</a>

                            <strong>{{ $data->extension_no ? "(Ext-$data->extension_no)" : null }}</strong>
                        </td>
                        <td class="breakWords text-left">{{ $data->client_name }}</td>
                        <td>{{ $data->quantity }}</td>
                        <td class="text-left">{{ $data->houseBl->masterbl->mv }}</td>
                        <td class="text-left">{{ $data->houseBl->masterbl->fvessel }}</td>
                        <td>{{ $data->houseBl->masterbl->principal }}</td>
                        <td class="breakWords">
                            <strong>Total: <span>{{ $data->houseBl->containernumber }}</span></strong> <br>
                            {{ $data->houseBl->containers->pluck('contref')->join(', ', ', ') }}
                        </td>
                        <td>
                            @if ($data->houseBl->masterbl->noc)
                                <button class="btn btn-sm bg-danger p-1 m-0" disabled> NOC </button>
                            @endif
                        </td>
                        <td style="vertical-align: top">
                            @foreach ($data->MoneyreceiptDetail as $mr_dtl)
                                {{ $mr_dtl->particular }}<br>
                            @endforeach
                        </td>
                        <td style="text-align: right; vertical-align: top">
                            @php($total = 0)
                            @foreach ($data->MoneyreceiptDetail as $receiptDetails)
                                {{ $receiptDetails->amount . '/-' }}@if (!$loop->last)
                                    <br>
                                @endif
                                @php($total += $receiptDetails->amount)
                            @endforeach
                            @if ($total > 0 && count($data->MoneyreceiptDetail) > 1)
                                <hr class="m-0 p-0">
                                <strong>{{ $total }}/-</strong>
                            @endif
                        </td>
                        <td>
                            @if ($data->deliveryOrder)
                                <a target="_blank" class="btn btn-sm bg-success p-1 m-1"
                                    href="{{ route('egmdoPdf', $data->deliveryOrder->id) }}">DO-{{ $data->deliveryOrder->id }}</a>
                                <br>
                                <strong>{{ $data->deliveryOrder->issue_date ? date('d/m/Y', strtotime($data->deliveryOrder->issue_date)) : null }}</strong>
                            @endif
                        </td>

                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    {{-- <a href="" data-toggle="tooltip" title="Details" class="btn btn-primary"><i class="fas fa-eye"></i></a> --}}
                                    @can('moneyreceipt-edit')
                                        <a href="{{ url('egmmoneyreceipts/' . $data->id . '/edit') }}" data-toggle="tooltip"
                                            title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                    @endcan
                                    @can('moneyreceipt-delete')
                                        <form action="{{ url('egmmoneyreceipts', [$data->id]) }}" method="POST"
                                            data-toggle="tooltip" title="Delete" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    @endcan
                                    <a href="{{ route('egmmrPdf', $data->id) }}" target="_blank" data-toggle="tooltip"
                                        title="Print" class="btn btn-success"><i class="fas fa-print"></i></a>
                                    <a href="{{ url('egmmoneyreceipts/log/' . $data->id) }}" data-toggle="tooltip"
                                        title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
                                </nobr>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="15">
                                <h5 class="text-muted my-3"> No Data Found Based on your query. </h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="float-right">
            {{ $moneyReceipts->links() }}
        </div>
    @endsection

@section('script')
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            $('#fromDate').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true
            });
            $('#tillDate').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true
            });

            $("#bolreference").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('egmLoadHouseblBolreferenceAutoComplete') }}",
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
            });
            $("#principal").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('egmLoadMasterPrincipalAutoComplete') }}",
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
                    $('#principal').val(ui.item.value); // display the selected text
                    //                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });
            $("#client").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('egmLoadCnfClientNameAutoComplete') }}",
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
                    $('#client').val(ui.item.value); // display the selected text
                    //                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });
        });
    </script>
@endsection
