@extends('layouts.backend-layout')
@section('title', 'General Bills List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of General Bills
@endsection


@section('breadcrumb-button')
    <a href="{{ url('generalBill/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($generalBills) }}
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
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($generalBills as $key => $generalBill)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $generalBill->project->name }}</td>
                        <td>{{ $generalBill->user->employee->fullName ?? 'N/A' }}</td>
                        <td> {{ $generalBill->date }}</td>
                        <td> @money($generalBill->total_amount)</td>
                        @php
                            $approvals = \App\Approval\ApprovalLayerDetails::with('department', 'approvalLayer')
                                ->whereHas('approvalLayer', function ($q) use ($generalBill) {
                                    $q->where([['name', 'General Bill'], ['department_id', $generalBill->user->department_id]]);
                                })
                                ->whereDoesntHave('approvals', function ($q) use ($generalBill) {
                                    $q->where('approvable_id', $generalBill->id)->where('approvable_type', \App\Procurement\GeneralBill::class);
                                })
                                ->orderBy('order_by', 'asc')
                                ->get();

                            $TotalApproval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($generalBill) {
                                $q->where([['name', 'General Bill'], ['department_id', $generalBill->user->department_id]]);
                            })
                                ->orderBy('order_by', 'asc')
                                ->get()
                                ->count();
                        @endphp

                        <td>
                            @if ($generalBill->approval()->exists())
                                @foreach ($generalBill->approval as $approval1)
                                    <span
                                        class="badge @if ($approval1->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                        {{ $approval1->status }} - {{ $approval1->user->employee->department->name ?? '' }}
                                        - {{ $approval1->user->employee->designation->name ?? '' }}
                                    </span><br>
                                @endforeach
                                @if ($generalBill->approval->count() != $TotalApproval)
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
                                    @php
                                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($generalBill) {
                                            $q->where([['name', 'General Bill'], ['department_id', $generalBill->user->department_id]]);
                                        })
                                            ->whereDoesntHave('approvals', function ($q) use ($generalBill) {
                                                $q->where('approvable_id', $generalBill->id)->where('approvable_type', \App\Procurement\GeneralBill::class);
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
                                        <a href="{{ url("generalBill/approved/$generalBill->id/1") }}"
                                            data-toggle="tooltip" title="Approve Bill" class="btn btn-success"><i
                                                class="fa fa-check" aria-hidden="true"></i></a>
                                        <a href="{{ url("generalBill/approved/$generalBill->id/0") }}"
                                            data-toggle="tooltip" title="Reject Bill" class="btn btn-danger"><i
                                                class="fa fa-times" aria-hidden="true"></i></a>
                                    @endif

                                    @if (
                                        $generalBill->approval()->doesntExist() ||
                                            auth()->user()->hasAnyRole(['admin', 'super-admin']))
                                        <a href="{{ url("generalBill/$generalBill->id/edit") }}" data-toggle="tooltip"
                                            title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        {!! Form::open([
                                            'url' => "generalBill/$generalBill->id",
                                            'method' => 'delete',
                                            'class' => 'd-inline',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Delete',
                                        ]) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                        {!! Form::close() !!}
                                    @endif()

                                    <a href="{{ url("generalBill/$generalBill->id") }}" data-toggle="tooltip"
                                        title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>

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
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function() {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
