@extends('layouts.new-layout')
@section('title', 'C-Track DO Report')

@section('breadcrumb-title', "C-Track Delivery Order Report")

@section('breadcrumb-button')
    <a href="{{ route('moneyreceipts.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
{{--    Total: {{$moneyReceipts ? $moneyReceipts->total() : 0}}--}}
@endsection

@section('title', 'DO Report')

@section('content')
    <div class="col-lg-12">
        <form class="form-inline md-form form-sm mt-0 row" action="{{ route('searchDoReport') }}" method="get">
            @csrf
            <div class="col-lg-3">
                <div class="md-form">
                    <select name="dateType" id="dateType" class="form-control w-100" required>
                        <option value="today" selected> Today </option>
                        <option value="weekly" {{$dateType == "weekly" ? "selected" : ''}}> Last 7 Days </option>
                        <option value="monthly" {{$dateType == "monthly" ? "selected" : ''}}> Last 30 Days </option>
                        <option value="custom" {{$dateType == "custom" ? "selected" : ''}}> Custom </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4" id="fromDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <div class="md-form">
                    <input id="fromDate" class="form-control w-100" value="{{$fromDate ? date('d-m-Y', strtotime($fromDate)) : ''}}"  type="text" name="fromDate" placeholder="Select From Date" autocomplete="off">
                    <label for="fromDate"> From Date </label>
                </div>
            </div>
            <div class="col-md-4" id="tillDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <div class="md-form">
                    <input id="tillDate" class="form-control w-100" value="{{!empty($tillDate) ? date('d-m-Y', strtotime($tillDate)) : ''}}"  type="text" name="tillDate" placeholder="Select Till Date" autocomplete="off">
                    <label for="tillDate"> Till Date </label>
                </div>
            </div>

            <button type="submit" class="btn btn-sm btn-pink"><i class="fas fa-search" aria-hidden="true"></i></button>
        </form>
    </div>

    @if($deliveryOrders)
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead class="indigo white-text text-center">
                    <tr>
                        <th class="th-sm"> # </th>
                        <th class="th-sm"> Bl Reference </th>
                        <th> DO Date </th>
                        <th> BE No </th>
                        <th> BE Date </th>
                    </tr>
                </thead>
                <tbody class="text-center">
                @foreach($deliveryOrders as $key => $container)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td> {{$container->bolreference}} </td>
                        <td> {{$container->DO_Date ? date('d-m-Y', strtotime($container->DO_Date)) : ''}} </td>
                        <td> {{$container->BE_No}} </td>
                        <td> {{$container->BE_Date ? date('d-m-Y', strtotime($container->BE_Date)) : ''}} </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
    <div class="col-md-12">
        <p class="bg-light py-3 text-center lead"> <strong> No DO Found based on the date/date range.  </strong> </p>
    </div>
    @endif
@endsection

@section('script')
    <script>
        $(function(){
            $('#fromDate').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true});
            $('#tillDate').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true});

            $("#dateType").change(function(){
                let type = $(this).val();
                if(type === 'custom'){
                    $("#fromDateArea, #tillDateArea").show('slow');
                    $("#fromDate, #tillDate").attr('required', true);
                }else{
                    $("#fromDateArea, #tillDateArea").hide('slow');
                    $("#fromDate, #tillDate").removeAttr('required');
                }
            });

        });

    </script>
@endsection
