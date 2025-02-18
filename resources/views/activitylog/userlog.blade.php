@extends('layouts.new-layout')
@section('title', 'User Activity Log')

@section('breadcrumb-title', 'User Activity Log')

@section('breadcrumb-button')
    <a href="{{ url('mloblinformations') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    Total : {{ count($useractivities) }}
@endsection

@section('content')
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Sl</th>
                <th>Type</th>
                <th>User</th>
                <th>Model</th>
                <th>Old Data</th>
                <th>New Data</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl</th>
                <th>Type</th>
                <th>User</th>
                <th>Model</th>
                <th>Old Data</th>
                <th>New Data</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($useractivities as $key => $useractivitie)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td> {{$useractivitie->description}}</td>
                    <td> {{$useractivitie->causer->name}}</td>
                    <td> {{$useractivitie->subject_type}}</td>
                    {{--<td style="white-space: normal">--}}
                        {{--@if(!in_array($useractivitie->description, ['created', 'deleted', 'restored']))--}}
                            {{--@foreach($useractivitie->properties['old'] as $key => $attribute)--}}
                                {{--{{ucwords($key)}} : <strong>{{$attribute}}</strong> <br>--}}
                            {{--@endforeach--}}
                        {{--@else--}}
                            {{--- - ---}}
                        {{--@endif--}}
                    {{--</td>--}}
                    {{--<td style="white-space: normal">--}}
                        {{--@foreach($useractivitie->properties['attributes'] as $key => $attribute)--}}
                            {{--{{ucwords($key)}} : <strong>{{$attribute}}</strong> <br>--}}
                        {{--@endforeach--}}
                    {{--</td>--}}

                    <td class="breakWords" style="max-width: 200px; min-width: 200px">
                        @if($useractivitie->description != 'created' && !empty($useractivitie->properties['old']))
                            @foreach($useractivitie->properties['old'] as $key => $attribute)
                                @if(is_array($attribute))
                                    @foreach($attribute as $key => $detail)
                                        {{$key}} => {{$detail}} <br>
                                    @endforeach
                                @else
                                    {{ucwords($key)}} : <strong>{{$attribute}}</strong> <br>
                                @endif
                            @endforeach
                        @else
                            - - -
                        @endif
                    </td>
                    <td class="breakWords" style="max-width: 200px; min-width: 200px">
                        @if($useractivitie->description != 'created')
                            @foreach($useractivitie->properties['attributes'] as $key => $attribute)
                                @if(is_array($attribute))
                                    @foreach($attribute as $key => $detail)
                                        {{$key}} => {{$detail}} <br>
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
    {{--<div class="float-right">--}}
        {{--{{$useractivities->links()}}--}}
    {{--</div>--}}
@endsection



