@extends('layouts.backend-layout')
@section('title', 'BOQ - Calculation')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Work Orders
@endsection

@section('breadcrumb-button')
    <a href="{{ url('workorders/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($workorders) }}
@endsection

@section('content')

    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Work Order No</th>
                    <th>Issue Date</th>
                    <th>Project Name</th>
                    <th>Supplier Name</th>
                    <th>CS Ref No.</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Work Order No</th>
                    <th>Issue Date</th>
                    <th>Project Name</th>
                    <th>Supplier Name</th>
                    <th>CS Ref No.</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($workorders as $key => $workorder)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $workorder->workorder_no }}</td>
                        <td>{{ $workorder->issue_date }}</td>
                        <td>{{ $workorder->workCs->project->name }} </td>
                        <td>{{ $workorder->supplier->name }}</td>
                        <td>
                            <a href="{{ route('work-cs.show', $workorder->work_cs_id) }}"
                                target="_blank">{{ $workorder->workCs->reference_no }}</a>
                        </td>
                        @php
                            $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($workorder) {
                                $q->where([['name', 'WORK ORDER'], ['department_id', $workorder->appliedBy->department_id]]);
                            })
                                ->whereDoesntHave('approvals', function ($q) use ($workorder) {
                                    $q->where('approvable_id', $workorder->id)->where('approvable_type', \App\Billing\Workorder::class);
                                })
                                ->orderBy('order_by', 'asc')
                                ->get();

                            $TotalApproval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($workorder) {
                                $q->where([['name', 'WORK ORDER'], ['department_id', $workorder->appliedBy->department_id]]);
                            })
                                ->orderBy('order_by', 'asc')
                                ->get()
                                ->count();
                        @endphp
                        <td>
                            @if ($workorder->approval()->exists())
                                @foreach ($workorder->approval as $approval1)
                                    <span
                                        class="badge @if ($approval1->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                        {{ $approval1->status }} -
                                        {{ $approval1->user->employee->department->name ?? '' }} -
                                        {{ $approval1->user->employee->designation->name ?? '' }}
                                    </span><br>
                                @endforeach
                                @if ($workorder->approval->count() != $TotalApproval)
                                    <span class="badge bg-warning badge-sm">Pending in
                                        {{ $approval->first()->designation->name ?? '' }} -
                                        {{ $approval->first()->department->name ?? '' }}</span>
                                @endif
                            @else
                                <span class="badge bg-warning badge-sm">Pending in
                                    {{ $approval->first()->designation->name ?? '' }} -
                                    {{ $approval->first()->department->name ?? '' }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>

                                    @php
                                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($workorder) {
                                            $q->where([['name', 'WORK ORDER'], ['department_id', $workorder->appliedBy->department_id]]);
                                        })
                                            ->whereDoesntHave('approvals', function ($q) use ($workorder) {
                                                $q->where('approvable_id', $workorder->id)->where('approvable_type', \App\Billing\Workorder::class);
                                            })
                                            ->orderBy('order_by', 'asc')
                                            ->first();
                                    @endphp

                                    @if (
                                        (!empty($approval) &&
                                            $approval->designation_id == auth()->user()->designation?->id &&
                                            $approval->department_id == auth()->user()->department_id) ||
                                            (!empty($approval) &&
                                                auth()->user()->hasAnyRole(['admin', 'super-admin'])))
                                        <a href="{{ url("workorder/approved/$workorder->id/1") }}" data-toggle="tooltip"
                                            title="Approve" class="btn btn-success"><i class="fa fa-check"
                                                aria-hidden="true"></i></a>
                                    @endif
                                    @if (
                                        $workorder->approval()->doesntExist() ||
                                            auth()->user()->hasAnyRole(['admin', 'super-admin']))
                                        <a href="{{ url("workorders/$workorder->id/edit") }}" data-toggle="tooltip"
                                            title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        <a href="{{ route('workorder-payments', $workorder->id) }}" data-toggle="tooltip"
                                            title="Edit Payment Schedule" class="btn btn-outline-warning"><i
                                                class="fas fa-pen"></i></a>
                                        <a href="{{ route('workorder-terms', $workorder->id) }}" data-toggle="tooltip"
                                            title="Edit Terms" class="btn btn-outline-warning"><i
                                                class="fas fa-pen"></i></a>
                                        @if ($workorder->approval()->doesntExist())
                                            {!! Form::open([
                                                'url' => "workorders/$workorder->id",
                                                'method' => 'delete',
                                                'class' => 'd-inline',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Delete',
                                            ]) !!}
                                            {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                            {!! Form::close() !!}
                                        @endif
                                    @endif
                                    <a href="{{ url("workorderpdf/$workorder->id") }}" data-toggle="tooltip" title="PDF"
                                        class="btn btn-outline-primary"><i class="fas fa-file"></i></a>
                                    <a href="{{ url("workorderLog/$workorder->id/log") }}" data-toggle="tooltip"
                                        title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a>

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
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage

            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.getItem('scrl') || 0)
        };
        window.onload = init;

        $(document).ready(function() {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
        $(document).ready(function() {
            const oldcss = localStorage.getItem('sstt');
            $('#mCSB_1_container').css("top", oldcss);
            setTimeout(() => {
                const oldcss = localStorage.getItem('sstt');
                $('#mCSB_1_container').css("top", oldcss);
            }, 5000)
        })

        $(window).load(function() {
            const oldcss = localStorage.getItem('sstt');
            $('#mCSB_1_container').css("top", oldcss);
        });
        $(document).on('mousemove', function() {

            const newcss = $('#mCSB_1_container').css("top");
            localStorage.setItem("sstt", newcss);
        })
    </script>
@endsection
