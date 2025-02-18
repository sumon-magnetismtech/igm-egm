@extends('layouts.new-layout')
@section('title', 'User')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit User
    @else
        Create User
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('users') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')
@section('content')
    @if($formType == 'edit')
        <form action="{{route("users.update", $user->id) }}" method="post" class="custom-form">
            @method('PUT')
            <input type="hidden" value="{{$user->id}}" name="id">
    @else
        <form action="{{ route('users.store') }}" method="post" class="custom-form">
    @endif
        <div class="row">
            @csrf
            <div class="col-12 my-1">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon">Name<span class="text-danger">*</span></label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : (!empty($user) ? $user->name: null) }}" required autofocus>
                    @error('name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                </div>
            </div>

            <div class="col-12 my-1">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon">Email<span class="text-danger">*</span></label>
                    <input id="email" type="email" class="form-control text-lowercase @error('email') is-invalid @enderror" name="email" value="{{ old('email') ? old('email') : (!empty($user) ? $user->email: null) }}" required>
                    @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>
            </div>

            <div class="col-12 my-1">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon">Password<span class="text-danger">*</span></label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">
                    @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>
            </div>

            <div class="col-12 my-1">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon">Confirm Password <span class="text-danger">*</span></label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off">
                </div>
            </div>

            <div class="col-12 my-1">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon"> Roles <span class="text-danger">*</span></label>
                    <select name="role" id="role" class="form-control" required>
                        <option disabled selected value=""> Selected Role </option>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}" {{!empty($user) && in_array($role->name, $user->getRoleNames()->toArray()) ? "selected" : null}}>{{strtoupper($role->name)}}</option>
                        @endforeach
                    </select>
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











