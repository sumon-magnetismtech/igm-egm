@extends('layouts.new-layout')
@section('title', 'Feeder Information')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Feeder Information
    @else
        Add New Feeder Information
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('feederinformations') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    @if ($formType == 'edit')
        <form action="{{ route('feederinformations.update', $feederinformation->id) }}" method="post" class="custom-form">
            @method('PUT')
            <input type="hidden" name="id" value="{{ $feederinformation->id }}">
        @else
            <form action="{{ route('feederinformations.store') }}" method="post" class="custom-form">
    @endif
    @csrf
    <div class="row px-2">
        <div class="col-xl-2 col-lg-4 col-md-4 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Custom Code <span class="text-danger">*</span></span>
                <input type="text" name="COCode" class="form-control" value="301" readonly tabindex="-1" required>
            </div>
        </div>
        <div class="col-xl-4 col-lg-8 col-md-8 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Custom Office <span class="text-danger">*</span></span>
                <input type="text" name="COName" class="form-control" value="Custom House, Chittagong" readonly
                    tabindex="-1" required>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Transport Code <span class="text-danger">*</span></span>
                <input type="text" name="mtCode" class="form-control" value="1" tabindex="-1" readonly required>
            </div>
        </div>
        <div class="col-xl-4 col-lg-8 col-md-8 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Transport Mode <span class="text-danger">*</span></span>
                <input type="text" name="mtType" class="form-control" value="Sea Transport" tabindex="-1" readonly
                    required>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Carrier Name <span class="text-danger">*</span></span>
                <input type="text" id="careerName" class="form-control" value=" Magnetism Tech Ltd"
                    placeholder=" Magnetism Tech Ltd" readonly tabindex="-1">
                <input type="hidden" name="careerName" value="301043125" required>
            </div>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-8 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Carrier Address <span class="text-danger">*</span></span>
                <input type="text" id="careerAddress" name="careerAddress" class="form-control"
                    value="CANDF TOWER, 4TH FLOOR, AGRABAD, CHITTAGONG, BANGLADESH." readonly tabindex="-1" required>
            </div>
        </div>
    </div>
    <hr class="my-2 bg-success">

    <div class="row px-2">
        <div class="col-xl-6 col-lg-8 col-md-12 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Feeder Vessel <span class="text-danger">*</span></span>
                <input type="text" name="feederVessel" class="form-control text-uppercase"
                    value="{{ old('feederVessel') ? old('feederVessel') : (!empty($feederinformation) ? $feederinformation->getOriginal('feederVessel') : null) }}"
                    required autofocus spellcheck="false" autocomplete="off">
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Voyage No <span class="text-danger">*</span></span>
                <input type="text" name="voyageNumber" class="form-control text-uppercase"
                    value="{{ old('voyageNumber') ? old('voyageNumber') : (!empty($feederinformation) ? $feederinformation->voyageNumber : null) }}"
                    required autocomplete="off">
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Registration No </span>
                <input type="text" name="rotationNo" class="form-control text-uppercase"
                    value="{{ old('rotationNo') ? old('rotationNo') : (!empty($feederinformation) ? $feederinformation->rotationNo : null) }}">
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Dep. Port code <span class="text-danger">*</span></span>
                <input type="text" id="depPortCode" name="depPortCode" class="form-control text-uppercase"
                    onchange="loadDepPort()"
                    value="{{ old('depPortCode') ? old('depPortCode') : (!empty($feederinformation) ? $feederinformation->depPortCode : 'SGSIN') }}"
                    autocomplete="off">
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Dep. Port Name <span class="text-danger">*</span></span>
                <input type="text" id="depPortName" class="form-control text-uppercase" name="depPortName"
                    value="{{ old('depPortName') ? old('depPortName') : (!empty($feederinformation) ? $feederinformation->depPortName : 'Singapore') }}">
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Des. Port Code <span class="text-danger">*</span></span>
                <input type="text" id="desPortCode" name="desPortCode" class="form-control text-uppercase"
                    onchange="loadDesPort()"
                    value="{{ old('desPortCode') ? old('desPortCode') : (!empty($feederinformation) ? $feederinformation->desPortCode : 'BDCGP') }}"
                    tabindex="-1">
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Des. Port Name <span class="text-danger">*</span></span>
                <input type="text" name="desPortName" id="desPortName" class="form-control text-uppercase"
                    value="{{ old('desPortName') ? old('desPortName') : (!empty($feederinformation) ? $feederinformation->desPortName : 'CHITTAGONG') }}"
                    tabindex="-1">
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Departure Date <span class="text-danger">*</span></span>
                <input type="text" id="departureDate" name="departureDate" class="form-control"
                    value="{{ old('departureDate') ? old('departureDate') : (!empty($feederinformation) ? date('d/m/Y', strtotime($feederinformation->departureDate)) : null) }}"
                    placeholder="dd/mm/yyyy" autocomplete="off" required>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Arrival Date </span>
                <input type="text" id="arrivalDate" name="arrivalDate" class="form-control"
                    value="{{ old('arrivalDate') ? old('arrivalDate') : (!empty($feederinformation->arrivalDate) ? date('d/m/Y', strtotime($feederinformation->arrivalDate)) : null) }}"
                    placeholder="dd/mm/yyyy" autocomplete="off">
            </div>
        </div>
        @php($count = 0)
        @if (!empty($feederinformation))
            @foreach ($feederinformation->mloblInformation as $mlobinformation)
                @if ($mlobinformation->mloMoneyReceipt)
                    @php($count = 1)
                    @break
                @endif
            @endforeach
        @endif
        <div class="col-xl-4 col-lg-4 col-md-6 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Berthing Date </span>
                <input type="text" id="berthingDate" name="berthingDate"
                    class="form-control {{ $count ? 'readOnly' : null }}"
                    value="{{ old('berthingDate') ? old('berthingDate') : (!empty($feederinformation->berthingDate) ? date('d/m/Y', strtotime($feederinformation->berthingDate)) : null) }}"
                    placeholder="dd/mm/yyyy" autocomplete="off" {{ $count ? 'readonly' : null }}>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Nationality Code<span class="text-danger">*</span></span>
                <input type="text" id="transportNationality" name="transportNationality"
                    class="form-control text-uppercase" placeholder="Code"
                    value="{{ old('transportNationality') ? old('transportNationality') : (!empty($feederinformation) ? $feederinformation->transportNationality : null) }}"
                    required autocomplete="off">
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Country Name <span class="text-danger">*</span></span>
                <input type="text" id="countryName" name="countryName" class="form-control text-uppercase"
                    value="{{ old('countryName') ? old('countryName') : (!empty($feederinformation) ? $feederinformation->country->name : null) }}"
                    required autocomplete="off">
            </div>
        </div>
        <div class="col-xl-4 col-lg-8 col-md-6 px-1">
            <div class="input-group input-group-sm ">
                <span class="input-group-addon"> Depot <span class="text-danger">*</span></span>
                <input type="text" name="depot" class="form-control" value="CHITTAGONG PORT"
                    placeholder="Depot Name" readonly tabindex="-1" required>
            </div>
        </div>
    </div><!-- end row -->


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
        function loadCountryByIso() {
            var countryIso = $("#transportNationality").val();
            let url = '{{ url('loadCountryByIso') }}/' + countryIso;
            fetch(url)
                .then((resp) => resp.json())
                .then(function(country) {
                    $('#countryName').val(country.name);
                })
                .catch(function() {
                    $("#countryName").val(null);
                });
        } //loadCountryByIso



        function loadDepPort() {
            var portCode = $("#depPortCode").val();
            let url = '{{ url('loadPortData') }}/' + portCode;
            fetch(url)
                .then((resp) => resp.json())
                .then(function(portCode) {
                    $('#depPortName').val(portCode.depPortName);
                })
                .catch(function() {

                });
        } //loadDepPort from Location


        function loadDesPort() {
            var portCode = $("#desPortCode").val();
            let url = '{{ url('loadPortData') }}/' + portCode;
            fetch(url)
                .then((resp) => resp.json())
                .then(function(portCode) {
                    $('#desPortName').val(portCode.depPortName);
                })
                .catch(function() {


                });
        } //loadDepPort from Location


        // CSRF Token
        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(document).ready(function() {
            $('#departureDate').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true
            });
            $('#arrivalDate').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true
            });
            $('#berthingDate').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true
            });

            $("#transportNationality").on('keyup blur change', function() {
                loadCountryByIso();
            });


            $("#depPortName").autocomplete({
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
                    $('#depPortName').val(ui.item.label); // display the selected text
                    $('#depPortCode').val(ui.item.value); // save selected id to input
                    return false;
                }
            });

            $("#countryName").autocomplete({
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('loadCountryByNameAutoComplete') }}",
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
                    $('#countryName').val(ui.item.label); // display the selected text
                    $('#transportNationality').val(ui.item.iso); // save selected id to input
                    return false;
                }
            });

        });
    </script>
@endsection
