@extends('layouts.new-layout')
@section('title', 'Container Bulk Edit')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title', 'Container Bulk Edit')

@section('breadcrumb-button')
    <a href="{{ url('housebls') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    Total Containers: {{!empty($allContainers) ? count($allContainers) : null}}
@endsection

@section('content')
    <form action="{{ url('searchhouseblcontainers') }}" method="get">
        <div class="row px-2">
            @csrf
            <div class="col-md-3 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <input type="text" name="igm" id="igm"  class="form-control form-control-sm" value="{{$seachedIgm}}" placeholder="Enter IGM Number" autocomplete="off">
                </div>
            </div>
            <div class="col-md-1 px-1 my-md-0">
                <div class="input-group md-form form-sm form-1 pl-0 py-1 my-0">
                    <div class="input-group input-group-sm">
                        <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->
    </form> <!-- end form -->

    @if($showType == 'yes')
        <div class="row d-flex align-items-end">
            <div class="col my-1">
                <strong>
                    <span class="text-success">Feeder Vessel: <span class="text-dark">{{ $masterbl->fvessel}}</span>;</span>
                    <span class="text-success">Voyage : <span class="text-dark">{{ $masterbl->voyage}}</span>;</span>
                    <span class="text-success">Rotation : <span class="text-dark">{{ $masterbl->rotno}}</span>;</span> <br>
                    <span class="text-success">Master B/L : <span class="text-dark">{{ $masterbl->mblno}}</span>;</span>
                    <span class="text-success">Quantity : <span class="text-dark">{{ $masterbl->housebls->sum('packageno')}}</span>;</span>
                    <span class="text-success">Gross Weight : <span class="text-dark">{{ $masterbl->housebls->sum('grosswt')}}</span>;</span>
                </strong>
            </div>
            <div class="col my-1">
                <div class="float-right">
                    @foreach($typeCount as $key => $type)
                        <button type="button" class="btn btn-primary btn-sm px-2" tabindex="-1">
                            {{$key}} <span class="badge badge-dark">{{$type}}</span>
                        </button>
                    @endforeach
                </div>
            </div>

        </div><!-- end row -->

        <div class="dt-responsive table-responsive">
            <table id="dataTable" class="table table-striped table-bordered dataTable">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Container Ref</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Seal No</th>
                    <th>Line No </th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Container Ref</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Seal No</th>
                    <th>Line No </th>
                    <th>Action</th>
                </tr>
                </tfoot>

                <tbody>
                @foreach($allContainers as $containerInfo)
                    <tr>
                        <form action="{{ url('containersBulkUpdate') }}" method="post">
                            @csrf
                            <td>{{$loop->iteration}}</td>
                            <td>
                                <input type="text" name="newContref" value="{{$containerInfo->contref}}" class="form-control form-control-sm contrefno" />
                                <input type="hidden" name="igm" value="{{$seachedIgm}}">
                                <input type="hidden" name="oldContref" value="{{$containerInfo->contref}}">
                                <span class="d-none">{{$containerInfo->contref}}</span>
                            </td>
                            <td>
                                <select name="type" required class="custom-select form-control form-control-sm">
                                    <option value disabled selected>Enter Container Type</option>
                                    @foreach ($containertypes as $containertype)
                                        <option value="{{ $containertype }}" {{($containerInfo->type == $containertype) ? 'selected' : null}} >{{ $containertype }}</option>
                                    @endforeach
                                </select>
                                <span class="d-none">{{$containerInfo->type}}</span>
                            </td>
                            <td>
                                <select name="status" class="custom-select form-control form-control-sm">
                                    <option value disabled selected>Enter Container Status</option>
                                    <option value="PRT" {{($containerInfo->status == "PRT") ? 'selected' : null}} >PRT</option>
                                    <option value="LCL" {{($containerInfo->status == "LCL") ? 'selected' : null}} >LCL</option>
                                    <option value="FCL" {{($containerInfo->status == "FCL") ? 'selected' : null}} >FCL</option>
                                    <option value="ETY" {{($containerInfo->status == "ETY") ? 'selected' : null}} >ETY</option>
                                </select>
                                <span class="d-none">{{$containerInfo->status}}</span>
                            </td>
                            <td>
                                <input type="text" value="{{$containerInfo->sealno}}" name="sealno"  class="form-control form-control-sm sealno" id="sealno"/>
                                <span class="d-none">{{$containerInfo->sealno}}</span>
                            </td>
                            <td class="text-center">
                                <?php $containerNumber =
                                        \Illuminate\Support\Facades\DB::select('SELECT line FROM housebls INNER JOIN containers ON containers.housebl_id= housebls.id WHERE contref="'.$containerInfo->contref.'" AND igm="'.$containerInfo->igm.'" ORDER BY housebls.line ASC')?>
                                @foreach($containerNumber as $key => $rr)
                                    {{$rr->line}}{{$loop->last ? null : ", "}}
                                @endforeach
                            </td>
                            <td>
                                <button type="submit" class="btn btn-sm btn-success btn-block p-1"> Update </button>
                            </td>
                        </form>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

    @endif
@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            $( "#igm" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('loadHouseblIgmAutoComplete')}}",
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
                    $('#igm').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                    return false;
                }
            });
        });


        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true,
                paging:   false,
                bFilter: false,
                info: false,
                "order": [[ 5, "asc" ]],
                "columnDefs": [
                    { "orderable": false, "targets": 6}
                ]

            });
        });

    </script>
@endsection