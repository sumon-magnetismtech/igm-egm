@extends('layouts.new-layout')
@section('title', 'Feeder Activity Log')

@section('breadcrumb-title', 'Feeder Activity Log')

@section('breadcrumb-button')
    <a href="{{ url('feederinformations') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    Total : {{ count($feeders) }}
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
            @foreach($feeders as $key => $feeder)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td> {{$feeder->description}}</td>
                    <td> {{$feeder->causer->name}}</td>
                    <td>
                        @if(!in_array($feeder->description, ['created', 'deleted', 'restored']))
                            @foreach($feeder->properties['old'] as $key => $attribute)
                                {{ucwords($key)}} : <strong>{{$attribute}}</strong> <br>
                            @endforeach
                        @else
                            - - -
                        @endif
                    </td>
                    <td>
                        @if(!in_array($feeder->description, ['created', 'deleted', 'restored']))
                            @foreach($feeder->properties['attributes'] as $key => $attribute)
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