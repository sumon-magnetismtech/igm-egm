@extends('layouts.egm-layout')
@section('title', 'FRD Money Receipt')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Money Receipt
    @else
        Add Money Receipt
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('moneyreceipts') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    @if ($formType == 'edit')
        <form action="{{ route('egmmoneyreceipts.update', $egmmoneyreceipt->id) }}" method="post" class="custom-form">
            @method('PUT')
            <input type="hidden" name="id" value="{{ $egmmoneyreceipt->id }}">
        @else
            <form action="{{ route('egmmoneyreceipts.store') }}" method="post" class="custom-form">
    @endif
    @csrf
    <div class="row px-2 d-flex align-items-end">
        <div class="col-xl-4 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Issue Date <span class="text-danger">*</span></span>
                <input type="text" id="issue_date" name="issue_date" class="form-control"
                    value="{{ old('issueDate')? old('issueDate'): (!empty($egmmoneyreceipt)? date('d/m/Y', strtotime($egmmoneyreceipt->issue_date)): now()->format('d/m/Y')) }}"
                    tabindex="-1" required>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> House BL <span class="text-danger">*</span> </span>
                <input type="text" name="bolreference" list="housebls" id="bolreference" class="form-control text-uppercase"
                    value="{{ old('bolreference') ? old('bolreference') : (!empty($bolreference) ? $bolreference : null) }}"
                    autofocus autocomplete="off" required>
                <input type="hidden" name="hblno" id="hbl_id"
                    value="{{ old('hblno') ? old('hblno') : (!empty($egmmoneyreceipt) ? $egmmoneyreceipt->hblno : null) }}">
                <datalist id="housebls">
                    @foreach ($housebls as $housebl)
                        <option>{{ Str::upper($housebl) }}</option>
                    @endforeach
                </datalist>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Accounts </span>
                <input type="text" id="accounts" name="accounts" class="form-control"
                    value="{{ old('accounts') ? old('accounts') : (!empty($egmmoneyreceipt) ? $egmmoneyreceipt->accounts : null) }}"
                    readonly tabindex="-1">
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Feeder Vessel </span>
                <input type="text" id="fvsl" name="fvsl" class="form-control"
                    value="{{ old('fvsl') ? old('fvsl') : (!empty($egmmoneyreceipt) ? $egmmoneyreceipt->housebl->masterbl->fvessel : null) }}"
                    readonly tabindex="-1">
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Voyage No </span>
                <input type="text" id="voyage" name="voyage" class="form-control"
                    value="{{ old('voyage') ? old('voyage') : (!empty($egmmoneyreceipt) ? $egmmoneyreceipt->housebl->masterbl->voyage : null) }}"
                    readonly tabindex="-1">
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Rotation No <span class="text-danger">*</span></span>
                <input type="text" id="rotation" name="rotation" class="form-control"
                    value="{{ old('rotation') ? old('rotation') : (!empty($egmmoneyreceipt) ? $egmmoneyreceipt->housebl->masterbl->rotno : null) }}"
                    readonly tabindex="-1">
            </div>
        </div>
        <div class="col-xl-2 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Quantity </span>
                <input type="text" id="quantity" name="quantity" class="form-control"
                    value="{{ old('quantity') ? old('quantity') : (!empty($egmmoneyreceipt) ? $egmmoneyreceipt->quantity : null) }}"
                    readonly tabindex="-1">
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Mother Vessel </span>
                <input type="text" id="mvsl" name="mvsl" class="form-control"
                    value="{{ old('mvsl') ? old('mvsl') : (!empty($egmmoneyreceipt) ? $egmmoneyreceipt->housebl->masterbl->mv : null) }}"
                    readonly tabindex="-1">
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Description </span>
                <textarea id="description" name="description" class="form-control" readonly
                    tabindex="-1">{{ old('description')? old('description'): (!empty($egmmoneyreceipt)? $egmmoneyreceipt->housebl->description: null) }}</textarea>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> D/O Note </span>
                <input type="text" id="doNote" name="doNote" class="form-control bg-warning" style="color:red!important;"
                    value="{{ old('doNote') ? old('doNote') : (!empty($egmmoneyreceipt) ? $egmmoneyreceipt->houseBl->note : null) }}"
                    tabindex="-1" readonly>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Free Time (Days) </span>
                <input type="number" min="0" id="free_time" name="free_time" class="form-control" placeholder="Free Time" required
                    value="{{ old('free_time') ? old('free_time') : (!empty($egmmoneyreceipt) ? $egmmoneyreceipt->free_time : null) }}">
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> From Date </span>
                <input type="text" id="from_date" name="from_date" class="form-control"
                    value="{{ old('from_date')? old('from_date'): (!empty($egmmoneyreceipt)? date('d/m/Y', strtotime($egmmoneyreceipt->from_date)): null) }}"
                    placeholder="dd/mm/yyyy" autocomplete="off" tabindex="-1" readonly>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Till Date </span>
                <input type="text" id="till_date" name="till_date" class="form-control"
                    value="{{ old('till_date')? old('till_date'): (!empty($egmmoneyreceipt) && $egmmoneyreceipt->till_date? date('d/m/Y', strtotime($egmmoneyreceipt->till_date)): null) }}"
                    placeholder="dd/mm/yyyy" autocomplete="off" tabindex="-1" readonly>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Upto Date</span>
                <input type="text" id="upto_date" name="upto_date" class="form-control"
                    value="{{ old('upto_date')? old('upto_date'): (!empty($egmmoneyreceipt)? ($egmmoneyreceipt->upto_date? date('d/m/Y', strtotime($egmmoneyreceipt->upto_date)): null): null) }}"
                    placeholder="dd/mm/yyyy" autocomplete="off">
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Total (Days)</span>
                <input type="number" id="duration" name="duration" class="form-control"
                    value="{{ old('duration') ? old('duration') : (!empty($egmmoneyreceipt) ? $egmmoneyreceipt->duration : 0) }}"
                    min="0" readonly tabindex="-1">
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Chargeable Days </span>
                <input type="number" id="chargeable_days" name="chargeable_days" class="form-control"
                    value="{{ old('chargeable_days')? old('chargeable_days'): (!empty($egmmoneyreceipt)? $egmmoneyreceipt->chargeable_days: 0) }}"
                    min="0" tabindex="-1" readonly>
            </div>
        </div>
        <div class="col-xl-6 col-lg-9 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Client Name <span class="text-danger">*</span> </span>
                <input type="text" id="client_name" name="client_name" list="clientList" class="form-control"
                    value="{{ old('client_name') ? old('client_name') : (!empty($egmmoneyreceipt) ? $egmmoneyreceipt->client_name : null) }}"
                    required autocomplete="off">
                <datalist id="clientList">
                    @foreach ($clients as $client)
                        <option value="{{ $client }}">{{ $client }}</option>
                    @endforeach
                </datalist>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Remarks </span>
                <textarea id="remarks" name="remarks" class="form-control" rows="2"
                    spellcheck="false">{{ old('remarks') ? old('remarks') : (!empty($egmmoneyreceipt) ? $egmmoneyreceipt->remarks : null) }}</textarea>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Pay Mode <span class="text-danger">*</span> </span>
                <select type="text" id="pay_mode" name="pay_mode" class="form-control">
                    <option value="cash" selected> Cash</option>
                    <option value="cheque"
                        {{ old('pay_mode') && old('pay_mode') == 'cheque'? 'selected': (!empty($egmmoneyreceipt) && $egmmoneyreceipt->pay_mode === 'cheque'? 'selected': null) }}>
                        Cheque </option>
                    <option value="payorder"
                        {{ old('pay_mode') && old('pay_mode') == 'payorder'? 'selected': (!empty($egmmoneyreceipt) && $egmmoneyreceipt->pay_mode === 'payorder'? 'selected': null) }}>
                        Pay Order </option>
                </select>
            </div>
        </div>


        <div class="col-xl-6 col-md-6" id="source_name_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="source_name">Bank Name <span class="text-danger">*</span></label>
                <input type="text" id="source_name" name="source_name" class="form-control"
                    value="{{ old('source_name') ? old('source_name') : (!empty($egmmoneyreceipt) ? $egmmoneyreceipt->source_name : null) }}">
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 px-1" id="pay_number_area">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Number </span>
                <input type="text" id="pay_number" name="pay_number" class="form-control"
                    value="{{ old('pay_number') ? old('pay_number') : (!empty($egmmoneyreceipt) ? $egmmoneyreceipt->pay_number : null) }}">
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 px-1" id="dated_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="dated">Dated <span class="text-danger">*</span></label>
                <input type="text" id="dated" name="dated" class="form-control"
                    value="{{ old('dated')? old('dated'): (!empty($egmmoneyreceipt)? date('d/m/Y', strtotime($egmmoneyreceipt->dated)): null )}}"">
            </div>
        </div>

        <div class="col-xl-1 col-md-6 px-1">
            <div class="border-checkbox-section">
                <div class="border-checkbox-group border-checkbox-group-primary">
                    <input type="checkbox" id="noc" name="noc" class="border-checkbox"
                        @if (old('noc') || (!empty($egmmoneyreceipt) && $egmmoneyreceipt->housebl->masterbl->noc)) checked @endif tabindex="-1" readonly onclick="return false; ">
                    <label class="border-checkbox-label" for="noc">NOC</label>
                </div>
            </div>
        </div>
    </div><!-- end row -->

    <hr class="my-2 bg-success">

    <div class="row d-flex align-items-center">
        <div class="col-md-6 my-1">
            <p class="my-1" id="totalContainers">
                @if (!empty($egmmoneyreceipt))
                    Total Containers: <strong>{{ count($egmmoneyreceipt->houseBl->containers) }}</strong>
                @endif
            </p>
        </div>
        <div class="col-md-6 my-1">
            <div class="float-right" id="containerList">
                @if (!empty($egmmoneyreceipt) && $containers)
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
        <table class="table table-striped table-bordered table-sm " id="moneyReceiptTable">
            <tr>
                <th class="text-center">Particulars</th>
                <th class="text-center">Amount</th>
                <th class="text-center">Action</th>
            </tr>
            @if (old('particular'))
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
                            <input type="text" style="text-align: right" name="amount[]"
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
            @elseif(!empty($egmmoneyreceipt))
                @foreach ($egmmoneyreceipt->MoneyreceiptDetail as $egmmoneyreceiptDetail)
                    <tr>
                        <td>
                            <select name="particular[]" class="form-control form-control-sm" required>
                                @foreach ($particulars as $particular)
                                    <option value="{{ $particular }}"
                                        {{ $egmmoneyreceiptDetail->particular == $particular ? 'selected' : null }}>
                                        {{ $particular }}</option>
                                @endforeach
                            </select>

                        </td>
                        <td class="text-right"><input type="text" name="amount[]" onkeyup="totalOperation()"
                                style="text-align: right" class="form-control form-control-sm amount"
                                value="{{ $egmmoneyreceiptDetail->amount }}"> </td>
                        <td> <button class="btn btn-success btn-sm addItem" type="button"><i
                                    class="fa fa-plus"></i></button> <button class="btn btn-danger btn-sm deleteItem"
                                id="" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>
                        <select name="particular[]" class="form-control form-control-sm" required>
                            @foreach ($particulars as $particular)
                                <option value="{{ $particular }}"
                                    {{ 'DSC / DO FEE' == $particular ? 'selected' : null }}> {{ $particular }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="text-right"><input type="text" name="amount[]" onkeyup="totalOperation()"
                            style="text-align: right" class="form-control form-control-sm amount" value="3500"> </td>
                    <td>
                        <button class="btn btn-success btn-sm addItem" type="button"><i
                                class="fa fa-plus"></i></button>
                        <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                class="fa fa-minus"></i></button>
                    </td>
                </tr>
            @endif
            <tfoot>
                <tr>
                    <td class="text-right"> Total </td>
                    <td><input type="text" id="totalAmount" class="form-control form-control-sm text-right" readonly
                            tabindex="-1"> </td>
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
            let MR_Row =
                `<tr>
                <td>
                <select name="particular[]" class="form-control form-control-sm" required>
                @foreach ($particulars as $particular)
                    <option value="{{ $particular }}"> {{ $particular }}</option>
                @endforeach
                    </select>
                    <td ><input style="text-align: right" type="text" name="amount[]" onkeyup="totalOperation()" class="form-control form-control-sm amount" placeholder="0.00" required></td>
                    <td><button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button> <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>`;
            $('#moneyReceiptTable').append(MR_Row);
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
        }

        function payModeCheck() {
            let payMode = $("#pay_mode").val();
            let moreInfoNeeds = ['cheque', 'payorder'];
            if (jQuery.inArray(payMode, moreInfoNeeds) !== -1) {
                $("#source_name_area, #pay_number_area, #dated_area").removeClass('d-none');
                $("#source_name, #pay_number, #dated").prop('required', true);
            } else {
                $("#source_name_area, #pay_number_area, #dated_area").addClass('d-none');
                $("#source_name, #pay_number, #dated").prop('required', false).val(null);
            }
        } //Check Payment Mode


        function calculateFreeTime() {
            let totalDays = parseInt($("#duration").val());
            let free_time = parseInt($("#free_time").val());

            if (isNaN(totalDays) || isNaN(free_time)) {
                $("#chargeable_days").val(0);
            } else if (free_time > totalDays) {
                $("#chargeable_days").val(0);
            } else {
                $("#chargeable_days").val(totalDays - free_time);
            }
        }

        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(document).ready(function() {
            totalOperation();
            payModeCheck();
            $('#issue_date').datepicker({
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
                totalOperation();
            });

            $("#upto_date").on('blur change', function() {
                let from_date, upto_date, totalDays;
                if (berthingStatus) {
                    if ($(this).val()) {
                        from_date = moment($("#from_date").val(), "DD/MM/YYYY");
                        upto_date = moment($("#upto_date").val(), "DD/MM/YYYY").add(1, 'days');
                        if (upto_date > from_date) {
                            totalDays = upto_date.diff(from_date, 'days');
                            $("#duration").val(totalDays);
                            calculateFreeTime();
                        } else {
                            alert("The Upto Date must be greater than the From Date.");
                            $(this).val(null).focus();
                            $("#duration").val(0);
                            $("#chargeable_days").val(0);
                        }
                    } else {
                        $("#duration").val(0);
                        $("#chargeable_days").val(0);
                    }
                }
            }).datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true
            }); //upto_date


            $("#free_time").on('change', function() {
                //                let from_date = $("#from_date").val();
                //                let free_time = $(this).val();
                //                if(from_date.length > 0){
                //                    from_dateParse = moment(from_date, "DD/MM/YYYY").add(free_time, 'days').subtract(1, 'd');
                //                    $("#till_date").val(moment(from_dateParse).format('DD/MM/YYYY'));
                //                }else{
                //                    alert("From Date is Empty.");
                //                }
                calculateFreeTime();
            });


            $("#bolreference").on('change', function() {
                let url = '{{ url('getEgmHouseBlinfo') }}/' + $(this).val();
                fetch(url)
                    .then((resp) => resp.json())
                    .then(function(hblno) {
                        if (hblno.from_date) {
                            berthingStatus = true;
                            $("#from_date").val(hblno.from_date);
                            $("#mvsl").val(hblno.mv);
                            $("#fvsl").val(hblno.vesselname);
                            $("#voyage").val(hblno.voyage);
                            $("#description").val(hblno.description);
                            $("#doNote").val(hblno.doNote);
                            $("#rotation").val(hblno.rotation);
                            $("#accounts").val(hblno.principal);
                            hblno.noc ? $("#noc").prop('checked', true) : $("#noc").prop('checked',
                                false);
                            if (hblno.extension) {
                                $("#extension").text(`(Extension-${hblno.extension})`);
                                alert(
                                    "Money Receipt has been generated before against this B/L No. Are you sure you want to extend?")
                            } else {
                                $("#extension").empty();
                            }
                            $("#client_name").val(hblno.client_name);
                            $("#totalContainers").text("Total Containers: " + hblno.containernumber);

                            $("#quantity").val(hblno.packageno);
                            //                        $("#contrNo").val(hblno.containernumber);
                            $("#hbl_id").val(hblno.hbl_id);

                            $("#containerList").empty();
                            for (var key in hblno.typeCount) {
                                $("#containerList").append(
                                    `<button type="button" class="btn btn-primary btn-sm px-2" tabindex="-1"> ${key} <span class="badge badge-dark">${hblno.typeCount[key]}</span></button>`
                                    );
                            }

                            if (hblno.free_time !== null) {
                                $("#free_time").val(hblno.free_time).addClass("readOnly").attr(
                                    'readonly', true).attr("tabindex", -1);
                            } else {
                                $("#free_time").val(0).removeClass("readOnly").removeAttr('readonly',
                                    'tabindex');
                            }

                            $("#upto_date").val(null);
                            $("#duration").val(null);
                            $("#chargeable_days").val(null);

                        } else {
                            berthingStatus = false;
                            $("#bolreference").focus();
                            $("#quantity, #mvsl,#fvsl,#contrNo,#rotation,#voyage,#accounts,#hbl_id, #doNote, #description,#from_date,#upto_date,#free_time,#duration,#chargeable_days,#client_name")
                                .val(null);
                            $("#totalContainers").text(null);
                            $("#containerList").empty();
                            alert("Berthing Date is empty. Please Updated Berthing Date First.");
                        }
                    })
                    .catch(function() {
                        alert("No record found based on your query.");
                        $("#quantity, #mvsl,#fvsl,#contrNo,#rotation,#voyage,#accounts,#hbl_id, #doNote, #description,#from_date,#upto_date,#free_time,#duration,#chargeable_days,#client_name")
                            .val(null);
                        $("#totalContainers").text(null);
                        $("#containerList").empty();
                    });
            });


            $("#pay_mode").on('change', function() {
                payModeCheck();
            }); //paymode onChange

            $("#remarks").focus(function() {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(this).offset().top - 50
                }, 1000);
            });
        }); //end document ready
    </script>
@endsection
