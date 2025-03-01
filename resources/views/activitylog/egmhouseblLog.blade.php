@extends('layouts.egm-layout')
@section('title', 'HBL Activity Log')

@section('breadcrumb-title', 'House BL Activity Log')

@section('breadcrumb-button')
    <a href="{{ url('housebls') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    Total : {{ count($housebls) }}
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
            @foreach($housebls as $key => $housebl)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td> {{$housebl->description}}</td>
                    <td> {{$housebl->causer->name}}</td>
                    <td>
                        @if(!in_array($housebl->description, ['created', 'deleted', 'restored']))
                            @foreach($housebl->properties['old'] as $key => $attribute)
                                {{ucwords($key)}} : <strong>{{$attribute}}</strong> <br>
                            @endforeach
                        @else
                            - - -
                        @endif
                    </td>
                    <td>
                        @if(!in_array($housebl->description, ['created', 'deleted', 'restored']))
                            @foreach($housebl->properties['attributes'] as $key => $attribute)
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
