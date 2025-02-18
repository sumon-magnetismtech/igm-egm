@extends('layouts.layoutMLO')
@section('title','List of Deleted Master BLs')
@section('content')

    <div class="container">

        <div class="row">

            <div class="col-lg-12">

                <div class="float-left">

                    <h2 class="h2-responsive font-weight-bold text-primary">List of Deleted Master BLs</h2>

                </div>

                <div class="float-right">

                    <a href="{{ url('masterbls') }}"> <button type="button" class="btn btn-sm btn-amber float-right"><i class="fas fa-backward fa-1x"></i></button></a>

                </div>

            </div>

        </div>


        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif


        <div class="row">

            <div class="col-12">


                <table id="dtHorizontalVerticalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">

                    <thead class="indigo white-text text-center">

                    <tr>
                        <th>Sl. No</th>
                        <th>IGM No </th>
                        <th>NOC</th>
                        <th>Custom Office</th>
                        <th>Master B/L No</th>
                        <th>BOL Nature</th>
                        <th>BOL Type</th>
                        <th>Feeder Vessel</th>
                        <th>Voyage</th>
                        <th>Principal</th>
                        <th>Place of Origin</th>
                        <th>Place of Unloading</th>
                        <th>Carrier Name</th>
                        <th>Carrier Address</th>
                        <th>Depot</th>
                        <th>Rotation</th>
                        <th>Mother Vessel Name</th>
                        <th>Free Time</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                        <th>Berthing</th>
                        <th>MLO</th>
                        <th>MLO Address</th>
                        <th>Action</th>
                    </tr>

                    </thead>

                    @php
                        $i = 0;
                    @endphp


                    <tbody class="text-center">

                    @foreach($masterbls as $masterbl)

                        <tr>


                            <td>{{++$i}}</td>
                            <td>{{$masterbl->id}}</td>
                            <td>{{$masterbl->noc}}</td>
                            <td>{{$masterbl->cofficecode}} {{$masterbl->cofficename}}</td>
                            <td>{{$masterbl->mblno}}</td>
                            <td>{{$masterbl->blnaturecode}} {{$masterbl->blnaturetype}}</td>
                            <td>{{$masterbl->bltypecode}} {{$masterbl->bltypename}}</td>
                            <td>{{$masterbl->fvessel}}</td>
                            <td>{{$masterbl->voyage}}</td>
                            <td>{{$masterbl->principal}}</td>
                            <td>{{$masterbl->poname}} {{$masterbl->pocode}}</td>
                            <td>{{$masterbl->puname}} {{$masterbl->pucode}}</td>
                            <td>{{$masterbl->carrier}}</td>
                            <td>{{$masterbl->carrieraddress}}</td>
                            <td>{{$masterbl->depot}}</td>
                            <td>{{$masterbl->rotation}}</td>
                            <td>{{$masterbl->mv}}</td>
                            <td>{{$masterbl->freetime}}</td>
                            <td>{{$masterbl->departure->format('d/m/Y')}}</td>
                            <td>{{$masterbl->arrival->format('d/m/Y')}}</td>
                            <td>{{$masterbl->berthing->format('d/m/Y')}}</td>
                            <td>{{$masterbl->mlocode}} {{$masterbl->mloname}}</td>
                            <td>{{$masterbl->mloaddress}}</td>
                            <td>

                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                    <a href="{{ route('mblrestore', $masterbl->id) }}"> <button type="button" class="btn btn-success btn-sm">Restore</button></a>
                                    <form action="{{ url('masterbls', [$masterbl->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>






                            </td>

                        </tr>

                    @endforeach


                    </tbody>

                </table>

            </div>

        </div>


    </div>









@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#dtHorizontalVerticalExample').DataTable({
                "scrollX": true,
                "scrollY": 200,
            });
            $('.dataTables_length').addClass('bs-select');
        });

    </script>
@endsection
