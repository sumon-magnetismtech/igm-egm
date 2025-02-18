@extends('layouts.new-layout')
@section('title', 'Feeder Custom Update')


@section('breadcrumb-title', 'Feeder Custom Update')

@section('breadcrumb-button')

@endsection

@section('sub-title')
    Total : {{count($feederInformations)}}
@endsection

@section('content')
    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-4 px-1 my-1">
                <input type="text" id="feederVessel" name="feederVessel" class="form-control form-control-sm" value="{{$feederVessel ?? null}}" placeholder="Feeder Vessel" autocomplete="off">
            </div>
            <div class="col-md-2 px-1 my-1">
                <input type="text" id="voyage" name="voyage" class="form-control form-control-sm" list="voyageList" value="{{$voy ?? null}}" placeholder="Voyage" autocomplete="off">
                <datalist id="voyageList"></datalist>
            </div>
            <div class="col-md-2 px-1 my-1">
                <input type="text" id="rotationNo" name="rotationNo" class="form-control form-control-sm" value="{{$rotationNo ?? null}}" placeholder="Rotation" autocomplete="off">
            </div>
            <div class="col-md-1 px-1 my-1">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Sl</th>
                <th>Feeder Vessel & Voy</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Berthing</th>
                <th>IMP. REG</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl</th>
                <th>Feeder Vessel & Voy</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Berthing</th>
                <th>IMP. REG</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($feederInformations as $key => $feederInformation)
                <tr>
                    <td> {{$loop->iteration}}</td>
                    <td>
                        <strong>{{$feederInformation->feederVessel}}</strong> V.{{$feederInformation->voyageNumber}}
                        <input type="hidden" name="id" class="id" value="{{$feederInformation->id ?? null}}">
                    </td>

                    <td>
                        {{$feederInformation->departureDate ? date('d/m/Y', strtotime($feederInformation->departureDate)) : null}}
                    </td>
                    <td>
                        {{$feederInformation->arrivalDate ? date('d/m/Y', strtotime($feederInformation->arrivalDate)) : null}}
                    </td>
                    <td>
                        <input type="text" style="width: 90px" class="berthingDate" placeholder="dd/mm/yyyy" name="berthingDate" value="{{$feederInformation->berthingDate ? date('d/m/Y', strtotime($feederInformation->berthingDate)) : null}}">
                    </td>
                    <td>
                        <input style="width: 90px" type="text" class="rotationNo" name="rotationNo" value="{{$feederInformation->rotationNo ?? null}}">
                    </td>
                    <td> <button class="btn btn-sm btn-primary updateBtn"> Update</button> </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div> <!-- end table-responsive -->

    <div class="float-right">
        {!! $feederInformations->links() !!}
    </div>
@endsection


@section('script')
    <script>
        $(".updateBtn").on('click', function () {
            let id= $(this).closest('tr').find('.id').val();
            let berthingDate= $(this).closest('tr').find('.berthingDate').val();
            let rotationNo= $(this).closest('tr').find('.rotationNo').val();
            $.ajax({
                type: 'post',
                url: '{{url("feederCustomUpdate")}}',
                data: {
                    _token: "{{ csrf_token() }}",
                    id:id,
                    berthingDate:berthingDate,
                    rotationNo:rotationNo
                },
                dataType:'html',
                success: function (Response) {
                    location.reload();
                }
            });
        });

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){

            $( "#feederVessel" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('feederNameAutoComplete')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                select: function (event, ui) {
                    $('#feederVessel').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            }).blur(function () {
                let vesselName = $(this).val();
                let dataList = $("#voyageList");
                if(vesselName != null){
                    const url = '{{url('voyageAutoComplete')}}/'+vesselName;
                    fetch(url)
                            .then((resp) => resp.json())
                .then(function (hblno) {
                        dataList.empty();
                        hblno.forEach(function (data) {
                            dataList.append(`<option value="${data.voyageNumber}"></option>`);
                        });
                    })
                            .catch(function () {
                                $("#voyageNumber").val(null);
                            });
                }
            });//vessel autocomplete

            $( "#rotationNo" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('rotationNoAutoComplete')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                select: function (event, ui) {
                    $('#rotationNo').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });//rotation autocomplete

        }); //document ready
    </script>
@endsection
