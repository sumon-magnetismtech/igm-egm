@extends('layouts.new-layout')
@section('title', 'List of C&F Agents')

@section('breadcrumb-title', 'List of C&F Agents')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-button')
    @can('cnfagent-create')
    <a href="{{ route('cnfagents.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total : {{ count($cnfagents) }}
@endsection

@section('content')
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Sl. No.</th>
                <th>C&F Name </th>
                <th>Contact</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl. No.</th>
                <th>C&F Name </th>
                <th>Contact</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($cnfagents as $key => $cnfagent)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$cnfagent->cnfagent}}</td>
                    <td>{{$cnfagent->contact}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @can('cnfagent-edit')
                                <a href="{{ url('cnfagents/'.$cnfagent->id.'/edit') }}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                                @can('cnfagent-delete')
                                <form action="{{ url('cnfagents', [$cnfagent->id]) }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                </form>
                                @endcan
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection


@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection