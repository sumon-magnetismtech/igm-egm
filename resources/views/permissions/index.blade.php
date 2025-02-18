@extends('layouts.new-layout')
@section('title', 'List of Permissions')

@section('breadcrumb-title', 'List of Permissions')

@section('breadcrumb-button')
    <a href="{{ route('permissions.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{$permissions->total()}}
@endsection

@section('content')
    <form action="" method="get">
        <div class="row">
            <div class="col-md-3 pr-md-1 my-1 my-md-0">
                <input type="text" name="name" class="form-control form-control-sm" placeholder="Search Permission" autocomplete="off">
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
                <th>Sl</th>
                <th>Permission</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl</th>
                <th>Permission</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($permissions as $key => $permission)
                <tr>
                    <td>{{ $permissions->firstItem()+$key }}</td>
                    <td> {{ $permission->name }}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url('permissions/'.$permission->id.'/edit') }}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                <form action="{{ url('permissions', [$permission->id]) }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
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
    <div class="float-right">
        {!! $permissions->links() !!}
    </div>
@endsection