@extends('layouts.new-layout')
@section('title', 'Role')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Role
    @else
        Create Role
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('roles') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    @if($formType == 'edit')
        <form action="{{ route('roles.update', $role->id) }}" method="post" class="custom-form">
            @method('PUT')
            <input type="hidden" name="id" value="{{$role->id}}">
            @else
        <form action="{{ route('roles.store') }}" method="post" class="custom-form">
    @endif
            <div class="row">
                @csrf
                <div class="col-12 my-1">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon"> Role Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ old("name") ? old("name") : (!empty($role) ? $role->name : null) }}">
                    </div>
                </div>
                <div class="col-12 my-1">
                    <label class="col-12 px-0"> <strong>Permissions</strong> <span class="text-danger">*</span></label>
                    <div class="input-group input-group-sm input-group-primary">
                        <div class="border-checkbox-section">
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <div class="col-3">
                                        <div class="border-checkbox-group border-checkbox-group-warning">
                                            <input class="border-checkbox" type="checkbox" name="permission[]" id="{{$permission->name}}" value="{{$permission->name}}"
                                                    {{!empty($role) && in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? "checked" : null}}
                                            />
                                            <label class="border-checkbox-label" for="{{$permission->name}}">{{$permission->name}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div> <!-- end row -->
                        </div> <!-- end border-checkbox-section -->
                    </div>
                </div>
            </div><!-- end row -->
            <div class="row">
                <div class="offset-md-4 col-md-4 mt-2">
                    <div class="input-group input-group-sm ">
                        <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                    </div>
                </div>
            </div> <!-- end row -->
    </form>
@endsection