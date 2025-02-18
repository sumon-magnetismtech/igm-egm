@extends('layouts.new-layout')
@section('title', 'Container Types')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title', 'Container Types List')

@section('breadcrumb-button')
    @can('containertype-create')
    <a href="{{ route('containertypes.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total : {{ count($containertypes) }}
@endsection

@section('content')
    {{--<div class="table-responsive">--}}
        {{--<table id="example" class="table table-striped table-bordered">--}}
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered dataTable">
            <thead>
            <tr>
                <th>Sl. No.</th>
                <th>ISO Code</th>
                <th>Dimension</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl. No.</th>
                <th>ISO Code</th>
                <th>Dimension</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($containertypes as $key => $containertype)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$containertype->isocode}}</td>
                    <td>{{$containertype->dimension}}</td>
                    <td>{{$containertype->description}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @can('containertype-edit')
                                <a href="{{route('containertypes.edit', $containertype->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                                @can('containertype-delete')
                                <form action="{{route('containertypes.destroy', $containertype->id)}}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
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