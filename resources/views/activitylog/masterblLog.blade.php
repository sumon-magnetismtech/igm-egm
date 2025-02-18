@extends('layouts.new-layout')
@section('title', 'MBL Activity Log')

@section('breadcrumb-title', 'MBL Activity Log')

@section('breadcrumb-button')
    <a href="{{ url('masterbls') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    Total : {{ count($masterbls) }}
@endsection

@section('content')
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Sl</th>
                <th>Type</th>
                <th>User</th>
                <th>Old Data</th>
                <th>New Data</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl</th>
                <th>Type</th>
                <th>User</th>
                <th>Old Data</th>
                <th>New Data</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($masterbls as $key => $masterbl)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td> {{$masterbl->description}}</td>
                    <td> {{$masterbl->causer->name}}</td>
                    <td>
                        @if(!in_array($masterbl->description, ['created', 'deleted', 'restored']))
                            @foreach($masterbl->properties['old'] as $key => $attribute)
                                {{ucwords($key)}} : <strong>{{$attribute}}</strong> <br>
                            @endforeach
                        @else
                            - - -
                        @endif
                    </td>
                    <td>
                        @if(!in_array($masterbl->description, ['created', 'deleted', 'restored']))
                            @foreach($masterbl->properties['attributes'] as $key => $attribute)
                                {{ucwords($key)}} : <strong>{{$attribute}}</strong> <br>
                            @endforeach
                        @else
                            - - -
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
