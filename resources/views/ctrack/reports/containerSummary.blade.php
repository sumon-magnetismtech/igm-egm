@extends('layouts.new-layout')
@section('title', 'Summary Table')

@section('breadcrumb-title', "The Summary of Containers' Inventory")

@section('breadcrumb-button')
{{--    <a href="{{ route('moneyreceipts.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>--}}
@endsection

@section('sub-title')
{{--    Total: {{$moneyReceipts ? $moneyReceipts->total() : 0}}--}}
    Date: {{date('d-m-Y')}}
@endsection


@section('style')
    <style>
        table,td,th{
            border: 1px solid black;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">


        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" style="text-align: center" cellspacing="0" width="100%">
            <!--Table head-->
            <thead class="cyan lighten-3">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2" class="text-dark">MLO Name</th>
                <th class="red lighten-3 font-weight-bold" colspan="7">LADEN</th>
                <th class="font-weight-bold green lighten-3" colspan="7">EMPTY</th>
                <th class="font-weight-bold orange lighten-3" rowspan="2">Total</th>
            </tr>
            <tr>
                <th class="font-weight-bold red lighten-3">20'GP</th>
                <th class="font-weight-bold red lighten-3">40'GP</th>
                <th class="font-weight-bold red lighten-3">40'HC</th>
                <th class="font-weight-bold red lighten-3">20'FR</th>
                <th class="font-weight-bold red lighten-3">40'FR</th>
                <th class="font-weight-bold red lighten-3">20'OT</th>
                <th class="font-weight-bold red lighten-3">40'OT</th>

                <th class="font-weight-bold green lighten-3">20'GP</th>
                <th class="font-weight-bold green lighten-3">40'GP</th>
                <th class="font-weight-bold green lighten-3">40'HC</th>
                <th class="font-weight-bold green lighten-3">20'FR</th>
                <th class="font-weight-bold green lighten-3">40'FR</th>
                <th class="font-weight-bold green lighten-3">20'OT</th>
                <th class="font-weight-bold green lighten-3">40'OT</th>
            </tr>
            </thead>
            <tbody>
            @php($sum1=$sum2=$sum3=$sum4=$sum5=$sum6=$sum7=$sum8=$sum9=$sum10=$sum11=$sum12=$sum13=$sum14=$sum15=0)
            @foreach($blInformations as $key => $blInformation)
                <tr>
                    <td> {{$key+1}} </td>
                    <td class="font-weight-bold text-primary"><b> {{$blInformation->mloname}} </b></td>
                        {{--Laden--}}
                        <td class="font-weight-bold red-text lighten-3">@php($count1=\Illuminate\Support\Facades\DB::table('blcontainers')->select('blcontainers.*')->where('mloblinformation_id','=',$blInformation->id)->where('type','=',"20GP")->where('containerStatus', '=', 'laden')->count()){{$count1}}</td>
                        <td class="font-weight-bold red-text lighten-3">@php($count2=\Illuminate\Support\Facades\DB::table('blcontainers')->select('blcontainers.*')->where('mloblinformation_id','=',$blInformation->id)->where('type','=',"40GP")->where('containerStatus', '=', 'laden')->count()){{$count2}}</td>
                        <td class="font-weight-bold red-text lighten-3">@php($count3=\Illuminate\Support\Facades\DB::table('blcontainers')->select('blcontainers.*')->where('mloblinformation_id','=',$blInformation->id)->where('type','=',"40HC")->where('containerStatus', '=', 'laden')->count()){{$count3}}</td>
                        <td class="font-weight-bold red-text lighten-3">@php($count4=\Illuminate\Support\Facades\DB::table('blcontainers')->select('blcontainers.*')->where('mloblinformation_id','=',$blInformation->id)->where('type','=',"20FR")->where('containerStatus', '=', 'laden')->count()){{$count4}}</td>
                        <td class="font-weight-bold red-text lighten-3">@php($count5=\Illuminate\Support\Facades\DB::table('blcontainers')->select('blcontainers.*')->where('mloblinformation_id','=',$blInformation->id)->where('type','=',"40FR")->where('containerStatus', '=', 'laden')->count()){{$count5}}</td>
                        <td class="font-weight-bold red-text lighten-3">@php($count6=\Illuminate\Support\Facades\DB::table('blcontainers')->select('blcontainers.*')->where('mloblinformation_id','=',$blInformation->id)->where('type','=',"20OT")->where('containerStatus', '=', 'laden')->count()){{$count6}}</td>
                        <td class="font-weight-bold red-text lighten-3">@php($count7=\Illuminate\Support\Facades\DB::table('blcontainers')->select('blcontainers.*')->where('mloblinformation_id','=',$blInformation->id)->where('type','=',"40OT")->where('containerStatus', '=', 'laden')->count()){{$count7}}</td>
                        {{--//Empty --}}
                        <td class="font-weight-bold red-text lighten-3">@php($count8=\Illuminate\Support\Facades\DB::table('blcontainers')->select('blcontainers.*')->where('mloblinformation_id','=',$blInformation->id)->where('type','=',"20GP")->where('containerStatus', '=', 'empty')->count()){{$count8}}</td>
                        <td class="font-weight-bold red-text lighten-3">@php($count9=\Illuminate\Support\Facades\DB::table('blcontainers')->select('blcontainers.*')->where('mloblinformation_id','=',$blInformation->id)->where('type','=',"40GP")->where('containerStatus', '=', 'empty')->count()){{$count9}}</td>
                        <td class="font-weight-bold red-text lighten-3">@php($count10=\Illuminate\Support\Facades\DB::table('blcontainers')->select('blcontainers.*')->where('mloblinformation_id','=',$blInformation->id)->where('type','=',"40HC")->where('containerStatus', '=', 'empty')->count()){{$count10}}</td>
                        <td class="font-weight-bold red-text lighten-3">@php($count11=\Illuminate\Support\Facades\DB::table('blcontainers')->select('blcontainers.*')->where('mloblinformation_id','=',$blInformation->id)->where('type','=',"20FR")->where('containerStatus', '=', 'empty')->count()){{$count11}}</td>
                        <td class="font-weight-bold red-text lighten-3">@php($count12=\Illuminate\Support\Facades\DB::table('blcontainers')->select('blcontainers.*')->where('mloblinformation_id','=',$blInformation->id)->where('type','=',"40FR")->where('containerStatus', '=', 'empty')->count()){{$count12}}</td>
                        <td class="font-weight-bold red-text lighten-3">@php($count13=\Illuminate\Support\Facades\DB::table('blcontainers')->select('blcontainers.*')->where('mloblinformation_id','=',$blInformation->id)->where('type','=',"20OT")->where('containerStatus', '=', 'empty')->count()){{$count13}}</td>
                        <td class="font-weight-bold red-text lighten-3">@php($count14=\Illuminate\Support\Facades\DB::table('blcontainers')->select('blcontainers.*')->where('mloblinformation_id','=',$blInformation->id)->where('type','=',"40OT")->where('containerStatus', '=', 'empty')->count()){{$count14}}</td>
                        {{--Total--}}
                        <td class="font-weight-bold orange lighten-3">@php($total=$count1+$count2+$count3+$count4+$count5+$count6+$count7+$count8+$count9+$count10+$count11+$count12+$count13+$count14){{$total}}</td>
                </tr>
                @php($sum1+=$count1)
                @php($sum2+=$count2)
                @php($sum3+=$count3)
                @php($sum4+=$count4)
                @php($sum5+=$count5)
                @php($sum6+=$count6)
                @php($sum7+=$count7)
                @php($sum8+=$count8)
                @php($sum9+=$count9)
                @php($sum10+=$count10)
                @php($sum11+=$count11)
                @php($sum12+=$count12)
                @php($sum13+=$count13)
                @php($sum14+=$count14)
                @php($sum15+=$total)
            @endforeach
            </tbody>

            <tfoot class="orange lighten-3">
            <tr>
                <td colspan="2">Total: </td>
                <td class="font-weight-bold red lighten-3">{{$sum1}}</td>
                <td class="font-weight-bold red lighten-3">{{$sum2}}</td>
                <td class="font-weight-bold red lighten-3">{{$sum3}}</td>
                <td class="font-weight-bold red lighten-3">{{$sum4}}</td>
                <td class="font-weight-bold red lighten-3">{{$sum5}}</td>
                <td class="font-weight-bold red lighten-3">{{$sum6}}</td>
                <td class="font-weight-bold red lighten-3">{{$sum7}}</td>
                <td class="font-weight-bold green lighten-3">{{$sum8}}</td>
                <td class="font-weight-bold green lighten-3">{{$sum9}}</td>
                <td class="font-weight-bold green lighten-3">{{$sum10}}</td>
                <td class="font-weight-bold green lighten-3">{{$sum11}}</td>
                <td class="font-weight-bold green lighten-3">{{$sum12}}</td>
                <td class="font-weight-bold green lighten-3">{{$sum13}}</td>
                <td class="font-weight-bold green lighten-3">{{$sum14}}</td>
                <td class="font-weight-bold orange lighten-3">{{$sum15}}</td>
            </tr>
            </tfoot>
        </table>

    </div>

@endsection


