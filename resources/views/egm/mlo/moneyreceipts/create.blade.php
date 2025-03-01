@extends('layouts.egm-layout')
@section('title', 'MLO Money Receipt')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Money Receipt-MLO
    @else
        Add Money Receipt-MLO
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('egmmlomoneyreceipts') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    @if ($formType == 'edit')
        <form action="{{ route('egmmlomoneyreceipts.update', $mlomoneyreceipt->id) }}" method="post" class="custom-form">
            @method('PUT')
            <input type="hidden" name="id" value="{{ $mlomoneyreceipt->id }}">
        @else
            <form action="{{ route('egmmlomoneyreceipts.store') }}" method="post" class="custom-form">
    @endif
    @csrf
    <div class="row px-2 d-flex align-items-end">
        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Issue Date <span class="text-danger">*</span></span>
                <input type="text" placeholder="dd/mm/yyyy" id="issueDate" aria-label="Departure" class="form-control"
                    name="issueDate"
                    value="{{ old('issueDate') ? old('issueDate') : (!empty($mlomoneyreceipt) ? date('d/m/Y', strtotime($mlomoneyreceipt->issueDate)) : date('d/m/Y', strtotime(now()))) }}"
                    autocomplete="off" required>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> BL Reference <span class="text-danger">*</span></span>
                <input type="text" id="bolRef" name="bolRef" class="form-control text-uppercase"
                    value="{{ old('bolRef') ? old('bolRef') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->bolRef : null) }}"
                    onchange="getBLInfo()" required tabindex="-1" spellcheck="false" autocomplete="off" autofocus>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Vessel </span>
                <input type="text" id="vessel" class="form-control" name="feederVessel"
                    value="{{ old('feederVessel') ? old('feederVessel') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->molblInformations->mlofeederInformation->feederVessel : null) }}"
                    readonly tabindex="-1">
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Voyage No </span>
                <input type="text" id="voyage" name="voyageNumber" class="form-control"
                    value="{{ old('voyageNumber') ? old('voyageNumber') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->molblInformations->mlofeederInformation->voyageNumber : null) }}"
                    readonly tabindex="-1">
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Rotation No <span class="text-danger">*</span></span>
                <input type="text" id="rotationNo" name="rotationNo" class="form-control" placeholder="Rotation No"
                    value="{{ old('rotationNo') ? old('rotationNo') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->molblInformations->mlofeederInformation->rotationNo : null) }}"
                    tabindex="-1">
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Principal </span>
                <input type="text" id="principal" name="principal" class="form-control"
                    value="{{ old('principal') ? old('principal') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->molblInformations->principal->name : null) }}"
                    readonly tabindex="-1">
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Description </span>
                <textarea id="description" name="description" class="form-control" readonly tabindex="-1">{{ old('description') ? old('description') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->molblInformations->description : null) }}</textarea>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> D/O Note </span>
                <textarea id="doNote" name="note" style="color: red;" class="form-control bg-warning font-weight-bold text-danger"
                    readonly tabindex="-1">{{ old('note') ? old('note') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->molblInformations->note : null) }}</textarea>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Free Time (Days) </span>
                <input type="number" min="0" id="freeTime" name="freeTime" class="form-control"
                    placeholder="Free Time"
                    value="{{ old('freeTime') ? old('freeTime') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->freeTime : 0) }}">
            </div>
        </div>


        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> From Date </span>
                <input type="text" id="fromDate" name="fromDate" class="form-control"
                    value="{{ old('fromDate') ? old('fromDate') : (!empty($mlomoneyreceipt) ? date('d/m/Y', strtotime($mlomoneyreceipt->fromDate)) : null) }}"
                    placeholder="dd/mm/yyyy" autocomplete="off" tabindex="-1" required readonly>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Till Date </span>
                <input type="text" id="tillDate" name="tillDate" class="form-control"
                    value="{{ old('tillDate') ? old('tillDate') : (!empty($mlomoneyreceipt) && $mlomoneyreceipt->tillDate ? date('d/m/Y', strtotime($mlomoneyreceipt->tillDate)) : null) }}"
                    placeholder="dd/mm/yyyy" autocomplete="off" tabindex="-1" required readonly>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Upto Date <span class="text-danger">*</span></span>
                <input type="text" id="uptoDate" name="uptoDate" class="form-control"
                    value="{{ old('uptoDate') ? old('uptoDate') : (!empty($mlomoneyreceipt) ? ($mlomoneyreceipt->uptoDate ? date('d/m/Y', strtotime($mlomoneyreceipt->uptoDate)) : null) : null) }}"
                    placeholder="dd/mm/yyyy" autocomplete="off" required>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Total (Days)</span>
                <input type="number" id="duration" name="duration" class="form-control"
                    value="{{ old('duration') ? old('duration') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->duration : 0) }}"
                    min="0" readonly tabindex="-1">
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Chargeable Days </span>
                <input type="number" id="chargeableDays" name="chargeableDays" class="form-control"
                    value="{{ old('chargeableDays') ? old('chargeableDays') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->chargeableDays : 0) }}"
                    min="0" tabindex="-1" readonly>
            </div>
        </div>
        <div class="col-xl-6 col-lg-9 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Client Name <span class="text-danger">*</span></span>
                <input type="text" id="clientName" name="clientName" class="form-control text-uppercase"
                    value="{{ old('clientName') ? old('clientName') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->client->cnfagent : null) }}"
                    spellcheck="false" required autocomplete="off">
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 px-1 d-none">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Client ID </span>
                <input type="text" name="client_id" id="client_id" class="form-control"
                    value="{{ old('client_id') ? old('client_id') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->client_id : null) }}"
                    readonly>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Remarks </span>
                <textarea id="remarks" name="remarks" class="form-control" rows="2" spellcheck="false">{{ old('remarks') ? old('remarks') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->remarks : null) }}</textarea>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Pay Mode <span class="text-danger">*</span></span>
                <select name="payMode" id="payMode" class="form-control">
                    <option value="cash" selected> Cash</option>
                    <option value="cheque"
                        {{ old('payMode') && old('payMode') == 'cheque' ? 'selected' : (!empty($mlomoneyreceipt) && $mlomoneyreceipt->payMode === 'cheque' ? 'selected' : null) }}>
                        Cheque </option>
                    <option value="payorder"
                        {{ old('payMode') && old('payMode') == 'payorder' ? 'selected' : (!empty($mlomoneyreceipt) && $mlomoneyreceipt->payMode === 'payorder' ? 'selected' : null) }}>
                        Pay Order </option>
                </select>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 px-1" id="source_name_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="source_name">Bank Name <span class="text-danger">*</span></label>
                <input type="text" id="source_name" name="source_name" class="form-control"
                    value="{{ old('source_name') ? old('source_name') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->source_name : null) }}">
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 px-1" id="pay_number_area">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Number </span>
                <input type="text" id="payNumber" name="payNumber" class="form-control"
                    value="{{ old('payNumber') ? old('payNumber') : (!empty($mlomoneyreceipt) ? $mlomoneyreceipt->payNumber : null) }}">
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 px-1" id="dated_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="dated">Dated <span class="text-danger">*</span></label>
                <input type="text" id="dated" name="dated" class="form-control"
                    value="{{ old('dated') ? old('dated') : (!empty($mlomoneyreceipt) ? date('d/m/Y', strtotime($mlomoneyreceipt->dated)) : null) }}">
            </div>
        </div>
    </div><!-- end row -->

    <hr class="my-2 bg-success">

    <div class="row d-flex align-items-center">
        <div class="col-md-6 my-1">
            <p class="my-1" id="totalContainers">
                @if (!empty($mlomoneyreceipt))
                    {{ 'Total Containers: ' . count($mlomoneyreceipt->molblInformations->blcontainers) }}
                @endif
            </p>
        </div>
        <div class="col-md-6 my-1">
            <div class="float-right" id="containerList">
                @if (!empty($mlomoneyreceipt) && $containers)
                    @foreach ($containers as $key => $container)
                        <button type="button" class="btn btn-primary btn-sm px-2" tabindex="-1">
                            {{ $key }} <span class="badge badge-dark">{{ $container }}</span>
                        </button>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="moneyReceiptTable" class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th>Particulars</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (old('particular'))
                    @php($totalAmount = 0)
                    @foreach (old('particular') as $key => $oldParticular)
                        <tr>
                            <td>
                                <select name="particular[]" class="form-control form-control-sm">
                                    @foreach ($particulars as $particular)
                                        @if ($particular == old('particular')[$key])
                                            <option value="{{ $particular }}" selected> {{ $particular }}</option>
                                        @else
                                            <option value="{{ $particular }}"> {{ $particular }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                @php($totalAmount += old('amount')[$key])
                                <input type="text" style="text-align: right" name="amount[]"
                                    id="{{ old('particular')[$key] == 'Cleaning' ? 'cleaningAmount' : null }}"
                                    class="form-control form-control-sm amount" placeholder="0.00"
                                    value="{{ old('amount')[$key] }}" onkeyup="totalOperation()" required>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm addItem" type="button"><i
                                        class="fa fa-plus"></i></button>
                                <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                        class="fa fa-minus"></i></button>
                            </td>
                        </tr>
                    @endforeach
                @elseif(!empty($mlomoneyreceipt))
                    @php($totalAmount = 0)
                    @foreach ($mlomoneyreceipt->mloMoneyReceiptDetails as $receiptDetail)
                        <tr>
                            <td>
                                <select name="particular[]" class="form-control form-control-sm">
                                    @foreach ($particulars as $particular)
                                        @if ($particular == $receiptDetail->particular)
                                            <option value="{{ $particular }}" selected> {{ $particular }}</option>
                                        @else
                                            <option value="{{ $particular }}"> {{ $particular }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                @php($totalAmount += $receiptDetail->amount)
                                <input style="text-align: right" type="text" name="amount[]"
                                    id="{{ $receiptDetail->particular == 'Cleaning' ? 'cleaningAmount' : null }}"
                                    class="form-control form-control-sm amount" placeholder="0.00"
                                    value="{{ $receiptDetail->amount }}" onkeyup="totalOperation()" required>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm addItem" type="button"><i
                                        class="fa fa-plus"></i></button>
                                <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                        class="fa fa-minus"></i></button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>
                            <select name="particular[]" class="form-control form-control-sm particular" tabindex="-1"
                                required>
                                @foreach ($particulars as $particular)
                                    @if ($particular == 'DOCUMENTATION')
                                        <option value="{{ $particular }}" selected> {{ $particular }} </option>
                                    @else
                                        <option value="{{ $particular }}"> {{ $particular }} </option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td><input style="text-align: right" type="text" name="amount[]"
                                class="form-control form-control-sm amount" value="3500" required
                                onkeyup="totalOperation()"></td>
                        <td>
                            <button class="btn btn-success btn-sm addItem" type="button"><i
                                    class="fa fa-plus"></i></button>
                            <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                    class="fa fa-minus"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="particular[]" class="form-control form-control-sm particular" tabindex="-1"
                                required>
                                @foreach ($particulars as $particular)
                                    @if ($particular == 'CLEANING FEE')
                                        <option value="{{ $particular }}" selected> {{ $particular }} </option>
                                    @else
                                        <option value="{{ $particular }}"> {{ $particular }} </option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td><input style="text-align: right" type="text" name="amount[]" id="cleaningAmount"
                                class="form-control form-control-sm amount" placeholder="0.00" required
                                onkeyup="totalOperation()"></td>
                        <td>
                            <button class="btn btn-success btn-sm addItem" type="button"><i
                                    class="fa fa-plus"></i></button>
                            <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                    class="fa fa-minus"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="particular[]" class="form-control form-control-sm particular" tabindex="-1"
                                required>
                                @foreach ($particulars as $particular)
                                    @if ($particular == 'DETENTION')
                                        <option value="{{ $particular }}" selected> {{ $particular }} </option>
                                    @else
                                        <option value="{{ $particular }}"> {{ $particular }} </option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td><input style="text-align: right" type="text" name="amount[]"
                                class="form-control form-control-sm amount" placeholder="0.00" required
                                onkeyup="totalOperation()"></td>
                        <td>
                            <button class="btn btn-success btn-sm addItem" type="button"><i
                                    class="fa fa-plus"></i></button>
                            <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                    class="fa fa-minus"></i></button>
                        </td>
                    </tr>
                @endif
            </tbody>

            <tfoot>
                <tr>
                    <td class="text-right"> Total </td>
                    <td>
                        <input type="text" id="totalAmount" class="form-control  form-control-sm text-right"
                            value="{{ old('particular') ? $totalAmount : (!empty($mlomoneyreceipt) ? $totalAmount : null) }}"
                            readonly>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

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
    <script src="{{ asset('js/moment.js') }}"></script>

    <script>
        var berthingStatus = true;
        var i = 1;

        function addRow() {
            i++;
            var MR_Row = `
            <tr>
            <td><select name="particular[]" class="form-control" required> <option value=""> Select Particular </option>@foreach ($particulars as $particular) <option value="{{ $particular }}"> {{ $particular }}</option> @endforeach</select>
            <td><input style="text-align: right" type="text" name="amount[]" class="form-control amount" placeholder="0.00" required onkeyup="totalOperation()"></td>
            <td><button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button> <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
            </tr>
        `;

            $('#moneyReceiptTable tbody').append(MR_Row);
            totalOperation();
        }

        function totalOperation() {
            var total = 0;
            if ($(".amount").length > 0) {
                $(".amount").each(function(i, row) {
                    var amountTK = Number($(row).val());
                    total += parseFloat(amountTK);
                })
            }
            $("#totalAmount").val(total);
        };

        function payModeCheck() {
            let payMode = $("#payMode").val();
            let moreInfoNeeds = ['cheque', 'payorder'];
            if (jQuery.inArray(payMode, moreInfoNeeds) !== -1) {
                $("#source_name_area, #pay_number_area, #dated_area").removeClass('d-none');
                $("#source_name, #payNumber, #dated").prop('required', true);
            } else {
                $("#source_name_area, #pay_number_area, #dated_area").addClass('d-none');
                $("#source_name, #payNumber, #dated").prop('required', false).val(null);
            }
        } //Check Payment Mode


        function getBLInfo() {
            var bolRef = $("#bolRef").val();
            let url = '{{ url('getEgmBLInfo/') }}/' + bolRef;
            fetch(url)
                .then((resp) => resp.json())

                .then(function(blno) {
                    if (blno.fromDate) {
                        berthingStatus = true;
                        $("#fromDate").val(blno.fromDate);
                        $("#vessel").val(blno.feederVessel);
                        $("#voyage").val(blno.voyageNumber);
                        $("#description").val(blno.description);
                        $("#doNote").val(blno.note);
                        $("#rotationNo").val(blno.rotationNo);
                        $("#principal").val(blno.principal);
                        if (blno.extension) {
                            $("#extension").text(`(Extension-${blno.extension})`);
                            alert(
                                "Money Receipt has been generated before against this B/L No. Are you sure you want to extend?")
                        } else {
                            $("#extension").empty();
                        }
                        $("#client_id").val(blno.client_id);
                        $("#clientName").val(blno.clientName);



                        $("#totalContainers").text("Total Containers: " + blno.total);

                        $("#containerList").empty();
                        for (var key in blno.typeCount) {
                            $("#containerList").append(
                                `<button type="button" class="btn btn-primary btn-sm px-2" tabindex="-1">${key} <span class="badge badge-dark">${blno.typeCount[key]}</span></button>`
                                );
                        }

                        let cleaningCharge = 0;
                        if (blno.principal == "DOLPHINE LINE") {
                            blno.containersInfo.forEach(function(container) {
                                let containerType = container.type;
                                if (containerType.includes('20', 0)) {
                                    cleaningCharge += 1300;
                                } else if (containerType.includes('40', 0) || containerType.includes('L5', 0)) {
                                    cleaningCharge += 2500;
                                } else {
                                    cleaningCharge += 1300;
                                }
                            });
                        } else {
                            cleaningCharge = blno.total * 850;
                        }
                        $("#cleaningAmount").val(cleaningCharge);
                        totalOperation();


                        if (blno.freeTime !== null) {
                            $("#freeTime").val(blno.freeTime).addClass("readOnly").attr('readonly', true).attr(
                                "tabindex", -1);
                        } else {
                            $("#freeTime").val(0).removeClass("readOnly").removeAttr('readonly', 'tabindex');
                        }

                        $("#uptoDate").val(null);
                        $("#duration").val(null);
                        $("#chargeableDays").val(null);
                    } else {
                        berthingStatus = false;
                        $("#bolRef").focus();
                        $("#vessel,#voyage,#description,#doNote,#rotationNo,#fromDate,#principal,#uptoDate,#freeTime,#duration,#freeTime,#chargeableDays, #cleaningAmount, #client_id, #clientName")
                            .val(null);
                        $("#totalContainers").text(null);
                        $("#containerList").empty();
                        alert("Berthing Date is empty. Please Updated Berthing Date First.");
                    }
                })
                .catch(function() {
                    $("#vessel,#voyage,#description,#doNote,#rotationNo,#fromDate,#principal,#uptoDate,#freeTime,#duration,#freeTime,#chargeableDays, #cleaningAmount, #client_id, #clientName")
                        .val(null);
                    $("#totalContainers").text(null);
                    $("#containerList").empty();
                });
        }


        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(document).ready(function() {
            payModeCheck();
            $('#issueDate').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true
            });
            $('#dated').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true
            });

            $(document).on('click', ".addItem", function() {
                addRow();
            });

            $("#moneyReceiptTable").on('click', '.deleteItem', function() {
                $(this).closest('tr').remove();
            });


            $("#uptoDate").on('blur change', function() {
                    let fromDate, uptoDate, totalDays;
                    if (berthingStatus) {
                        if ($(this).val()) {
                            fromDate = moment($("#fromDate").val(), "DD/MM/YYYY");
                            uptoDate = moment($("#uptoDate").val(), "DD/MM/YYYY").add(1, 'days');
                            if (uptoDate > fromDate) {
                                totalDays = uptoDate.diff(fromDate, 'days');
                                $("#duration").val(totalDays);
                                calculateFreeTime();
                            } else {
                                alert("The Upto Date must be greater than the From Date.");
                                $(this).val(null).focus();
                                $("#duration").val(0);
                                $("#chargeableDays").val(0);
                            }
                        } else {
                            $("#duration").val(0);
                            $("#chargeableDays").val(0);
                        }
                    }
                })
                .datepicker({
                    format: "dd/mm/yyyy",
                    autoclose: true,
                    todayHighlight: true
                }); //uptoDate


            $("#freeTime").on('keyup', function() {
                calculateFreeTime();
            });


            function calculateFreeTime() {
                let totalDays = parseInt($("#duration").val());
                let freeTime = parseInt($("#freeTime").val());

                if (isNaN(totalDays) || isNaN(freeTime)) {
                    $("#chargeableDays").val(0);
                } else if (freeTime > totalDays) {
                    $("#chargeableDays").val(0);
                } else {
                    $("#chargeableDays").val(totalDays - freeTime);
                }
            }



            $("#bolRef").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('egmbolreferenceAutoComplete') }}",
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

            $("#payMode").on('change', function() {
                payModeCheck();
            }); //paymode onChange

            $("#remarks").focus(function() {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(this).offset().top - 50
                }, 1000);
            });
            $("#clientName").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('loadCnfClientNameAutoComplete') }}",
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
                    $('#clientName').val(ui.item.value); // display the selected text
                    $('#client_id').val(ui.item.id); // display the selected text
                    return false;
                }
            });
        }); //end document ready
    </script>




@endsection
