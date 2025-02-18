@extends('layouts.layoutCtrack')
@section('title', 'Update Bl Container')
@section('content')

    <div class="container">
        <h2 class="h2-responsive font-weight-bolder text-dark text-center"> Update BL Container </h2>
        <p class="text-center lead"> Container Ref: <strong>{{$emptyContainer->contref}}</strong> </p>
        <hr class="my-4">

        @if ($message = Session::get('message'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-12 table-responsive text-nowrap">
                <form class="form-inline md-form form-sm mt-0 row" action="{{route('emptycontainers.update', $emptyContainer->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$emptyContainer->id}}">

                    <div class="col-lg-3">
                        <div class="md-form">
                            <select name="emptyLocation" id="emptyLocation" class="form-control w-100" required>
                                <option value="Port" selected> Port </option>
                                <option value="Depo" {{$emptyContainer->emptyLocation == 'Depo' ? 'selected' : ''}}> Depo </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4" id="emptyDepoNameArea" style="display: {{$emptyContainer->emptyLocation === 'Depo' ? 'block' : 'none'}}" >
                        <div class="md-form">
                            <input id="emptyDepoName" class="form-control w-100 date" value="{{old('emptyDepoName') ? old('emptyDepoName') : (!empty($emptyContainer->emptyDepoName) ? $emptyContainer->emptyDepoName : '')}}" type="text" name="emptyDepoName" autocomplete="off">
                            <label for="emptyDepoName"> Depo Name </label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="md-form">
                            <input id="emptyDate" class="form-control w-100 date" value="{{old('emptyDate') ? old('emptyDate') : (!empty($emptyContainer->emptyDate) ? date('d-m-Y', strtotime($emptyContainer->emptyDate)) : '')}}"  type="text" name="emptyDate" placeholder="Select Empty Date" autocomplete="off" required>
                            <label for="emptyDate"> Empty Date </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-pink">Submit</button>
                </form>
            </div> <!-- end col-12 table-responsive text-nowrap -->
        </div> <!-- end row -->
    </div>
@endsection

@section('footerscripts')
    @parent

    <script>
        $(document).ready(function () {
            $('#emptyDate').datepicker({format: 'dd-mm-yyyy',showOtherMonths: true});

            $("#emptyLocation").change(function(e){
                var location = $(this).val();
                if(location === 'Depo'){
                    $('#emptyDepoNameArea').show('slow');
                    $('#emptyDepoName').attr('required', true);
                }
                else{
                    $('#emptyDepoNameArea').hide('slow');
                    $('#emptyDepoName').removeAttr('required');
                }
            });

        });//end document ready

    </script>
@endsection
