@extends('layouts.new-layout')
@section('title', 'Container List')

@section('breadcrumb-title', 'Add New Outbound Container ')

@section('breadcrumb-button')
    <a href="{{route('exports.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fa fa-database"></i></a>
@endsection

@section('sub-title')
    {{--Total: {{$moneyReceipts ? $moneyReceipts->total() : 0}}--}}
@endsection


@section('content')
<div class="container">
    @if($fromType=='edit')
    <form action="{{ route('exports.update', $export->id)}}" method="post" class="custom-form">
        @method('PUT')
        <input type="hidden"  name="id" value="{{$export->id}}">
    @else
        <form action="{{route('exports.store')}}" method="post" class="custom-form">
    @endif
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> Vessel Name <span class="text-danger">*</span></span>
                    <input name="vesselName" type="text" id="vesselName" class="form-control"  value="{{ old("vesselName") ? old("vesselName") : (!empty($export) ? $export->vesselName : null) }}">
                </div>
            </div> <!-- end col-lg-4 -->
            <div class="col-lg-4">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> Vessel Code <span class="text-danger">*</span></span>
                    <input name="vesselCode" type="text" id="vesselCode" class="form-control"  value="{{ old("vesselCode") ? old("vesselCode") : (!empty($export) ? $export->vesselCode : null) }}">
                </div>
            </div> <!-- end col-lg-4 -->
            <div class="col-lg-4">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> Export Date <span class="text-danger">*</span></span>
                    <input name="exportDate" placeholder="select date" type="text" id="exportDate" class="form-control"  value="{{ old("exportDate") ? old("exportDate") : (!empty($export) ? date('d-m-Y', strtotime($export->exportDate)) : null) }}" autocomplete="off">
                </div>
            </div> <!-- end col-lg-4 -->
            <div class="col-lg-4">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> Voyage No <span class="text-danger">*</span></span>
                    <input name="voyageNo" type="text" id="voyageNo" class="form-control"  value="{{ old("voyageNo") ? old("voyageNo") : (!empty($export) ? $export->voyageNo : null) }}">
                </div>
            </div> <!-- end col-lg-4 -->
            <div class="col-lg-4">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> Rotation No <span class="text-danger">*</span></span>
                    <input name="rotationNo" type="text" id="rotationNo" class="form-control"  value="{{ old("rotationNo") ? old("rotationNo") : (!empty($export) ? $export->rotationNo : null) }}">
                </div>
            </div> <!-- end col-lg-4 -->
            <div class="col-lg-4">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> Sailing Date <span class="text-danger">*</span></span>
                    <input name="sailingDate" placeholder="Select Date" type="text" id="sailingDate" class="form-control"  value="{{ old("sailingDate") ? old("sailingDate") : (!empty($export) ? date('d-m-Y', strtotime($export->sailingDate)) : null) }}" autocomplete="off">
                </div>
            </div> <!-- end col-lg-4 -->
            <div class="col-lg-4">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> ETA Date <span class="text-danger">*</span></span>
                    <input name="etaDate" placeholder="Select Date" type="text" id="etaDate" class="form-control"  value="{{ old("etaDate") ? old("etaDate") : (!empty($export) ? date('d-m-Y', strtotime($export->etaDate)) : null) }}" autocomplete="off">
                </div>
            </div> <!-- end col-lg-4 -->
            <div class="col-lg-4">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon">  Export Status <span class="text-danger">*</span></span>
                    <select name="eStatus" id="eStatus" class="form-control">
                        <option disabled selected> Select E-Status </option>
                        @foreach($eStatus as $status)
                            <option value="{{$status}}" @if(old('eStatus')==$status || !empty($export->eStatus) &&  $export->eStatus== $status) selected @endif>
                                {{$status}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div> <!-- end col-lg-4 -->
            <div class="col-lg-4">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> Commodity <span class="text-danger">*</span></span>
                    <input name="commodity" type="text" id="commodity" class="form-control"  value="{{ old("commodity") ? old("commodity") : (!empty($export) ? $export->commodity : null) }}">
                </div>
            </div> <!-- end col-lg-4 -->
            <div class="col-lg-4">

                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> Destination <span class="text-danger">*</span></span>
                    <input name="destination" type="text" id="destination" class="form-control"  value="{{ old("destination") ? old("destination") : (!empty($export) ? $export->destination : null) }}">
                </div>
            </div> <!-- end col-lg-4 -->
            <div class="col-lg-4">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> Seal No <span class="text-danger">*</span></span>
                    <input name="sealNo" type="text" id="sealNo" class="form-control"  value="{{ old("sealNo") ? old("sealNo") : (!empty($export) ? $export->sealNo : null) }}">
                </div>
            </div> <!-- end col-lg-4 -->
            <div class="col-lg-4">

                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> Transhipment Port<span class="text-danger">*</span></span>
                    <input name="transhipmentPort" type="text" id="transhipmentPort" class="form-control"  value="{{ old("transhipmentPort") ? old("transhipmentPort") : (!empty($export) ? $export->transhipmentPort : null) }}">
                </div>
            </div> <!-- end col-lg-4 -->
            <div class="col-lg-12">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> Remarks <span class="text-danger">*</span></span>
                    <textarea name="remarks" rows="2" type="text" id="remarks" class="form-control">{{ old("remarks") ? old("remarks") : (!empty($export) ? $export->remarks : null)}}</textarea>
                </div>
            </div> <!-- end col-lg-4 -->
        </div> <!-- end row -->

        <p class="lead"> Container List ({{count($containers)}}) </p>
        @foreach($containers as $key => $container)
            <span class="bafdge badge-pill badge-primary p-2 {{!$loop->first ? 'm-2' : ''}} rounded-0" id="containerList">
                <input type="hidden" class='contRef' name="contRef[]" value="{{$container}}">
                <input type="checkbox" id="blContainer{{$key}}" class="blContainer" checked name="blcontainer_id[]" value="{{$key}}">
                <label for="blContainer{{$key}}" style="cursor: pointer"> {{$container}} </label>
            </span>
        @endforeach

        <div class="row">
            <div class="offset-xl-5 col-xl-2 offset-md-4 col-md-4 mt-3">
                <div class="input-group input-group-sm" id="submitBtnArea">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div> <!-- end row -->
    </form>
</div>
@endsection

@section('script')

    <script>

        $('input[name="blcontainer_id[]"]').click(function () {
            if(this.checked==false){
                $(this).parent("#containerList").addClass('badge-warning');
                $(this).siblings().removeAttr('name');
                $(this).removeAttr('name');
            }else{
                $(this).parent("#containerList").removeClass('badge-warning');
                $(this).siblings('.contRef').attr('name', 'contRef[]');
                $(this).attr('name', 'blcontainer_id[]');
            }

        });

        $(function(){
            $('#exportDate').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true});
            $('#sailingDate').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true});
            $('#etaDate').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true});

//            $(".blContainer").click(function(){
//                if(this.checked == true){
//
//                }
//            });



        });//document.ready()



    </script>
@endsection
