@extends('layouts.new-layout')
@section('title', 'Money Receipt Log')

@section('breadcrumb-title', 'Money Receipt Activity Log')

@section('breadcrumb-button')
    <a href="{{ url('moneyreceipts') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    Total : {{ count($moneyreceipts) }}
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
            @foreach($moneyreceipts as $key => $moneyreceipt)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td> {{$moneyreceipt->description}}</td>
                    <td> {{$moneyreceipt->causer->name}}</td>
                    <td>
                        @if(!in_array($moneyreceipt->description, ['created', 'deleted', 'restored']))
                            @foreach($moneyreceipt->properties['old'] as $key => $attribute)
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
                        @if(!in_array($moneyreceipt->description, ['deleted', 'restored']))
                            @foreach($moneyreceipt->properties['attributes'] as $key => $attribute)
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
