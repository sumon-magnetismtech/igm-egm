@extends('layouts.new-layout')
@section('title', 'Container Movement')

@section('breadcrumb-title')
    {{--@if($formType == 'edit')--}}
        {{--Edit Container Movement--}}
    {{--@else--}}
        {{--Add New Container Movement--}}
    {{--@endif--}}
    Container Movement
@endsection

@section('breadcrumb-button')
    {{--<a href="{{ url('masterbls') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>--}}
@endsection

@section('sub-title')
    {{--<span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('style')
    <style>
        #bolreference{
            position: relative;
        }
        #bolreferenceList{
            position: absolute;
            width: 100%;
        }
        #bolreferenceList ul{
            width: 100%;
        }
        #bolreferenceList ul a{
            width: 100%;
            display: block;
            font-size: 14px;
            padding: 5px;
        }
        #bolreferenceList ul li:hover{
            background: #e8e8e8;
        }
        .form-check-label:hover{
            cursor: pointer;
        }
    </style>
@endsection


@section('content')
    <div class="col-12">
        <form action="{{ route('searchContainer') }}" method="get">
            <div class="row">
                @csrf
                <div class="col-md-4 px-md-1 my-1 my-md-0">
                    <input class="form-control form-control-sm" type="text" id="bolreference" value="{{!empty($bolreference) ? $bolreference : ''}}" name="bolreference" placeholder="Enter BL Reference" autocomplete="off" required>
                    <div id="bolreferenceList"></div>
                </div>
                <div class="col-md-1 pl-md-1 my-1 my-md-0">
                    <div class="input-group input-group-sm">
                        <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="col-12">
        <div class="row">
            @if($containerList)
                <div class="col-md-6">
                    <form action="{{route('searchContainerByConRef')}}" method="get">
                        @csrf
                        <input type="hidden" id="bolreference" value="{{!empty($bolreference) ? $bolreference : ''}}" name="bolreference">
                        <div class="row">
                            <div class="col-md-9 px-md-1 my-1 my-md-0">
                                <input class="form-control form-control-sm" type="text" id="contRef" value="{{!empty($contRef) ? $contRef : ''}}" name="contRef" placeholder="Enter Container No" autocomplete="off" required>
                            </div>
                            <div class="col-md-3 pl-md-1 my-1 my-md-0">
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i> Container </button>
                                </div>
                            </div>
                        </div> <!-- end row -->

                    </form>
                </div> <!-- col-md-6 -->
                <div class="col-md-6">
                    <button type="button" class="btn btn-warning btn-sm float-right" id="bulkEditBtn"> Bulk Movement </button>
                </div>
            @endif
        </div> <!-- end row -->


    </div> <!-- end row -->
    <div class="row">
        <div class="col-12">
            <form class="" action="{{route('emptyContainerBulkEdit')}}" method="post">
                <!-- end bulk edit form -->
                <div class="text-nowrap col-12 bg-light my-2" id="bulkForm" style="display: block;">
                    @csrf
                    <input type="hidden" name="bolreference" value="{{!empty($bolreference) ? $bolreference : ''}}">
                    <div class="row p-1">
                        <div class="col-md-2 px-md-1 my-1 my-md-0">
                            <select name="movementType" id="movementType" class="form-control form-control-sm" required>
                                <option disabled selected> Movement Type </option>
                                <option value="empty"> Empty </option>
                                <option value="stuffing"> Stuffing </option>
                                <option value="force load"> Force Load </option>
                            </select>
                        </div>
                        <div class="col-md-3 px-md-1 my-1 my-md-0">
                            <select name="location" id="location" class="form-control form-control-sm" required>
                                <option disabled selected> Select Location </option>
                            </select>
                        </div>
                        <div class="col-md-3 px-md-1 my-1 my-md-0" id="depoNameArea" style="display: none">
                            <input id="depoName" class="form-control form-control-sm date" value="" type="text" name="depoName" placeholder="Depo Name" autocomplete="off">
                        </div>
                        <div class="col-md-2 px-md-1 my-1 my-md-0">
                            <input id="date" class="form-control form-control-sm date" value=""  type="text" name="date" placeholder="Select Date" autocomplete="off" required>
                        </div>

                        <div class="col-md-1 px-md-1 my-1 my-md-0 d-flex align-items-end">
                            <div class="border-checkbox-section">
                                <div class="border-checkbox-group border-checkbox-group-white">
                                    <input type="checkbox" class="border-checkbox" id="chassisDelivery" name="chassisDelivery">
                                    <label class="border-checkbox-label" for="chassisDelivery">On Ch. Del. </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 pl-md-1 my-1 my-md-0">
                            <div class="input-group input-group-sm">
                                <button class="btn btn-success btn-sm btn-block">Update</button>
                            </div>
                        </div>
                    </div>

                </div> <!-- end col-12 table-responsive text-nowrap -->
                <!-- end bulk edit form -->


                @if($containerGroup)
                    <div>
                        <button type="button" class="btn btn-sm btn-primary">
                            Total <span class="badge badge-light"> {{count($containerList)}} </span>
                        </button>
                        @foreach($containerGroup as $key=>$single)
                            <button type="button" class="btn btn-sm btn-primary">
                                {{ucfirst($key)}} <span class="badge badge-light"> {{$single}} </span>
                            </button>
                        @endforeach
                    </div>
                @endif

                @if($containerList)
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped table-bordered" id="containerTable">
                            <thead class="indigo white-text text-center">
                            <tr>
                                <th id="turnOff"> <input type="checkbox" id="bulkEditAll" class="bulkEditAll"> </th>
                                <th class="th-sm"> # </th>
                                <th class="th-sm"> Container Ref </th>
                                <th> Type </th>
                                <th> Current Status </th>
                                <th> Empty Date </th>
                                <th> Empty Location </th>
                                <th> On Ch. Del. </th>
                                <th> Aging </th>
                                <th> Total Aging </th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @foreach($containerList as $key => $container)
                                <tr>
                                    <td style="vertical-align: middle">
                                        <input type="checkbox" class="singleCheck" value="{{$container->contref}}">
                                        @if($container->containerStatus == "laden" || $container->containerStatus == "empty" )
                                            <input type="checkbox" class="singleCheck" value="{{$container->contref}}">
                                        @endif
                                        <input type="hidden" class="containerId" value="{{$container->id}}">
                                    </td>
                                    <td style="vertical-align: middle">{{$key+1}} </td>
                                    <td style="vertical-align: middle"> {{$container->contref}} </td>
                                    <td style="vertical-align: middle"> {{$container->type}} </td>

                                    <td style="vertical-align: middle">
                                        {{ucfirst($container->containerStatus)}}
                                    </td>

                                    <td style="vertical-align: top">
                                        @forelse($container->emptyContainers as $date)
                                            {{$date->date ? date('d-m-Y', strtotime($date->date)) : ""}}
                                            <br>
                                        @empty
                                            - - -
                                        @endforelse
                                    </td>

                                    <td style="vertical-align: top">
                                        @forelse($container->emptyContainers as $date)
                                            {{$date->location ? $date->location : "- - -"}}
                                            {{$date->depoName ? "($date->depoName)" : ""}}
                                            <br>
                                        @empty
                                            - - -
                                        @endforelse
                                    </td>

                                    <td style="vertical-align: top">
                                        @forelse($container->emptyContainers as $date)
                                            {{$date->chassisDelivery ? "Yes" : "No"}}
                                            <br>
                                        @empty
                                            - - -
                                        @endforelse
                                    </td>
                                    @php $ageStart = 0; @endphp
                                    <td style="vertical-align: top">
                                        @forelse($container->emptyContainers as $key => $date)
                                            @php
                                            $date=\Carbon\Carbon::parse($date->date);
                                            @endphp

                                            @if($loop->first)
                                                @php $ageStart = $date; @endphp
                                            @endif

                                            @if(!$loop->last)
                                                @php
                                                $outDate =\Carbon\Carbon::parse($container->emptyContainers[$key+1]->date);
                                                @endphp
                                                <strong>{{$date->diffInDays($outDate, false)+1}}</strong> Day(s)
                                                <br>
                                            @endif

                                            @if($loop->last)
                                                <strong>{{\Carbon\Carbon::now()->diffInDays($date)+1}}</strong> Day(s)
                                            @endif
                                        @empty
                                            - - -
                                        @endforelse
                                    </td>
                                    <td style="vertical-align: middle">
                                        {{$ageStart ? \Carbon\Carbon::now()->diffInDays($ageStart) .' Day(s)'  : '---'}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end col-12 table-responsive text-nowrap -->
                @else
                    <div>
                        <p class="bg-light py-3 text-center lead"> <strong>Please Enter Bl Number to get Bl Containers list.</strong> </p>
                    </div>
                @endif

            </form>
        </div> <!-- end col-12 -->
    </div>

@endsection

@section('script')
    <script>

        $( "#bolreference" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url:"{{route('bolreferenceAutoComplete')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: "{{csrf_token()}}",
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#bolreference').val(ui.item.value); // display the selected text
//                    $('#mblno').val(ui.item.mblno); // display the selected text
                return false;
            }
        });//bolreference autocomplete


        $(function(){
            $('#date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true});

            $("#movementType").change(function(e){
                var movementType = $(this).val();
                if(movementType === 'stuffing'){
                    $('#location').empty().append(
                            '<option selected disabled> Select Location </option>',
                            '<option value="Depo"> Depo </option>',
                            '<option value="EPZ"> EPZ </option>',
                            '<option value="customerPremises"> Customer Premises </option>'
                    );
                }else if(movementType === 'empty'){
                    $('#location').empty().append(
                            '<option selected disabled> Select Location </option>',
                            '<option value="Depo"> Depo </option>',
                            '<option value="Port"> Port </option>'
                    );
                }else if(movementType === 'force load'){
                    $('#location').empty().append(
                            '<option selected disabled> Select Location </option>',
                            '<option value="Port With Ack"> Port with Acknowledge </option>',
                            '<option value="Port Without Ack"> Port without Acknowledge </option>'
                    );
                    $('#depoNameArea').hide(10);
                    $('#depoName').removeAttr('required');
                }
            });


            $("#location").change(function(e){
                var location = $(this).val();
                if(location === 'Depo' || location === 'customerPremises'){
                    $('#depoNameArea').show(10);
                    $('#depoName').attr('required', true);
                }
                else{
                    $('#depoNameArea').hide(10);
                    $('#depoName').removeAttr('required');
                }
            });


            $('.bulkEditAll').click(function() {
                var checkedStatus = this.checked;
                $('#containerTable').find('.singleCheck').each(function() {
                    $(this).prop('checked', checkedStatus);

                    if($(this).prop("checked") == true){
                        $(this).attr('name', "contref[]");
                        $(this).siblings('.containerId').attr('name', "blcontainer_id[]");
                    }
                    else if($(this).prop("checked") == false){
                        $(this).removeAttr('name');
                        $(this).siblings('.containerId').removeAttr('name');
                    }
                });

            });


            $('#bulkEditBtn').click(function(e){
                let item = $('.singleCheck:checked').length;
                if(item > 0){
                    $(this).text(function(i, text){
                        return text === "Cancel Bulk Edit" ? "Bulk Edit" : "Cancel Bulk Edit";
                    });
                    $("#bulkForm").slideToggle('slow');
                }else{
                    alert("Please select at least 1 item for bulk edit.");
                }
            });

            $('.singleCheck').click(function(){
                let total = $('.singleCheck').length;
                let totalChecked = $('.singleCheck:checked').length;

                if($(this).prop("checked") == true){
                    $(this).attr('name', "contref[]");
                    $(this).siblings('.containerId').attr('name', "blcontainer_id[]");
                }
                else if($(this).prop("checked") == false){
                    $(this).removeAttr('name');
                    $(this).siblings('.containerId').removeAttr('name');
                }

                if(total == totalChecked){
                    $('#bulkEditAll').prop('checked', true);
                }else{
                    $('#bulkEditAll').prop('checked', false);
                }
            });

        });
    </script>

@endsection