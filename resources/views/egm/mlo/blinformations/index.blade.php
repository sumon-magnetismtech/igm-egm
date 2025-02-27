@extends('layouts.egm-layout')
@section('title', 'List of BL Information')

@section('breadcrumb-title', 'List of BL Information')

@section('breadcrumb-button')
    {{-- <a href="" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
    Total: {{ $mlobls->total() }}
@endsection

@section('content')
    <form action="" method="get">
        <div class="row">
            <div class="col-md-2 pr-md-1 my-1 my-md-0">
                <input type="text" id="igm" name="igm" value="{{ $request->igm ?? null }}"
                    class="form-control form-control-sm" placeholder="IGM" autocomplete="off">
            </div>
            <div class="col-md-3 px-md-1 my-1 my-md-0">
                <input type="text" id="bolreference" name="bolreference" value="{{ $request->bolreference ?? null }}"
                    class="form-control form-control-sm" placeholder=" B/L" autocomplete="off">
            </div>
            <div class="col-md-3 px-md-1 my-1 my-md-0">
                <input type="text" id="feederVessel" name="feederVessel" value="{{ $request->feederVessel ?? null }}"
                    class="form-control form-control-sm" placeholder="Vessel" autocomplete="off">
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0">
                <input type="text" id="voyageNumber" name="voyageNumber" value="{{ $request->voyageNumber ?? null }}"
                    list="voyageList" class="form-control form-control-sm" placeholder="Voyage" autocomplete="off">
                <datalist id="voyageList"></datalist>
            </div>
            <div class="col-md-2 pl-md-1 my-1 my-md-0">
                <input type="text" id="contref" name="contref" value="{{ $request->contref ?? null }}"
                    class="form-control form-control-sm" placeholder="Container">
            </div>



            <div class="col-md-3 pr-md-1 my-1 my-md-0">
                <input type="text" id="notify_id" name="notify_id" list="consigneeBins"
                    value="{{ $request->notify_id ?? null }}" class="form-control form-control-sm mt-1"
                    placeholder="Notify BIN" autocomplete="off">
                <datalist id="consigneeBins">
                    @foreach ($consigneenames as $key => $consigneename)
                        <option> {{ $key }}</option>
                    @endforeach
                </datalist>
            </div>
            <div class="col-md-3 px-md-1 my-1 my-md-0">
                <input type="text" id="notifyname" name="notifyname" value="{{ $request->notifyname ?? null }}"
                    class="form-control form-control-sm mt-1" placeholder="Notify Party Name">
            </div>



            <div class="col-md-6 pl-md-1 my-1 my-md-0">
                <input type="text" id="description" name="description" value="{{ $request->description ?? null }}"
                    class="form-control form-control-sm mt-1" placeholder="Description" autocomplete="off">
            </div>

            <div class="col-md-3 col-sm-3 col-lg-3 pr-md-1 my-1 my-md-0 d-flex align-items-end">
                <div class="border-checkbox-section">
                    <div class="border-checkbox-group border-checkbox-group-warning">
                        <input type="checkbox" id="note" name="note" class="border-checkbox"
                            @if ($note) checked @endif>
                        <label class="border-checkbox-label" for="note">DO Note</label>
                    </div>
                    <div class="border-checkbox-group border-checkbox-group-danger">
                        <input type="checkbox" id="dgCheck" name="dgCheck" class="border-checkbox"
                            @if ($dgCheck) checked @endif>
                        <label class="border-checkbox-label" for="dgCheck">DG</label>
                    </div>
                </div>
            </div>
            <div class="col-md-1 pl-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block mt-1"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end form row -->
    </form>
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>##</th>
                    <th>Edit</th>
                    <th>IGM No</th>
                    <th> B/L No</th>
                    <th>Vessel</th>
                    <th>Voyage</th>
                    <th>Rotation</th>
                    <th>Arrival Date</th>
                    <th>Berthing Date</th>
                    <th>Description</th>
                    <th>Consignee</th>
                    <th>Notify</th>
                    <th>Container No</th>
                    <th>Size</th>
                    <th>DO Note</th>
                    <th>DG</th>
                    <th>MR</th>
                    <th>DO No <br> Do Date</th>
                    <th> Customer Details </th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($mlobls as $key => $mlobl)
                    @foreach ($mlobl->blcontainers as $container)
                        <tr class="{{ $loop->parent->even ? 'bg-light' : null }}">
                            @php $totalContainer = count($mlobl->blcontainers) @endphp
                            @if ($loop->first)
                                <td rowspan="{{ $totalContainer }}">{{ $mlobls->firstItem() + $key }}</td>
                                <td rowspan="{{ $totalContainer }}" class="text-center">
                                    <div class="icon-btn">
                                        <nobr>
                                            @can('mlo-mloblinformation-edit')
                                                <a href="{{ url('mloblinformations/' . $mlobl->id . '/edit') }}"
                                                    data-toggle="tooltip" title="Edit" class="btn btn-warning"><i
                                                        class="fas fa-pen"></i></a>
                                            @endcan
                                        </nobr>
                                    </div>
                                </td>
                                <td rowspan="{{ $totalContainer }}">{{ $mlobl->feederinformations_id }}</td>
                                <td rowspan="{{ $totalContainer }}">{{ $mlobl->bolreference }}</td>
                                <td rowspan="{{ $totalContainer }}">{{ $mlobl->mlofeederInformation->feederVessel }}</td>
                                <td rowspan="{{ $totalContainer }}">{{ $mlobl->mlofeederInformation->voyageNumber }}</td>
                                <td rowspan="{{ $totalContainer }}">{{ $mlobl->mlofeederInformation->rotationNo }}</td>
                                <td rowspan="{{ $totalContainer }}">
                                    @if (!empty($mlobl->mlofeederInformation->arrivalDate))
                                        {{ date('d/m/Y', strtotime($mlobl->mlofeederInformation->arrivalDate)) }}
                                    @endif
                                </td>
                                <td rowspan="{{ $totalContainer }}">
                                    @if (!empty($mlobl->mlofeederInformation->berthingDate))
                                        {{ date('d/m/Y', strtotime($mlobl->mlofeederInformation->berthingDate)) }}
                                    @endif
                                </td>
                                <td rowspan="{{ $totalContainer }}" class="breakWords">
                                    {{ $mlobl->description }}
                                </td>
                                <td rowspan="{{ $totalContainer }}">
                                    <strong>{{ $mlobl->blConsignee->NAME }}</strong> <br>
                                    {{ $mlobl->blConsignee->BIN }}
                                </td>
                                <td rowspan="{{ $totalContainer }}">
                                    <strong>{{ $mlobl->blNotify->NAME }}</strong> <br>
                                    {{ $mlobl->blNotify->BIN }}
                                </td>
                            @endif

                            <td>{{ $container->contref }}</td>
                            <td>{{ $container->type }}</td>

                            @if ($loop->first)
                                <td rowspan="{{ $totalContainer }}">
                                    @if ($mlobl->note)
                                        <button class="btn btn-sm bg-warning p-1 m-0" disabled> Yes </button>
                                    @endif
                                </td>
                                <td rowspan="{{ $totalContainer }}">
                                    @if ($mlobl->dg)
                                        <button class="btn btn-sm bg-danger p-1 m-0" disabled> DG </button>
                                    @endif
                                </td>
                                <td rowspan="{{ $totalContainer }}">
                                    @if ($mlobl->mloMoneyReceipt)
                                        <a target="_blank" class="btn btn-sm bg-success p-2 m-2"
                                            href="{{ route('mloMoneyReceiptPdf', $mlobl->mloMoneyReceipt->id) }}">MR-{{ $mlobl->mloMoneyReceipt->id }}</a>
                                        <br>
                                        <strong>{{ $mlobl->mloMoneyReceipt->issueDate ? date('d/m/Y', strtotime($mlobl->mloMoneyReceipt->issueDate)) : null }}</strong>
                                    @endif
                                </td>
                                <td rowspan="{{ $totalContainer }}">
                                    @if ($mlobl->mloMoneyReceipt)
                                        @if ($mlobl->mloMoneyReceipt->deliveryOrder && $mlobl->mloMoneyReceipt->deliveryOrder->id)
                                            <a target="_blank" class="btn btn-sm bg-success p-2 m-2"
                                                href="{{ route('mloDoPDF', $mlobl->mloMoneyReceipt->deliveryOrder->id) }}">DO-{{ $mlobl->mloMoneyReceipt->deliveryOrder->id }}</a>
                                            <br>
                                            <strong>{{ $mlobl->mloMoneyReceipt->deliveryOrder->DO_Date ? date('d/m/Y', strtotime($mlobl->mloMoneyReceipt->deliveryOrder->DO_Date)) : null }}</strong>
                                        @endif
                                    @endif
                                </td>
                                <td rowspan="{{ $totalContainer }}" class="text-center">
                                    @if ($mlobl->mloMoneyReceipt && $mlobl->mloMoneyReceipt->deliveryOrder)
                                        {{ $mlobl->mloMoneyReceipt->client->cnfagent }} <br>
                                        {{ $mlobl->mloMoneyReceipt->client->contact }}
                                    @endif
                                </td>
                                <td rowspan="{{ $totalContainer }}" class="text-center">
                                    <div class="icon-btn">
                                        <nobr>
                                            <a href="{{ url('egmmloblinformations/' . $mlobl->id) }}" data-toggle="tooltip"
                                                title="Details" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                            @can('mlo-mloblinformation-edit')
                                                <a href="{{ url('egmmloblinformations/' . $mlobl->id . '/edit') }}"
                                                    data-toggle="tooltip" title="Edit" class="btn btn-warning"><i
                                                        class="fas fa-pen"></i></a>
                                            @endcan

                                            @can('mlo-mloblinformation-delete')
                                                <form action="{{ url('egmmloblinformations', [$mlobl->id]) }}" method="POST"
                                                    data-toggle="tooltip" title="Delete" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete"><i
                                                            class="fas fa-trash"></i></button>
                                                </form>
                                            @endcan
                                            <a href="{{ url('egmmloblinformations/log/' . $mlobl->id) }}" data-toggle="tooltip"
                                                title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
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
        {!! $mlobls->links() !!}
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
        $(document).ready(function() {
            $("#feederVessel").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('feederNameAutoComplete') }}",
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
                    $('#feederVessel').val(ui.item.value); // display the selected text
                    //                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            }).blur(function() {
                let vesselName = $(this).val();
                let dataList = $("#voyageList");
                if (vesselName != null) {
                    const url = '{{ url('voyageAutoComplete') }}/' + vesselName;
                    fetch(url)
                        .then((resp) => resp.json())
                        .then(function(hblno) {
                            dataList.empty();
                            hblno.forEach(function(data) {
                                dataList.append(
                                    `<option value="${data.voyageNumber}"></option>`);
                            });
                        })
                        .catch(function() {
                            $("#voyageNumber").val(null);
                        });
                }
            }); //vessel autocomplete

            $("#rotationNo").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('rotationNoAutoComplete') }}",
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
                    $('#rotationNo').val(ui.item.value); // display the selected text
                    //                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            }); //rotation autocomplete

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

            $("#notify_id").change(function() {
                let url = '{{ url('getBin') }}/' + $('#notify_id').val();
                fetch(url)
                    .then((resp) => resp.json())
                    .then(function(notifybin) {
                        $('#notifyname').val(notifybin.binName);
                    })
                    .catch(function() {
                        $('#notifyname').val(null);
                    });
            });

            $("#notifyname").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('binDataByNameAutoComplete') }}",
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
                    $('#notifyname').val(ui.item.name); // display the selected text
                    $('#notify_id').val(ui.item.bin); // display the selected text
                    return false;
                }
            });

        }); //document.ready
    </script>
@endsection
