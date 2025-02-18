@extends('layouts.new-layout')
@section('title', 'Attendance')

@section('breadcrumb-title', 'Employee Attendance')

@section('breadcrumb-button')
    @can('masterbl-create')
{{--    <a href="{{route('attendances.create')}}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>--}}
    @endcan
@endsection

@section('sub-title')
    Total :
@endsection

@section('content')
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Date</th>
                <th>Employee Name (ID) </th>
                <th>Status </th>
                <th>In Time</th>
                <th>Out Time</th>
                <th>Late</th>
                <th>Early Leave</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Date</th>
                <th>Employee Name (ID) </th>
                <th>Status </th>
                <th>In Time</th>
                <th>Out Time</th>
                <th>Late</th>
                <th>Early</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @forelse($attendances as $attendance)
                <tr>
                    <td>{{$attendance->date}}</td>
                    <td>{{$attendance->employee_id}}</td>
                    <td>{{$attendance->status}}</td>
                    <td>{{$attendance->in_time}}</td>
                    <td>{{$attendance->out_time}}</td>
                    <td class="text-danger"><strong>{{$attendance->late ? "$attendance->late Min(s)" : null}}</strong></td>
                    <td class="text-danger"><strong>{{$attendance->early ? "$attendance->early Min(s)" : null}}</strong></td>
                    <td>
                        <div class="icon-btn">
                        <a href="{{ route('attendances.edit', $attendance->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8"><h5 class="text-muted my-3"> No Data Found Based on your query. </h5> </td>
                </tr>
            @endforelse

            </tbody>
        </table>
    </div>
    <div class="float-right">
        {{--{{$masterbls->links()}}--}}
    </div>
@endsection

@section('script')
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#fromDate').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});
            $('#tillDate').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});

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
        }); //document.ready


    </script>
@endsection