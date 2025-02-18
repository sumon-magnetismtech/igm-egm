@extends('layouts.new-layout')
@section('title', 'Container List')

@section('breadcrumb-title')
    {{--@if($formType == 'edit')--}}
        {{--Edit Master BL--}}
    {{--@else--}}
        {{--Add New Master BL--}}
    {{--@endif--}}
    STF - Container List
@endsection

@section('breadcrumb-button')
{{--    <a href="{{ url('masterbls') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>--}}
@endsection

@section('sub-title')
    {{--<span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content')
    <div class="col-12">
        <form action="{{route('stfcontainerlist')}}" method="get">
            @csrf
            <div class="row">
                <div class="col-md-4 px-md-1 my-1 my-md-0">
                    <input class="form-control form-control-sm" type="text" id="contRef" value="{{$searchedCont ? $searchedCont : null}}" name="contRef" placeholder="Enter Container No" autocomplete="off">
                </div>
                <div class="col-md-1 pl-md-1 my-1 my-md-0">
                    <div class="input-group input-group-sm">
                        <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form action="{{route('exports.create')}}" method="get">
            <button class="btn btn-sm btn-success float-right" id="loadVessel" style="display: none;"> Add to Vessel </button>

            <div class="table-responsive text-nowrap">
                <table class="table table-striped table-bordered" id="containerTable">
                    <thead class="indigo white-text text-center">
                        <tr>
                            <th class="th-sm"> <input type="checkbox" id="bulkEditAll" class="bulkEditAll"> </th>
                            <th class="th-sm"> # </th>
                            <th class="th-sm"> Container Ref </th>
                            <th class="th-sm"> Status </th>
                            <th> Type </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    @forelse($stfContainerList as $key => $container)
                        <tr>
                            <td>
                                <input type="checkbox" class="singleCheck" value="{{$container->id}}">
                                <input type="hidden" class="contRef" value="{{$container->contref}}">
                            </td>
                            <td>{{$key+1}} </td>
                            <td> {{$container->contref}}  </td>
                            <td> {{Str::title($container->containerStatus)}}  </td>
                            <td> {{$container->type}} </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <p class="lead"> NO STF-Container available at this moment. </p>
                            </td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div> <!-- end col-12 table-responsive text-nowrap -->
            </form>
        </div>

    </div> <!-- end row -->
@endsection

@section('script')
    <script>
        $(function () {
            $("#bulkEditAll").click(function () {
                let allStatus = this.checked;
                (allStatus) ?  $("#loadVessel").slideDown() : $("#loadVessel").slideUp();

                $("#containerTable").find('.singleCheck').each(function () {
                    $(this).prop('checked', allStatus);
                    if($(this).prop('checked')==true) {
                        $(this).attr('name', 'id[]');
                        $(this).siblings('.contRef').attr('name', 'contRef[]')
                    }else{
                        $(this).removeAttr('name');
                        $(this).siblings('.contRef').removeAttr('name')
                    }
                });
            }); //check all / uncheck all

            $('.singleCheck').click(function () {
                let itemStatus = this.checked;
                let totalItem = $('.singleCheck').length;
                let totalChecked = $('.singleCheck:checked').length;

                (itemStatus) ? $(this).attr('name', 'id[]') : $(this).removeAttr('name');
                (itemStatus) ? $(this).siblings('.contRef').attr('name', 'contRef[]') : $(this).siblings('.contRef').removeAttr('name');

                (totalItem == totalChecked) ? $("#bulkEditAll").prop('checked', true) : $("#bulkEditAll").prop('checked', false);
                (totalChecked == 0) ? $("#loadVessel").slideUp() : $("#loadVessel").slideDown();
            }); //check single item


        });//document.ready
    </script>
@endsection