@extends('layouts.new-layout')
@section('title', 'FRD - Reports')

@section('breadcrumb-title')
    @if (\Request::is('searchFrdLetter'))
        Forwarding Letter
    @endif
    @if (\Request::is('extensionLetter'))
        Extension Letter
    @endif
    @if (\Request::is('onChassisLetter'))
        On-Chassis Letter
    @endif
    @if (\Request::is('eDeliverySearch'))
        E-Delivery Letter
    @endif

@endsection

@section('breadcrumb-button')

@endsection

@section('sub-title')
    {{-- Total : --}}
@endsection

@section('content')
    @if (\Request::is('searchFrdLetter'))
        <form action="{{ route('frdLetter') }}" method="post">
            @csrf
            <input type="hidden" name="type" value="frd">
            <div class="row px-2">
                <div class="col-md-2 px-1 my-1">
                    <input type="text" id="mblno" name="mblno" class="form-control form-control-sm"
                        placeholder="Master BL" value="{{ old('mblno') ?? null }}" required>
                </div>
                <div class="col-md-4 px-1 my-1">
                    <input type="text" id="client" name="client" class="form-control form-control-sm"
                        list="clientlist" placeholder="Client Name" value="{{ old('client') ?? null }}" required>
                    <datalist id="clientlist">
                        @foreach ($clients as $client)
                            <option> {{ $client }}</option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-md-2 px-1 my-1">
                    <input type="text" name="deliveryLocation" id="deliveryLocation" class="form-control form-control-sm"
                        placeholder="Delivery Location" value="{{ old('deliveryLocation') ?? 'Chittagong Port' }}"
                        list="locationList" required>
                    <datalist id="locationList">
                        <option>Chittagong Port</option>
                        <option>On Chassis</option>
                        <option>Depot</option>
                    </datalist>
                </div>
                <div class="col-md-2 px-1 my-1">
                    <input type="text" name="freeTime" id="freeTime" class="form-control form-control-sm"
                        placeholder="Free Time" value="{{ old('freeTime') ?? null }}" autocomplete="off">
                </div>
                <div class="col-md-2 px-1 my-1">
                    <input type="text" name="mloLineNo" id="mloLineNo" class="form-control form-control-sm"
                        placeholder="Line No" value="{{ old('mloLineNo') ?? null }}" autocomplete="off">
                </div>
                <div class="col-md-6 px-1 my-1">
                    <input type="text" name="mloCommodity" id="mloCommodity" class="form-control form-control-sm"
                        placeholder="Commodity" value="{{ old('mloCommodity') ?? null }}" autocomplete="off">
                </div>
                <div class="col-md-2 px-1 my-1">
                    <select name="contMode" id="contMode" class="form-control form-control-sm">
                        <option disabled selected> Container Mode</option>
                        <option value="FCL"
                            {{ old('contMode') ? (old('contMode') == 'FCL' ? 'selected' : null) : null }}>
                            FCL </option>
                        <option value="LCL"
                            {{ old('contMode') ? (old('contMode') == 'LCL' ? 'selected' : null) : null }}>
                            LCL </option>
                        <option value="ETY"
                            {{ old('contMode') ? (old('contMode') == 'ETY' ? 'selected' : null) : null }}>
                            ETY </option>
                    </select>
                </div>
                <div class="col-md-2 px-1 my-1 d-flex align-items-end">
                    <div class="border-checkbox-section">
                        <div class="border-checkbox-group border-checkbox-group-primary">
                            <input type="checkbox" class="border-checkbox" id="withPad" name="withPad" checked>
                            <label class="border-checkbox-label" for="withPad">With Pad</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 px-1 my-1">
                    <div class="input-group input-group-sm">
                        <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div><!-- end form row -->
        </form>
    @endif

    @if (\Request::is('extensionLetter'))
        <form action="{{ route('extensionLetterData') }}" method="post">
            @csrf
            <input type="hidden" name="type" value="extension">
            <div class="row px-2">
                <div class="col-md-3 px-1 my-1">
                    <input class="form-control form-control-sm" type="text" id="mblno" name="mblno"
                        placeholder="Master BL" onchange="getContainersForExtension()" value="{{ old('mblno') ?? null }}"
                        required>
                </div>
                <div class="col-md-3 px-1 my-1">
                    <input class="form-control form-control-sm" type="text" id="bolreference" name="bolreference"
                        placeholder="House BL" onchange="getContainersForExtensionByBolRef()"
                        value="{{ old('bolreference') ?? null }}" required>
                </div>
                <div class="col-md-4 px-1 my-1">
                    <input class="form-control form-control-sm" list="clientlist" type="text" name="client"
                        id="client" placeholder="Client Name" value="{{ old('client') ?? null }}" required>
                    <datalist id="clientlist">
                        @foreach ($clients as $client)
                            <option> {{ $client }}</option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-md-2 px-1 my-1">
                    <input type="text" name="deliveryLocation" id="deliveryLocation"
                        class="form-control form-control-sm" list="locationList" placeholder="Delivery Location"
                        value="{{ old('deliveryLocation') ?? null }}" required>
                    <datalist id="locationList">
                        <option>On Chassis</option>
                        <option>Chittagong Port</option>
                        <option>Depot</option>
                    </datalist>
                </div>
                <div class="col-md-3 px-1 my-1">
                    <input type="text" name="freeTime" id="freeTime" class="form-control form-control-sm"
                        placeholder="Free Time" value="{{ old('freeTime') ?? null }}">
                </div>
                <div class="col-md-3 px-1 my-1 d-flex align-items-end">
                    <div class="border-checkbox-section">
                        <div class="border-checkbox-group border-checkbox-group-primary">
                            <input type="checkbox" class="border-checkbox" id="withPad" name="withPad" checked>
                            <label class="border-checkbox-label" for="withPad">With Pad</label>
                        </div>
                    </div>
                </div>
                <div id="containerArea"></div>
                <div class="col-md-2 px-1 my-1">
                    <div class="input-group input-group-sm">
                        <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div><!-- end form row -->
        </form>
    @endif

    @if (\Request::is('eDeliverySearch'))
        <form action="{{ route('eDeliveryData') }}" method="get">
            <input type="hidden" name="type" value="e-frd">
            @csrf
            <div class="row px-2">
                <div class="col-md-2 px-1 my-1">
                    <input type="text" id="mblno" name="mblno" class="form-control form-control-sm"
                        placeholder="Master BL" value="{{ old('mblno') ?? null }}" required>
                </div>
                <div class="col-md-2 px-1 my-1">
                    <input type="text" id="freeTime" name="freeTime" class="form-control form-control-sm"
                        placeholder="Free Time" value="{{ old('freeTime') ?? null }}">
                </div>
                <div class="col-md-2 px-1 my-1">
                    <input type="text" id="mloLineNo" name="mloLineNo" class="form-control form-control-sm"
                        placeholder="Line No" value="{{ old('mloLineNo') ?? null }}">
                </div>
                <div class="col-md-2 px-1 my-1">
                    <input type="text" id="mloCommodity" name="mloCommodity" class="form-control form-control-sm"
                        placeholder="Enter Commodity" value="{{ old('mloCommodity') ?? null }}" autocomplete="off">
                </div>
                <div class="col-md-2 px-1 my-1">
                    <select name="contMode" id="contMode" class="form-control form-control-sm">
                        <option disabled selected> Container Mode</option>
                        <option value="FCL"
                            {{ old('contMode') ? (old('contMode') == 'FCL' ? 'selected' : null) : null }}> FCL </option>
                        <option value="LCL"
                            {{ old('contMode') ? (old('contMode') == 'LCL' ? 'selected' : null) : null }}> LCL </option>
                        <option value="ETY"
                            {{ old('contMode') ? (old('contMode') == 'ETY' ? 'selected' : null) : null }}> ETY </option>
                    </select>
                </div>
                <div class="col-md-1 px-1 my-1">
                    <div class="input-group input-group-sm">
                        <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div><!-- end form row -->
        </form>
    @endif

    @if (\Request::is('onChassisLetter'))
        <form action="{{ route('onChassisLetterData') }}" method="post">
            @csrf
            <input type="hidden" name="type" value="onChassis">
            <div class="row px-2">
                <div class="col-md-2 px-1 my-1">
                    <input type="text" id="bolreference" name="bolreference" class="form-control form-control-sm"
                        placeholder="House BL" value="{{ old('bolreference') ?? null }}" required>
                </div>
                <div class="col-md-3 px-1 my-1">
                    <input type="text" id="client" name="client" class="form-control form-control-sm"
                        list="clientlist" placeholder="Client Name" value="{{ old('client') ?? null }}" required
                        autocomplete="off">
                    <datalist id="clientlist">
                        @foreach ($clients as $client)
                            <option> {{ $client }}</option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-md-2 px-1 my-1">
                    <input type="text" id="deliveryLocation" name="deliveryLocation"
                        class="form-control form-control-sm" list="locationList" placeholder="Delivery Location"
                        value="{{ old('deliveryLocation') ?? null }}" required autocomplete="off">
                    <datalist id="locationList">
                        <option>On Chassis</option>
                        <option>Chittagong Port</option>
                        <option>Depot</option>
                    </datalist>
                </div>
                <div class="col-md-2 px-1 my-1">
                    <input type="text" id="freeTime" name="freeTime" class="form-control form-control-sm"
                        placeholder="Free Time" value="{{ old('freeTime') ?? null }}" autocomplete="off">
                </div>
                <div class="col-md-2 px-1 my-1">
                    <input type="text" name="date" id="date" class="form-control form-control-sm"
                        placeholder="dd/mm/yyyy" value="{{ old('date') ?? null }}" required>
                </div>
                <div class="col-md-1 px-1 my-1">
                    <div class="input-group input-group-sm">
                        <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div><!-- end form row -->
        </form>
    @endif
