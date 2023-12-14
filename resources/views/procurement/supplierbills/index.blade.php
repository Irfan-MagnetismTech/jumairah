@extends('layouts.backend-layout')
@section('title', 'Supplier Bill List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of  Supplier Bill
@endsection

@section('breadcrumb-button')
    <a href="{{ url('supplierbills/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($supplierbills) }}
    @endsection

    @section('content')

            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Project Name</th>
                <th>Supplier Name</th>
                <th>Date</th>
                <th>Office Bill No</th>
                <th>Bill No</th>
                <th>Amount</th>
                <th>Applied By</th>
                <th>Purpose</th>
                <th>Status</th>
                <th>Request Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Project Name</th>
                <th>Supplier Name</th>
                <th>Date</th>
                <th>Office Bill No</th>
                <th>Bill No</th>
                <th>Amount</th>
                <th>Applied By</th>
                <th>Purpose</th>
                <th>Status</th>
                <th>Request Date</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($supplierbills as $supplierbill)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$supplierbill->costCenter->name}} </td>
                    <td>{{$supplierbill->officebilldetails->first()->supplier->name}} </td>
                    <td>{{$supplierbill->date}} </td>
                    <td>{{$supplierbill->register_serial_no}} </td>
                    <td>{{$supplierbill->billRegister->bill_no}} </td>
                    <td>{{ $supplierbill->officebilldetails[0]->amount }}</td>
                    <td>{{$supplierbill->appliedBy->name}} </td>
                    <td>{{$supplierbill->purpose}} </td>
{{--                    <td>--}}
{{--                        <span class="badge bg-warning badge-sm"> {{$supplierbill->status}} </span>--}}
{{--                    </td>--}}
{{--                    <td> <span class="badge @if($supplierbill->status == 'Accepted') bg-success @else bg-warning @endif badge-sm"> {{$supplierbill->status}} </span> </td>--}}
                    @php
                        $approval = \App\Approval\ApprovalLayerDetails::
                        whereHas('approvalLayer', function ($q)use($supplierbill){
                            $q->where([['name','Supplier Bill'],['department_id',$supplierbill->appliedBy->department_id]]);
                        })->whereDoesntHave('approvals',function ($q) use($supplierbill){
                            $q->where('approvable_id',$supplierbill->id)->where('approvable_type',\App\Procurement\Supplierbill::class);
                        })
                        ->orderBy('order_by','asc')->first();
                        @endphp
                    <td>
                        @if($supplierbill->approval()->exists())
                            @foreach($supplierbill->approval as $approval)
                                <span class="badge @if($approval->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                    {{ $approval->status }} - {{$approval->user->employee->department->name ?? ''}} - {{$approval->user->employee->designation->name ?? ''}}
                                </span><br>
                            @endforeach
                        @else
                        <span class="badge bg-warning badge-sm">Pending in {{$approval->designation->name ?? ''}} - {{$approval->department->name ?? ''}}</span>
                        @endif
                    </td>
                    <td>
                        @php
                        $approval = \App\Approval\ApprovalLayerDetails::
                        whereHas('approvalLayer', function ($q)use($supplierbill){
                            $q->where([['name','Supplier Bill'],['department_id',$supplierbill->appliedBy->department_id]]);
                        })->whereDoesntHave('approvals',function ($q) use($supplierbill){
                            $q->where('approvable_id',$supplierbill->id)->where('approvable_type',\App\Procurement\Supplierbill::class);
                        })
                        ->orderBy('order_by','asc')->first();


                        //dump($approval, auth()->user()->designation?->id)
                        @endphp

                        @if(empty($approval) && !($supplierbill->request_date))
                        {!! Form::open(array('url' => "supplierBillRequest/$supplierbill->id",'method' => 'get', 'class'=>'d-inline')) !!}
                        {{Form::text('date', old('date') ? old('date') : (!empty($supplierbill->request_date) ? $supplierbill->request_date : null),['class' => 'form-control','class' => 'date','autocomplete'=>"off","required", 'readonly'])}}
                        @elseif($supplierbill->request_date)
                        <span class="badge bg-success badge-sm">{{ 'Requested' }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
{{--                                <a href="{{ url("supplierbills/approved/$supplierbill->id/1") }}" data-toggle="tooltip" title="Approve Requisition" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>--}}
{{--                                <a href="{{ url("supplierbills/approved/$supplierbill->id/0") }}" data-toggle="tooltip" title="Reject Requisition" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>--}}
                                @if(empty($approval) && !($supplierbill->request_date))
                                {{ Form::button('<i class="ti-target"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-success btn-sm','data-toggle'=>"tooltip",'title'=>"Request"])}}
                                {!! Form::close() !!}

                                @endif


                                @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                    <a href="{{ url("supplierBillApprove/$supplierbill->id/1") }}" data-toggle="tooltip" title="Approval" class="btn btn-outline-success">Approve</a>
                                @endif

                                <a href="{{ url("supplierbills/$supplierbill->id") }}" data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                @if($supplierbill->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                    <a href="{{ url("supplierbills/$supplierbill->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    @if($supplierbill->approval()->doesntExist())
                                    {!! Form::open(array('url' => "supplierbills/$supplierbill->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                    @endif
                                @endif
                                <a href="{{ url("supplierBillLog/$supplierbill->id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a>
                                <a href="{{ route("supplierbills-pdf", $supplierbill->id) }}" data-toggle="tooltip" title="PDF" class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></a>

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
        $(document).on('click',function(){
            $('.date,.required_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            })
        })

    </script>
@endsection
