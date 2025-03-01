@extends('layouts.egm-layout')
@section('title', 'MLO-Delivery Order')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Delivery Order-MLO
    @else
        Add Delivery Order-MLO
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('egmmlodeliveryorders') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    @if ($formType == 'edit')
        <form action="{{ route('egmmlodeliveryorders.update', $deliveryOrder->id) }}" method="post" class="custom-form">
            @method('PUT')
            <input type="hidden" name="id" value="{{ $deliveryOrder->id }}">
        @else
            <form action="{{ route('egmmlodeliveryorders.store') }}" method="post" class="custom-form">
    @endif
    @csrf
    <div class="row d-flex align-items-end">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> BL No. <span class="text-danger">*</span></span>
                <input type="text" id="bolRef" name="bolRef" class="form-control text-uppercase"
                    value="{{ old('bolRef') ? old('bolRef') : (!empty($deliveryOrder) ? $deliveryOrder->moneyReceipt->bolRef : null) }}"
                    min="1" max="5" list="bolNolist" autocomplete="off" onchange="getBLData()">
                <datalist id="bolNolist">
                    @foreach ($bolNos as $bolNo)
                        <option value="{{ $bolNo }}">
                    @endforeach
                </datalist>
                <input type="hidden" id="mlo_money_receipt_id" name="mlo_money_receipt_id"
                    value="{{ old('mlo_money_receipt_id') ? old('mlo_money_receipt_id') : (!empty($deliveryOrder) ? $deliveryOrder->mlo_money_receipt_id : null) }}">
            </div>
        </div>
        <div class="col-xl-8 col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Client Name </span>
                <input type="text" id="client_name" name="client_name" class="form-control "
                    value="{{ old('client_name') ? old('client_name') : (!empty($deliveryOrder) ? $deliveryOrder->moneyReceipt->client->cnfagent : null) }}"
                    tabindex="-1" autocomplete="off" readonly>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Shipping Marks </span>
                <textarea type="text" id="shippingmarks" name="shippingmarks" class="form-control " tabindex="-1" readonly>{{ old('shippingmarks') ? old('shippingmarks') : (!empty($deliveryOrder) ? $deliveryOrder->moneyReceipt->molblInformations->shippingmark : null) }}</textarea>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Description </span>
                <textarea type="text" id="description" name="description" class="form-control " tabindex="-1" readonly>{{ old('description') ? old('description') : (!empty($deliveryOrder) ? $deliveryOrder->moneyReceipt->molblInformations->description : null) }}</textarea>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Total Package </span>
                <input type="text" id="packageNo" name="packageNo" class="form-control"
                    value="{{ old('packageNo') ? old('packageNo') : (!empty($deliveryOrder) ? $deliveryOrder->moneyReceipt->molblInformations->packageno : null) }}"
                    tabindex="-1" readonly>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Package Type </span>
                <input type="text" id="packageType" name="packageType" class="form-control "
                    value="{{ old('packageType') ? old('packageType') : (!empty($deliveryOrder) ? $deliveryOrder->moneyReceipt->molblInformations->package->packagecode : null) }}"
                    tabindex="-1" readonly>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Gross Weight </span>
                <input type="text" id="grosswt" name="grosswt" class="form-control "
                    value="{{ old('grosswt') ? old('grosswt') : (!empty($deliveryOrder) ? $deliveryOrder->moneyReceipt->molblInformations->grosswt : null) }}"
                    tabindex="-1" readonly>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Berthing Date </span>
                <input type="text" id="berthing_date" name="berthing_date" class="form-control"
                    value="{{ old('berthing_date') ? old('berthing_date') : (!empty($deliveryOrder) ? date('d/m/Y', strtotime($deliveryOrder->moneyReceipt->molblInformations->mlofeederInformation->berthingDate)) : null) }}"
                    tabindex="-1" autocomplete="off" readonly>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> From Date </span>
                <input type="text" id="from_date" name="from_date" class="form-control "
                    value="{{ old('from_date') ? old('from_date') : (!empty($deliveryOrder) ? date('d/m/Y', strtotime($deliveryOrder->moneyReceipt->fromDate)) : null) }}"
                    tabindex="-1" autocomplete="off" readonly>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Up To Date </span>
                <input type="text" id="upto_date" name="upto_date" class="form-control "
                    value="{{ old('upto_date') ? old('upto_date') : (!empty($deliveryOrder) ? date('d/m/Y', strtotime($deliveryOrder->moneyReceipt->uptoDate)) : null) }}"
                    tabindex="-1" readonly>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> BE No <span class="text-danger">*</span></span>
                <input type="text" id="BE_No" name="BE_No" class="form-control"
                    value="{{ old('BE_No') ? old('BE_No') : (!empty($deliveryOrder) ? $deliveryOrder->BE_No : null) }}">
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> BE Date <span class="text-danger">*</span></span>
                <input type="text" id="BE_Date" name="BE_Date" class="form-control "
                    value="{{ old('BE_Date') ? old('BE_Date') : (!empty($deliveryOrder) ? date('d/m/Y', strtotime($deliveryOrder->BE_Date)) : now()->format('d/m/Y')) }}"
                    autocomplete="off">
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> DO Date <span class="text-danger">*</span></span>
                <input type="text" id="DO_Date" name="DO_Date" class="form-control"
                    value="{{ old('DO_Date') ? old('DO_Date') : (!empty($deliveryOrder) ? date('d/m/Y', strtotime($deliveryOrder->DO_Date)) : now()->format('d/m/Y')) }}"
                    autocomplete="off">
            </div>
        </div>
    </div><!-- end row -->
    <input type="hidden" id="mbolRef" name="mbolRef">
    <div class="row">
        <div class="offset-xl-5 col-xl-2 offset-md-4 col-md-4 mt-3">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->
    </form>
@endsection

@section('script')
    <script>
        function getBLData() {
            var bolRef = $("#bolRef").val();
            let url = '{{ url('getEgmMloBlInfo/') }}/' + bolRef;
            // let url ='/getMloBlInfo/'+document.getElementById('bolRef').value;
            fetch(url) //Call the fetch function passing the url of the API  as a parameter
                .then((resp) => resp.json())
                .then(function(blno) {
                    $("#mlo_money_receipt_id").val(blno.mlo_money_receipt_id);
                    $("#client_name").val(blno.clientName);
                    $("#packageNo").val(blno.packageno);
                    $("#packageType").val(blno.packagecode);
                    $("#grosswt").val(blno.grosswt);
                    $("#shippingmarks").val(blno.shippingmark);
                    $("#from_date").val(blno.fromDate);
                    $("#upto_date").val(blno.uptoDate);
                    $("#berthing_date").val(blno.berthingDate);
                    $("#description").val(blno.description);
                })
                .catch(function() {
                    $("#mlo_money_receipt_id, #client_name,#packageNo,#packageType,#grosswt,#shippingmarks,#upto_date,#berthing_date,#description")
                        .val(null);
                });
        }

        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(document).ready(function() {
            $('#BE_Date').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true
            });
            $('#DO_Date').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true
            });


            $("#bolRef").autocomplete({
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
                    $('#bolRef').val(ui.item.value); // display the selected text
                    //                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            }); //bolreference autocomplete
        });
    </script>
@endsection
