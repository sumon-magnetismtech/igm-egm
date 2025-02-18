@extends('layouts.new-layout')
@section('title', 'List of Commodity Codes')

@section('breadcrumb-title', 'List of Commodities')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-button')
    @can('commodity-create')
    <a href="{{ route('commoditys.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total : {{ count($commoditys)}}
@endsection

@section('content')
    <!-- put search form  here-->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Sl. No.</th>
                <th>Commodity Code</th>
                <th>Commodity Description</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl. No.</th>
                <th>Commodity Code</th>
                <th>Commodity Description</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($commoditys as $key => $commodity)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$commodity->commoditycode}}</td>
                    <td>{{$commodity->commoditydescription}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @can('commodity-edit')
                                <a href="{{route('commoditys.edit', $commodity->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                                @can('commodity-delete')
                                <form action="{{route('commoditys.destroy', $commodity->id)}}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
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