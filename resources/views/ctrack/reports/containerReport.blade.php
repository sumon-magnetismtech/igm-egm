@extends('layouts.new-layout')
@section('title', 'C-Track Container Report')

@section('breadcrumb-title', "Container Report")

@section('breadcrumb-button')
{{--    <a href="{{ route('moneyreceipts.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>--}}
@endsection

@section('sub-title')
    {{--    Total: {{$moneyReceipts ? $moneyReceipts->total() : 0}}--}}
@endsection


@section('content')

    <form action="{{ route('containerReport')}}" method="get">
        @csrf
        <div class="row">
            <div class="col-md-2 px-md-1 my-1 my-md-0">
                <select name="searchType" id="searchType" class="form-control form-control-sm">
                    <option value="all" selected> All </option>
                    <option value="laden" {{$searchType =='laden' ? 'selected' : ''}}> Laden </option>
                    <option value="empty" {{$searchType =='empty' ? 'selected' : ''}}> Empty </option>
                    <option value="mlo" {{$searchType =='mlo' ? 'selected' : ''}}> Mlo </option>
                </select>
            </div>
            <div class="col-md-2 px-md-1 my-1 my-md-0" id="mloNameArea" style="display:{{$searchType!='all' ? "block" : 'none'}}">
                <input name="mloName" autocomplete="off" id="mloName" list="mloNames" class="form-control form-control-sm" placeholder="Enter Mlo Name" value="{{!empty($selectedMloName) ? $selectedMloName : ''}}">
                <datalist id="mloNames">
                    @foreach($mloNames as $mloName)
                        <option value="{{$mloName}}"> {{$mloName}} </option>
                    @endforeach
                </datalist>
            </div>
            <div class="col-md-1 pl-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        @if($containerList)
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th> # </th>
                        <th> Cont No </th>
                        <th> Type </th>
                        <th> Mlo Name </th>
                        <th> Import Vessel Name </th>
                        <th> Rotation No </th>
                        <th> Cld Date </th>
                        <th> Status </th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($containerList as $key => $container)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td> {{$container->contref}}</td>
                            <td> {{$container->type}} </td>
                            <td> {{$container->mloblinformation->mloname}}</td>
                            <td> {{$container->mloblinformation->mlofeederInformation->feederVessel}} </td>
                            <td> {{$container->mloblinformation->mlofeederInformation->rotationNo}} </td>
                            <td> {{$container->mloblinformation->mlofeederInformation->berthingDate ? date('d-m-Y', strtotime($container->mloblinformation->mlofeederInformation->berthingDate)) : ''}} </td>
                            <td> {{count($container->emptyContainers) > 0 ? "Empty" : "Laden"}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        @else
        <div class="col-md-12">
            <p class="bg-light py-3 text-center lead"> <strong> No DO Found based on the date/date range.  </strong> </p>
        </div>
        @endif
    </div> <!-- end row -->
@endsection

@section('script')
    @parent
    <script>
        $(function(){
            $("#searchType").change(function(){
                let type = $(this).val();
                $("#mloName").val('');
                if(type === 'mlo' || type === 'empty' || type === 'laden'){
                    $("#mloNameArea").fadeIn(100);
                }else{
                    $("#mloNameArea").fadeOut(100);
                }
            });
        });

    </script>
@endsection