@endsection



@section('script')
    <script>
        function getContainersForExtension() {
            $("#bolreference").val(null).removeAttr('required');

            let mblno = $("#mblno").val();
            let url = '{{ url('containerExtension') }}/' + mblno;
            let containerArea = $("#containerArea");
            containerArea.empty();
            fetch(url)
                .then((resp) => resp.json())
                .then(function(containers) {
                    containers.forEach(function(container) {
                        containerArea.append(
                            `
                            <button type="button" class="btn btn-primary btn-sm px-2">
                                <h6 class="mb-0">
                                    <input id="${container.id}" name="extensionContainer[]" value="${container.id}" type="checkbox">
                                    <label class="mb-0" for="${container.id}">${container.contref}</label>
                                </h6>
                            </button>
                        `
                        );
                    });
                })
        }

        function getContainersForExtensionByBolRef() {
            $("#mblno").val(null).removeAttr('required');

            let bolref = $("#bolreference").val();
            let url = '{{ url('containerExtensionByBolRef') }}/' + bolref;
            let containerArea = $("#containerArea");
            containerArea.empty();
            fetch(url)
                .then((resp) => resp.json())
                .then(function(containers) {
                    containers.forEach(function(container) {
                        containerArea.append(
                            `<button type="button" class="btn btn-primary btn-sm px-2">
                                <h6 class="mb-0">
                                    <input id="${container.id}" name="extensionContainer[]" value="${container.id}" type="checkbox">
                                    <label class="mb-0" for="${container.id}">${container.contref}</label>
                                </h6>
                            </button>
                        `
                        );
                    });
                })
        }


        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            $("#igm").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('loadHouseblIgmAutoComplete') }}",
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
                    $('#igm').val(ui.item.value); // display the selected text
                    //                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });
            $("#mblno").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('loadHouseblMblNoAutoComplete') }}",
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
                    $('#mblno').val(ui.item.value); // display the selected text
                    //                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });
            $("#bolreference").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('loadHouseblBolreferenceAutoComplete') }}",
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

            $("#mblno").blur(function() {
                let mblno = $(this).val();
                let url = '{{ url('getIgmByMbl') }}/' + mblno;
                fetch(url)
                    .then((resp) => resp.json())
                    .then(function(masterbl) {
                        $("#mloLineNo").val(masterbl.mloLineNo);
                        $("#mloCommodity").val(masterbl.mloCommodity);
                        $("#contMode").val(masterbl.contMode);
                    })
            });

        }); //document ready
    </script>
@endsection
