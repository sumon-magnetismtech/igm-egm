@extends('layouts.new-layout')
@section('title', 'Principal')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Principal Information
    @else
        Create Principal Information
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
    <form action="{{ route('principals.update', $principal->id) }}" method="post" class="custom-form">
        @method('PUT')
        <input type="hidden" name="id" value="{{$principal->id}}">
        @else
    <form action="{{ route('principals.store') }}" method="post" class="custom-form">
        @endif
        <div class="row">
            @csrf
            <div class="col-12 my-1">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon">Short Code<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="code" value="{{ old("code") ? old("code") : (!empty($principal) ? $principal->code : null) }}">
                </div>
            </div>
            <div class="col-12 my-1">
                <div class="input-group input-group-sm input-group-primary">
                    <span class="input-group-addon">Principal Name<span class="text-danger">*</span></span>
                    <input type="text" name="name" class="form-control" value="{{ old("name") ? old("name") : (!empty($principal) ? $principal->name : null) }}">
                </div>
            </div>
            <div class="col-12 my-1">
                <div class="input-group input-group-sm input-group-primary">
                    <span class="input-group-addon">Description</span>
                    <input type="text" name="description" class="form-control" value="{{ old("description") ? old("description") : (!empty($principal) ? $principal->description : null) }}">
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