@extends('layouts.egm-layout')
@section('title', 'Master BL')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Master BL
    @else
        Add New Master BL
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('egmmasterbls') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    <div class="row">

        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="input-group input-group-sm input-group-success">
                <span class="input-group-addon"> Clone IGM </span>
                <input type="text" id="igm" class="form-control" tabindex="-1">
            </div>
        </div>
    </div>

    @if ($formType == 'edit')
        <form action="{{ route('egmmasterbls.update', $egmmasterbl->id) }}" method="post" class="custom-form">
            @method('PUT')
            <input type="hidden" name="id" value="{{ $egmmasterbl->id }}">
        @else
            <form action="{{ route('egmmasterbls.store') }}" method="post" class="custom-form">
    @endif
    @csrf
    <div class="row d-flex align-items-end">
        <div class="col-xl-1 col-lg-2 col-md-2">
            <div class="border-checkbox-section">
                <div class="border-checkbox-group border-checkbox-group-primary">
                    <input type="checkbox" id="noc" name="noc" class="border-checkbox"
                        @if (old('noc') || (!empty($egmmasterbl) && $egmmasterbl->noc)) checked @endif>
                    <label class="border-checkbox-label" for="noc">NOC</label>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Custom Code <span class="text-danger">*</span></span>
                <input type="text" id="cofficecode" name="cofficecode" class="form-control" value="301" readonly>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Custom Office <span class="text-danger">*</span></span>
                <input type="text" id="cofficename" name="cofficename" class="form-control"
                    value="Custom House, Chittagong" readonly>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-4 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> BOL Nature <span class="text-danger">*</span></span>
                <select name="blnaturecode" id="blnaturecode" class="form-control" tabindex="-1"
                    data-parsley-required="true" onchange="getblnaturetype()">
                    @foreach ($blnaturecodes as $blnaturecode)
                        <option value="{{ $blnaturecode }}"
                            {{ !empty($egmmasterbl) && $egmmasterbl->blnaturecode == $blnaturecode ? 'selected' : null }}>
                            {{ $blnaturecode }} </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-2 col-lg-8 col-md-8 ">
            <div class="input-group input-group-sm ">
                <input type="text" id="blnaturetype" name="blnaturetype" class="form-control" tabindex="-1"
                    value="{{ old('blnaturetype') ? old('blnaturetype') : (!empty($egmmasterbl) ? $egmmasterbl->blnaturetype : null) }}"
                    placeholder="BOL Nature">
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-4 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> BOL Type <span class="text-danger">*</span></span>
                <select id="bltypecode" name="bltypecode" class="form-control" tabindex="-1" data-parsley-required="true"
                    onchange="getbltypename()">
                    @foreach ($bltypecodes as $bltypecode)
                        <option value="{{ $bltypecode }}"
                            {{ !empty($egmmasterbl) && $egmmasterbl->bltypecode == $bltypecode ? 'selected' : null }}>
                            {{ $bltypecode }} </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-4 col-lg-8 col-md-8 ">
            <div class="input-group input-group-sm ">
                <input type="text" id="bltypename" name="bltypename" class="form-control" tabindex="-1"
                    value="{{ old('bltypename') ? old('bltypename') : (!empty($egmmasterbl) ? $egmmasterbl->bltypename : null) }}"
                    placeholder="Enter B/L Type">
            </div>
        </div>
        <div class="col-xl-5 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Depot <span class="text-danger">*</span></span>
                <input type="text" id="depot" name="depot" class="form-control" tabindex="-1"
                    value="{{ old('depot') ? old('depot') : (!empty($egmmasterbl) ? $egmmasterbl->depot : 'CHITTAGONG PORT') }}"
                    placeholder="Enter Depot Name">
            </div>
        </div>
        <div class="col-xl-5 col-lg-6 col-md-6">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Carrier Name <span class="text-danger">*</span></span>
                <input type="text" id="carrier" name="carrier" class="form-control"
                    value="Magnetism Tech Ltd Limited" placeholder="Magnetism Tech Ltd Limited" disabled>
                <input type="hidden" name="carrier" value="301080083">
            </div>
        </div>
        <div class="col-xl-7 col-lg-12 col-md-12">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Carrier Address <span class="text-danger">*</span></span>
                <textarea class="form-control" rows="1" aria-label="Carrier Address" tabindex="-1" name="carrieraddress"
                    id="carrieraddress" readonly>CANDF TOWER, 4TH FLOOR, AGRABAD, CHITTAGONG, BANGLADESH</textarea>
            </div>
        </div>
    </div><!-- end row -->
    <hr class="my-2 bg-success">
    <div class="row d-flex align-items-end">
        <div class="col-xl-4 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Master B/L No <span class="text-danger">*</span></span>
                <input type="text" name="mblno" class="form-control text-uppercase" autofocus
                    value="{{ old('mblno') ? old('mblno') : (!empty($egmmasterbl) ? $egmmasterbl->mblno : null) }}"
                    required autocomplete="off">
            </div>
        </div>
        <div class="col-xl-5 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Feeder Vessel <span class="text-danger">*</span></span>
                <input type="text" id="fvessel" name="fvessel" class="form-control text-uppercase"
                    value="{{ old('fvessel') ? old('fvessel') : (!empty($egmmasterbl) ? $egmmasterbl->fvessel : null) }}"
                    required autocomplete="off">
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Voyage No <span class="text-danger">*</span></span>
                <input type="text" id="voyage" name="voyage" class="form-control text-uppercase"
                    value="{{ old('voyage') ? old('voyage') : (!empty($egmmasterbl) ? $egmmasterbl->voyage : null) }}"
                    required autocomplete="off">
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Departure <span class="text-danger">*</span></span>
                <input type="text" id="departure" name="departure" class="form-control"
                    value="{{ old('departure') ? old('departure') : (!empty($egmmasterbl) ? ($egmmasterbl->departure ? $egmmasterbl->departure->format('d/m/Y') : null) : null) }}"
                    placeholder="dd/mm/yyyy" required autocomplete="off">
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Arrival <span class="text-danger">*</span></span>
                <input type="text" id="arrival" name="arrival" class="form-control"
                    value="{{ old('arrival') ? old('arrival') : (!empty($egmmasterbl) ? ($egmmasterbl->arrival ? $egmmasterbl->arrival->format('d/m/Y') : null) : null) }}"
                    placeholder="dd/mm/yyyy" required autocomplete="off">
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Berthing </span>
                <input type="text" id="berthing" name="berthing" class="form-control"
                    value="{{ old('berthing') ? old('berthing') : (!empty($egmmasterbl) ? ($egmmasterbl->berthing ? $egmmasterbl->berthing->format('d/m/Y') : null) : null) }}"
                    placeholder="dd/mm/yyyy" autocomplete="off">
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Rotation </span>
                <input type="text" id="rotno" name="rotno" class="form-control"
                    value="{{ old('rotno') ? old('rotno') : (!empty($egmmasterbl) ? $egmmasterbl->rotno : null) }}">
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> PO Code <span class="text-danger">*</span> </span>
                <input type="text" id="pocode" name="pocode" class="form-control"
                    value="{{ old('pocode') ? old('pocode') : (!empty($egmmasterbl) ? $egmmasterbl->pocode : null) }}"
                    onchange="loadPortName()" required>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> PO Name <span class="text-danger">*</span> </span>
                <input type="text" id="poname" name="poname" class="form-control"
                    value="{{ old('poname') ? old('poname') : (!empty($egmmasterbl) ? $egmmasterbl->poname : null) }}"
                    required tabindex="-1">
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> PU Code <span class="text-danger">*</span> </span>
                <input type="text" id="pucode" name="pucode" class="form-control"
                    value="{{ old('pucode') ? old('pucode') : (!empty($egmmasterbl) ? $egmmasterbl->pucode : 'BDCGP') }}"
                    onchange="loadPortName2()">
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> PU Name <span class="text-danger">*</span> </span>
                <input type="text" id="puname" name="puname" class="form-control"
                    value="{{ old('puname') ? old('puname') : (!empty($egmmasterbl) ? $egmmasterbl->puname : null) }}"
                    required tabindex="-1">
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Principal <span class="text-danger">*</span> </span>
                <input type="text" list="principals" id="principal" class="form-control" name="principal"
                    value="{{ old('principal') ? old('principal') : (!empty($egmmasterbl) ? $egmmasterbl->principal : null) }}"
                    required>
                <datalist id="principals">
                    @foreach ($principals as $principal)
                        <option value="{{ $principal }}"></option>
                    @endforeach
                </datalist>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Mother Vessel</span>
                <input type="text" id="mv" name="mv" class="form-control text-uppercase"
                    value="{{ old('mv') ? old('mv') : (!empty($egmmasterbl) ? $egmmasterbl->mv : null) }}"
                    autocomplete="off">
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> MLO Code </span>
                <input type="text" id="mlocode" name="mlocode" class="form-control" list="mlocodes"
                    value="{{ old('mlocode') ? old('mlocode') : (!empty($egmmasterbl) ? $egmmasterbl->mlocode : null) }}"
                    onchange="loadMloName()" autocomplete="off">
                <datalist id="mlocodes">
                    @foreach ($mlocodes as $mlocode)
                        <option value="{{ $mlocode }}"></option>
                    @endforeach
                </datalist>
            </div>
        </div>

        <div class="col-xl-8 col-lg-6 col-md-6">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> MLO Name </span>
                <input type="text" id="mloname" name="mloname" class="form-control"
                    value="{{ old('mloname') ? old('mloname') : (!empty($egmmasterbl) ? $egmmasterbl->mloname : null) }}"
                    autocomplete="off">
            </div>
        </div>

        <div class="col-xl-12 col-lg-6 col-md-6 ">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> MLO Address </span>
                <textarea id="mloaddress" name="mloaddress" class="form-control" rows="2">{{ old('mloaddress') ? old('mloaddress') : (!empty($egmmasterbl) ? $egmmasterbl->mloaddress : null) }}</textarea>
            </div>
        </div>
    </div> <!-- end row -->

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
        function loadPortName() {
            let url = '{{ url('loadPortData') }}/' + $('#pocode').val();
            fetch(url)
                .then((resp) => resp.json())
                .then(function(pocode) {
                    $('#poname').val(pocode.depPortName);
                })
                .catch(function() {
                    alert("No Record Found.");
                    $('#poname').val("");
                });
        }


        function loadPortName2() {
            let url = '{{ url('loadPortData') }}/' + $('#pucode').val();
            fetch(url)
                .then((resp) => resp.json())
                .then(function(pucode) {
                    $('#puname').val(pucode.depPortName);
                })
                .catch(function() {
                    alert("No Record Found.");
                    $('#puname').val("");
                });
        }

        function loadMloName() {
            let url = '{{ url('getEgmMloname') }}/' + document.getElementById('mlocode').value;
            fetch(url)
                .then((resp) => resp.json())
                .then(function(mlocode) {
                    $("#mloname").val(mlocode.mloname);
                    $("#mloaddress").val(mlocode.mloaddress);
                })
                .catch(function() {
                    alert("No Record Found.");
                    $("#mloname").val("");
                    $("#mloaddress").val("");
                });
        }
    </script>

    <script>
        if (document.getElementById('blnaturecode').value == 23) {
            document.getElementById('blnaturetype').value = 'Import';
        }


        if (document.getElementById('bltypecode').value == 'HSB') {

            document.getElementById('bltypename').value = 'House Sea Bill';
        }

        if (document.getElementById('pucode').value == 'BDCGP') {

            document.getElementById('puname').value = 'Chittagong';
        }

        function getblnaturetype() {

            if (document.getElementById('blnaturecode').value == 22) {

                document.getElementById('blnaturetype').value = 'Export';
            } else if (document.getElementById('blnaturecode').value == 23) {

                document.getElementById('blnaturetype').value = 'Import';
            } else if (document.getElementById('blnaturecode').value == 24) {

                document.getElementById('blnaturetype').value = 'Transit';
            } else if (document.getElementById('blnaturecode').value == 28) {

                document.getElementById('blnaturetype').value = 'Transhipment';
            }

        }

        function getbltypename() {

            if (document.getElementById('bltypecode').value == 'MSB') {

                document.getElementById('bltypename').value = 'Master Sea Bill';
            } else if (document.getElementById('bltypecode').value == 'AWB') {

                document.getElementById('bltypename').value = 'Air Way Bill';
            } else if (document.getElementById('bltypecode').value == 'MAB') {

                document.getElementById('bltypename').value = 'Master AirwayBill';
            } else if (document.getElementById('bltypecode').value == 'HSB') {

                document.getElementById('bltypename').value = 'House Sea Bill';
            }

        }

        // function carrierid() {
        //
        //     document.getElementById('carrier').value=404355;
        //
        // }




        $(document).ready(function() {

            $("#pocode, #pucode").on('input', function() {
                // store current positions in variables
                var start = this.selectionStart,
                    end = this.selectionEnd;

                this.value = this.value.toUpperCase();

                // restore from variables...
                this.setSelectionRange(start, end);

            });

        });

        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(document).ready(function() {

            $("#poname").autocomplete({
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('loadPortDataAutoComplete') }}",
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
                    // Set selection
                    $('#poname').val(ui.item.label); // display the selected text
                    $('#pocode').val(ui.item.value); // save selected id to input
                    return false;
                }
            });


            $("#igm").on('blur', function() {
                let igm = $(this).val();

                let url = '{{ url('egmCloneMasterblById/') }}/' + igm;
                fetch(url)
                    .then((resp) => resp.json())
                    .then(function(masterbl) {
                        $('#cofficecode').val(masterbl.cofficecode);
                        $('#cofficename').val(masterbl.cofficename);
                        $('#blnaturecode').val(masterbl.blnaturecode);
                        $('#blnaturetype').val(masterbl.blnaturetype);
                        $('#bltypecode').val(masterbl.bltypecode);
                        $('#bltypename').val(masterbl.bltypename);
                        $('#fvessel').val(masterbl.fvessel);
                        $('#voyage').val(masterbl.voyage);
                        $('#rotno').val(masterbl.rotno);
                        $('#principal').val(masterbl.principal);
                        $('#departure').val(masterbl.departureDate);
                        $('#arrival').val(masterbl.arrivalDate);
                        $('#berthing').val(masterbl.berthingDate);
                        $('#pocode').val(masterbl.pocode);
                        $('#poname').val(masterbl.poname);
                        $('#pucode').val(masterbl.pucode);
                        $('#puname').val(masterbl.puname);
                        $('#carrier').val(masterbl.carrier);
                        $('#carrieraddress').val(masterbl.carrieraddress);
                        $('#depot').val(masterbl.depot);
                        $('#mv').val(masterbl.mv);
                        $('#mlocode').val(masterbl.mlocode);
                        $('#mloname').val(masterbl.mloname);
                        $('#mloaddress').val(masterbl.mloaddress);
                    })
                    .catch(function() {});

            }); //clone img data by id

        }); //document.ready
    </script>
@endsection
