@extends('layouts.new-layout')
@section('title', 'Inbound Performance Report ')

@section('style')
    <style>
        .table td{
            white-space: normal!important;
        }
    </style>
@endsection

@section('breadcrumb-title', 'Inbound Performance Report ')

@section('breadcrumb-button')

@endsection

@section('sub-title')

@endsection

@section('content')
    <form action="{{ route('inboundPerformanceReport') }}" method="get">
        <div class="row px-2">

            <div class="col-md-2 px-1 my-1 my-md-0">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf" {{$dateType == "reportType" ? "selected" : ''}}> PDF </option>
                </select>
            </div>

            <div class="col-md-2 px-1 my-1 my-md-0">
                <select name="dateType" id="dateType" class="form-control form-control-sm" required>
                    <option value="today" selected> Today </option>
                    <option value="weekly" {{$dateType == "weekly" ? "selected" : ''}}> Last 7 Days </option>
                    <option value="monthly" {{$dateType == "monthly" ? "selected" : ''}}> Last 30 Days </option>
                    <option value="custom" {{$dateType == "custom" ? "selected" : ''}}> Custom </option>
                </select>
            </div>

            <div class="col-md-2 px-1 my-1 my-md-0" id="fromDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <input id="fromDate" class="form-control form-control-sm" value="{{$fromDate ? date('d/m/Y', strtotime($fromDate)) : ''}}"  type="text" name="fromDate" placeholder="Select From Date" autocomplete="off">
            </div>

            <div class="col-md-2 px-1 my-1 my-md-0" id="tillDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <input id="tillDate" class="form-control form-control-sm" value="{{!empty($tillDate) ? date('d/m/Y', strtotime($tillDate)) : ''}}"  type="text" name="tillDate" placeholder="Select Till Date" autocomplete="off">
            </div>


            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>

        </div><!-- end row -->
    </form>

    @if($locationWiseContTypesWithCount->isNotEmpty())
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered">
                <tr>
                    <td rowspan="2"> BL</td>
                    <td rowspan="2"> MLO</td>
                    <td rowspan="2"> VESSEL & VOY </td>
                    <td rowspan="2"> BERTH </td>
                    @foreach($locationWiseContTypesWithCount as $key => $containerGroup)
                        <td colspan="{{count($containerGroup)+2}}" class="{{$loop->iteration % 2 == 0 ? 'bg-success' : 'bg-warning'}}">
                            {{$key}}
                        </td>
                    @endforeach
                    <td colspan="{{count($locationWiseContTypesWithCount->collapse())+2}}">
                        Grand Total
                    </td>
                </tr>

                <tr style="background: #1d5ea6; color: #fff; text-align: center">
                    @foreach($locationWiseContTypesWithCount as $key => $containerGroup)
                        @foreach($containerGroup as $groupKey => $singleGroup)
                            <td class="{{$loop->parent->iteration % 2 == 0 ? 'bg-success' : 'bg-warning'}}">
                                {{$groupKey}}
                            </td>
                        @endforeach
                        <td class="{{$loop->iteration % 2 == 0 ? 'bg-success' : 'bg-warning'}}">
                            Total
                        </td>
                        <td class="{{$loop->iteration % 2 == 0 ? 'bg-success' : 'bg-warning'}}">
                            TUES
                        </td>
                    @endforeach
                    @foreach($locationWiseContTypesWithCount->collapse() as $commonGroupKey=>$commonGroup)
                        <td>
                            {{$commonGroupKey}}
                        </td>
                    @endforeach
                    <td>Total </td>
                    <td>Tues </td>
                </tr>


                @foreach($mloblinformations as $mloblinformation)
                    <tr>
                        <td class="text-left"><nobr>{{$mloblinformation->bolreference}}</nobr></td>
                        <td class="text-left"><nobr>{{$mloblinformation->principal->name}}</nobr></td>
                        <td class="text-left"><nobr>{{$mloblinformation->mlofeederInformation->feederVessel}} V. {{$mloblinformation->mlofeederInformation->voyageNumber}}</nobr></td>
                        <td class="text-left"><nobr>{{$mloblinformation->mlofeederInformation->berthingDate ? date('d/m/Y', strtotime($mloblinformation->mlofeederInformation->berthingDate)) : "--"}}</nobr></td>

                        @foreach($locationWiseContTypesWithCount as $key => $containerGroup)
                            @foreach($containerGroup as $groupKey => $singleGroup)
                                @php
                                $countItem=0;
                                $countTues = 0;
                                @endphp
                                <td>
                                    @if($key == $mloblinformation->PUloding)
                                        @foreach($mloblinformation->blcontainers as $container)
                                            @php($countItem += $groupKey == $container->containerGroup->group)
                                            @if(str_contains($container->containerGroup->group, 20))
                                                @php($countTues+= 1)
                                            @else
                                                @php($countTues+= 2)
                                            @endif

                                        @endforeach
                                    @endif
                                    {{$countItem}}
                                </td>
                            @endforeach
                            <td style="background: #c3c3c3">
                                @if($key == $mloblinformation->PUloding)
                                    {{count($mloblinformation->blcontainers)}}
                                @else
                                    0
                                @endif
                            </td>
                            <td style="background: #a3a3a3">
                                {{$countTues}}
                            </td>

                        @endforeach

                        @foreach($locationWiseContTypesWithCount->collapse() as $commonGroupKey=>$commonGroup)
                            <td>
                                @php($totalGroupItem=0)
                                @foreach($mloblinformation->blcontainers as $container)
                                    @if($commonGroupKey == $container->containerGroup->group)
                                        @php($totalGroupItem+=1)
                                    @endif
                                @endforeach
                                {{$totalGroupItem}}
                            </td>
                        @endforeach
                        <td style="background: #c3c3c3">
                            {{count($mloblinformation->blcontainers)}}
                        </td>
                        <td style="background: #a3a3a3">
                            @php($totalTues=0)
                            @foreach($mloblinformation->blcontainers as $container)
                                @if(str_contains($container->containerGroup->group, 20))
                                    @php($totalTues+= 1)
                                @else
                                    @php($totalTues+= 2)
                                @endif
                            @endforeach
                            {{$totalTues}}
                        </td>
                    </tr>
                @endforeach {{--End mloblinformation rows foreach --}}


                {{--Grand Total--}}
                <tr class="bg-warning">
                    @php($grandTotal = 0)
                    @php($grandTotalTues = 0)
                    <td colspan="4" style="text-align: right">TOTAL</td>
                    @foreach($locationWiseContTypesWithCount as $containerGroupKey => $containerGroup)
                        @php($columnTypeTotal=0)
                        @foreach($containerGroup as $contTypeKey => $singleGroup)
                            <td class="{{$loop->parent->iteration % 2 == 0 ? 'bg-success' : 'bg-warning'}}">
                                @php($columnTypeTotal += $singleGroup)
                                {{$singleGroup}}
                            </td>
                        @endforeach

                        <td class="{{$loop->iteration % 2 == 0 ? 'bg-success' : 'bg-warning'}}">
                            {{$columnTypeTotal}}
                            @php($grandTotal += $columnTypeTotal)
                        </td>

                        <td class="{{$loop->iteration % 2 == 0 ? 'bg-success' : 'bg-warning'}}">
                            @php($columnTuesTotal=0)
                            @foreach($containerGroup as $groupKey => $singleGroup)
                                @if(str_contains($groupKey, 20))
                                    @php($columnTuesTotal+= $singleGroup*1)
                                @else
                                    @php($columnTuesTotal+= $singleGroup*2)
                                @endif
                            @endforeach
                            {{$columnTuesTotal}}
                            @php($grandTotalTues +=$columnTuesTotal)
                        </td>
                    @endforeach

                    @foreach($locationWiseContTypesWithCount->collapse() as $commonGroupKey=>$commonGroup)
                        <td>
                            @php($totalGroup=0)
                            @foreach($locationWiseContTypesWithCount as $key=>$contGroups)
                                @foreach($contGroups as $groupKey=> $group)
                                    @if($commonGroupKey == $groupKey)
                                        @php($totalGroup+=$group)
                                    @endif
                                @endforeach
                            @endforeach
                            {{$totalGroup}}
                        </td>
                    @endforeach
                    <td> {{$grandTotal}} </td>
                    <td> {{$grandTotalTues}}  </td>
                </tr>
            </table>
        </div>
    @else
        <p class="bg-light py-3 text-center lead"> <strong> No Data Found based on your query.  </strong> </p>
    @endif
@endsection

@section('script')
    <script>

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
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

            $( "#principal").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('principalAutoComplete')}}",
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
                    $('#principal').val(ui.item.label); // display the selected text
                    return false;
                }
            });
        });
    </script>
@endsection


