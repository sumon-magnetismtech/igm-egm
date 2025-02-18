@extends('layouts.new-layout')
@section('title', 'List of Export')

@section('breadcrumb-title', 'List of Exports')

@section('breadcrumb-button')
    <a href="{{ route('stfcontainerlist') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    {{--Total: {{$moneyReceipts ? $moneyReceipts->total() : 0}}--}}
@endsection


@section('content')
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="th-sm"> # </th>
                    <th class="th-sm"> Vessel Name </th>
                    <th class="th-sm"> Vessel Code </th>
                    <th class="th-sm"> Export Date </th>
                    <th class="th-sm"> Voyage No </th>
                    <th class="th-sm"> Rotation No </th>
                    <th class="th-sm"> Sailing Date </th>
                    <th class="th-sm"> ETA Date </th>
                    <th class="th-sm"> Action </th>
                </tr>
            </thead>
            <tbody>
                @forelse($exports as $key => $export)
                    <tr>
                        <td>{{$key + 1 }} </td>
                        <td> {{$export->vesselName}} </td>
                        <td> {{$export->vesselCode}} </td>
                        <td> {{($export->exportDate) ? date('d-m-Y', strtotime($export->exportDate)) : null}} </td>
                        <td> {{$export->voyageNo}} </td>
                        <td> {{$export->rotationNo}} </td>
                        <td> {{($export->sailingDate) ? date('d-m-Y', strtotime($export->sailingDate)) : null}} </td>
                        <td> {{($export->etaDate) ? date('d-m-Y', strtotime($export->etaDate)) : null}} </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{url('exports/'.$export->id)}}" data-toggle="tooltip" title="Details" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ url('exports/'.$export->id.'/edit') }}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>

                                    <form action="{{ url('exports', [$export->id]) }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </nobr>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9"> <p class="lead"> Currently No Data available. </p> </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection