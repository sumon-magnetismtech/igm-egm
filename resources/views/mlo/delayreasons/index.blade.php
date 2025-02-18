@extends('layouts.layoutMLO')
@section('title','Delay Reasons')
@section('style')
    <style>

    </style>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="float-left">
                    <h2 class="h2-responsive font-weight-bold text-primary">List of Delay Reasons</h2>
                </div>
            </div>
        </div>

        @if (Session::has('message'))
            <div class="alert alert-success alert-block mb-0 text-center message" id="messageForUser">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <h4 class="alert-heading font-weight-bold"> {{ Session::get('message') }}  </h4>
            </div>
        @endif

        <form action="" method="GET">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                <div class="input-group md-form form-sm form-2 pl-0">
                    <input class="form-control my-0 py-1 amber-border" type="text" placeholder="Search Bl Reference" aria-label="Search" name="bolreference">
                    <div class="input-group-append">
                        <span class="input-group-text amber lighten-3" id="basic-text1">
                            <i class="fas fa-search text-grey" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="input-group md-form form-sm form-1 pl-0">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-amber btn-sm my-0 py-2"><i class="fas fa-filter"></i></button>
                    </div>
                </div>
            </div>
        </div>

        </form>

        <div class="row">
            <div class="col-12 table-responsive text-nowrap">
                <table class="table table-striped table-bordered">
                    <thead class="indigo white-text text-center">
                        <tr>
                            <th>Sl. No</th>
                            <th>BL Reference</th>
                            <th>Feeder Vessel</th>
                            <th>Principal</th>
                            <th>Reason</th>
                            <th>Noted On</th>
                            <th>Noted By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">

                    @foreach($delayreasons as $key => $delayreason)
                      <tr>
                          <td>{{ $delayreasons->firstItem()+$key }}</td>
                          <td> {{ $delayreason->mloblinformation->bolreference }}</td>
                          <td> {{ $delayreason->mloblinformation->mlofeederInformation->feederVessel }}</td>
                          <td> {{ $delayreason->mloblinformation->principal->name }}</td>
                          <td>{{$delayreason->reason}}</td>
                          <td>{{$delayreason->noted_date}}</td>
                          <td>{{$delayreason->user->name}}</td>
                          <td>
                              <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                  <a href="{{ url('delayreasons/'.$delayreason->id.'/edit') }}" data-toggle="tooltip" title="Edit">
                                      <button type="button" class="btn btn-warning btn-sm px-3"><i class="fa fa-pen"></i></button>
                                  </a>
                                  <form action="{{ url('delayreasons', [$delayreason->id]) }}" method="POST" data-toggle="tooltip" title="Delete">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-danger btn-sm delete px-3">
                                          <i class="fa fa-trash"></i>
                                      </button>
                                  </form>
                              </div>
                          </td>
                      </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            {!! $delayreasons->links() !!}
        </div>
    </div>

@endsection

@section('footerscripts')

    @parent


    <script>
        $(function(){
            $('[data-toggle=tooltip]').tooltip({container: 'body'});

        });//document.ready


    </script>


@endsection