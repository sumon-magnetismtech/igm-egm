@extends('layouts.new-layout')
@section('title', 'B/L Information')

@section('style')
    <style>
        /*#addContainer{display: none; }*/
        #fileUploadArea{ display: none; }
        table.fixed { table-layout:fixed; }
        table.fixed td { overflow: hidden; }
    </style>
@endsection

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit B/L Information
    @else
        Add B/L Information
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('egmfeederinformations') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
    @if($feederInfo->id)
    <a href="{{url("blxmldownload/$feederInfo->id")}}" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-download"></i> XML</a>
    @endif
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    @if($formType == 'edit')
        <form action="{{ route('egmmloblinformations.update', $mloblinformation->id) }}" method="post" id="mainForm" class="custom-form" enctype="multipart/form-data" >
            @method('PUT')
            <input type="hidden" name="id" value="{{$mloblinformation->id}}">
    @else
        <form action="{{ route('egmmloblinformations.store') }}" method="post" id="mainForm" class="custom-form" enctype="multipart/form-data" >
    @endif
        @csrf

        <div class="row d-flex align-items-end px-1">
            <div class="col-xl-2 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Custom Code </span>
                    <input type="text" class="form-control" id="customoffice" name="cofficecode" tabindex="-1" value="{{ old("cofficecode") ? old("cofficecode") : (!empty($feederInfo->COCode) ? $feederInfo->COCode : null)}}" readonly>
                </div>
            </div>
            <div class="col-xl-2 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Feeder ID </span>
                    <input type="text" id="feederinformations_id" name="feederinformations_id" class="form-control" value="{{ old("feederinformations_id") ? old("feederinformations_id") : (!empty($feederInfo->id) ? $feederInfo->id : null) }}" readonly>
                </div>
            </div>
            <div class="col-xl-5 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Feeder Vessel </span>
                    <input type="text" id="fvessel" name="vesselname" class="form-control" value="{{ old("vesselname") ? old("vesselname") : (!empty($feederInfo->feederVessel) ? $feederInfo->feederVessel : null)  }}" readonly>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Voyage </span>
                    <input type="text" id="voyage" name="voyage" class="form-control" value="{{ old("voyage") ? old("voyage") : (!empty($feederInfo->voyageNumber) ? $feederInfo->voyageNumber : null) }}" readonly>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Rotation </span>
                    <input type="text" id="rotno" name="rotation" class="form-control" value="{{ old("rotation") ? old("rotation") : (!empty($feederInfo->rotationNo) ? $feederInfo->rotationNo : null) }}" tabindex="-1" readonly>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Departure Date </span>
                    <input type="text" id="departure" name="departure" class="form-control"  value="{{ old("departure") ? old("departure") : (!empty($feederInfo->departureDate) ? date('d/m/Y', strtotime($feederInfo->departureDate)) : null) }}" tabindex="-1" readonly>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Arrival Date </span>
                    <input type="text" id="arrival" name="arrival" class="form-control"  value="{{ old("arrival") ? old("arrival") : (!empty($feederInfo->arrivalDate) ? date('d/m/Y', strtotime($feederInfo->arrivalDate)) : null) }}" tabindex="-1" readonly>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Berthing Date </span>
                    <input type="text" id="berthing" name="berthing" class="form-control"  value="{{ old("berthing") ? old("berthing") : (!empty($feederInfo->berthingDate) ? date('d/m/Y', strtotime($feederInfo->berthingDate)) : null) }}" tabindex="-1" readonly>
                </div>
            </div>

        </div> <!-- end row  -->
        <hr class="my-2 bg-success">

        <div class="row d-flex align-items-end px-1">
            <div class="col-xl-3 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Line <span class="text-danger">*</span> </span>
                    <input type="text" id="lineno" name="line" class="form-control" value="{{$lineNumber ?? (($mloblinformation) ? $mloblinformation->line : null)}}" required readonly>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 px-1">
                <div class="input-group input-group-sm pt-3">
                    <span class="input-group-addon"> BOL Reference <span class="text-danger">*</span> </span>
                    <label class="badge badge-danger characterLimit"></label>
                    <input type="text" id="bolref" name="bolreference" class="form-control" maxlength="17" value="{{ old("bolreference") ? old("bolreference") : (!empty($mloblinformation) ? $mloblinformation->bolreference : null) }}" required spellcheck="false" autofocus autocomplete="off">
                </div>
            </div>
            <div class="col-xl-6 col-md-6 px-1">
                <div class="input-group input-group-sm pt-3">
                    <span class="input-group-addon"> Principal Name <span class="text-danger">*</span> </span>
                    <input type="text" id="principal" name="principal" class="form-control bg-warning text-danger font-weight-bold" list="principalList" value="{{ old("principal") ? old("principal") : (!empty($mloblinformation) ? $mloblinformation->principal->name : null) }}" autocomplete="off" required spellcheck="false">
                    <datalist id="principalList">
                        @foreach($principals as $principal)
                            <option value="{{$principal}}">{{$principal}}</option>
                        @endforeach
                    </datalist>
                    <input type="hidden" class="form-control bg-warning text-danger" id="principal_id" name="principal_id" value="{{ old("principal_id") ? old("principal_id") : (!empty($mloblinformation) ? $mloblinformation->principal_id : null) }}" readonly>
                </div>
            </div>

            <div class="col-xl-6 col-md-6 px-1">
                <div class="input-group input-group-sm pt-3">
                    <span class="input-group-addon"> Exporter Name <span class="text-danger">*</span> </span>
                    <label class="badge badge-danger characterLimit"></label>
                    <input type="text" id="exportername" name="exportername" class="form-control" list="exporterInfos" maxlength="35" value="{{ old("exportername") ? old("exportername") : (!empty($mloblinformation) ? $mloblinformation->exportername : null) }}" style="font-size: 14px" onchange="loadExporterAddress()" autocomplete="off"  spellcheck="false" required>
                    <datalist id="exporterInfos">
                        @foreach($exporterInfos as $exporterInfo)
                            <option value="{{$exporterInfo}}"></option>
                        @endforeach
                    </datalist>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 px-1">
                <div class="input-group input-group-sm pt-3">
                    <span class="input-group-addon"> Exporter Address <span class="text-danger">*</span> </span>
                    <textarea type="text" id="exporteraddress" name="exporteraddress" class="form-control" tabindex="-1" rows="1" spellcheck="false" required>{{ old("exporteraddress") ? old("exporteraddress") : (!empty($mloblinformation) ? $mloblinformation->exporteraddress : null) }}</textarea>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 px-1">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> POL Code <span class="text-danger">*</span> </span>
                    <input type="text" id="depPortCode" name="pOrigin" required class="form-control" value="{{ old("pOrigin") ? old("pOrigin") : (!empty($mloblinformation) ? $mloblinformation->pOrigin : null) }}">
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 px-1">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> POL Name <span class="text-danger">*</span> </span>
                    <input type="text" id="pOriginName" name="pOriginName" class="form-control" value="{{ old("pOriginName") ? old("pOriginName") : (!empty($mloblinformation) ? $mloblinformation->pOriginName : null) }}" required>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 px-1">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> POU Code <span class="text-danger">*</span> </span>
                    <input type="text" id="desPortCode" name="PUloding" class="form-control" value="{{ old("PUloding") ? old("PUloding") : (!empty($mloblinformation) ? $mloblinformation->PUloding : "BDCGP") }}" required>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 px-1">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> POU Name <span class="text-danger">*</span> </span>
                    <input type="text" id="unloadingName" name="unloadingName" class="form-control" value="{{ old("unloadingName") ? old("unloadingName") : (!empty($mloblinformation) ? $mloblinformation->unloadingName : "Chittagong") }}" required>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-4 px-1">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> BOL Nature <span class="text-danger">*</span></span>
                    <select id="blnaturecode" name="blnaturecode" class="form-control" onchange="getblnaturetype()" tabindex="-1" readonly>
                        <option value="23" {{old('blnaturecode') && old('blnaturecode')==23 ? 'selected' : (!empty($mloblinformation->blnaturecode) && $mloblinformation->blnaturecode ==23 ? 'selected' : null)}} selected>23</option>
                        <option value="22" {{old('blnaturecode') && old('blnaturecode')==22 ? 'selected' : (!empty($mloblinformation->blnaturecode) && $mloblinformation->blnaturecode ==22 ? 'selected' : null)}}>22</option>
                        <option value="24" {{old('blnaturecode') && old('blnaturecode')==24 ? 'selected' : (!empty($mloblinformation->blnaturecode) && $mloblinformation->blnaturecode ==24 ? 'selected' : null)}}>24</option>
                        <option value="28" {{old('blnaturecode') && old('blnaturecode')==28 ? 'selected' : (!empty($mloblinformation->blnaturecode) && $mloblinformation->blnaturecode ==28 ? 'selected' : null)}}>28</option>
                    </select>
                </div>
            </div>
            <div class="col-xl-3 col-lg-8 col-md-8 px-1">
                <div class="input-group input-group-sm">
                    <input type="text" id="blnaturetype" name="blnaturetype" class="form-control" value="{{ old("blnaturetype") ? old("blnaturetype") : (!empty($mloblinformation) ? $mloblinformation->blnaturetype : null) }}"  tabindex="-1" readonly>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-4 px-1">
                <div class="input-group input-group-sm ">
                    <span class="input-group-addon"> BOL Type <span class="text-danger">*</span></span>
                    <select id="bltypecode" name="bltypecode" class="form-control" onchange="getbltypename()">
                        <option value="HSB" {{old('bltypecode') && old('bltypecode')=="HSB" ? 'selected' : (!empty($mloblinformation->bltypecode) && $mloblinformation->bltypecode =="HSB" ? 'selected' : null)}} selected>HSB</option>
                        <option value="MSB" {{old('bltypecode') && old('bltypecode')=="MSB" ? 'selected' : (!empty($mloblinformation->bltypecode) && $mloblinformation->bltypecode =="MSB" ? 'selected' : null)}}>MSB</option>
                        <option value="AWB" {{old('bltypecode') && old('bltypecode')=="AWB" ? 'selected' : (!empty($mloblinformation->bltypecode) && $mloblinformation->bltypecode =="AWB" ? 'selected' : null)}}>AWB</option>
                        <option value="MAB" {{old('bltypecode') && old('bltypecode')=="MAB" ? 'selected' : (!empty($mloblinformation->bltypecode) && $mloblinformation->bltypecode =="MAB" ? 'selected' : null)}}>MAB</option>
                    </select>
                </div>
            </div>
            <div class="col-xl-3 col-lg-8 col-md-8 px-1">
                <div class="input-group input-group-sm ">
                    <input type="text" class="form-control" name="bltypename" id="bltypename" value="{{ old("bltypename") ? old("bltypename") : (!empty($mloblinformation) ? $mloblinformation->bltypename : null) }}" readonly tabindex="-1">
                </div>
            </div>

            <div class="col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">Consig. BIN  <span class="text-danger">*</span> </span>
                    <input type="text" list="consigneeBins" class="form-control" id="consignee_id" name="consignee_id" onchange="loadConsigneeBin()" value="{{ old("consignee_id") ? old("consignee_id") : (!empty($mloblinformation) ? $mloblinformation->blConsignee->BIN : null) }}" autocomplete="off" required>
                    <datalist id="consigneeBins">
                        @foreach($consigneenames as $key => $consigneename)
                            <option> {{$key}}</option>
                        @endforeach
                    </datalist>
                </div>

                <div class="input-group input-group-sm pt-3">
                    <span class="input-group-addon"> Consig. Name <span class="text-danger">*</span> </span>
                    <label class="badge badge-danger characterLimit"></label>
                    <input type="text" id="consigneename" maxlength="35" name="consigneename" class="form-control " value="{{ old("consigneename") ? old("consigneename") : (!empty($mloblinformation) ? $mloblinformation->blConsignee->NAME : null) }}" tabindex="-1" autocomplete="off" required>
                </div>

                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Consig. Address <span class="text-danger">*</span>  </span>
                    <textarea class="form-control md-textarea" id="consigneeaddress" rows="2" name="consigneeaddress" required tabindex="-1">{{ old("consigneeaddress") ? old("consigneeaddress") : (!empty($mloblinformation) ? $mloblinformation->blConsignee->ADD1 : null) }}</textarea>
                </div>
            </div>
            <div class="col-md-6 px-1">
                <div class="d-flex align-items-center mb-1">
                    <input type="checkbox" id="cloneNotifyBtn" class="checkbox" name="cloneNotifyBtn" value="cloneNotifyBtn">
                    <label for="cloneNotifyBtn" style="margin: 0 0 0 5px"> Same Consignee & Notify</label>
                </div>
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Notify BIN <span class="text-danger">*</span> </span>
                    <input type="text" list="notifyBins" class="form-control" id="notify_id" name="notify_id" onchange="loadNotifyBin()" value="{{ old("notify_id") ? old("notify_id") : (!empty($mloblinformation) ? $mloblinformation->blNotify->BIN : null) }}" autocomplete="off" required>
                    <datalist id="notifyBins">
                        @foreach($notifynames as $key => $notifyname)
                            <option> {{$key}}</option>
                        @endforeach
                    </datalist>
                </div>
                <div class="input-group input-group-sm pt-3">
                    <span class="input-group-addon">Notify Name <span class="text-danger">*</span> </span>
                    <label class="badge badge-danger characterLimit"></label>
                    <input type="text" class="form-control " id="notifyname" maxlength="35" name="notifyname" value="{{ old("notifyname") ? old("notifyname") : (!empty($mloblinformation) ? $mloblinformation->blNotify->NAME : null) }}" autocomplete="off" required tabindex="-1">
                </div>
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Notify Address <span class="text-danger">*</span> </span>
                    <textarea id="notifyaddress" name="notifyaddress" class="form-control" rows="2" required tabindex="-1">{{ old("notifyaddress") ? old("notifyaddress") : (!empty($mloblinformation) ? $mloblinformation->blNotify->ADD1 : null) }}</textarea>
                </div>
            </div>

            <div class="col-xl-6 col-md-12 px-1">
                <div class="input-group input-group-sm pt-3">
                    <span class="input-group-addon"> Shipping Mark <span class="text-danger">*</span></span>
                    <label class="badge badge-danger characterLimit"></label>
                    <textarea id="shippingmark" name="shippingmark" class="form-control " rows="3" maxlength="512" required @if($formType=='create') onfocus="this.select()" @endif>{{ old("shippingmark") ? old("shippingmark") : (!empty($mloblinformation) ? $mloblinformation->shippingmark : null) }}</textarea>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 px-1">
                <div class="input-group input-group-sm pt-3">
                    <span class="input-group-addon">Description <span class="text-danger">*</span></span>
                    <label class="badge badge-danger characterLimit"></label>
                    <textarea type="text" id="description" name="description" class="form-control " rows="3" required maxlength="512">{{ old("description") ? old("description") : (!empty($mloblinformation) ? $mloblinformation->description : null) }}</textarea>
                </div>
            </div>

            <div class="col-xl-2 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> MLO Code <span class="text-danger">*</span></span>
                    <input type="text" id="mlocode" name="mlocode" list="mlocodes" class="form-control" value="{{ old("mlocode") ? old("mlocode") : (!empty($mloblinformation) ? $mloblinformation->mlocode : "QCM") }}" onchange="loadMloName()" tabindex="-1" readonly>
                    <datalist id="mlocodes">
                        @foreach($mlocodes as $mlocode)
                            <option value="{{$mlocode}}"></option>
                        @endforeach
                    </datalist>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> MLO Name <span class="text-danger">*</span> </span>
                    <input type="text" id="mloname" name="mloname" class="form-control" value="{{ old("mloname") ? old("mloname") : (!empty($mloblinformation) ? $mloblinformation->mloname : "QC MARITIME LIMITED") }}" placeholder="Enter MLO Name" readonly tabindex="-1">
                </div>
            </div>
            <div class="col-xl-6 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> MLO Address <span class="text-danger">*</span> </span>
                    <textarea id="mloaddress" name="mloaddress" class="form-control" rows="1" maxlength="512" readonly tabindex="-1">{{ old("mloaddress") ? old("mloaddress") : (!empty($mloblinformation) ? $mloblinformation->mloaddress : "CANDF TOWER, 4TH FLOOR, AGRABAD, CHITTAGONG, BANGLADESH") }}</textarea>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Freight Status</span>
                    <input type="text" id="freightstatus" name="freightstatus" class="form-control" value="{{ old("freightstatus") ? old("freightstatus") : (!empty($mloblinformation) ? $mloblinformation->freightstatus : null) }}" tabindex="-1">
                </div>
            </div>
            <div class="col-xl-3 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">Freight Value</span>
                    <input type="text" id="freightvalue" name="freightvalue" class="form-control" value="{{ old("freightvalue") ? old("freightvalue") : (!empty($mloblinformation) ? $mloblinformation->freightvalue : null) }}" tabindex="-1">
                </div>
            </div>
            <div class="col-xl-6 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Co-Loader </span>
                    <input type="text" id="coloader" name="coloader" class="form-control" value="{{ old("coloader") ? old("coloader") : (!empty($mloblinformation) ? $mloblinformation->coloader : null) }}" tabindex="-1">
                </div>
            </div>

            <div class="col-xl-3 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Total Package <span class="text-danger">*</span></span>
                    <input type="number" class="form-control" id="nofpackage" name="packageno" min="1" step="1" pattern="[0-9]" value="{{ old("packageno") ? old("packageno") : (!empty($mloblinformation) ? $mloblinformation->packageno : null) }}" autocomplete="off" required>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Package Code <span class="text-danger">*</span> </span>
                    <input type="text" list="packagecodeList" name="packagecode" id="packagecode" class="form-control " data-parsley-required="true" onchange="loadPackageName()" style="font-size: 13px" value="{{ old('packagecode') ? old('packagecode') : (!empty($mloblinformation) ? $mloblinformation->package->packagecode : null)}}" required >
                    <input type="hidden" name="package_id" id="package_id" value="{{ old("package_id") ? old("package_id") : (!empty($mloblinformation) ? $mloblinformation->package_id : null) }}">
                    <datalist id="packagecodeList">
                        @foreach($packagecodes as $packagecode)
                            <option value="{{$packagecode}}">{{ $packagecode }}</option>
                        @endforeach
                    </datalist>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">Package Name <span class="text-danger">*</span> </span>
                    <input type="text" id="packagename" name="packagetype" class="form-control" value="{{ old("packagetype") ? old("packagetype") : (!empty($mloblinformation) ? $mloblinformation->package->description : null) }}" required tabindex="-1">
                </div>
            </div>

            <div class="col-xl-3 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Gross Weight <span class="text-danger">*</span> </span>
                    <input type="text" id="hblgrossweight" name="grosswt" class="form-control" value="{{ old("grosswt") ? old("grosswt") : (!empty($mloblinformation) ? $mloblinformation->grosswt : null) }}" required autocomplete="off">
                </div>
            </div>
            <div class="col-xl-3 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Measurement <span class="text-danger">*</span> </span>
                    <input type="number" min="0" id="measurement" name="measurement" class="form-control" value="{{ old("measurement") ? old("measurement") : (!empty($mloblinformation) ? $mloblinformation->measurement : 0) }}" required autocomplete="off">
                </div>
            </div>
            <div class="col-xl-3 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Total Container <span class="text-danger">*</span> </span>
                    <input type="number" id="noofcontainer" name="containernumber" class="form-control" value="{{ old("containernumber") ? old("containernumber") : (!empty($mloblinformation) ? $mloblinformation->containernumber : null) }}" min="0" required autocomplete="off">
                </div>
            </div>

            <div class="col-xl-6 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> Remarks </span>
                    <textarea id="remarks" name="remarks" class="form-control" rows="1" tabindex="-1">{{ old("remarks") ? old("remarks") : (!empty($mloblinformation) ? $mloblinformation->remarks : null) }}</textarea>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 px-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"> DO Note </span>
                    <textarea id="notefordo" name="note" class="form-control bg-light text-danger bg-warning font-weight-bold" rows="1">{{ old("note") ? old("note") : (!empty($mloblinformation) ? $mloblinformation->note : null) }}</textarea>
                </div>
            </div>
        </div> <!-- end row -->
        <hr class="my-2 bg-success">


        <div class="row d-flex align-items-end px-1">
            <div class="col-md-6 px-1 my-1">
                <button type="button" class="btn btn-outline-warning btn-block" id="uploadBtn" tabindex="-1">Upload a file</button>
            </div>
            <div class="col-md-6 px-1 my-1">
                <button type="button" class="btn btn-warning btn-block"  id="addContainerBtn" tabindex="-1"> Add/Hide Container </button>
            </div>
        </div> <!-- end row -->


        <div class="row" id="fileUploadArea">
            <div class="card m-2 py-0 border border-secondary rounded">
                <div class="card-block">
                    <div class="sub-title text-right"><a href="{{asset('containerformat_mlo.xlsx')}}" class="text-danger font-weight-bold"> <i class="fa fa-download"></i> Download Container XL Format </a></div>
                    <div class="input-group input-group-sm input-group-primary">
                        <span class="input-group-addon">Upload <span class="text-danger">*</span></span>
                        <input type="file" name="file" class="form-control" id="file">
                    </div>
                </div>
            </div>
        </div> <!-- end fileUploadArea -->

        <div id="addContainer">
            <div class="row">
                <div class="col-md-3 my-2">
                    <div class="border-checkbox-section">
                        <div class="border-checkbox-group border-checkbox-group-primary">
                            <input type="checkbox" id="consolidatedcargo" name="consolidated" class="border-checkbox" onclick="return false;" tabindex="-1"
                            {{old('consolidated') ? 'checked' : (!empty($mloblinformation->consolidated) ? 'checked' : null)}}
                            >
                            <label class="border-checkbox-label" for="consolidatedcargo">Consolidated Cargo</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 my-2">
                    <div class="border-checkbox-section">
                        <div class="border-checkbox-group border-checkbox-group-success">
                            <input type="checkbox" class="border-checkbox" id="qccontainer" name="qccontainer" tabindex="-1"
                            {{old('qccontainer') ? 'checked' : (!empty($mloblinformation->qccontainer) ? 'checked' : null)}}
                            >
                            <label class="border-checkbox-label" for="qccontainer">QC Container</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 my-2">
                    <div class="border-checkbox-section">
                        <div class="border-checkbox-group border-checkbox-group-danger">
                            <input type="checkbox" id="dgstatus" name="dg" class="border-checkbox" onclick="return false;" tabindex="-1"
                            {{old('dg') ? 'checked' : (!empty($mloblinformation->dg) ? 'checked' : null)}}
                            >
                            <label class="border-checkbox-label text-danger" for="dgstatus">DG Status</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 my-2 d-flex flex-row-reverse">
                    <button type="button" class="btn btn-success btn-sm addContainerBtn" tabindex="-1"><i class="fa fa-plus"></i></button>
                </div>
            </div> <!-- end row -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm fixed" id="containerTable">
                    <col width="50px" />
                    <col width="30px" />
                    <col width="25px" />
                    <col width="50px" />
                    <col width="30px" />
                    <col width="30px" />
                    <col width="35px" />
                    <col width="23px" />
                    <col width="23px" />
                    <col width="35px" />
                    <col width="60px" />
                    <col width="32px" />
                    <thead>
                        <tr>
                            <th>Container Ref</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Seal No</th>
                            <th>Pkgs No</th>
                            <th>Gross Wt</th>
                            <th>VGM</th>
                            <th>IMCO</th>
                            <th>UN</th>
                            <th>Ctn Loc</th>
                            <th>Commodity</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody id="tbody">
                    @if(old('addmore'))
                        @foreach(old('addmore') as $key => $addmore)
                            <tr>
                                <td><input type="text" name="addmore[{{$key}}][contref]" value="{{$addmore['contref'] ? $addmore['contref'] : null}}" class="form-control form-control-sm contrefno" onchange="checkFCLContainer(this)" pattern="*" maxlength="11" required/></td>
                                <td>
                                    <input type="text" name="addmore[{{$key}}][type]" value="{{$addmore['type'] ? $addmore['type'] : null}}" class="form-control form-control-sm " list="containerTypes" required/>
                                    <datalist id="containerTypes">
                                        @foreach ($containertypes as $containertype)
                                            <option value="{{ $containertype }}">{{ $containertype }}</option>
                                        @endforeach
                                    </datalist>
                                </td>
                                <td>
                                    <select name="addmore[{{$key}}][status]" class="form-control form-control-sm contStatus" required>
                                        <option value disabled selected>Container Status</option>
                                        <option value="PRT" {{(!empty($addmore['status']) && "PRT" == $addmore['status']) ? 'selected' : null}}>PRT</option>
                                        <option value="LCL" {{(!empty($addmore['status']) && "LCL" == $addmore['status']) ? 'selected' : null}}>LCL</option>
                                        <option value="FCL" {{(!empty($addmore['status']) && "FCL" == $addmore['status']) ? 'selected' : null}}>FCL</option>
                                        <option value="ETY" {{(!empty($addmore['status']) && "ETY" == $addmore['status']) ? 'selected' : null}}>ETY</option>
                                    </select>
                                </td>
                                <td><input type="text" name="addmore[{{$key}}][sealno]" value="{{$addmore['sealno']}}" class="form-control form-control-sm sealno"/></td>
                                <td><input type="number" name="addmore[{{$key}}][pkgno]" min="0" value="{{$addmore['pkgno']}}" class="form-control form-control-sm pkgno"/></td>
                                <td><input type="number" name="addmore[{{$key}}][grosswt]" min="0" step=".01" value="{{$addmore['grosswt']}}" class="form-control form-control-sm containerGrossWeight"/></td>
                                <td><input type="number" name="addmore[{{$key}}][verified_gross_mass]" min="0" step=".01" value="{{$addmore['verified_gross_mass']}}" class="form-control form-control-sm"/></td>
                                <td><input type="number" name="addmore[{{$key}}][imco]" min="0" step=".01" value="{{$addmore['imco']}}" class="form-control form-control-sm imco" /></td>
                                <td><input type="text" name="addmore[{{$key}}][un]" value="{{$addmore['un']}}" class="form-control form-control-sm un" maxlength="4"/></td>
                                <td>
                                    <input type="text" name="addmore[{{$key}}][location]" value="{{$addmore['location']}}" list="locationss" class="form-control form-control-sm"/>
                                    <datalist id="locationss">
                                        @foreach($offdocks as $offdock)
                                            <option value="{{ $offdock->code }}" >{{ $offdock->name }}</option>
                                        @endforeach
                                    </datalist>
                                </td>
                                <td>
                                    <select name="addmore[{{$key}}][commodity]" class="form-control form-control-sm commodity">
                                        @foreach($commoditys as $commodity)
                                            <option value="{{ $commodity->commoditycode }}" {{$commodity->commoditycode == $addmore['commodity'] ? 'selected' : null}}>
                                                {{ $commodity->commoditycode }} : {{ $commodity->commoditydescription }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm addContainerBtn"><i class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger remove-tr" tabindex="-1"><i class="fas fa-minus fa-1x"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @elseif(!empty($mloblinformation) && $mloblinformation->blcontainers->isNotEmpty())
                        @foreach($mloblinformation->blcontainers as $key => $container)
                            <tr>
                                <td><input type="text" name="addmore[{{ $key }}][contref]" class="form-control form-control-sm contrefno" value="{{ $container->contref }}" onchange="checkFCLContainer(this)" required pattern="*" maxlength="11" /></td>
                                <td>
                                    <input type="text" name="addmore[{{ $key }}][type]" value="{{ $container->type }}" class="form-control form-control-sm " list="containerTypes" required/>
                                    <datalist id="containerTypes">
                                        @foreach ($containertypes as $containertype)
                                            <option value="{{ $containertype }}">{{ $containertype }}</option>
                                        @endforeach
                                    </datalist>
                                </td>
                                <td>
                                    <select name="addmore[{{ $key }}][status]" class="form-control form-control-sm contStatus" required>
                                        <option value="PRT" {{ $container->status == "PRT" ? 'selected' : null}}>PRT</option>
                                        <option value="LCL" {{ $container->status == "LCL" ? 'selected' : null}}>LCL</option>
                                        <option value="FCL" {{ $container->status == "FCL" ? 'selected' : null}}>FCL</option>
                                        <option value="ETY" {{ $container->status == "ETY" ? 'selected' : null}}>ETY</option>
                                    </select>
                                </td>
                                <td><input type="text" name="addmore[{{ $key }}][sealno]" value="{{ $container->sealno }}" class="form-control form-control-sm sealno"/></td>
                                <td><input type="number" name="addmore[{{ $key }}][pkgno]" min="0" value="{{ $container->pkgno }}" class="form-control  form-control-sm pkgno" /></td>
                                <td><input type="number" name="addmore[{{ $key }}][grosswt]" min="0" step=".01" value="{{ $container->grosswt }}" class="form-control form-control-sm containerGrossWeight"/></td>

                                <td><input type="number" name="addmore[{{$key}}][verified_gross_mass]" min="0" step=".01" value="{{ $container->verified_gross_mass }}" class="form-control form-control-sm"/></td>

                                <td><input type="number" name="addmore[{{ $key }}][imco]" min="0" step=".01" value="{{ $container->imco }}" class="form-control form-control-sm imco" /></td>
                                <td><input type="text" name="addmore[{{ $key }}][un]" value="{{ $container->un }}" class="form-control form-control-sm un" maxlength="4" /></td>

                                <td><input type="text" name="addmore[{{ $key }}][location]" value="{{ $container->location }}" list="locations" class="form-control form-control-sm" />
                                    <datalist id="locations">
                                        @foreach($offdocks as $offdock)
                                            <option value="{{ $offdock->code }}">{{ $offdock->name }}</option>
                                        @endforeach
                                    </datalist>
                                </td>

                                <td>
                                    <select name="addmore[{{ $key }}][commodity]" class="form-control form-control-sm commodity">
                                        @foreach($commoditys as $commodity)
                                            <option value="{{ $commodity->commoditycode }}" {{($commodity->commoditycode == $container->commodity) ? "selected" : null}}>
                                                {{ $commodity->commoditycode }} : {{ $commodity->commoditydescription }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm addContainerBtn"><i class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger remove-tr" tabindex="-1"><i class="fas fa-minus fa-1x"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div> <!-- end addContainer -->

        <div class="row">
            <div class="offset-xl-5 col-xl-2 offset-md-4 col-md-4 mt-3">
                <div class="input-group input-group-sm ">
                    <button class="btn btn-success btn-round btn-block py-2" id="submit">Submit</button>
                </div>
            </div>
        </div> <!-- end row -->

    </form>
@endsection

@section('script')
    <script>
        var i = {!! json_encode(old('addmore') ? count(old('addmore')) : (!empty($housebl) ? $housebl->containers->count()-1 : 0)) !!};
        function addContainer(){
            $("#containerTable tbody").append(`
            <tr>
                <td><input type="text" name="addmore[${i}][contref]" class="form-control form-control-sm contrefno" required onchange="checkFCLContainer(this)" pattern="*" maxlength="11" /></td>
                <td>
                    <input type="text" name="addmore[${i}][type]" class="form-control form-control-sm " list="containerTypes" required/>
                    <datalist id="containerTypes">
                        @foreach ($containertypes as $containertype)
                            <option value="{{ $containertype }}">{{ $containertype }}</option>
                        @endforeach
                    </datalist>
                </td>
                <td>
                    <select name="addmore[${i}][status]" class="form-control form-control-sm contStatus" required>
                        <option value disabled selected>Container Status</option>
                        <option value="PRT">PRT</option>
                        <option value="LCL">LCL</option>
                        <option value="FCL">FCL</option>
                        <option value="ETY">ETY</option>
                    </select>
                </td>
                <td><input type="text" name="addmore[${i}][sealno]" class="form-control form-control-sm sealno"/></td>
                <td><input type="number" name="addmore[${i}][pkgno]"  class="form-control form-control-sm pkgno" min="0" /></td>
                <td><input type="number" name="addmore[${i}][grosswt]" class="form-control form-control-sm containerGrossWeight" min="0" step=".01"/></td>

                <td><input type="number" name="addmore[${i}][verified_gross_mass]" class="form-control form-control-sm" min="0" step=".01"/></td>

                <td><input type="number" name="addmore[${i}][imco]" step=".01" class="form-control form-control-sm imco" min="0"/></td>
                <td><input type="number" name="addmore[${i}][un]"  class="form-control form-control-sm un" maxlength="4" pattern="\d{4}"/></td>
                <td>
                    <input type="text" name="addmore[${i}][location]" class="form-control form-control-sm" list="locationss" />
                    <datalist id="locationss">
                        @foreach($offdocks as $offdock)
                            <option value="{{ $offdock->code }}">{{ $offdock->name }}</option>
                        @endforeach
                    </datalist>
                </td>
                <td>
                    <select name="addmore[${i}][commodity]" class="form-control form-control-sm commodity">
                    @foreach($commoditys as $commodity)
                        @foreach ($commoditys as $commodity)
                            <option value="{{ $commodity->commoditycode }}" {{$commodity->commoditycode == 35 ? "selected" : null}}>
                            {{ $commodity->commoditycode }} : {{ $commodity->commoditydescription }}
                            </option>
                        @endforeach
                    @endforeach
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm addContainerBtn"><i class="fa fa-plus"></i></button>
                    <button type="button" class="btn btn-sm btn-danger remove-tr" tabindex="-1"><i class="fas fa-minus fa-1x"></i></button>
                </td>
            </tr>
        `)}
        $(document).on('click', '.remove-tr', function(){
            $(this).parents('tr').remove();
        });
        $(document).on('click', '.addContainerBtn', function(){
            ++i;
            let totalRows = $("#containerTable tbody tr").length;
            if(totalRows > 0){
                var $tr    = $("#containerTable tbody tr:last").closest('tr');
                var $clone = $tr.clone().find('[name]').attr('name', function(idx, attrVal){
                    return attrVal.replace(/\d/g, i);
                }).end();
                $tr.after($clone);
            $(".contrefno").last().focus();
            }else{
            addContainer();
            }
        });


        $("#bolref").on('change', function () {
            let bolRef = $(this).val();
            let url ='{{url("loadBlInfoByBolRef")}}/'+bolRef;
            let containerTable = $("#containerTable tbody");
            fetch(url)
            .then((resp) => resp.json())
            .then(function(blInfo) {
                $("#principal_id").val(blInfo.principal_id);
                $("#principal").val(blInfo.principal.name);
                $("#exportername").val(blInfo.exportername);
                $("#exporteraddress").val(blInfo.exporteraddress);
                $("#depPortCode").val(blInfo.pOrigin);
                $("#pOriginName").val(blInfo.pOriginName);
                $("#desPortCode").val(blInfo.PUloding);
                $("#unloadingName").val(blInfo.unloadingName);
                $("#blnaturecode").val(blInfo.blnaturecode);
                $("#blnaturetype").val(blInfo.blnaturetype);
                $("#bltypecode").val(blInfo.bltypecode);
                $("#bltypename").val(blInfo.bltypename);
                $("#consignee_id").val(blInfo.bl_consignee.BIN);
                $("#consigneename").val(blInfo.bl_consignee.NAME);
                $("#consigneeaddress").val(blInfo.bl_consignee.ADD1);
                $("#notify_id").val(blInfo.bl_notify.BIN);
                $("#notifyname").val(blInfo.bl_notify.NAME);
                $("#notifyaddress").val(blInfo.bl_notify.ADD1);
                $("#shippingmark").val(blInfo.shippingmark);
                $("#package_id").val(blInfo.package_id);
                $("#nofpackage").val(blInfo.packageno);
                $("#packagecode").val(blInfo.package.packagecode);
                $("#packagename").val(blInfo.package.description);
                $("#mlocode").val(blInfo.mlocode);
                $("#mloname").val(blInfo.mloname);
                $("#mloaddress").val(blInfo.mloaddress);
                $("#hblgrossweight").val(blInfo.grosswt);
                $("#hblgrossweight").val(blInfo.verified_gross_mass);
                $("#measurement").val(blInfo.measurement);
                $("#noofcontainer").val(blInfo.containernumber);
                $("#remarks").val(blInfo.remarks);

                $("#freightstatus").val(blInfo.freightstatus);
                $("#freightvalue").val(blInfo.freightvalue);
                $("#coloader").val(blInfo.coloader);
                $("#description").val(blInfo.description);
                $("#notefordo").val(blInfo.note);

                blInfo.consolidated ? $("#consolidatedcargo").prop('checked', true) : $("#consolidatedcargo").prop('checked', false);
                blInfo.qccontainer ? $("#qccontainer").prop('checked', true) : $("#qccontainer").prop('checked', false);
//                blInfo.dg ? $("#dgstatus").prop('checked', true) : $("#dgstatus").prop('checked', false);

                countBolrefCharacter();
                countExporterNameCharacter();
                countConsigneeNameCharacter();
                countNotifyNameCharacter();
                countShippingMarkCharacter();
                countDescriptionCharacter();



                $(containerTable).empty();
                blInfo.blcontainers.forEach(function(container, key){
//                    (container.status == 'PRT' || container.status == 'LCL') ? $("#consolidatedcargo").prop('checked', true) : $("#consolidatedcargo").prop('checked', false);

                    $(containerTable).append(`
                    <tr>
                        <td><input type="text" name="addmore[${key}][contref]" value="${container.contref}" class="form-control form-control-sm contrefno" onchange="checkFCLContainer(this)" required /></td>
                        <td>
                            <input type="text" name="addmore[${key}][type]" value="${container.type}" class="form-control form-control-sm " list="containerTypes" required/>
                            <datalist id="containerTypes">
                            @foreach ($containertypes as $containertype)
                                <option value="{{ $containertype }}">{{ $containertype }}</option>
                            @endforeach
                            </datalist>
                        </td>
                        <td>
                            <select name="addmore[${key}][status]" class="form-control form-control-sm contStatus" required>
                                <option value disabled selected>Enter Container Status</option>
                                <option value="PRT" ${container.status == "PRT" ? 'selected' : null}>PRT</option>
                                <option value="LCL" ${container.status == "LCL" ? 'selected' : null}>LCL</option>
                                <option value="FCL" ${container.status == "FCL" ? 'selected' : null}>FCL</option>
                                <option value="ETY" ${container.status == "ETY" ? 'selected' : null}>ETY</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="addmore[${key}][sealno]" value="${container.sealno ?? ''}" class="form-control form-control-sm sealno"/>
                        </td>
                        <td>
                            <input type="text" name="addmore[${key}][pkgno]"  value="${container.pkgno ?? ''}" class="form-control form-control-sm pkgno"/>
                        </td>

                        <td>
                            <input type="number" name="addmore[${key}][grosswt]"  value="${container.grosswt ?? ''}" class="form-control form-control-sm containerGrossWeight" min="0" step=".01"/>
                        </td>


                        <td>
                            <input type="number" name="addmore[${key}][verified_gross_mass]"  value="${container.verified_gross_mass ?? ''}" class="form-control form-control-sm" min="0" step=".01"/>
                        </td>


                        <td>
                            <input type="text" name="addmore[${key}][imco]" step=".01" value="" class="form-control form-control-sm imco"/>
                        </td>
                        <td><input type="text" name="addmore[${key}][un]"  value="" class="form-control form-control-sm" maxlength="4"/></td>
                        <td>
                            <input type="text" name="addmore[${key}][location]" value="${container.location ?? '' }" class="form-control form-control-sm" list="locationss" />
                            <datalist id="locationss">
                                @foreach($offdocks as $offdock)
                                        <option value="{{ $offdock->code }}" >{{ $offdock->name }}</option>
                                @endforeach
                            </datalist>
                        </td>
                        <td>
                            <select name="addmore[${key}][commodity]" class="form-control form-control-sm commodity">
                            @foreach($commoditys as $commodity)
                                <option value="{{ $commodity->commoditycode }}" ${container.commodity == "{{$commodity->commoditycode}}" ? 'selected' : null}>
                                {{ $commodity->commoditycode }} : {{ $commodity->commoditydescription }}
                                </option>
                            @endforeach
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm addContainerBtn"><i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-sm btn-danger remove-tr" tabindex="-1"><i class="fas fa-minus fa-1x"></i></button>
                        </td>
                    </tr>
                    `);
                });//containers loop
            })
                    .catch(function () {
                    });
        });

        function loadExporterAddress() {
            let url ='{{url("/loadMLOExporterInfo/")}}/'+$('#exportername').val();
            fetch(url)
            .then((resp) => resp.json())
            .then(function(exporterInfo) {
                $('#exporteraddress').val(exporterInfo.exporteraddress);
            })
            .catch(function () {
                alert("No Data Found.");
                $('#exporteraddress').val(null).focus();
            });
        }//loadExporterAddress

        function loadDepPort(){
            var portCode = $("#depPortCode").val();
            let url ='{{url("loadPortData")}}/'+portCode;
            fetch(url)
            .then((resp) => resp.json())
            .then(function(portCode) {
                document.getElementById('pOriginName').value = portCode.depPortName;
            }).catch(function () {
                $("#pOriginName").val(null);
            });
        }
        function loadDesPort(){
            var portCode = $("#desPortCode").val();
            let url ='{{url("loadPortData")}}/'+portCode;
            fetch(url)
            .then((resp) => resp.json())
            .then(function(portCode) {
                document.getElementById('unloadingName').value = portCode.depPortName;
            }).catch(function () {
                $("#unloadingName").val(null);
            });
        }
        function loadConsigneeBin() {
            let url ='{{url("getBin")}}/'+$('#consignee_id').val();
            fetch(url)
                    .then((resp) => resp.json())
            .then(function(consigneebin) {
                document.getElementById('consigneename').value = consigneebin.binName;
                document.getElementById('consigneeaddress').value = consigneebin.binAddress;
            })
            .catch(function () {
                $('#consigneename, #consigneeaddress').val(null);
                if(newBinConfirmation){
                    $("#consigneename").removeAttr("onchange").focus();
                }else{
                    $("#consigneename").attr("onchange", 'loadConsigneeBinByName()').removeAttr("tabindex").focus();
                }
                $("#consigneeaddress").removeAttr("tabindex");
            });
        }//loadConsigneeBin


        function loadNotifyBin() {
            let url ='{{url("getBin")}}/'+$('#notify_id').val();
            fetch(url)
            .then((resp) => resp.json())
            .then(function(notifybin) {
                $('#notifyname').val(notifybin.binName);
                $('#notifyaddress').val(notifybin.binAddress);
            })
            .catch(function () {
                $('#notifyname, #notifyaddress').val(null);
                if(newBinConfirmation){
                    $("#notifyname").removeAttr("onchange").focus();
                }else{
                    $("#notifyname").attr("onchange", 'loadNotifyBinByName()').removeAttr("tabindex").focus();
                }
                $("#notifyaddress").removeAttr("tabindex");
            });
        } //loadNotifyBin

        function loadPackageName() {
            let url ='{{url("getPackageName")}}/'+document.getElementById('packagecode').value;
            fetch(url)
            .then((resp) => resp.json())
            .then(function(packagecode) {
                document.getElementById('package_id').value = packagecode.id;
                document.getElementById('packagename').value = packagecode.packagename;
            })
            .catch(function () {

            });
        } //loadPackageName

        function loadMloName () {
            let url ='{{url("getBLMloname")}}/'+document.getElementById('mlocode').value;
            fetch(url) //Call the fetch function passing the url of the API  as a parameter
            .then((resp) => resp.json())
            .then(function(mlocode) {
                document.getElementById('mloname').value = mlocode.mloname;
                document.getElementById('mloaddress').value = mlocode.mloaddress;
            })
            .catch(function () {
                $("#mloname, #mloaddress").val(null);
            });
        } //loadMloName

        if (document.getElementById('blnaturecode').value==23){
            document.getElementById('blnaturetype').value='Import';
        }
        if (document.getElementById('bltypecode').value=='HSB'){
            document.getElementById('bltypename').value='House Sea Bill';
        }
        function getblnaturetype() {
            if (document.getElementById('blnaturecode').value==22){
                document.getElementById('blnaturetype').value='Export';
            }
            else if (document.getElementById('blnaturecode').value==23){
                document.getElementById('blnaturetype').value='Import';
            }
            else if (document.getElementById('blnaturecode').value==24){
                document.getElementById('blnaturetype').value='Transit';
            }
            else if (document.getElementById('blnaturecode').value==28){
                document.getElementById('blnaturetype').value='Transhipment';
            }
        }
        function getbltypename() {
            if (document.getElementById('bltypecode').value=='MSB'){
                document.getElementById('bltypename').value='Master Sea Bill';
            }
            else if (document.getElementById('bltypecode').value=='AWB'){
                document.getElementById('bltypename').value='Air Way Bill';
            }
            else  if (document.getElementById('bltypecode').value=='MAB'){
                document.getElementById('bltypename').value='Master AirwayBill';
            }
            else if (document.getElementById('bltypecode').value=='HSB'){
                document.getElementById('bltypename').value='House Sea Bill';
            }
        }

        function checkFCLContainer(e){
            let currentStatus= $(e).closest('tr').find('.contStatus');
            let contref= $(e).closest('tr').find('.contrefno').val();
            let feeder_id = $("#feederinformations_id").val();

            if(feeder_id){
                if(currentStatus.val()){
                    let url = "{{url('checkMLOFCLContainer')}}/"+feeder_id+'/'+contref;
                    fetch(url)
                    .then((resp) => resp.json())
                    .then(function(housebl) {
                        if(housebl){
                            alert("This Container Uploaded before with FCL Status. \n IGM: "+housebl.feederinformations_id+" \n HBL: "+housebl.bolreference);
//                            $(currentStatus).val(null);
                        }
                    }).catch(function(){

                    });
                }
            }else{
                alert("Please Insert IGM First.");
            }
        }

        function getLocation() {
            $(document).ready(function () {
                if ($('#pucode').val() === 'BDKAM') {
                    $('#contloc').val('102DICD');
                }
                else if ($('#pucode').val() === 'BDPNG'){
                    $('#contloc').val('752NPNG');
                }
                else {
                    $('#contloc').val(null);
                }
            });
        }//Set Container Location Based on House Uploading Location

        function countBolrefCharacter(){
            let currentNode = $("#bolref");
            currentNode.siblings('.characterLimit').html(currentNode.val().length +' / '+ currentNode.attr('maxlength'));
        }
        function countExporterNameCharacter(){
            let currentNode = $("#exportername");
            currentNode.siblings('.characterLimit').html(currentNode.val().length +' / '+ currentNode.attr('maxlength'));
        }
        function countConsigneeNameCharacter(){
            let currentNode = $("#consigneename");
            currentNode.siblings('.characterLimit').html(currentNode.val().length +' / '+ currentNode.attr('maxlength'));
        }
        function countNotifyNameCharacter(){
            let currentNode = $("#notifyname");
            currentNode.siblings('.characterLimit').html(currentNode.val().length +' / '+ currentNode.attr('maxlength'));
        }
        function countShippingMarkCharacter(){
            let currentNode = $("#shippingmark");
            currentNode.siblings('.characterLimit').html(currentNode.val().length +' / '+ currentNode.attr('maxlength'));
        }
        function countDescriptionCharacter(){
            let currentNode = $("#description");
            currentNode.siblings('.characterLimit').html(currentNode.val().length +' / '+ currentNode.attr('maxlength'));
        }


        //dg status checked unchecked
        function dgStatus(){
            if($(".imco").filter(function() {
                return $(this).val();
            }).length > 0) {
                $("#dgstatus").prop('checked', true)
            }else{
                $("#dgstatus").prop('checked', false)
            }
        };



        window.onload = function() {
            countBolrefCharacter();
            countExporterNameCharacter();
            countConsigneeNameCharacter();
            countNotifyNameCharacter();
            countShippingMarkCharacter();
            countDescriptionCharacter();
        };

        function getPrincipalDataByName() {
            let principalName = $('#principal').val();
            let url ='{{url("getPrincipalDataByName")}}/'+principalName;
            fetch(url)
                    .then((resp) => resp.json())
        .then(function(principal) {
                $('#principal_id').val(principal.id);
                $('#principalCode').val(principal.code).attr('readonly', true);
            })
            .catch(function () {
                $("#principal_id").val(null);
                $('#principalCode').val(principal.code).attr('readonly', false);
            });
        }

        function checkDuplicateContainers() {
            var duplicateContainer = false;
            $(".contrefno").each(function(){
                var currentValue = $(this).val();
                duplicateContainer =
                        $('.contrefno').not(this).filter(function(){
                            return $(this).val() === currentValue;
                        }).length > 0;
                if(duplicateContainer) return false;
            });
            return duplicateContainer;
        }
    </script>


    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(document).ready(function () {
//            $('#departureDate').datepicker({format: "dd/mm/yyyy",autoclose: true,todayHighlight: true});

            @if($formType == 'create' && !old('addmore'))
                addContainer();
            @endif

            @if(old("line"))
                $("#lineno").select();
            @endif

            $("#depPortCode").on('keyup blur change', function(){
                loadDepPort();
            });
            $("#desPortCode").on('keyup blur change', function(){
                loadDesPort();
            });

            $('#noofcontainer').blur(function (e) {
                let totalContainer = $(this).val();
                if(totalContainer == 1){
                    let firstRow = $("#containerTable > tbody").children('tr:first');
                    firstRow.find(".containerGrossWeight").val($('#hblgrossweight').val());
                    firstRow.find(".pkgno").val($('#nofpackage').val());
                }
            }); // copy housebl grossWight and  package if container 1

            $("#principal").on('keyup blur change', function(){
                getPrincipalDataByName();
            });

            $("#consigneename").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('binDataByNameAutoComplete')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                select: function (event, ui) {
                    $('#consigneename').val(ui.item.name); // display the selected text
                    $('#consignee_id').val(ui.item.bin); // display the selected text
                    $('#consigneeaddress').val(ui.item.address); // display the selected text
                    return false;
                }
            }).keyup(function () {
                countConsigneeNameCharacter();
            });

            $("#notifyname").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('binDataByNameAutoComplete')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                select: function (event, ui) {
                    $('#notifyname').val(ui.item.name); // display the selected text
                    $('#notify_id').val(ui.item.bin); // display the selected text
                    $('#notifyaddress').val(ui.item.address); // display the selected text
                    return false;
                }
            }).keyup(function () {
                countNotifyNameCharacter();
            });

            $(document).on('change','.contStatus',function(){
                let currentStatus = $(this);
                let contref= $(this).closest('tr').find('.contrefno').val();

                let feeder_id = $("#feederinformations_id").val();

                let contStatus = $(".contStatus");
                let allStatus = [];
                contStatus.each(function(key){
                    allStatus.push($(this).val());
                });
                if($.inArray("PRT", allStatus) !== -1 || $.inArray("LCL", allStatus) !== -1){
                    $('#consolidatedcargo').prop('checked', true);
                }else{
                    $('#consolidatedcargo').prop('checked', false);
                }
                checkFCLContainer(this);
            });

            $( "#pOriginName" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('loadPortDataAutoComplete')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                select: function (event, ui) {
                    // Set selection
                    $('#pOriginName').val(ui.item.label); // display the selected text
                    $('#depPortCode').val(ui.item.value); // save selected id to input
                    return false;
                }
            });
            $( "#unloadingName" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('loadPortDataAutoComplete')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                select: function (event, ui) {
                    // Set selection
                    $('#unloadingName').val(ui.item.label); // display the selected text
                    $('#desPortCode').val(ui.item.value); // save selected id to input
                    return false;
                }
            });

            $("#cloneNotifyBtn").on('click', function(){
                if($(this).prop("checked") == true){
                    $("#notify_id").val($("#consignee_id").val());
                    $("#notifyname").val($("#consigneename").val());
                    $("#notifyaddress").val($("#consigneeaddress").val());
                    countNotifyNameCharacter();
                }else{
                    $("#notify_id, #notifyname, #notifyaddress").val(null);
                }
            }); // clone consignee data for notify

            $(document).on('keypress', '.sealno, .contrefno', function(e){
                var regex = new RegExp("^[a-zA-Z0-9]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    return true;
                }
                e.preventDefault();
                return false;
            }); // Stop special character

            $('#shippingmark').keyup(function(){
                countShippingMarkCharacter();
            }).focus(function(){
                this.select();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(this).offset().top-50
                }, 1000);
            });
            $('#description').keyup(function () {
                countDescriptionCharacter();
            });

            $('#bolref').keyup(function(){
                countBolrefCharacter()
            });
            $('#exportername').keyup(function(){
                countExporterNameCharacter()
            });


            //check imco and set DG Status Checked
            $(document).on('change','.imco', function(){
                dgStatus();
            });

            $("#mainForm").on('submit', function(){
                if(!$("#file").val()){
                    return validateHblForm();
                }
            });


        });//document.ready


        function validateHblForm() {
            var totalContainers = $("#noofcontainer").val();
            var containerRows = $("#containerTable tbody tr").length;
            var totalPackages = $("#nofpackage").val();
            var containerPackages = 0;

            if(totalContainers != containerRows){
                alert('Total Number of Containers Mismatching!');
                return false;
            }

            $('.pkgno').each(function(){
                containerPackages +=parseFloat($(this).val());
            });
            if ( totalPackages != containerPackages){
                alert('Total Number of Packages Mismatch!');
                return false;
            }


            var totalGrossWight = parseFloat($("#hblgrossweight").val()).toFixed(2);
            var containerGrossWeight = 0;

            $(".containerGrossWeight").each(function(){
                containerGrossWeight += parseFloat($(this).val());
            });

            if ( totalGrossWight != containerGrossWeight.toFixed(2)){
                alert('Total Gross Weight Mismatching! \nGross Weight= '+totalGrossWight+'\n Containers Weight = '+containerGrossWeight);
                return false;
            }
        }// check total container, total packages & total Gross Weight with BL and Containers info

        $(document).ready(function () {
            $('#uploadBtn').click(function () {
                if(confirm("By pressing OK Button all container data will be erased which created manually!")){
                    $('#addContainer').hide();
                    $('#fileUploadArea').show();
                    $("#addContainerBtn").removeClass("btn-warning").addClass("btn-outline-warning");
                    $(this).removeClass("btn-outline-warning").addClass("btn-warning");
                    $("#containerTable tbody").empty();
                }
            });

            $('#addContainerBtn').click(function () {
                $('#fileUploadArea').hide();
                $('#addContainer').show();
                $("#uploadBtn").removeClass("btn-warning").addClass("btn-outline-warning");
                $(this).removeClass("btn-outline-warning").addClass("btn-warning");
            });

            $("#mainForm").submit(function (event) {
                if(checkDuplicateContainers()){
                    alert("Duplicate Container Found.");
                    return false;
                }else{
                    return true;
                }
            });

        });
    </script>



@endsection
