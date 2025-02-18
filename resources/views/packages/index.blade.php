@extends('layouts.new-layout')
@section('title', 'List of Package Codes')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title', 'List of Package Codes')

@section('breadcrumb-button')
    @can('package-create')
    <a href="{{ route('packages.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total : {{ count($packages) }}
@endsection

@section('content')
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Sl. No.</th>
                <th>Package Code</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl. No.</th>
                <th>Package Code</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($packages as $key => $package)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$package->packagecode}}</td>
                    <td>{{$package->description}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{route('packages.edit', $package->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                <form action="{{route('packages.destroy', $package->id)}}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                </form>
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