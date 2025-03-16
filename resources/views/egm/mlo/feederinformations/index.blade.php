@extends('layouts.egm-layout')
@section('title', 'Feeder Information')

@section('breadcrumb-title', 'List of Feeder Information')

@section('breadcrumb-button')
    @can('mlo-feederinformation-create')
        <a href="{{ route('egmfeederinformations.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i
                class="fa fa-plus"></i></a>
    @endcan

    @role('super-admin')
        <a href="{{ route('egmtrashfeeder') }}" class="btn btn-out-dashed btn-sm btn-danger"><i class="fas fa-trash"></i> Trash</a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ $feederInformations->total() }}
@endsection

@section('content')
    <form action="" method="get">
        <div class="row">
            <div class="col-md-1 pr-md-1 my-1 my-md-0">
                <input type="text" id="igm" name="igm" class="form-control form-control-sm text-uppercase"
                    placeholder="IGM" autocomplete="off">
            </div>
            <div class="col-md-3 px-md-1 my-1 my-md-0">
                <input type="text" id="feederVessel" name="feederVessel"
                    class="form-control form-control-sm text-uppercase" placeholder="Vessel" autocomplete="off">
            </div>
            <div class="col-md-1 px-md-1 my-1 my-md-0">
                <input type="text" id="voyageNumber" name="voyageNumber"
                    class="form-control form-control-sm text-uppercase" list="voyageList" placeholder="Voyage"
                    autocomplete="off">
                <datalist id="voyageList"></datalist>
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0">
                <input type="text" id="rotationNo" name="rotationNo" class="form-control form-control-sm text-uppercase"
                    placeholder="Registration No" autocomplete="off">
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0">
                <input type="text" id="arrivalDate" name="arrivalDate" class="form-control form-control-sm"
                    placeholder="Arrival Date" autocomplete="off">
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0">
                <input type="text" id="contref" name="contref" class="form-control form-control-sm"
                    placeholder="Container">
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
                    <th> SL </th>
                    <th> IGM No </th>
                    <th> Feeder Vessel</th>
                    <th> Voyage </th>
                    <th> Rotation No</th>
                    <th> Dep. Code</th>
                    <th> Des. Code</th>
                    <th> Departure Date</th>
                    <th> Arrival Date</th>
                    <th> Berthing Date</th>
                    <th> Actions </th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th> SL </th>
                    <th> IGM No </th>
                    <th> Feeder Vessel</th>
                    <th> Voyage </th>
                    <th> Rotation No</th>
                    <th> Dep. Code</th>
                    <th> Des. Code</th>
                    <th> Departure Date</th>
                    <th> Arrival Date</th>
                    <th> Berthing Date</th>
                    <th> Actions </th>
                </tr>
            </tfoot>

            <tbody>
                @if ($feederInformations->isNotEmpty())
                    @foreach ($feederInformations as $key => $feederInfo)
                        <tr>
                            <td>{{ $feederInformations->firstItem() + $key }}</td>
                            <td><a href="{{ url('egmfeederinformations/' . $feederInfo->id) }}"
                                    class="btn btn-sm btn-dark-green">{{ $feederInfo->id }} </a></td>
                            <td class="text-left"> {{ $feederInfo->feederVessel }} </td>
                            <td class="text-left"> {{ $feederInfo->voyageNumber }} </td>
                            <td> {{ $feederInfo->rotationNo }} </td>
                            <td> <strong>{{ $feederInfo->depPortCode }}</strong></td>
                            <td> <strong>{{ $feederInfo->desPortCode }}</strong></td>
                            <td>{{ date('d/m/Y', strtotime($feederInfo->departureDate)) }}</td>
                            <td>
                                @if (!empty($feederInfo->arrivalDate))
                                    {{ date('d/m/Y', strtotime($feederInfo->arrivalDate)) }}
                                @endif
                            </td>
                            <td>
                                @if (!empty($feederInfo->berthingDate))
                                    {{ date('d/m/Y', strtotime($feederInfo->berthingDate)) }}
                                @endif
                            </td>
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        <a href="{{ route('egmfeederinformations.show', $feederInfo->id) }}"
                                            data-toggle="tooltip" title="Details" class="btn btn-primary"><i
                                                class="fas fa-eye"></i></a>

                                        {{-- @can('mloblinformation-create') --}}
                                        <a href="{{ url("egmBlEntryByFeeder/$feederInfo->id") }}" data-toggle="tooltip"
                                            class="btn btn-success addBlBtn" title="Add BL" target="_blank">
                                            <i class="fa fa-plus"></i> BL
                                        </a>
                                        {{-- @endcan --}}

                                        <a href="{{ url('egmfeederinformations/' . $feederInfo->id) }}" data-toggle="tooltip"
                                            title="Details" class="btn btn-primary"><i class="fas fa-eye"></i></a>

                                        @can('mlo-feederinformation-edit')
                                            <a href="{{ url('egmfeederinformations/' . $feederInfo->id . '/edit') }}"
                                                data-toggle="tooltip" title="Edit" class="btn btn-warning"><i
                                                    class="fas fa-pen"></i></a>
                                        @endcan

                                        @can('mlo-feederinformation-delete')
                                            <form action="{{ url('egmfeederinformations', [$feederInfo->id]) }}" method="POST"
                                                data-toggle="tooltip" title="Delete" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        @endcan

                                        <a href="{{ url('egmfeeders/log/' . $feederInfo->id) }}" data-toggle="tooltip"
                                            title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
                                        <button class="btn btn-outline-success moreButtonsSwitch" data-toggle="tooltip"
                                            title="More Options"><i class="fas fa-chevron-down"></i></button>
                                    </nobr>
                                </div>
                                @if ($feederInfo->mloblInformation->isNotEmpty())
                                    <div class="d-none moreButtons">
                                        <div class="icon-btn">
                                            <a href="{{ url('egmMloblxmldownload/' . $feederInfo->id) }}" data-toggle="tooltip"
                                                title="Download XML" class="mt-1 btn btn-outline-dark"><i
                                                    class="fas fa-download"></i> XML</a>
                                            <a href="{{ url("egmMlofeederinformations/$feederInfo->id/containerList") }}"
                                                data-toggle="tooltip" title="Download Container List"
                                                class="mt-1 btn btn-outline-dark"><i class="fas fa-download"></i> CNT</a>
                                            <a href="{{ url("egmMloprintAllBLByFeederID/$feederInfo->id/all") }}"
                                                target="_blank" data-toggle="tooltip" title="Print All IGM"
                                                class="mt-1 btn btn-outline-dark"><i class="fas fa-print"></i> IGM</a>
                                            <a href="{{ url("egmMloprintAllBLByFeederID/$feederInfo->id/bdkam") }}"
                                                target="_blank" data-toggle="tooltip" title="Print BDKAM"
                                                class="mt-1 btn btn-outline-dark"><i class="fas fa-print"></i> BDKAM </a>
                                            <a href="{{ url("egmMloprintAllBLByFeederID/$feederInfo->id/bdpng") }}"
                                                target="_blank" data-toggle="tooltip" title="Print BDPNG"
                                                class="mt-1 btn btn-outline-dark"><i class="fas fa-print"></i> BDPNG </a>
                                        </div>
                                        <div class="icon-btn">
                                            <a href="{{ url("egmMlofeederinformations/$feederInfo->id/ioccontainerlist") }}"
                                                target="_blank" data-toggle="tooltip" title="IOC"
                                                class="mt-1 btn btn-outline-dark"><i class="fas fa-paper-plane"></i>
                                                IOC</a>
                                            <a href="{{ url("egmMlofeederinformations/$feederInfo->id/lclContainerList") }}"
                                                data-toggle="tooltip" title="LCL Container List"
                                                class="mt-1 btn btn-outline-dark"><i class="fas fa-paper-print"></i>
                                                LCL</a>
                                            <a href="{{ url("egmMlofeederinformations/$feederInfo->id/inboundContainerList") }}"
                                                data-toggle="tooltip" title="Inbound Container List"
                                                class="mt-1 btn btn-outline-dark"><i class="fas fa-th"></i></a>
                                            <a href="{{ url("feederinformations/$feederInfo->id/permissionPDF") }}"
                                                data-toggle="tooltip" title="Permission English"
                                                class="mt-1 btn btn-outline-dark"><i class="fas fa-envelope"></i></a>
                                            <a href="{{ url("feederinformations/$feederInfo->id/permissionBengaliPDF") }}"
                                                data-toggle="tooltip" title="Permission Bengali"
                                                class="mt-1 btn btn-outline-dark"><i class="fas fa-envelope"></i></a>
                                            <a href="{{ url("egmMlofeederinformations/$feederInfo->id/arrivalNoticePDF") }}"
                                                target="_blank" data-toggle="tooltip" title="Arrival Notice"
                                                class="mt-1 btn btn-outline-dark"><i class="fas fa-copy"></i></a>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10">
                            <h5 class="text-muted my-3"> No Data Found Based on your query. </h5>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="float-right">
        {{ $feederInformations->links() }}
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
            //feeder first item bl button auto focus
            $(".addBlBtn").first().focus().addClass('bg-dark');
            $('#arrivalDate').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true
            });

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

            $(".moreButtonsSwitch").on('click', function() {
                $(this).parents('td').find('.fa-chevron-down').toggleClass('fa-chevron-up');
                $(this).parents('td').find('.moreButtons').toggleClass('d-none');
            });

        }); //document.ready
    </script>

@endsection
