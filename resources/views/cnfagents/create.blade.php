@extends('layouts.new-layout')
@section('title', 'C & F')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Cnf Agent
    @else
        Add New Cnf Agent
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('cnfagents') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')
@section('content')
    @if($formType == 'edit')
    <form action="{{ route('cnfagents.update',$cnfagent->id) }}" method="post" class="custom-form">
        @method('PUT')
        <input type="hidden"  name="id" value="{{$cnfagent->id}}">
    @else
    <form action="{{ route('cnfagents.store') }}" method="post" class="custom-form">
        @endif
        <div class="row">
            @csrf
            <div class="col-12 my-1">
                <div class="input-group input-group-sm input-group-primary">
                    <span class="input-group-addon" id="">Cnf Agent<span class="text-danger">*</span></span>
                    <input type="text" id="cnfagent" class="form-control" name="cnfagent" value="{{old("cnfagent") ? old("cnfagent") : (!empty($cnfagent) ? $cnfagent->cnfagent : null)}}">
                </div>
            </div>
            <div class="col-12 my-1">
                <div class="input-group input-group-sm input-group-primary">
                    <span class="input-group-addon" id="">Contact<span class="text-danger">*</span></span>
                    <input type="text" id="contact" class="form-control" name="contact" value="{{old("contact") ? old("contact") : (!empty($cnfagent) ? $cnfagent->contact : null)}}">
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
        <form action="{{ route('cnfagentimport') }}" method="POST" enctype="multipart/form-data" class="custom-form">
            @csrf
            <div class="card mt-4 border">
                <div class="card-block">
                    <div class="sub-title">Upload XL File</div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="input-group input-group-sm input-group-primary">
                                <span class="input-group-addon">Upload <span class="text-danger">*</span></span>
                                <input type="file" class="form-control">
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