@extends('layouts.backend-layout')
@section('title', 'Material Received List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Material Received Report (MRR)
@endsection


@section('breadcrumb-button')
    <a href="{{ url('materialReceives/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($receives) }}
@endsection


@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>MRR No.</th>
                    <th>PO No.</th>
                    <th>MPR No.</th>
                    <th>Project Name</th>
                    <th>Supplier Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>MRR No.</th>
                    <th>PO No.</th>
                    <th>MPR No.</th>
                    <th>Project Name</th>
                    <th>Supplier Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                    @php
                        $indx = 1;
                    @endphp
                @foreach ($receives as $key => $receive)
                    @if ( auth()->user()->project_assigned == 0 || (auth()->user()->project_assigned == 1 && (in_array($receive->cost_center_id, auth()->user()->assignedProject->pluck('cost_center_id')->toArray()))))
                        <tr>
                        <td>{{ $indx++ }}</td>
                            <td> {{ $receive->mrr_no }}</td>
                            <td>
                                <a href="{{ url("purchaseOrders/{$receive->purchaseorderForPo->id}") }}">{{ $receive->po_no }}</a>
                            </td>
                            <td>
                                @if ($receive->purchaseorderForPo->mpr)
                                <a href="{{ url("/requisitions/{$receive->purchaseorderForPo->mpr->id}") }}">{{ $receive->purchaseorderForPo->mpr->mpr_no }}</a>
                                @else
                                <a href="#">{{ $receive->purchaseorderForPo->mpr->mpr_no }}</a>
                                @endif
                            </td>
                            <td> {{ $receive->costCenters->name }} </td>
                            <td>
                                {{ $receive->purchaseorderForPo->supplier->name }}
                            </td>
                            <td> {{ $receive->date }}</td>
                            @php
                                $approvals = \App\Approval\ApprovalLayerDetails::with('department', 'approvalLayer')
                                ->whereHas('approvalLayer', function ($q) use ($receive) {
                                    $q->where([['name', 'Material Receive Report'], ['department_id', $receive->user->department_id]]);
                                })
                                ->whereDoesntHave('approvals', function ($q) use ($receive) {
                                    $q->where('approvable_id', $receive->id)->where('approvable_type', \App\Procurement\MaterialReceive::class);
                                })
                                ->orderBy('order_by', 'asc')
                                ->get();
                            @endphp
                            <td>
                                @if ($receive->approval()->exists())
                                    @foreach ($receive->approval as $approval)
                                        <span
                                            class="badge @if ($approval->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                            {{ $approval->status }} - {{ $approval->user->employee->department->name ?? '' }}
                                            - {{ $approval->user->employee->designation->name ?? '' }}
                                        </span><br>
                                    @endforeach
                                @else
                                    {{-- <span class="badge bg-warning badge-sm">{{ 'Pending' }}</span> --}}
                                    <span class="badge bg-warning badge-sm">Pending in
                                        {{ $approvals->first()->designation->name ?? '' }} -
                                        {{ $approvals->first()->department->name ?? '' }}
                                    </span>
                                @endif
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @php
                                            $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($receive) {
                                                $q->where('name', 'Material Receive Report')->where('department_id', $receive->appliedBy->department_id);
                                            })
                                                ->whereDoesntHave('approvals', function ($q) use ($receive) {
                                                    $q->where('approvable_id', $receive->id)->where('approvable_type', \App\Procurement\MaterialReceive::class);
                                                })
                                                ->orderBy('order_by', 'asc')
                                                ->first();
                                        @endphp
                                        @if ((!empty($approval) &&
                                            $approval->designation_id == auth()->user()->designation?->id &&
                                            $approval->department_id == auth()->user()->department_id) ||
                                            (!empty($approval) &&
                                                auth()->user()->hasAnyRole(['admin', 'super-admin'])))
                                            <a href="{{ url("material-receive-approve/$receive->id/1") }}"
                                                data-toggle="tooltip" title="Approve" class="btn btn-success approve"><i
                                                    class="fa fa-check" aria-hidden="true"></i></a>
                                        @endif
                                        @if ($receive->approval()->doesntExist() ||
                                            auth()->user()->hasAnyRole(['admin', 'super-admin']))
                                            <a href="{{ url("materialReceives/$receive->id/edit") }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                            @if ($receive->approval()->doesntExist())
                                                {!! Form::open([
                                                    'url' => "materialReceives/$receive->id",
                                                    'method' => 'delete',
                                                    'class' => 'd-inline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => 'Delete',
                                                ]) !!}
                                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                                {!! Form::close() !!}
                                            @endif
                                        @endif()
                                        <a href="{{ url("materialReceives/$receive->id") }}" data-toggle="tooltip"
                                            title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                        <a href="{{ url("materialReceiveLog/$receive->id/log") }}" data-toggle="tooltip"
                                            title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a>
                                    </nobr>
                                </div>
                            </td>
                        </tr>
                    @endif
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
            $('.approve').on('click', function() {
                $(this).addClass('disabled');
            })
        });
    </script>
@endsection
