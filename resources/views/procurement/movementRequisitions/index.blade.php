@extends('layouts.backend-layout')
@section('title', 'MTR List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Material Transfer Requisition (MTR)
@endsection


@section('breadcrumb-button')
    <a href="{{ url('movement-requisitions/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($movement_requisitions) }}
    @endsection


    @section('content')
            <!-- put search form here.. -->

    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>MTRF No.</th>
                    <th>Transfer From</th>
                    <th>Transfer To</th>
                    <th>Applied Date</th>
                    <th>Requisition By</th>
                    <th>Created at</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>MTRF No.</th>
                    <th>Transfer From</th>
                    <th>Transfer To</th>
                    <th>Applied Date</th>
                    <th>Requisition By</th>
                    <th>Created at</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($movement_requisitions as $key => $requisition)

                <tr>
                    <td>{{$loop->iteration}} </td>
                    <td> MTRF - {{$requisition->mtrf_no}}</td>
                    <td> {{$requisition->fromCostCenter->name}} </td>
                    <td> {{$requisition->toCostCenter->name}} </td>
                    <td> {{ $requisition->delivery_date }}</td>
                    <td> {{ $requisition->user->name }}</td>
                    <td> {{ $requisition->created_at }}</td>
                    @php
                                    $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($requisition){
                                        $q->where([['name','Movement Requisition'],['department_id',$requisition->user->department_id]]);
                                    })->whereDoesntHave('approvals',function ($q) use($requisition){
                                        $q->where('approvable_id',$requisition->id)->where('approvable_type',\App\Procurement\MovementRequisition::class);
                                    })->orderBy('order_by','asc')->first();
                                @endphp
                    <td>
                        @if($requisition->approval()->exists())
                            @foreach($requisition->approval as $approval)
                                <span class="badge @if($approval->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                    {{ $approval->status }} - {{$approval->user->employee->department->name ?? ''}} - {{$approval->user->employee->designation->name ?? ''}}
                                </span><br>
                            @endforeach
                        @else
                        <span class="badge bg-warning badge-sm">Pending in {{$approval->designation->name ?? ''}} - {{$approval->department->name ?? ''}}</span>
                        @endif
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @php
                                    $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($requisition){
                                        $q->where([['name','Movement Requisition'],['department_id',$requisition->user->department_id]]);
                                    })->whereDoesntHave('approvals',function ($q) use($requisition){
                                        $q->where('approvable_id',$requisition->id)->where('approvable_type',\App\Procurement\MovementRequisition::class);
                                    })->orderBy('order_by','asc')->first();
                                @endphp
                                @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                    <a href="{{ url("movement-requisitions/approved/$requisition->id/1") }}" data-toggle="tooltip" title="Approve Requisition" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                    <a href="{{ url("movement-requisitions/approved/$requisition->id/0") }}" data-toggle="tooltip"
                                        title="Reject Requisition" class="btn btn-danger"><i class="fa fa-times"
                                            aria-hidden="true"></i></a>
                                @endif

                                @if($requisition->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                    {{-- <!-- <a href="{{ url("requisitions/$requisition->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                     --}}
                                    @if($requisition->approval()->doesntExist())
                                    {!! Form::open(array('url' => "requisitions/$requisition->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                    @endif
                                @endif

                                <a href="{{ url("movement-requisitions/$requisition->id") }}" data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>

                                <a href="{{ url("movementRequisitionLog/$requisition->id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a>

                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
{{--            {{die()}}--}}
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
