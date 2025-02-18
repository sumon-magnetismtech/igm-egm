@extends('layouts.new-layout')
@section('title', 'List of MR Heads')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Money Receipt Head
    @else
        Add New Money Receipt Head
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('moneyreceiptheads') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    @if($formType == 'edit')
        <form action="{{ route('moneyreceiptheads.update', $moneyreceipthead->id) }}" method="post" class="custom-form">
            @method('PUT')
    @else
    <form action="{{ route('moneyreceiptheads.store') }}" method="post" class="custom-form">
        @endif
        <div class="row">
            @csrf
            <div class="col-12 my-2">
                <div class="input-group input-group-sm input-group-primary">
                    <span class="input-group-addon"> Head Name<span class="text-danger">*</span></span>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old("name") ? old("name") : (!empty($moneyreceipthead) ? $moneyreceipthead->name : null) }}" autocomplete="off">
                </div>
            </div>
            <div class="col-12 my-2">
                <div class="input-group input-group-sm input-group-primary">
                    <span class="input-group-addon">Description<span class="text-danger">*</span></span>
                    <input type="text" class="form-control" id="description" name="description" value="{{ old("description") ? old("description") : (!empty($moneyreceipthead) ? $moneyreceipthead->description : null) }}" autocomplete="off">
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
