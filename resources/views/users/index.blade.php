@extends('layouts.new-layout')
@section('title', 'List of Users')

@section('breadcrumb-title', 'List of Users')

@section('breadcrumb-button')
    <a href="{{ route('users.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{$users->total()}}
@endsection

@section('content')
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th> User ID </th>
                <th> User Name </th>
                <th> User Email </th>
                <th> Permission </th>
                <th> Action </th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th> User ID </th>
                <th> User Name </th>
                <th> User Email </th>
                <th> Permission </th>
                <th> Action </th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td> {{$user->id}} </td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <button type="button" class="btn btn-sm btn-dark" disabled> {{$role->name}} </button>
                        @endforeach
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url("users/$user->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                <form action="{{ url('users', [$user->id]) }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                </form>
                                <a href="{{ url("users/log/$user->id") }}" data-toggle="tooltip" title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="float-right">
        {!! $users->links() !!}
    </div>
@endsection