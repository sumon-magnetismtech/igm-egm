@extends('layouts.new-layout')
@section('title', 'Permission')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Permission
    @else
        Create Permission
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('principals') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')
@section('content')
    @if($formType == 'edit')
        <form action="{{ route('permissions.update', $permission->id) }}" method="post" class="custom-form">
            @method('PUT')
            <input type="hidden" name="id" value="{{$permission->id}}">
    @else
        <form action="{{ route('permissions.store') }}" method="post" class="custom-form">
    @endif
            <div class="row">
                @csrf
                <div class="col-12 my-1">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon"> Permission Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="bin" name="name" value="{{ old("name") ? old("name") : (!empty($permission) ? $permission->name : null) }}" required autofocus>
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