@extends('layouts.new-layout')
@section('title', 'List of Locations')

@section('breadcrumb-title', 'List of Locations')

@section('breadcrumb-button')
    @can('location-create')
    <a href="{{ route('locations.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total : {{ $locations->total() }}
@endsection

@section('content')
    <form action="" method="get">
        <div class="row">
            <div class="col-md-2 pr-md-1 my-1 my-md-0">
                <input type="text" id="portcode" name="portcode" class="form-control form-control-sm" placeholder="Port Code" autocomplete="off">
            </div>
            <div class="col-md-4 px-md-1 my-1 my-md-0">
                <input type="text"  id="description" name="description" class="form-control form-control-sm" placeholder="Description" autocomplete="off">
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
                <th>Sl. No.</th>
                <th>Port Code</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl. No.</th>
                <th>Port Code</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($locations as $key => $location)
                <tr>
                    <td>{{$key + $locations->firstItem()}}</td>
                    <td>{{$location->portcode}}</td>
                    <td>{{$location->description}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @can('location-edit')
                                <a href="{{ url('locations/'.$location->id.'/edit') }}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                                @can('location-delete')
                                <form action="{{ url('locations', [$location->id]) }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
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
    <div class="float-right">
        {{$locations->links()}}
    </div>
@endsection
