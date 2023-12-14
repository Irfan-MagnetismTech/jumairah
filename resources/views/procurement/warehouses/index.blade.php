@extends('layouts.backend-layout')
@section('title', 'Warehouses')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Warehouses
@endsection


@section('breadcrumb-button')
    <a href="{{ url('warehouses/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($warehouses) }}
@endsection


    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Warehouse Name</th>
                <th>Location</th>
                <th>Contact Person</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Warehouse Name</th>
                <th>Location</th>
                <th>Contact Person</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($warehouses as $key => $warehouse)
                <tr>
                    <td>{{$key + $warehouses->firstItem()}}</td>
                    <td> {{ $warehouse->name }}</td>
                    <td> {{ $warehouse->location }}</td>
                    <td> {{ $warehouse->users->name ?? '' }}</td>
                    <td>{{ $warehouse->number ?? '' }} </td>
                    <td>  {{ $warehouse->users->email ?? '' }}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @php
                                    $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($warehouse){
                                        $q->where([['name','WAREHOUSE'],['department_id',$warehouse->appliedBy->department_id]]);
                                    })->wheredoesnthave('approvals',function ($q) use($warehouse){
                                        $q->where('approvable_id',$warehouse->id)->where('approvable_type',\App\Procurement\Warehouse::class);
                                    })->orderBy('order_by','asc')->first();
                                @endphp

                                @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                    <a href="{{ url("scrapCs/approved/$warehouse->id/1") }}" data-toggle="tooltip" title="Approve" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                @endif

                                @if($warehouse->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                     <a href="{{ url("warehouses/$warehouse->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    @if($warehouse->approval()->doesntExist())
                                        {!! Form::open(array('url' => "warehouses/$warehouse->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                        {!! Form::close() !!}
                                    @endif
                                @endif
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
