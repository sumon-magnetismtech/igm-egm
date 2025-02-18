@extends('layouts.new-layout')
@section('title', 'List of Roles')

@section('breadcrumb-title', 'List of Roles')

@section('breadcrumb-button')
    <a href="{{ route('roles.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{$roles->total()}}
@endsection

@section('content')
    <!-- search form will go here -->
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th> Sl </th>
                <th> Role </th>
                <th> Permissions </th>
                <th> Action </th>
            </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
            @foreach($roles as $key => $role)
                <tr>
                    <td> {{$roles->firstItem() + $key}} </td>
                    <td>{{strtoupper($role->name)}}</td>
                    <td style="white-space: normal; text-align: left">
                        @foreach($role->permissions as $permission)
                            <label class="badge badge-warning">{{strtoupper($permission->name)}}</label>
                        @endforeach
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url("roles/$role->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                <form action="{{ url('roles', [$role->id]) }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                </form>
                                <a href="{{ url("roles/log/$role->id") }}" data-toggle="tooltip" title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="float-right">
        {!! $roles->links() !!}
    </div>
@endsection