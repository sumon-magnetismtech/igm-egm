@extends('layouts.egm-layout')
@section('title', 'FRD Delivery Order')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Delivery Order
    @else
        Add Delivery Order
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('egmdeliveryorders') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    @if($formType == 'edit')
        <form action="{{ route('egmdeliveryorders.update', $egmdeliveryorder->id) }}" method="post" class="custom-form">
            @method('PUT')
            <input type="hidden"  name="id" value="{{$egmdeliveryorder->id}}">
            @else
        <form action="{{ route('egmdeliveryorders.store') }}" method="post" class="custom-form">
            @endif
            @csrf
            <div class="row d-flex align-items-end">
                <div class="col-xl-4 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> House BL <span class="text-danger">*</span></span>
                        <input type="text" list="housebls" id="hblno" name="hblno" class="form-control" onchange="getHouseBLData()" value="{{ old("hblno") ? old("hblno") : (!empty($egmdeliveryorder) ? $egmdeliveryorder->moneyReceipt->houseBl->bolreference : null) }}" autocomplete="off" autofocus required>
                        {{-- <datalist id="housebls">
                            @foreach($moneyReceipts as $moneyReceipt)
                                <option> {{Str::upper($moneyReceipt->houseBl->bolreference)}} </option>
                            @endforeach
                        </datalist> --}}
                        <input type="hidden" id="moneyReceipt" name="moneyrecept_id" value="{{ old("moneyrecept_id") ? old("moneyrecept_id") : (!empty($egmdeliveryorder) ? $egmdeliveryorder->moneyrecept_id : null) }}">
                    </div>
                </div>
                <div class="col-xl-5 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> Client Name </span>
                        <input type="text" id="client_name" name="client_name" class="form-control" value="{{ old("client_name") ? old("client_name") : (!empty($egmdeliveryorder) ? $egmdeliveryorder->moneyReceipt->client_name : null) }}" tabindex="-1" readonly>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> Master BL No. </span>
                        <input type="text" id="mblno" name="mblno" class="form-control" value="{{ old("mblno") ? old("mblno") : (!empty($egmdeliveryorder) ? $egmdeliveryorder->moneyReceipt->houseBl->masterbl->mblno : null) }}" readonly tabindex="-1">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> Feeder Vessel </span>
                        <input type="text" id="fvsl" name="fvsl" class="form-control" value="{{ old("fvsl") ? old("fvsl") : (!empty($egmdeliveryorder) ? $egmdeliveryorder->moneyReceipt->houseBl->masterbl->fvessel : null) }}" readonly tabindex="-1">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> Rotation </span>
                        <input type="text" id="rotation" name="rotation" class="form-control" value="{{ old("rotation") ? old("rotation") : (!empty($egmdeliveryorder) ? $egmdeliveryorder->moneyReceipt->houseBl->masterbl->rotno : null) }}" readonly tabindex="-1">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> Arrival Date </span>
                        <input type="text" id="arrival_date" name="arrival_date" class="form-control" value="{{ old("arrival_date") ? old("arrival_date") : (!empty($egmdeliveryorder) ? date('d-m-Y', strtotime($egmdeliveryorder->moneyReceipt->houseBl->masterbl->arrival)) : null) }}" readonly tabindex="-1" autocomplete="off">
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> Total Container </span>
                        <input type="text" id="containernumber" name="containernumber" class="form-control" readonly tabindex="-1" value="{{ old("package") ? old("containernumber") : (!empty($egmdeliveryorder) ? $egmdeliveryorder->moneyReceipt->houseBl->containernumber : null) }}">
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> Total Package </span>
                        <input type="text" id="package" name="package" class="form-control" value="{{ old("package") ? old("package") : (!empty($egmdeliveryorder) ? $egmdeliveryorder->moneyReceipt->houseBl->packageno : null) }}" readonly tabindex="-1">
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> Gross Weight </span>
                        <input type="text" id="grosswt" name="grosswt" class="form-control" value="{{ old("grosswt") ? old("grosswt") : (!empty($egmdeliveryorder) ? $egmdeliveryorder->moneyReceipt->houseBl->grosswt : null) }}" readonly tabindex="-1">
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> Consignee </span>
                        <textarea type="text" id="consignee" name="consignee" rows="3" class="form-control" readonly tabindex="-1">{{ old("consignee") ? old("consignee") : (!empty($egmdeliveryorder) ? $egmdeliveryorder->moneyReceipt->houseBl->consigneename.', '.$egmdeliveryorder->moneyReceipt->houseBl->consigneeaddress.' ('.$egmdeliveryorder->moneyReceipt->houseBl->consigneebin.')': null)}}</textarea>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> Notify </span>
                        <textarea type="text" id="notify" name="notify" rows="3" class="form-control" readonly tabindex="-1">{{ old("notify") ? old("notify") : (!empty($egmdeliveryorder) ? $egmdeliveryorder->moneyReceipt->houseBl->notifyname.', '.$egmdeliveryorder->moneyReceipt->houseBl->notifyaddress.' ('.$egmdeliveryorder->moneyReceipt->houseBl->notifybin.')': null) }}</textarea>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> BE No <span class="text-danger">*</span></span>
                        <input type="text" id="BE_No" name="BE_No" class="form-control" value="{{ old("BE_No") ? old("BE_No") : (!empty($egmdeliveryorder) ? $egmdeliveryorder->BE_No : null) }}" required>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> BE Date <span class="text-danger">*</span></span>
                        <input type="text" id="BE_Date" name="BE_Date" class="form-control" value="{{ old("BE_Date") ? old("BE_Date") : (!empty($egmdeliveryorder) ? date('d-m-Y', strtotime($egmdeliveryorder->BE_Date)) : null) }}" required placeholder="dd/mm/yyyy" autocomplete="off">
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> Issue Date <span class="text-danger">*</span></span>
                        <input type="text" id="issue_date" name="issue_date" class="form-control" value="{{ old("issue_date") ? old("issue_date") : (!empty($egmdeliveryorder) ? date('d-m-Y', strtotime($egmdeliveryorder->issue_date)) : date('d/m/Y')) }}" required placeholder="dd/mm/yyyy" autocomplete="off">
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> Up To Date </span>
                        <input type="text" id="upto_date" name="upto_date" class="form-control" value="{{ old("upto_date") ? old("upto_date") : (!empty($egmdeliveryorder) ? $egmdeliveryorder->upto_date ? date('d-m-Y', strtotime($egmdeliveryorder->upto_date)) : null : null) }}" placeholder="dd/mm/yyyy" autocomplete="off">
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon"> Type of HBL </span>
                        <select type="text" id="bl_type" name="bl_type" class="form-control" required>
                            <option value="Original" {{old('bl_type') &&  old('bl_type')=='Original' ? 'selected' : (!empty($egmdeliveryorder) &&  $egmdeliveryorder->bl_type ==='Original' ? 'selected' : null)}}> Original </option>
                            <option value="Telex Release" {{old('bl_type') &&  old('bl_type')=='Telex Release' ? 'selected' : (!empty($egmdeliveryorder) &&  $egmdeliveryorder->bl_type ==='Telex Release' ? 'selected' : null)}}> Telex Release </option>
                            <option value="Bank Guarantee" {{old('bl_type') &&  old('bl_type')=='Bank Guarantee' ? 'selected' : (!empty($egmdeliveryorder) &&  $egmdeliveryorder->bl_type ==='Bank Guarantee' ? 'selected' : null)}}> Bank Guarantee </option>
                        </select>
                    </div>
                </div>
            </div><!-- end row -->

            <div class="row">
                <div class="offset-xl-5 col-xl-2 offset-md-4 col-md-4 mt-3">
                    <div class="input-group input-group-sm ">
                        <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                    </div>
                </div>
            </div> <!-- end row -->
        </form>
