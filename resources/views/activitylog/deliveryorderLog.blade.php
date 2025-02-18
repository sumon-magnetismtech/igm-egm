@extends('layouts.new-layout')
@section('title', 'FRD | DO Log')

@section('breadcrumb-title', 'Delivery Order Activity Log')

@section('breadcrumb-button')
    <a href="{{ url('deliveryorders') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    Total : {{ count($deliveryorders) }}
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
            @foreach($deliveryorders as $key => $deliveryorder)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td> {{$deliveryorder->description}}</td>
                    <td> {{$deliveryorder->causer->name}}</td>
                    <td>
                        @if(!in_array($deliveryorder->description, ['created', 'deleted', 'restored']))
                            @foreach($deliveryorder->properties['old'] as $key => $attribute)
                                {{ucwords($key)}} : <strong>{{$attribute}}</strong> <br>
                            @endforeach
                        @else
                            - - -
                        @endif
                    </td>
                    <td>
                        @if(!in_array($deliveryorder->description, ['created', 'deleted', 'restored']))
                            @foreach($deliveryorder->properties['attributes'] as $key => $attribute)
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