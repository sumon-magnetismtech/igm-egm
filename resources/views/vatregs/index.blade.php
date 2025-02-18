@extends('layouts.new-layout')
@section('title', 'List of Vat Regs')

@section('breadcrumb-title', 'List of Vat Regs')

@section('breadcrumb-button')
    @can('vatreg-create')
    <a href="{{ route('vatregs.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total : {{ $vatregs->total() }}
@endsection

@section('content')
    <form action="" method="get">
        <div class="row">
            <div class="col-md-3 pr-md-1 my-1 my-md-0">
                <input type="text" name="bin" class="form-control form-control-sm" placeholder="Search BIN" autocomplete="off">
            </div>
            <div class="col-md-3 px-md-1 my-1 my-md-0">
                <input  type="text" name="name" class="form-control form-control-sm" placeholder="Search Name" autocomplete="off">
            </div>

            <div class="col-md-1 pl-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end form row -->
    </form>
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Sl. No</th>
                <th>BIN</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl. No</th>
                <th>BIN</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($vatregs as $key => $vatreg)
                <tr>
                    <td>{{$key + $vatregs->firstItem()}}</td>
                    <td> {{ $vatreg->BIN }}</td>
                    <td> {{ $vatreg->NAME }}</td>
                    <td> {{ $vatreg->EMAIL }}</td>
                    <td style="text-align:left; white-space: normal"> {{ $vatreg->ADD1 }}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @can('vatreg-edit')
                                <a href="{{ route('vatregs.edit',$vatreg->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="float-right">
        {!! $vatregs->links() !!}
    </div>
@endsection