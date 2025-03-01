@extends('layouts.layoutMLO')

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
        #containerTable.table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.36);
        }

    </style>

@endsection

@section('title', 'Container Movement')

@section('content')
    <div class="container-fluid">
        <div class="jumbotron">
            <h2 class="h2-responsive font-weight-bolder text-dark text-center"> Container List for Money Receipt </h2>
            <hr>

            <div class="row">
                <div class="col-lg-12">
                    <form class="form-inline md-form form-sm mt-0 row" action="{{ route('containerListMR') }}" method="get">
                        <div class="col-md-5 offset-md-6">
                            <div class="md-form" style="margin-top: 0.3rem; margin-bottom: 0.3rem;">
                                <input class="form-control w-100" type="text" id="bolreference" value="{{!empty($bolreference) ? $bolreference : ''}}" name="bolreference" autocomplete="off" required>
                                <label for="bolreference"> BL Reference Number</label>
                                <div id="bolreferenceList"></div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-pink"><i class="fas fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                @if($containerList)
                                    <form class="col-9" action="{{route('containerByConRefMR')}}" method="get">
                                        @csrf
                                        <input type="hidden" id="bolreference" value="{{!empty($bolreference) ? $bolreference : ''}}" name="bolreference">
                                        <div class="md-form col-9" style="margin-top: 0; margin-bottom: 0;">
                                            <input class="form-control float-left w-100" type="text" id="contRef" value="{{!empty($contRef) ? $contRef : ''}}" name="contRef" autocomplete="off" required>
                                            <label for="contRef"> Enter Container Ref </label>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-success float-right"> <i class="fas fa-search" aria-hidden="true"></i> Search Container </button>
                                    </form>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-sm btn-primary">
                                            Total <span class="badge badge-light"> {{count($containerList)}} </span>
                                        </button>
                                    </div>
                                @endif
                            </div> <!-- row -->
                        </div><!-- col-md-9 -->
                        <div class="col-md-3">
                            <button class="btn btn-sm btn-success float-right" id="addMoneyReceipt" style="display: none;"> Generate Money Receipt </button>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- end col-12 -->

                <div class="col-12">
                    <form class="" id="selectedContainer" action="{{route('mlomoneyreceipts.create')}}" method="get">
                        @if($containerList)
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped table-bordered table-hover" id="containerTable">
                                    <thead class="indigo white-text text-center">
                                    <tr>
                                        <th id="turnOff"> <input type="checkbox" id="bulkEditAll" class="bulkEditAll"> </th>
                                        <th class="th-sm"> # </th>
                                        <th class="th-sm"> Container Ref </th>
                                        <th> Type </th>
                                        <th> Seal No </th>
                                        <th> Pkgno </th>
                                        <th> Grosswt </th>
                                        <th> IMCO </th>
                                        <th> UN </th>
                                        <th> Location </th>
                                        <th> Commodity </th>
                                        <th> Current Status </th>
                                        <th> Payment </th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach($containerList as $key => $container)
                                            <tr>
                                                <td style="vertical-align: middle">
                                                    @if(!$container->payment)
                                                        <input type="checkbox" class="singleCheck" value="{{$container->contref}}">
                                                    @endif
                                                    <input type="hidden" class="containerId" value="{{$container->id}}">
                                                    <input type="hidden" id="bolreference" value="{{!empty($bolreference) ? $bolreference : ''}}" name="bolreference">
                                                </td>
                                                <td>{{$key+1}} </td>
                                                <td> <strong>{{$container->contref}}</strong> </td>
                                                <td> {{$container->type}} </td>
                                                <td> {{$container->sealno}} </td>
                                                <td> {{$container->pkgno}} </td>
                                                <td> {{$container->grosswt}} </td>
                                                <td> {{$container->imco}} </td>
                                                <td> {{$container->un}} </td>
                                                <td> {{$container->location}} </td>
                                                <td> {{$container->commodity}} </td>
                                                <td> {{$container->containerStatus}} </td>
                                                @if($container->payment)
                                                <td class="bg-success"> <strong>Done</strong> </td>
                                                @else
                                                <td class="bg-warning"> <strong>Pending</strong> </td>
                                                @endif
                                            </tr>
                                            {{--<span class="bg-success"></span>--}}


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

            </div> <!-- end row -->

        </div> <!-- end jumbotron -->
    </div> <!-- end container -->


@endsection

@section('script')
    <script>

        $('#bolreference').keyup(function(){
            var query = $(this).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('getBolRef') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        $('#bolreferenceList').fadeIn();
                        $('#bolreferenceList').html(data);
                    }
                });
            }
        });

        $(document).on('click', '#bolreferenceList li', function(){
            $('#bolreference').val($(this).text());
            $('#bolreferenceList').fadeOut();
        });


        $(function(){

            $('.bulkEditAll').click(function() {
                var checkedStatus = this.checked;
                (checkedStatus) ?  $("#addMoneyReceipt").slideDown() : $("#addMoneyReceipt").slideUp();

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
                (totalChecked == 0) ?  $("#addMoneyReceipt").slideUp() : $("#addMoneyReceipt").slideDown();
            });

            $("#addMoneyReceipt").click(function(){
                $('#selectedContainer').submit();
            });

        });



    </script>
@endsection