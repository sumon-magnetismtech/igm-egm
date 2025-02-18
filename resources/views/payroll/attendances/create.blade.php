@extends('layouts.new-layout')
@section('title', 'Attendance')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Attendance
    @else
        Add New Attendance
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('masterbls') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    @if($formType == 'edit')
        <form action="{{ route('attendances.update', $attendance->id) }}" method="post" class="custom-form">
            @method('PUT')
            <input type="hidden"  name="id" value="{{$attendance->id}}">
    @else
        <form action="{{ route('attendances.store') }}" method="post" class="custom-form">
            @endif
            <div class="row">
                @csrf
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <span class="input-group-addon">Date<span class="text-danger">*</span></span>
                        <input type="text" id="date" name="date" class="form-control" value="{{ old("date") ? old("date") : (!empty($moneyreceipt) ? date('d/m/Y', strtotime($moneyreceipt->issue_date)) : now()->format('d/m/Y')) }}"  tabindex="-1" required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <span class="input-group-addon">Employee Name<span class="text-danger">*</span></span>
                        <input type="text" id="employee_id" name="employee_id" class="form-control" list="employee_list" value="{{ old("employee_id") ? old("employee_id") : (!empty($attendance) ? $attendance->employee_id : null) }}">
                        <datalist id="employee_list">
                            <option value="1">Sumon</option>
                            <option value="2">Saleha</option>
                            <option value="3">Hasan</option>
                            <option value="4">Jahangir</option>
                        </datalist>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <span class="input-group-addon">In Time</span>
                        <input type="time" class="form-control" id="in_time" name="in_time" value="{{ old("in_time") ? old("in_time") : (!empty($attendance) ? \Carbon\Carbon::createFromFormat('H:i:s',$attendance->in_time)->format('H:i') : null) }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <span class="input-group-addon">Out Time</span>
                        <input type="time" class="form-control" id="out_time" name="out_time" value="{{ old("out_time") ? old("out_time") : (!empty($attendance) ? \Carbon\Carbon::createFromFormat('H:i:s',$attendance->out_time)->format('H:i') : null) }}">
                    </div>
                </div>
            </div><!-- end row -->
            <div class="row">
                <div class="offset-md-4 col-md-4 mt-2">
                    <div class="input-group input-group-sm ">
                        <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                    </div>
                </div>
            </div> <!-- end row -->
        </form>

    @if($formType == 'create')
        <hr class="my-2 bg-success">
        <form action="" method="POST" enctype="multipart/form-data" class="custom-form">
            @csrf
            <div class="card mt-4 border">
                <div class="card-block">
                    <div class="sub-title">Upload XL File</div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="input-group input-group-sm input-group-primary">
                                <span class="input-group-addon">Upload <span class="text-danger">*</span></span>
                                <input type="file" class="form-control">
                            </div>
                        </div> <!-- end row -->

                        <div class="col-md-2 d-flex align-items-end">
                            <div class="input-group input-group-md input-group-primary">
                                <button class="btn btn-success btn-sm btn-block" onclick="alert('Not Implemented Yet.'); return false"><i class="fas fa-file-upload"></i> Submit</button>
                            </div>
                        </div>
                    </div>

                </div> <!-- end card-block -->
            </div> <!-- end card -->
        </form> <!-- end form import from excel-->
    @endif
@endsection

@section('script')
    <script>
        $('#date').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});

    </script>
@endsection