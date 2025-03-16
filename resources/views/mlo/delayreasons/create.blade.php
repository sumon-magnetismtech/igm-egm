@extends('layouts.new-layout')

@if($formType=='edit')
    @section('title', 'Edit Delay Reason')
@else
    @section('title', 'Create Delay Reason')
@endif

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="float-left">
                    <h4 class="h2-responsive font-weight-bolder text-dark">@if($formType=='edit') Edit @else  Add New  @endif Reason</h4>
                </div>
                <div class="float-right">
                    <a href="{{ url('delayreasons') }}"> <button type="button" class="btn btn-sm btn-amber float-right"><i class="fas fa-backward fa-2x"></i></button></a>
                </div>
            </div>
        </div>

        <hr>
        @if ($errors->any())
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <ul class="my-0 py-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($formType=='edit')
            <form action="{{ route('delayreasons.update', $delayreason->id) }}" method="post" >
                @method('PUT')
                <input type="hidden" name="id" value="{{$delayreason->id}}">
        @else
            <form action="{{ route('delayreasons.store') }}" method="post">
        @endif

            @csrf
            <div class="row">
                <input type="hidden" name="mloblinformation_id" value="{{ old("mloblinformation_id") ? old("mloblinformation_id") : (!empty($blinformation) ? $blinformation->id : null) }}">

                <div class="form-group col-2">
                    <label for="bolreference" class="font-weight-bolder text-dark">Bl Reference</label>
                    <input type="text" class="form-control" id="bolreference" name="bolreference" value="{{ old("bolreference") ? old("bolreference") : (!empty($blinformation) ? $blinformation->bolreference : null) }}" readonly>
                </div>
                <div class="form-group col-4">
                    <label for="feederVessel" class="font-weight-bolder text-dark">Feeder Vessel</label>
                    <input type="text" class="form-control" id="feederVessel" name="feederVessel" value="{{ old("feederVessel") ? old("feederVessel") : (!empty($blinformation) ? $blinformation->mlofeederInformation->feederVessel : null) }}" readonly>
                </div>
                <div class="form-group col-4">
                    <label for="principal" class="font-weight-bolder text-dark">Principal Name </label>
                    <input type="text" class="form-control" id="principal" name="principal" value="{{ old("principal") ? old("principal") : (!empty($blinformation) ? $blinformation->principal->name : null) }}" readonly>
                </div>
                <div class="form-group col-2">
                    <label for="noted_date" class="font-weight-bolder text-dark">Noted On </label>
                    <input type="text" class="form-control" id="noted_date" name="noted_date" value="{{ old("noted_date") ? old("noted_date") : (!empty($delayreason) ? $delayreason->noted_date : now()->format('d/m/Y') ) }}">
                </div>
                <div class="form-group col-12">
                    <label for="reason">Reason</label>
                    <textarea class="form-control rounded-0" id="reason" rows="3" name="reason">{{ old("reason") ? old("reason") : (!empty($delayreason) ? $delayreason->reason : null) }}</textarea>
                </div>
                <div class="form-group col-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footerscripts')
    @parent
    <script>
        $(function(){
            $('#noted_date').datepicker({format: 'dd/mm/yyyy',showOtherMonths: true});
        })
    </script>
@endsection