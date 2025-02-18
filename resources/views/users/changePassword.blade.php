@extends('layouts.new-layout')
@section('title', 'Change Password')

@section('breadcrumb-title')
        Change Password
@endsection


@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <form action="{{route('updatePassword')}}" method="post" class="custom-form">
        <div class="row">
            @csrf
            <div class="col-12 my-2">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="oldPassword">Old Password<span class="text-danger">*</span></label>
                    <input type="password" name="current_password" id="oldPassword" class="form-control">
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="new_password">New Password<span class="text-danger">*</span></label>
                    <input type="password" name="new_password" id="new_password" class="form-control">
                </div>
            </div>
            <div class="col-12 my-2">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="new_confirm_password">Conf. Password<span class="text-danger">*</span></label>
                    <input type="password" name="new_confirm_password" id="new_confirm_password" class="form-control">
                </div>
            </div>
        </div><!-- end row -->

        <div class="row">
            <div class="offset-xl-5 col-xl-2 offset-md-4 col-md-4 mt-3">
                <div class="input-group input-group-sm ">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div> <!-- end row -->
    </form>
@endsection