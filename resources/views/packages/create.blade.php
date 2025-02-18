@extends('layouts.new-layout')
@section('title', 'Packages')

@section('breadcrumb-title')
        Add New Package
@endsection

@section('breadcrumb-button')
    <a href="{{ url('vatregs') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')
@section('content')

    @if($formType == 'edit')
        <form action="{{ route('packages.update', $package->id) }}" method="post" class="custom-form">
            @method('PUT')
            <input type="hidden"  name="id" value="{{$package->id}}">
    @else
        <form action="{{ route('packages.store') }}" method="post" class="custom-form">
    @endif
        <div class="row">
            @csrf
            <div class="col-12 my-2">
                <div class="input-group input-group-sm input-group-primary">
                    <span class="input-group-addon">Package Code<span class="text-danger">*</span></span>
                    <input type="text" id="packagecode" name="packagecode" class="form-control" value="{{ old("packagecode") ? old("packagecode") : (!empty($package) ? $package->packagecode : null) }}">
                </div>
            </div>
            <div class="col-12 my-2">
                <div class="input-group input-group-sm input-group-primary">
                    <span class="input-group-addon">Description<span class="text-danger">*</span></span>
                    <input type="text" id="description" name="description" class="form-control" value="{{ old("packagecode") ? old("packagecode") : (!empty($package) ? $package->packagecode : null) }}">
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

    @if($formType == 'create')
        <hr class="my-2 bg-success">
        <form action="{{ route('packageimport') }}" method="POST" enctype="multipart/form-data" class="custom-form">
            @csrf
            <div class="card mt-4 border">
                <div class="card-block">
                    <div class="sub-title">Upload XL File</div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="input-group input-group-sm input-group-primary">
                                <span class="input-group-addon">Upload <span class="text-danger">*</span></span>
                                <input type="text" id="packagecode" class="form-control" name="packagecode">
                            </div>
                        </div> <!-- end row -->
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="input-group input-group-md input-group-primary">
                                <button class="btn btn-success btn-sm btn-block"><i class="fas fa-file-upload"></i> Submit</button>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-block -->
            </div> <!-- end card -->
        </form> <!-- end form import from excel-->
    @endif
@endsection