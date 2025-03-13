@extends('layouts.egm-layout')
@section('title', 'MLO-Money Receipt Log')

@section('breadcrumb-title', 'MLO-Money Receipt Log')

@section('breadcrumb-button')
    <a href="{{ url('mloblinformations') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    Total : {{ count($logs) }}
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
            @foreach($logs as $key => $log)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td> {{$log->description}}</td>
                    <td> {{$log->causer->name}}</td>
                    <td>
                        @if(!in_array($log->description, ['created', 'deleted', 'restored']))
                            @foreach($log->properties['old'] as $key => $attribute)
                                @if(is_array($attribute))
                                    @foreach($attribute as $key => $detail)
                                        {{$key}} = {{$detail}}/- <br>
                                    @endforeach
                                @else
                                    {{ucwords($key)}} : <strong>{{$attribute}}</strong> <br>
                                @endif
                            @endforeach
                        @else
                            - - -
                        @endif
                    </td>
                    <td>
                        @if(!in_array($log->description, ['created', 'deleted', 'restored']))
                            @foreach($log->properties['attributes'] as $key => $attribute)
                                @if(is_array($attribute))
                                    @foreach($attribute as $key => $detail)
                                        {{$key}} = {{$detail}}/- <br>
                                    @endforeach
                                @else
                                    {{ucwords($key)}} : <strong>{{$attribute}}</strong> <br>
                                @endif
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
