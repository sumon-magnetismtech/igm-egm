@extends('layouts.layout')
@section('title', 'Showing Office Name')
@section('content')

<div class="container">
    <div class="row">

        <div class="col-lg-12">

            <div class="float-left">

                <h2 class="h2-responsive font-weight-bolder text-dark">Showing Office Name</h2>

            </div>

            <div class="float-right">

                <a href="{{ url('officenames') }}"> <button type="button" class="btn btn-sm btn-amber float-right"><i class="fas fa-backward fa-2x"></i></button></a>

            </div>

        </div>

    </div>
    <hr>

    <div class="card">

        <div class="card-body">

            <ul>

                <li><strong>Office Code:</strong> {{ $officename->officecode }}</li>
                <li><strong>Office Name:</strong> {{ $officename->officename }}</li>

            </ul>


        </div>




    </div>

</div>




@endsection