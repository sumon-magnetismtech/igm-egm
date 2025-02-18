@extends('layouts.new-layout')
@section('title', 'FRD House BL')

@section('style')
    <style>
        #fileUploadArea {
            display: none;
        }

        table.fixed {
            table-layout: fixed;
        }

        table.fixed td {
            overflow: hidden;
        }

    </style>
@endsection
@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit House BL
    @else
        Add House BL
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('housebls') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    @if ($formType == 'edit')
        <form action="{{ route('housebls.update', $housebl->id) }}" method="post" id="mainForm" name="mainForm"
            class="custom-form" enctype="multipart/form-data">
            @method('PUT')
            <input type="hidden" name="id" value="{{ $housebl->id }}">
        @else
            <form action="{{ route('housebls.store') }}" method="post" id="mainForm" class="custom-form"
                enctype="multipart/form-data">
    @endif
    @csrf
    <div class="row d-flex align-items-end px-1">
        <div class="col-xl-2 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> IGM </span>
                <input type="text" id="igmno" name="igm" class="form-control"
                    value="{{ old('igm') ? old('igm') : (!empty($housebl) ? $housebl->igm : null) }}" onchange="loadIgm()"
                    required {{ old('igm') ? '' : 'autofocus' }} autocomplete="off">
            </div>
        </div>
        <div class="col-xl-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Master BL </span>
                <input type="text" id="mblno" name="mblno" class="form-control"
                    value="{{ old('mblno') ? old('mblno') : (!empty($housebl) ? $housebl->masterbl->mblno : null) }}"
                    onchange="loadIgmByMbl()" tabindex="-1" required>
            </div>
        </div>
        <div class="col-xl-5 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Vessel Name</span>
                <input type="text" id="fvessel" name="vesselname" class="form-control"
                    value="{{ old('vesselname') ? old('vesselname') : (!empty($housebl) ? $housebl->masterbl->fvessel : null) }}"
                    tabindex="-1" required readonly>
            </div>
        </div>
        <div class="col-xl-2 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon">Voyage </span>
                <input type="text" id="voyage" name="voyage" class="form-control"
                    value="{{ old('voyage') ? old('voyage') : (!empty($housebl) ? $housebl->masterbl->voyage : null) }}"
                    required readonly tabindex="-1">
            </div>
        </div>
        <div class="col-xl-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Rotation </span>
                <input type="text" id="rotno" name="rotation" class="form-control"
                    value="{{ old('rotation') ? old('rotation') : (!empty($housebl) ? $housebl->masterbl->rotno : null) }}"
                    tabindex="-1" readonly>
            </div>
        </div>
        <div class="col-xl-2 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Unloading Port </span>
                <input type="text" id="pucode" name="punloading" class="form-control"
                    value="{{ old('punloading') ? old('punloading') : (!empty($housebl) ? $housebl->masterbl->pucode : null) }}"
                    required tabindex="-1" readonly>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Departure Date </span>
                <input type="text" id="departure" name="departure" class="form-control"
                    value="{{ old('departure')? old('departure'): (!empty($housebl)? ($housebl->masterbl->departure? date('d-m-Y', strtotime($housebl->masterbl->departure)): null): null) }}"
                    required autocomplete="off" tabindex="-1" readonly>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Arrival Date </span>
                <input type="text" id="arrival" name="arrival" class="form-control"
                    value="{{ old('arrival')? old('arrival'): (!empty($housebl)? ($housebl->masterbl->arrival? date('d-m-Y', strtotime($housebl->masterbl->arrival)): null): null) }}"
                    required autocomplete="off" tabindex="-1" readonly>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Berthing Date </span>
                <input type="text" id="berthing" name="berthing" class="form-control"
                    value="{{ old('berthing')? old('berthing'): (!empty($housebl)? ($housebl->masterbl->berthing? date('d-m-Y', strtotime($housebl->masterbl->berthing)): null): null) }}"
                    required autocomplete="off" tabindex="-1" readonly>
            </div>
        </div>
        <div class="col-xl-1 col-md-6 px-1">
            <div class="border-checkbox-section">
                <div class="border-checkbox-group border-checkbox-group-primary">
                    <input type="checkbox" id="noc" name="noc" class="border-checkbox"
                        @if (old('noc') || (!empty($housebl) && $housebl->masterbl->noc)) checked @endif tabindex="-1" readonly onclick="return false; ">
                    <label class="border-checkbox-label" for="noc">NOC</label>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Nature </span>
                <input type="text" id="blnaturecode" name="nature" class="form-control"
                    value="{{ old('nature') ? old('nature') : (!empty($housebl) ? $housebl->masterbl->blnaturecode : null) }}"
                    required tabindex="-1" readonly>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Custom Code </span>
                <input type="text" id="customoffice" name="cofficecode" class="form-control"
                    value="{{ old('cofficecode') ? old('cofficecode') : (!empty($housebl) ? $housebl->masterbl->cofficecode : null) }}"
                    required tabindex="-1" readonly>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Gross Weight </span>
                <input type="text" id="igmGrossWeight" name="igmGrossWeight" class="form-control text-danger"
                    value="{{ old('igmGrossWeight') ? old('igmGrossWeight') : (!empty($totalGrossWeight) ? $totalGrossWeight : null) }}"
                    readonly tabindex="-1">
            </div>
        </div>
        <div class="col-xl-2 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon">Total Package</span>
                <input type="text" id="igmTotalPackage" name="igmTotalPackage" class="form-control text-danger"
                    value="{{ old('igmTotalPackage') ? old('igmTotalPackage') : (!empty($totalPackage) ? $totalPackage : null) }}"
                    readonly tabindex="-1">
            </div>
        </div>
        <div class="col-xl-2 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Total Line </span>
                <input type="text" id="igmTotalLine" name="igmTotalLine" class="form-control text-danger"
                    value="{{ old('igmTotalLine') ? old('igmTotalLine') : (!empty($totalLine) ? $totalLine : null) }}"
                    readonly tabindex="-1">
            </div>
        </div>
    </div> <!-- end row  -->
    <hr class="my-2 bg-success">

    <div class="row d-flex align-items-end px-1">
        <div class="col-xl-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Line <span class="text-danger">*</span> </span>
                <input type="text" id="lineno" name="line" class="form-control"
                    value="{{ old('line') ? old('line') : (!empty($housebl) ? $housebl->line : null) }}"
                    onblur="getLocation()" autocomplete="off" required autofocus>
            </div>
        </div>
        <div class="col-xl-6 offset-xl-3 col-md-6 px-1">
            <div class="input-group input-group-sm pt-3">
                <span class="input-group-addon"> BOL Reference <span class="text-danger">*</span> </span>
                <label class="badge badge-danger characterLimit"></label>
                <input type="text" id="bolref" name="bolreference" class="form-control " maxlength="17"
                    value="{{ old('bolreference') ? old('bolreference') : (!empty($housebl) ? $housebl->bolreference : null) }}"
                    autocomplete="off" required>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 px-1">
            <div class="input-group input-group-sm pt-3">
                <span class="input-group-addon"> Exporter Name <span class="text-danger">*</span> </span>
                <label class="badge badge-danger characterLimit"></label>
                <input type="text" id="exportername" name="exportername" class="form-control" list="exporterInfos"
                    maxlength="35" onchange="loadExporterAddress()"
                    value="{{ old('exportername') ? old('exportername') : (!empty($housebl) ? $housebl->exportername : null) }}"
                    autocomplete="off" required>
                <datalist id="exporterInfos">
                    @foreach ($exporterInfos as $exporterInfo)
                        <option value="{{ $exporterInfo }}"></option>
                    @endforeach
                </datalist>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 px-1">
            <div class="input-group input-group-sm pt-3">
                <span class="input-group-addon"> Exporter Address <span class="text-danger">*</span> </span>
                <input type="text" id="exporteraddress" name="exporteraddress" class="form-control"
                    value="{{ old('exporteraddress') ? old('exporteraddress') : (!empty($housebl) ? $housebl->exporteraddress : null) }}"
                    required>
            </div>
        </div>

        <div class="col-md-6 px-1">
            <div class="input-group input-group-sm xl-mr-5">
                <span class="input-group-addon">Consig. BIN <span class="text-danger">*</span> </span>
                <input type="hidden" id="consignee_status" value="0" name="consignee_status">
                <input type="text" list="consigneeBins" class="form-control mr-xl-5" id="consigneebin" name="consigneebin"
                    onchange="loadConsigneeBin()"
                    value="{{ old('consigneebin') ? old('consigneebin') : (!empty($housebl) ? $housebl->consigneebin : null) }}"
                    autocomplete="off" required>
                <datalist id="consigneeBins">
                    @foreach ($vatRegBins as $key => $vatRegBin)
                        <option value="{{ $vatRegBin }}">{{ $key }}</option>
                    @endforeach
                </datalist>
            </div>
            <div class="input-group input-group-sm pt-3">
                <span class="input-group-addon"> Consig. Name <span class="text-danger">*</span> </span>
                <label class="badge badge-danger characterLimit"></label>
                <input type="text" id="consigneename" maxlength="35" name="consigneename" class="form-control "
                    value="{{ old('consigneename') ? old('consigneename') : (!empty($housebl) ? $housebl->consigneename : null) }}"
                    tabindex="-1" autocomplete="off" required>
            </div>
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Consig. Address <span class="text-danger">*</span> </span>
                <textarea class="form-control md-textarea" id="consigneeaddress" rows="2" name="consigneeaddress" required
                    tabindex="-1">{{ old('consigneeaddress') ? old('consigneeaddress') : (!empty($housebl) ? $housebl->consigneeaddress : null) }}</textarea>
            </div>
        </div>

        <div class="col-md-6 px-1">
            <div class="d-flex align-items-center mb-1">
                <input type="checkbox" id="cloneNotifyBtn" class="checkbox" name="cloneNotifyBtn"
                    value="cloneNotifyBtn">
                <label for="cloneNotifyBtn" style="margin: 0 0 0 5px"> Same Consignee & Notify</label>
            </div>

            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Notify BIN <span class="text-danger">*</span> </span>
                <input type="hidden" id="notify_status" value="0" name="notify_status">
                <input type="text" list="notifyBins" class="form-control mr-xl-5" id="notifybin" name="notifybin"
                    onchange="loadNotifyBin()"
                    value="{{ old('notifybin') ? old('notifybin') : (!empty($housebl) ? $housebl->notifybin : null) }}"
                    autocomplete="off" required>
                <datalist id="notifyBins">
                    @foreach ($vatRegBins as $key => $vatRegBin)
                        <option value="{{ $vatRegBin }}">{{ $key }}</option>
                    @endforeach
                </datalist>
            </div>
            <div class="input-group input-group-sm pt-3">
                <span class="input-group-addon">Notify Name <span class="text-danger">*</span> </span>
                <label class="badge badge-danger characterLimit"></label>
                <input type="text" class="form-control " id="notifyname" maxlength="35" name="notifyname"
                    value="{{ old('notifyname') ? old('notifyname') : (!empty($housebl) ? $housebl->notifyname : null) }}"
                    autocomplete="off" required tabindex="-1">
            </div>
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Notify Address <span class="text-danger">*</span> </span>
                <textarea id="notifyaddress" name="notifyaddress" class="form-control" rows="2" required
                    tabindex="-1">{{ old('notifyaddress') ? old('notifyaddress') : (!empty($housebl) ? $housebl->notifyaddress : null) }}</textarea>
            </div>
        </div>

        <div class="col-md-12 px-1">
            <div class="input-group input-group-sm pt-3">
                <span class="input-group-addon"> Shipping Mark <span class="text-danger">*</span></span>
                <label class="badge badge-danger characterLimit"></label>
                <textarea id="shippingmark" name="shippingmark" class="form-control " rows="2" maxlength="512" required
                    @if ($formType == 'create') onfocus="this.select()" @endif>{{ old('shippingmark') ? old('shippingmark') : (!empty($housebl) ? $housebl->shippingmark : null) }}</textarea>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Total Package <span class="text-danger">*</span></span>
                <input type="number" class="form-control" id="nofpackage" name="packageno" min="0" step="1"
                    pattern="[0-9]" onkeypress="return !(event.charCode == 46)"
                    value="{{ old('packageno') ? old('packageno') : (!empty($housebl) ? $housebl->packageno : null) }}"
                    autocomplete="off" required>
            </div>
        </div>
        <div class="col-xl-4 offset-xl-1 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Package Code <span class="text-danger">*</span> </span>
                <input type="text" id="packagecode" name="packagecode" class="form-control " list="packagecodeList"
                    onchange="loadPackageName()"
                    value="{{ old('packagecode') ? old('packagecode') : (!empty($housebl) ? $housebl->packagecode : null) }}"
                    required>
                <datalist id="packagecodeList">
                    @foreach ($packagecodes as $key => $packagecode)
                        <option value="{{ $key }}">{{ $packagecode }} </option>
                    @endforeach
                </datalist>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon">Package Name <span class="text-danger">*</span> </span>
                <input type="text" id="packagename" name="packagetype" class="form-control"
                    value="{{ old('packagetype') ? old('packagetype') : (!empty($housebl) ? $housebl->packagetype : null) }}"
                    required tabindex="-1">
            </div>
        </div>

        <div class="col-md-12 px-1">
            <div class="input-group input-group-sm pt-3">
                <span class="input-group-addon">Description <span class="text-danger">*</span></span>
                <label class="badge badge-danger characterLimit"></label>
                <textarea type="text" id="description" name="description" class="form-control " rows="2" required
                    maxlength="512">{{ old('description') ? old('description') : (!empty($housebl) ? $housebl->description : null) }}</textarea>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Gross Weight <span class="text-danger">*</span> </span>
                <input type="text" id="hblgrossweight" name="grosswt" class="form-control"
                    value="{{ old('grosswt') ? old('grosswt') : (!empty($housebl) ? $housebl->grosswt : null) }}"
                    required autocomplete="off">
            </div>
        </div>
        <div class="col-xl-3 offset-xl-2 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Measurement <span class="text-danger">*</span> </span>
                <input type="number" id="measurement" name="measurement" min="0" step="0.01" class="form-control"
                    value="{{ old('measurement') ? old('measurement') : (!empty($housebl) ? $housebl->measurement : null) }}"
                    required autocomplete="off">
            </div>
        </div>
        <div class="col-xl-3 offset-xl-1 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Total Container <span class="text-danger">*</span> </span>
                <input type="text" id="noofcontainer" name="containernumber" class="form-control"
                    value="{{ old('containernumber') ? old('containernumber') : (!empty($housebl) ? $housebl->containernumber : null) }}"
                    required autocomplete="off">
            </div>
        </div>
        <div class="col-xl-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Remarks </span>
                <input type="text" id="remarks" name="remarks" class="form-control"
                    value="{{ old('remarks') ? old('remarks') : (!empty($housebl) ? $housebl->remarks : null) }}"
                    tabindex="-1">
            </div>
        </div>

        <div class="col-xl-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Freight Status</span>
                <input type="text" id="freightstatus" name="freightstatus" class="form-control"
                    value="{{ old('freightstatus') ? old('freightstatus') : (!empty($housebl) ? $housebl->freightstatus : null) }}"
                    tabindex="-1">
            </div>
        </div>
        <div class="col-xl-3 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon">Freight Value</span>
                <input type="text" id="freightvalue" name="freightvalue" class="form-control"
                    value="{{ old('freightvalue') ? old('freightvalue') : (!empty($housebl) ? $housebl->freightvalue : null) }}"
                    tabindex="-1">
            </div>
        </div>
        <div class="col-xl-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon"> Co-Loader </span>
                <input type="text" id="coloader" name="coloader" class="form-control"
                    value="{{ old('coloader') ? old('coloader') : (!empty($housebl) ? $housebl->coloader : null) }}"
                    tabindex="-1">
            </div>
        </div>

        <div class="col-xl-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon" style="background-color:#314b44!important;"> DO Note </span>
                <textarea id="notefordo" name="note" class="form-control bg-light text-danger font-weight-bold"
                    tabindex="-1">{{ old('note') ? old('note') : (!empty($housebl) ? $housebl->note : null) }}</textarea>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 px-1">
            <div class="input-group input-group-sm">
                <span class="input-group-addon" style="background-color: #3D9CDD!important;"> BL Note </span>
                <textarea class="form-control bg-light text-danger font-weight-bold" id="blNote" name="blNote"
                    tabindex="-1">{{ old('blNote') ? old('blNote') : (!empty($housebl) ? $housebl->blNote : null) }}</textarea>
            </div>
        </div>
    </div> <!-- end row -->
    <hr class="my-2 bg-success">

    <div class="row d-flex align-items-end px-1">
        <div class="col-md-6 px-1 my-1">
            <button type="button" class="btn btn-outline-warning btn-block" id="uploadBtn" tabindex="-1">Upload a
                file</button>
        </div>
        <div class="col-md-6 px-1 my-1">
            <button type="button" class="btn btn-warning btn-block" id="addContainerBtn" tabindex="-1"> Add/Hide Container
            </button>
        </div>
    </div> <!-- end row -->

    <div class="row" id="fileUploadArea">
        <div class="card m-2 py-0 border border-secondary rounded">
            <div class="card-block">
                <div class="sub-title text-right"><a href="{{ asset('containerformat.xlsx') }}"
                        class="text-danger font-weight-bold"> <i class="fa fa-download"></i> Download Container XL Format
                    </a></div>
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
                        @if (!empty($housebl->consolidated))
                            <input type="checkbox" id="consolidatedcargo" name="consolidated" class="border-checkbox"
                                value="{{ $housebl->consolidated }}" onclick="return false;" checked tabindex="-1">
                        @else
                            <input type="checkbox" id="consolidatedcargo" name="consolidated" class="border-checkbox"
                                value="1" tabindex="-1">
                        @endif
                        <label class="border-checkbox-label" for="consolidatedcargo">Consolidated Cargo</label>
                    </div>
                </div>
            </div>
            <div class="col-md-3 my-2">
                <div class="border-checkbox-section">
                    <div class="border-checkbox-group border-checkbox-group-success">
                        @if (!empty($housebl->qccontainer))
                            <input type="checkbox" class="border-checkbox" id="qccontainer" name="qccontainer"
                                value="{{ $housebl->qccontainer }}" checked tabindex="-1">
                        @else
                            <input type="checkbox" class="border-checkbox" id="qccontainer" name="qccontainer" value="QC"
                                tabindex="-1">
                        @endif
                        <label class="border-checkbox-label" for="qccontainer">QC Container</label>
                    </div>
                </div>
            </div>
            <div class="col-md-3 my-2">
                <div class="border-checkbox-section">
                    <div class="border-checkbox-group border-checkbox-group-danger">
                        <input type="checkbox" class="border-checkbox" id="dgstatus" name="dg"
                            {{ (old('dg') ? 'checked' : !empty($housebl->dg)) ? 'checked' : null }} onclick="return false;"
                            tabindex="-1">
                        <label class="border-checkbox-label text-danger" for="dgstatus">DG Status</label>
                    </div>
                </div>
            </div>
            <div class="col-md-3 my-2 d-flex flex-row-reverse">
                <button type="button" class="btn btn-success btn-sm addContainerBtn" tabindex="-1"><i
                        class="fa fa-plus"></i></button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm fixed" id="containerTable">
                <col width="50px" />
                <col width="30px" />
                <col width="25px" />
                <col width="50px" />
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
                        <th>IMCO</th>
                        <th>UN</th>
                        <th>Ctn Loc</th>
                        <th>Commodity</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="tbody">
                    @if (old('addmore'))
                        @foreach (old('addmore') as $key => $addmore)
                            <tr>
                                <td><input type="text" name="addmore[{{ $key }}][contref]"
                                        value="{{ $addmore['contref'] ? $addmore['contref'] : null }}"
                                        class="form-control form-control-sm contrefno" onchange="checkFCLContainer(this)"
                                        required pattern="*" max="11" /></td>
                                <td>
                                    <input type="text" name="addmore[{{ $key }}][type]"
                                        value="{{ $addmore['type'] ? $addmore['type'] : null }}"
                                        class="form-control form-control-sm type" list="containerTypes" required />
                                    <datalist id="containerTypes">
                                        @foreach ($containertypes as $containertype)
                                            <option value="{{ $containertype }}">{{ $containertype }}</option>
                                        @endforeach
                                    </datalist>
                                </td>
                                <td>
                                    <select name="addmore[{{ $key }}][status]"
                                        class="form-control form-control-sm contStatus" required>
                                        <option value disabled selected></option>
                                        <option value="PRT"
                                            {{ !empty($addmore['status']) && 'PRT' == $addmore['status'] ? 'selected' : null }}>
                                            PRT</option>
                                        <option value="LCL"
                                            {{ !empty($addmore['status']) && 'LCL' == $addmore['status'] ? 'selected' : null }}>
                                            LCL</option>
                                        <option value="FCL"
                                            {{ !empty($addmore['status']) && 'FCL' == $addmore['status'] ? 'selected' : null }}>
                                            FCL</option>
                                        <option value="ETY"
                                            {{ !empty($addmore['status']) && 'ETY' == $addmore['status'] ? 'selected' : null }}>
                                            ETY</option>
                                    </select>
                                </td>
                                <td><input type="text" name="addmore[{{ $key }}][sealno]"
                                        value="{{ $addmore['sealno'] }}" class="form-control form-control-sm sealno" />
                                </td>
                                <td><input type="text" name="addmore[{{ $key }}][pkgno]"
                                        value="{{ $addmore['pkgno'] }}" class="form-control form-control-sm pkgno" /></td>
                                <td><input type="text" name="addmore[{{ $key }}][grosswt]"
                                        value="{{ $addmore['grosswt'] }}"
                                        class="form-control form-control-sm containerGrossWeight" /></td>
                                <td><input type="text" name="addmore[{{ $key }}][imco]" value=""
                                        class="form-control form-control-sm imco" /></td>
                                <td><input type="text" name="addmore[{{ $key }}][un]" value=""
                                        class="form-control form-control-sm" maxlength="4" /></td>
                                <td><input type="text" name="addmore[{{ $key }}][location]"
                                        value="{{ $addmore['location'] }}" list="locationss"
                                        class="form-control form-control-sm location" />
                                    <datalist id="locationss">
                                        @foreach ($offdocks as $offdock)
                                            <option value="{{ $offdock->code }}">{{ $offdock->name }}</option>
                                        @endforeach
                                    </datalist>
                                </td>
                                <td>
                                    <select name="addmore[{{ $key }}][commodity]"
                                        class="form-control form-control-sm commodity">
                                        @foreach ($commoditys as $commodity)
                                            <option value="{{ $commodity->commoditycode }}"
                                                {{ $commodity->commoditycode == $addmore['commodity'] ? 'selected' : null }}>
                                                {{ $commodity->commoditycode }} :
                                                {{ $commodity->commoditydescription }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm addContainerBtn"><i
                                            class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger remove-tr" tabindex="-1"><i
                                            class="fas fa-minus fa-1x"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @elseif(!empty($housebl) && $housebl->containers->isNotEmpty())
                        @foreach ($housebl->containers as $key => $container)
                            <tr>
                                <td><input type="text" name="addmore[{{ $key }}][contref]"
                                        class="form-control form-control-sm contrefno" value="{{ $container->contref }}"
                                        onchange="checkFCLContainer(this)" required pattern="*" maxlength="11" /></td>
                                <td>
                                    <input type="text" name="addmore[{{ $key }}][type]"
                                        value="{{ $container->type }}" class="form-control form-control-sm type"
                                        list="containerTypes" required />
                                    <datalist id="containerTypes">
                                        @foreach ($containertypes as $containertype)
                                            <option value="{{ $containertype }}">{{ $containertype }}</option>
                                        @endforeach
                                    </datalist>
                                </td>
                                <td>
                                    <select name="addmore[{{ $key }}][status]"
                                        class="form-control form-control-sm contStatus" required>
                                        <option value="{{ $container->status }}" selected>{{ $container->status }}
                                        </option>
                                        <option value="PRT">PRT</option>
                                        <option value="LCL">LCL</option>
                                        <option value="FCL">FCL</option>
                                        <option value="ETY">ETY</option>
                                    </select>
                                </td>
                                <td><input type="text" name="addmore[{{ $key }}][sealno]"
                                        value="{{ $container->sealno }}" class="form-control form-control-sm sealno" />
                                </td>
                                <td><input type="text" name="addmore[{{ $key }}][pkgno]"
                                        value="{{ $container->pkgno }}" class="form-control  form-control-sm pkgno" />
                                </td>
                                <td><input type="text" name="addmore[{{ $key }}][grosswt]"
                                        value="{{ $container->grosswt }}"
                                        class="form-control form-control-sm containerGrossWeight" /></td>
                                <td><input type="text" name="addmore[{{ $key }}][imco]"
                                        value="{{ $container->imco }}" class="form-control form-control-sm imco" /></td>
                                <td><input type="text" name="addmore[{{ $key }}][un]"
                                        value="{{ $container->un }}" class="form-control form-control-sm"
                                        maxlength="4" /></td>
                                <td><input type="text" name="addmore[{{ $key }}][location]"
                                        value="{{ $container->location }}" list="locations"
                                        class="form-control form-control-sm location" />
                                    <datalist id="locations">
                                        @foreach ($offdocks as $offdock)
                                            <option value="{{ $offdock->code }}">{{ $offdock->name }}</option>
                                        @endforeach
                                    </datalist>
                                </td>
                                <td>
                                    <select name="addmore[{{ $key }}][commodity]"
                                        class="form-control form-control-sm commodity">
                                        @foreach ($commoditys as $commodity)
                                            <option value="{{ $commodity->commoditycode }}"
                                                {{ $commodity->commoditycode == $container->commodity ? 'selected' : null }}>
                                                {{ $commodity->commoditycode }} :
                                                {{ $commodity->commoditydescription }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm addContainerBtn"><i
                                            class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger remove-tr" tabindex="-1"><i
                                            class="fas fa-minus fa-1x"></i></button>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        var i = {!! json_encode(old('addmore') ? count(old('addmore')) : (!empty($housebl) ? $housebl->containers->count() - 1 : 0)) !!};

        function addContainer() {
            $("#containerTable tbody").append(`
                <tr>
                    <td><input type="text" name="addmore[${i}][contref]" class="form-control form-control-sm contrefno" onchange="checkFCLContainer(this)" required pattern="*" maxlength="11"/></td>
                    <td>
                        <input type="text" name="addmore[${i}][type]" class="form-control form-control-sm type" list="containerTypes" required/>
                        <datalist id="containerTypes">
                            @foreach ($containertypes as $containertype)
                                <option value="{{ $containertype }}">{{ $containertype }}</option>
                            @endforeach
                        </datalist>
                    </td>
                    <td>
                        <select name="addmore[${i}][status]" class="form-control form-control-sm contStatus" required>
                            <option value disabled selected></option>
                            <option value="PRT">PRT</option>
                            <option value="LCL">LCL</option>
                            <option value="FCL">FCL</option>
                            <option value="ETY">ETY</option>
                        </select>
                    </td>
                    <td><input type="text" name="addmore[${i}][sealno]" class="form-control form-control-sm sealno"/></td>
                    <td><input type="text" name="addmore[${i}][pkgno]"  class="form-control form-control-sm pkgno" /></td>
                    <td><input type="text" name="addmore[${i}][grosswt]" class="form-control form-control-sm containerGrossWeight" /></td>
                    <td><input type="text" name="addmore[${i}][imco]" class="form-control form-control-sm imco"/></td>
                    <td><input type="text" name="addmore[${i}][un]"  class="form-control form-control-sm" maxlength="4"/></td>
                    <td><input type="text" name="addmore[${i}][location]" class="form-control form-control-sm location" list="locationss" />
                        <datalist id="locationss">
                            @foreach ($offdocks as $offdock)
                                <option value="{{ $offdock->code }}">{{ $offdock->name }}</option>
                            @endforeach
                        </datalist>
                    </td>
                    <td>
                        <select name="addmore[${i}][commodity]" class="form-control form-control-sm commodity">
                            @foreach ($commoditys as $commodity)
                                <option value="{{ $commodity->commoditycode }}" {{ $commodity->commoditycode == 16 ? 'selected' : null }}>
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
            `)
        }
        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });

        //        $(document).on('click', '.addContainerBtn', function(){
        //            ++i;
        //            addContainer();
        //        });

        $(document).on('click', '.addContainerBtn', function() {
            ++i;
            let totalRows = $("#containerTable tbody tr").length;
            if (totalRows > 0) {
                var $tr = $("#containerTable tbody tr:last").closest('tr');
                var $clone = $tr.clone().find('[name]').attr('name', function(idx, attrVal) {
                    return attrVal.replace(/\d/g, i);
                }).end();
                $clone.find('.commodity').val(16);
                $clone.find('.contrefno, .type, .contStatus, .sealno, .pkgno, .containerGrossWeight').val(null);
                $tr.after($clone);
                $(".contrefno").last().focus();
            } else {
                addContainer();
            }
        });


        function loadIgm() {
            let formType = "{{ $formType }}";
            let url = '{{ url('getIgm') }}/' + document.getElementById('igmno').value;
            if (formType == 'edit') {
                let UserConfirmation = confirm("Do you want to change the IGM Number for this BL");
                console.log(UserConfirmation);
                if (UserConfirmation == true) {
                    fetch(url)
                        .then((resp) => resp.json())
                        .then(function(igmno) {
                            $("#mblno").val(igmno.mblno);
                            $("#fvessel").val(igmno.fvessel);
                            $("#voyage").val(igmno.voyage);
                            $("#rotno").val(igmno.rotno);
                            $("#blnaturecode").val(igmno.blnaturecode);
                            $("#pucode").val(igmno.pucode);
                            $("#igmGrossWeight").val(igmno.totalGrossWeight);
                            $("#igmTotalPackage").val(igmno.totalPackage);
                            $("#igmTotalLine").val(igmno.totalLine);
                            if (igmno.noc) {
                                document.getElementById('noc').checked = true;
                            } else {
                                document.getElementById('noc').checked = false;
                            }
                            $("#departure").val(igmno.departure);
                            $("#arrival").val(igmno.arrival);
                            $("#berthing").val(igmno.berthing);
                            $("#customoffice").val(igmno.cofficecode);
                        })
                        .catch(function() {
                            $("#mblno,#fvessel,#voyage,#rotno,#blnaturecode,#pucode,#departure,#arrival,#berthing,#customoffice")
                                .val(null);
                            document.getElementById('noc').checked = false;
                            $("#totalNotes").empty();
                            $("#igmGrossWeight, #igmTotalPackage").val(null);
                        });
                } else {
                    $("#igmno").val({{ $housebl->igm ?? null }});
                    $("#mblno").focus();
                }
            } else {
                fetch(url)
                    .then((resp) => resp.json())
                    .then(function(igmno) {
                        $("#mblno").val(igmno.mblno);
                        $("#fvessel").val(igmno.fvessel);
                        $("#voyage").val(igmno.voyage);
                        $("#rotno").val(igmno.rotno);
                        $("#blnaturecode").val(igmno.blnaturecode);
                        $("#pucode").val(igmno.pucode);
                        $("#igmGrossWeight").val(igmno.totalGrossWeight);
                        $("#igmTotalPackage").val(igmno.totalPackage);
                        $("#igmTotalLine").val(igmno.totalLine);
                        if (igmno.noc) {
                            document.getElementById('noc').checked = true;
                        } else {
                            document.getElementById('noc').checked = false;
                        }
                        $("#departure").val(igmno.departure);
                        $("#arrival").val(igmno.arrival);
                        $("#berthing").val(igmno.berthing);
                        $("#customoffice").val(igmno.cofficecode);
                    })
                    .catch(function() {
                        $("#mblno,#fvessel,#voyage,#rotno,#blnaturecode,#pucode,#departure,#arrival,#berthing,#customoffice")
                            .val(null);
                        document.getElementById('noc').checked = false;
                        $("#totalNotes").empty();
                        $("#igmGrossWeight, #igmTotalPackage").val(null);
                    });
            }

        } //loadIgm

        function loadIgmByMbl() {
            let url = '{{ url('getIgmByMbl') }}/' + document.getElementById('mblno').value;
            fetch(url)
                .then((resp) => resp.json())
                .then(function(mblno) {
                    $("#igmno").val(mblno.id);
                    $("#fvessel").val(mblno.fvessel);
                    $("#voyage").val(mblno.voyage);
                    $("#rotno").val(mblno.rotno);
                    $("#blnaturecode").val(mblno.blnaturecode);
                    $("#pucode").val(mblno.pucode);
                    var noc = $("#noc").val(mblno.noc);
                    if (noc) {
                        document.getElementById('noc').checked = true;
                    } else {
                        document.getElementById('noc').checked = false;
                    }
                    $("#departure").val(mblno.departure);
                    $("#arrival").val(mblno.arrival);
                    $("#berthing").val(mblno.berthing);
                    $("#customoffice").val(mblno.cofficecode);
                    $("#igmGrossWeight").val(mblno.totalGrossWeight);
                    $("#igmTotalPackage").val(mblno.totalPackage);
                    $("#igmTotalLine").val(mblno.totalLine);
                })
                .catch(function() {
                    $("#igmno,#fvessel,#voyage,#rotno,#blnaturecode,#pucode,#departure,#arrival,#berthing,#customoffice")
                        .val(null);
                    document.getElementById('noc').checked = false;
                    $("#igmGrossWeight, #igmTotalPackage").val(null);
                });
        } //loadIgmByMbl

        $("#bolref").on('change', function() {
            let bolRef = $(this).val();
            let url = '{{ url('loadHouseByBolRef') }}/' + bolRef;
            let containerTable = $("#containerTable tbody");
            fetch(url)
                .then((resp) => resp.json())
                .then(function(housebl) {
                    $("#igmno").val(housebl.igm);
                    $("#mblno").val(housebl.masterbl.mblno);
                    $("#fvessel").val(housebl.masterbl.fvessel);
                    $("#voyage").val(housebl.masterbl.voyage);
                    $("#rotno").val(housebl.masterbl.rotno);
                    $("#blnaturecode").val(housebl.masterbl.blnaturecode);
                    $("#pucode").val(housebl.masterbl.pucode);
                    $("#departure").val(housebl.departure ? housebl.departure : null);
                    $("#arrival").val(housebl.arrival ? housebl.arrival : null);
                    $("#berthing").val(housebl.berthing ? housebl.berthing : null);
                    $("#customoffice").val(housebl.masterbl.cofficecode);
                    $("#igmGrossWeight").val(housebl.totalGrossWeight);
                    $("#igmTotalPackage").val(housebl.totalPackage);
                    $("#igmTotalLine").val(housebl.totalPackage);
                    $("#lineno").val(housebl.line);
                    $("#exportername").val(housebl.exportername);
                    $("#exporteraddress").val(housebl.exporteraddress);
                    $("#consigneebin").val(housebl.consigneebin);
                    $("#consigneename").val(housebl.consigneename);
                    $("#consigneeaddress").val(housebl.consigneeaddress);
                    $("#notifybin").val(housebl.notifybin);
                    $("#notifyname").val(housebl.notifyname);
                    $("#notifyaddress").val(housebl.notifyaddress);
                    $("#shippingmark").val(housebl.shippingmark);
                    $("#nofpackage").val(housebl.packageno);
                    $("#packagecode").val(housebl.packagecode);
                    $("#packagename").val(housebl.packagetype);
                    $("#description").val(housebl.description);
                    $("#hblgrossweight").val(housebl.grosswt);
                    $("#measurement").val(housebl.measurement);
                    $("#noofcontainer").val(housebl.containernumber);
                    $("#remarks").val(housebl.remarks);
                    $("#freightstatus").val(housebl.freightstatus);
                    $("#freightvalue").val(housebl.freightvalue);
                    $("#coloader").val(housebl.coloader);
                    $("#notefordo").val(housebl.note);
                    countBolrefCharacter();
                    countExporterNameCharacter();
                    countConsigneeNameCharacter();
                    countNotifyNameCharacter();
                    countShippingMarkCharacter();
                    countDescriptionCharacter();

                    housebl.masterbl.noc ? $("#noc").prop('checked', true) : $("#noc").prop('checked', false);

                    $(containerTable).empty();
                    housebl.containers.forEach(function(container, key) {
                        (container.status == 'PRT' || container.status == 'LCL') ? $(
                                "#consolidatedcargo").prop('checked', true): $("#consolidatedcargo")
                            .prop('checked', false);

                        $(containerTable).append(`
                    <tr>
                        <td><input type="text" name="addmore[${key}][contref]" value="${container.contref}" class="form-control form-control-sm contrefno" onchange="checkFCLContainer(this)" required pattern="*" maxlength="11"/></td>
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
                                <option value disabled selected>Enter Status</option>
                                <option value="PRT" ${container.status == "PRT" ? 'selected' : null}>PRT</option>
                                <option value="LCL" ${container.status == "LCL" ? 'selected' : null}>LCL</option>
                                <option value="FCL" ${container.status == "FCL" ? 'selected' : null}>FCL</option>
                                <option value="ETY" ${container.status == "ETY" ? 'selected' : null}>ETY</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="addmore[${key}][sealno]" value="${container.sealno ?? ''}" class="form-control form-control-sm sealno"/>
                        </td>
                        <td class="packageno">
                            <input type="text" name="addmore[${key}][pkgno]"  value="${container.pkgno ?? ''}" class="form-control form-control-sm pkgno"/>
                        </td>
                        <td>
                            <input type="text" name="addmore[${key}][grosswt]"  value="${container.grosswt ?? ''}" class="form-control form-control-sm containerGrossWeight"/>
                        </td>
                        <td>
                            <input type="text" name="addmore[${key}][imco]"  value="" class="form-control form-control-sm imco"/>
                        </td>
                        <td><input type="text" name="addmore[${key}][un]"  value="" class="form-control form-control-sm" maxlength="4"/></td>
                        <td><input type="text" name="addmore[${key}][location]" value="${container.location ?? '' }" class="form-control form-control-sm location" list="locationss" />
                            <datalist id="locationss">
                                @foreach ($offdocks as $offdock)
                                    <option value="{{ $offdock->code }}">{{ $offdock->name }}</option>
                                @endforeach
                            </datalist>
                        </td>
		                <td>
			                <select name="addmore[${key}][commodity]" class="form-control form-control-sm commodity">
    @foreach ($commoditys as $commodity)
        <option value="{{ $commodity->commoditycode }}" ${container.commodity=="{{ $commodity->commoditycode }}"
            ? 'selected' : null}>
            {{ $commodity->commoditycode }} : {{ $commodity->commoditydescription }}
        </option>
    @endforeach
                            </select>
                        </td>
                        <td><button type="button" class="btn btn-success btn-sm addContainerBtn"><i class="fa fa-plus"></i></button> <button type="button" class="btn btn-sm btn-danger remove-tr" tabindex="-1"><i class="fas fa-minus fa-1x"></i></button></td>
                    </tr>
                    `);
                    }); //containers loop
                })
                .catch(function() {});
        });

        function loadExporterAddress() {
            let url = '{{ url('/loadExporterInfo/') }}/' + $('#exportername').val();
            fetch(url)
                .then((resp) => resp.json())
                .then(function(exporterInfo) {
                    $('#exporteraddress').val(exporterInfo.exporteraddress);
                })
                .catch(function() {
                    $('#exporteraddress').val("");
                });
        } //loadExporterAddress

        function loadConsigneeBin() {
            let url = '{{ url('getBin') }}/' + $('#consigneebin').val();
            fetch(url)
                .then((resp) => resp.json())
                .then(function(consigneebin) {
                    $('#consigneename, #consigneeaddress').attr('tabindex', '-1');
                    $('#consigneename').val(consigneebin.binName);
                    $('#consigneeaddress').val(consigneebin.binAddress);
                    $("#cloneNotifyBtn").focus();
                })
                .catch(function() {
                    document.getElementById('consignee_status').value = 1;
                    let newBinConfirmation = confirm("New Entry");
                    $('#consigneename, #consigneeaddress').val(null);

                    if (newBinConfirmation) {
                        $("#consigneename").removeAttr("onchange").focus();
                    } else {
                        $("#consigneename").attr("onchange", 'loadConsigneeBinByName()').removeAttr("tabindex").focus();
                    }
                    $("#consigneeaddress").removeAttr("tabindex");
                });
        } //loadConsigneeBin


        function loadNotifyBin() {
            let url = '{{ url('getBin') }}/' + $('#notifybin').val();
            fetch(url)
                .then((resp) => resp.json())
                .then(function(notifybin) {
                    $('#notifyname, #notifyaddress').attr('tabindex', '-1');
                    $('#notifyname').val(notifybin.binName);
                    $('#notifyaddress').val(notifybin.binAddress);
                    $("#shippingmark").focus();
                })
                .catch(function() {
                    document.getElementById('notify_status').value = 1;
                    $('#notifyname, #notifyaddress').val(null);
                    let newBinConfirmation = confirm("New Entry");
                    if (newBinConfirmation) {
                        $("#notifyname").removeAttr("onchange").focus();
                    } else {
                        $("#notifyname").attr("onchange", 'loadNotifyBinByName()').removeAttr("tabindex").focus();
                    }
                    $("#notifyaddress").removeAttr("tabindex");
                });
        } //loadNotifyBin

        function loadPackageName() {
            let url = '{{ url('getPackageName') }}/' + document.getElementById('packagecode').value;
            fetch(url)
                .then((resp) => resp.json())
                .then(function(packagecode) {
                    document.getElementById('packagename').value = packagecode.packagename;
                })
                .catch(function() {
                    alert("No Data Found.");
                    document.getElementById('packagename').value = "";
                });
        } //loadPackageName

        function checkFCLContainer(e) {
            let currentStatus = $(e).closest('tr').find('.contStatus');
            let contref = $(e).closest('tr').find('.contrefno').val();
            let igm = $("#igmno").val();

            if (igm) {
                if (currentStatus.val()) {
                    let url = "{{ url('checkFCLContainer') }}/" + igm + '/' + contref;
                    fetch(url)
                        .then((resp) => resp.json())
                        .then(function(housebl) {
                            if (housebl) {
                                alert("This Container Uploaded before with FCL Status. \n IGM: " + housebl.igm +
                                    " \n HBL: " + housebl.bolreference);
                                //                            $(currentStatus).val(null);
                            }
                        }).catch(function() {

                        });
                }
            } else {
                alert("Please Insert IGM First.");
            }
        }

        function getLocation() {
            $(document).ready(function() {
                if ($('#pucode').val() === 'BDKAM') {
                    $('#contloc').val('102DICD');
                } else if ($('#pucode').val() === 'BDPNG') {
                    $('#contloc').val('752NPNG');
                } else {
                    $('#contloc').val(null);
                }
            });
        } //Set Container Location Based on House Uploading Location

        function countBolrefCharacter() {
            let currentNode = $("#bolref");
            currentNode.siblings('.characterLimit').html(currentNode.val().length + ' / ' + currentNode.attr('maxlength'));
        }

        function countExporterNameCharacter() {
            let currentNode = $("#exportername");
            currentNode.siblings('.characterLimit').html(currentNode.val().length + ' / ' + currentNode.attr('maxlength'));
        }

        function countConsigneeNameCharacter() {
            let currentNode = $("#consigneename");
            currentNode.siblings('.characterLimit').html(currentNode.val().length + ' / ' + currentNode.attr('maxlength'));
        }

        function countNotifyNameCharacter() {
            let currentNode = $("#notifyname");
            currentNode.siblings('.characterLimit').html(currentNode.val().length + ' / ' + currentNode.attr('maxlength'));
        }

        function countShippingMarkCharacter() {
            let currentNode = $("#shippingmark");
            currentNode.siblings('.characterLimit').html(currentNode.val().length + ' / ' + currentNode.attr('maxlength'));
        }

        function countDescriptionCharacter() {
            let currentNode = $("#description");
            currentNode.siblings('.characterLimit').html(currentNode.val().length + ' / ' + currentNode.attr('maxlength'));
        }


        //dg status checked unchecked
        function dgStatus() {
            if ($(".imco").filter(function() {
                    return $(this).val();
                }).length > 0) {
                $("#dgstatus").prop('checked', true)
            } else {
                $("#dgstatus").prop('checked', false)
            }
        }





        window.onload = function() {
            countBolrefCharacter();
            countExporterNameCharacter();
            countConsigneeNameCharacter();
            countNotifyNameCharacter();
            countShippingMarkCharacter();
            countDescriptionCharacter();
        };
    </script>


    <script>
        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(document).ready(function() {
            @if ($formType == 'create' && !old('addmore'))
                addContainer();
            @endif

            @if (old('line'))
                $("#lineno").select();
            @endif

            $('#noofcontainer').blur(function(e) {
                let totalContainer = $(this).val();
                if (totalContainer == 1) {
                    let firstRow = $("#containerTable > tbody").children('tr:first');
                    firstRow.find(".containerGrossWeight").val($('#hblgrossweight').val());
                    firstRow.find(".pkgno").val($('#nofpackage').val());
                }
            }); // copy housebl grossWight and  package if container 1

            $("#consigneename").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('binDataByNameAutoComplete') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#consigneename').val(ui.item.name); // display the selected text
                    $('#consigneebin').val(ui.item.bin); // display the selected text
                    $('#consigneeaddress').val(ui.item.address); // display the selected text
                    return false;
                }
            }).keyup(function() {
                countConsigneeNameCharacter();
            });

            $("#notifyname").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('binDataByNameAutoComplete') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#notifyname').val(ui.item.name); // display the selected text
                    $('#notifybin').val(ui.item.bin); // display the selected text
                    $('#notifyaddress').val(ui.item.address); // display the selected text
                    return false;
                }
            }).keyup(function() {
                countNotifyNameCharacter();
            });

            $(document).on('change', '.contStatus', function() {
                let currentStatus = $(this);
                let contref = $(this).closest('tr').find('.contrefno').val();

                let igm = $("#igmno").val();

                let contStatus = $(".contStatus");
                let allStatus = [];
                contStatus.each(function(key) {
                    allStatus.push($(this).val());
                });
                if ($.inArray("PRT", allStatus) !== -1 || $.inArray("LCL", allStatus) !== -1) {
                    $('#consolidatedcargo').prop('checked', true);
                } else {
                    $('#consolidatedcargo').prop('checked', false);
                }
                checkFCLContainer(this);
            });

            $("#cloneNotifyBtn").on('click', function() {
                if ($(this).prop("checked") == true) {
                    $("#notifybin").val($("#consigneebin").val());
                    $("#notifyname").val($("#consigneename").val());
                    $("#notifyaddress").val($("#consigneeaddress").val());
                    countNotifyNameCharacter();
                } else {
                    $("#notifybin, #notifyname, #notifyaddress").val(null);
                }
            }); // clone consignee data for notify

            $(document).on('keypress', '.sealno, .contrefno', function(e) {
                var regex = new RegExp("^[a-zA-Z0-9]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    return true;
                }
                e.preventDefault();
                return false;
            }); // Stop special character

            $('#shippingmark').keyup(function() {
                countShippingMarkCharacter();
            });
            $('#description').keyup(function() {
                countDescriptionCharacter();
            }).focus(function() {
                this.select();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(this).offset().top - 50
                }, 1000);
            });

            $('#bolref').keyup(function() {
                countBolrefCharacter()
            });
            $('#exportername').keyup(function() {
                countExporterNameCharacter()
            });

            var fixedDescriptions = {!! json_encode($descriptions) !!};
            $("#description").autocomplete({
                source: fixedDescriptions
            });

            //check imco and set DG Status Checked
            $(document).on('change', '.imco', function() {
                dgStatus();
            });

            $("#mainForm").on('submit', function() {
                if (!$("#file").val()) {
                    return validateHblForm();
                }
            });



        }); //document.ready


        function validateHblForm() {
            var totalContainers = $("#noofcontainer").val();
            var containerRows = $("#containerTable tbody tr").length;
            var totalPackages = $("#nofpackage").val();
            var containerPackages = 0;

            if (totalContainers != containerRows) {
                alert('Total Number of Containers Mismatching!');
                return false;
            }

            $('.pkgno').each(function() {
                containerPackages += parseFloat($(this).val());
            });
            if (totalPackages != containerPackages) {
                alert('Total Number of Packages Mismatch!');
                return false;
            }


            var totalGrossWight = parseFloat($("#hblgrossweight").val()).toFixed(2);
            var containerGrossWeight = 0;

            $(".containerGrossWeight").each(function() {
                containerGrossWeight += parseFloat($(this).val());
            });

            if (totalGrossWight != containerGrossWeight.toFixed(2)) {
                alert('Total Gross Weight Mismatching! \nGross Weight= ' + totalGrossWight + '\n Containers Weight = ' +
                    containerGrossWeight);
                return false;
            }
        } // check total container, total packages & total Gross Weight with BL and Containers info


        $(document).ready(function() {
            $('#uploadBtn').click(function() {
                if (confirm("By pressing OK Button all container data will be erased which created manually!")) {
                    $('#addContainer').hide();
                    $('#fileUploadArea').show();
                    $("#addContainerBtn").removeClass("btn-warning").addClass("btn-outline-warning");
                    $(this).removeClass("btn-outline-warning").addClass("btn-warning");
                    $("#containerTable tbody").empty();
                }
            });

            $('#addContainerBtn').click(function() {
                $('#fileUploadArea').hide();
                $('#addContainer').show();
                $("#uploadBtn").removeClass("btn-warning").addClass("btn-outline-warning");
                $(this).removeClass("btn-outline-warning").addClass("btn-warning");
            });

        });
    </script>



@endsection
