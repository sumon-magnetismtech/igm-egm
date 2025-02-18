@extends('layouts.new-layout')
@section('title', 'Attendance')

@section('breadcrumb-title', 'Employee Attendance')

@section('breadcrumb-button')
    @can('masterbl-create')
    <a href="{{route('attendances.create')}}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total :
@endsection

@section('content')
    <form action="{{ route('doreport') }}" method="get">
        <div class="row">
            <div class="col-md-1 pr-md-1 my-1 my-md-0" data-toggle="tooltip" title="Output">
                <select name="requestType" class="form-control form-control-sm">
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0">
                <select name="dateType" id="dateType" class="form-control form-control-sm" required>
                    <option value="today" selected> Today </option>
                    <option value="weekly" {{$dateType == "weekly" ? "selected" : ''}}> Last 7 Days </option>
                    <option value="monthly" {{$dateType == "monthly" ? "selected" : ''}}> Last 30 Days </option>
                    <option value="custom" {{$dateType == "custom" ? "selected" : ''}}> Custom </option>
                </select>
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0" id="fromDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <input id="fromDate" class="form-control form-control-sm" value="{{$fromDate ? date('d/m/Y', strtotime($fromDate)) : ''}}"  type="text" name="fromDate" placeholder="From Date" autocomplete="off">
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0" id="tillDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <input id="tillDate" class="form-control form-control-sm" value="{{!empty($tillDate) ? date('d/m/Y', strtotime($tillDate)) : ''}}"  type="text" name="tillDate" placeholder="Till Date" autocomplete="off">
            </div>
            <div class="col-md-3 px-md-1 my-1 my-md-0">
                <input id="principal" class="form-control form-control-sm" value="{{$employeeName ?? ""}}"  type="text" name="employee_id" placeholder="Employee Name" autocomplete="off">
            </div>
            <div class="col-md-1 px-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>
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
                    <td>{{$attendance->employee->name}} ({{$attendance->employee->id}})</td>
                    <td class="{{$attendance->status == "absent" ? "bg-warning" : null}}">{{\Illuminate\Support\Str::title($attendance->status) }}</td>
                    <td>{{$attendance->in_time}}</td>
                    <td>{{$attendance->out_time}}</td>
                    <td class="text-danger">
                        @if($attendance->late)
                            <strong>
                                @if($attendance->late > 60)
                                    {{intdiv($attendance->late, 60)." Hour ".($attendance->late % 60)}} Min(s)
                                @else
                                    {{$attendance->late}} Min(s)
                                @endif
                            </strong>
                        @endif
                    </td>
                    <td class="text-danger">
                        @if($attendance->early)
                            <strong>
                                @if($attendance->early > 60)
                                    {{intdiv($attendance->early, 60)." Hour ".($attendance->early % 60)}} Min(s)
                                @else
                                    {{$attendance->early}} Min(s)
                                @endif
                            </strong>
                        @endif
                    </td>
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