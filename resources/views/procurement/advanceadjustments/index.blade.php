@extends('layouts.backend-layout')
@section('title', 'Advance Adjustment List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Advance Adjustment
@endsection


@section('breadcrumb-button')
    <a href="{{ url('advanceadjustments/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($advanceadjustments) }}
    @endsection


    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Project Name</th>
                    <th>Employee Name</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Project Name</th>
                    <th>Employee Name</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($advanceadjustments as $key => $advanceadjustment)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$advanceadjustment->costCenter->name}}</td>
                    <td>{{$advanceadjustment->user->employee->fullName ?? 'N/A'}}</td>
                    <td> {{ $advanceadjustment->date}}</td>
                    <td> @money( $advanceadjustment->grand_amount)</td>
                    <td> @money ($advanceadjustment->balance)</td>
                    {{-- <td>
                        @if($advanceadjustment->approval()->exists())
                            @foreach($advanceadjustment->approval as $approval)
                                <span class="badge @if($approval->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                    {{ $approval->status }} - {{$approval->user->employee->department->name ?? ''}} - {{$approval->user->employee->designation->name ?? ''}}
                                </span><br>
                            @endforeach
                        @else
                            <span class="badge bg-warning badge-sm">{{ 'Pending' }}</span>
                        @endif
                    </td> --}}
                    @php
                            $approvals = \App\Approval\ApprovalLayerDetails::with('department', 'approvalLayer')
                                ->whereHas('approvalLayer', function ($q) use ($advanceadjustment) {
                                    $q->where([['name', 'Advance Adjustment'], ['department_id', $advanceadjustment->user->department_id]]);
                                })
                                ->whereDoesntHave('approvals', function ($q) use ($advanceadjustment) {
                                    $q->where('approvable_id', $advanceadjustment->id)->where('approvable_type', \App\Procurement\AdvanceAdjustment::class);
                                })
                                ->orderBy('order_by', 'asc')
                                ->get();

                            $TotalApproval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($advanceadjustment) {
                                $q->where([['name', 'Advance Adjustment'], ['department_id', $advanceadjustment->user->department_id]]);
                            })
                                ->orderBy('order_by', 'asc')
                                ->get()
                                ->count();
                        @endphp

                        <td>
                            @if ($advanceadjustment->approval()->exists())
                                @foreach ($advanceadjustment->approval as $approval1)
                                    <span
                                        class="badge @if ($approval1->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                        {{ $approval1->status }} - {{ $approval1->user->employee->department->name ?? '' }}
                                        - {{ $approval1->user->employee->designation->name ?? '' }}
                                    </span><br>
                                @endforeach
                                @if ($advanceadjustment->approval->count() != $TotalApproval)
                                    <span class="badge bg-warning badge-sm">Pending in
                                        {{ $approvals->first()->designation->name ?? '' }} -
                                        {{ $approvals->first()->department->name ?? '' }}</span>
                                @endif
                            @else
                                <span class="badge bg-warning badge-sm">Pending in
                                    {{ $approvals->first()->designation->name ?? '' }} -
                                    {{ $approvals->first()->department->name ?? '' }}</span>
                            @endif
                        </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                {{-- @php
                                    $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($advanceadjustment){
                                        $q->where([['name','Advance Adjustment'],['department_id',$advanceadjustment->appliedBy->department_id]]);
                                    })->whereDoesntHave('approvals',function ($q) use($advanceadjustment){
                                        $q->where('approvable_id',$advanceadjustment->id)->where('approvable_type',\App\Procurement\AdvanceAdjustment::class);
                                    })->orderBy('order_by','asc')->first();
                                @endphp
                                @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                    <a href="{{ url("advanceadjustments/approved/$advanceadjustment->id/1") }}" data-toggle="tooltip" title="Approval" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                    <a href="{{ url("advanceadjustments/approved/$advanceadjustment->id/0") }}" data-toggle="tooltip" title="Reject" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
                                @endif
 --}}
                                @php
                                $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($advanceadjustment){
                                    $q->where([['name','Advance Adjustment'],['department_id',$advanceadjustment->appliedBy->department_id]]);
                                })->whereDoesntHave('approvals',function ($q) use($advanceadjustment){
                                    $q->where('approvable_id',$advanceadjustment->id)->where('approvable_type',\App\Procurement\AdvanceAdjustment::class);
                                })->orderBy('order_by','asc')->first();
                            @endphp
                            @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                <a href="{{ url("advanceadjustments/approved/$advanceadjustment->id/1") }}" data-toggle="tooltip" title="Approve Advance Adjustment" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                <a href="{{ url("advanceadjustments/approved/$advanceadjustment->id/0") }}" data-toggle="tooltip" title="Reject Advance Adjustment" class="btn btn-danger"><i
                                    class="fa fa-times" aria-hidden="true"></i></a>
                            @endif
                                @if($advanceadjustment->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                    <a href="{{ url("advanceadjustments/$advanceadjustment->id") }}" data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ url("advanceadjustments/$advanceadjustment->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    @if($advanceadjustment->approval()->doesntExist())
                                    {!! Form::open(array('url' => "advanceadjustments/$advanceadjustment->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                    @endif
                                @endif()
                                <a href="{{ url("advanceadjustmentsLog/$advanceadjustment->id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a>
                            </nobr>
                        </div>
                    <td>
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