@endsection

@section('script')
<script>
    function getHouseBLData(){
        let url = '{{url("getEgmHBLid")}}/'+document.getElementById('hblno').value;
        fetch(url)
                .then((resp) => resp.json())
    .then(function (hblno) {
            $("#client_name").val(hblno.client_name);
            $("#mblno").val(hblno.mblno);
            $("#dono").val("qclogfrd-"+hblno.moneyreceipt_id);
            $("#moneyReceipt").val(hblno.moneyreceipt_id);
            $("#fvsl").val(hblno.fvsl);
            $("#arrival_date").val(hblno.arrival_date);
            $("#rotation").val(hblno.rotation);
            $("#hbl_id").val(hblno.hbl_id);

            $("#consignee").val(hblno.consignee);
            $("#notify").val(hblno.notify);
            $("#containernumber").val(hblno.containernumber);
            $("#package").val(hblno.packageno);
            $("#grosswt").val(hblno.grosswt);
            if(hblno.specialContainer == true){
                $("#upto_date").prop("required", true);
            }else{
                $("#upto_date").prop("required", false);
            }
        })
                .catch(function () {
                    alert('Please Create Money Receipt First.');
                    $("#client_name,#mblno,#dono,#fvsl,#arrival_date,#rotation,#hbl_id,#consignee,#notify,#containernumber,#package,#grosswt").val(null);
                    $("#upto_date").removeAttr('required');
                });
    }
    $(function(){
        $('#BE_Date').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});
        $('#issue_date').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});
        $('#upto_date').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});

    }); //document.ready
</script>
@endsection