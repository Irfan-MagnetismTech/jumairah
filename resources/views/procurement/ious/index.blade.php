@extends('layouts.backend-layout')
@section('title', 'IOU List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of IOU Slip
@endsection


@section('breadcrumb-button')
    <a href="{{ url('ious/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($ious) }}
    @endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>IOU No</th>
                <th>Project Name</th>
                <th>Iou For</th>
                <th>Total Amount</th>
                <th>Applied Date</th>
                <th>Applied By</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>IOU No</th>
                <th>Project Name</th>
                <th>Iou For</th>
                <th>Total Amount</th>
                <th>Applied Date</th>
                <th>Applied By</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
                @php
                    $type= ['Employee','Supplier','Construction','Eme'];
                @endphp
            @foreach($ious as $key => $iou)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ isset($iou->iou_no) ? $iou->iou_no : 'N/A' }}</td>
                    <td> {{$iou->costCenter->name}} </td>
                    <td> {{ $type[$iou->type] }}</td>
                    <td> @money($iou->total_amount)</td>
                    <td> {{$iou->applied_date}}</td>
                    <td> {{$iou->appliedBy->name}}</td>
                    @php
                        $approvals = \App\Approval\ApprovalLayerDetails::with('department')->whereHas('approvalLayer', function ($q)use($iou){
                            $q->where([['name','IOU'],['department_id',$iou->appliedBy->department_id]]);
                        })->whereDoesntHave('approvals',function ($q) use($iou){
                            $q->where('approvable_id',$iou->id)->where('approvable_type',\App\Procurement\Iou::class);
                        })->orderBy('order_by','asc')->get();

                        $TotalApproval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($iou){
                            $q->where([['name','IOU'],['department_id',$iou->appliedBy->department_id]]);
                        })->orderBy('order_by','asc')->get()->count();
                    @endphp
                    <td>
                        @if($iou->approval()->exists())
                            @foreach($iou->approval as $approval1)
                                <span class="badge @if($approval1->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                    {{ $approval1->status }} - {{$approval1->user->employee->department->name ?? ''}} - {{$approval1->user->employee->designation->name ?? ''}}
                                </span><br>
                            @endforeach
                            @if (($iou->approval->count() != $TotalApproval))
                                <span class="badge bg-warning badge-sm">Pending in {{$approvals->first()->designation->name ?? ''}} - {{$approvals->first()->department->name ?? ''}}</span>
                            @endif
                        @else
                            <span class="badge bg-warning badge-sm">Pending in {{$approvals->first()->designation->name ?? ''}} - {{$approvals->first()->department->name ?? ''}}</span>
                        @endif
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                            @php
                                $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($iou){
                                    $q->where([['name','IOU'],['department_id',$iou->appliedBy->department_id]]);
                                })->whereDoesntHave('approvals',function ($q) use($iou){
                                    $q->where('approvable_id',$iou->id)->where('approvable_type',\App\Procurement\Iou::class);
                                })->orderBy('order_by','asc')->first();
                            @endphp
                            @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                <a href="{{ url("iou/approved/$iou->id/1") }}" data-toggle="tooltip" title="Approve Iou" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                <a href="{{ url("iou/approved/$iou->id/0") }}" data-toggle="tooltip" title="Reject Iou" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
                            @endif
                            @if($iou->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                <a href="{{ url("ious/$iou->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                @if($iou->approval()->doesntExist())
                                {!! Form::open(array('url' => "ious/$iou->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                {!! Form::close() !!}
                                @endif
                            @endif()
                                <a href="{{ url("ious/$iou->id") }}" data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                <a href="{{ route("iou.pdf", $iou->id) }}" data-toggle="tooltip" title="PDF" class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></a>
                                <a href="{{ url("ious/$iou->id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a>
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
