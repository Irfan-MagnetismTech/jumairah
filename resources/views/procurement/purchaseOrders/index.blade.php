@extends('layouts.backend-layout')
@section('title', 'Purchase Order List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')

    List of Purchase Orders
@endsection

@section('breadcrumb-button')
    <a href="{{ url('purchaseOrders/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($purchaseorders) }}
@endsection

@section('content')

    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>PO No.</th>
                    <th>Date</th>
                    <th>Project Name</th>
                    <th>Supplier Name</th>
                    <th>Mpr No.</th>
                    <th>CS Ref No.</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>PO No.</th>
                    <th>Date</th>
                    <th>Project Name</th>
                    <th>Supplier Name</th>
                    <th>Mpr No.</th>
                    <th>CS Ref No.</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                    @php
                        $indx = 1;
                    @endphp
                @foreach ($purchaseorders as $key => $purchaseorder)
                @if ( auth()->user()->project_assigned == 0 || (auth()->user()->project_assigned == 1 && (in_array($purchaseorder->cost_center_id, auth()->user()->assignedProject->pluck('cost_center_id')->toArray()))))
                   
                    <tr>
                        {{-- @dd(!empty($purchaseorder->material_receive)) --}}
                        <!-- <td>{{ $loop->iteration }}</td> -->
                        <td>{{ $indx++ }}</td>
                        @if ($purchaseorder->material_receive)
                            <td class="text-success">{{ $purchaseorder->po_no }}</td>
                        @else
                            <td>{{ $purchaseorder->po_no }}</td>
                        @endif
                        <td>{{ $purchaseorder->date }}</td>
                        <td>{{ $purchaseorder->mpr->costCenter->name }} </td>
                        <td>{{ $purchaseorder->supplier->name }}</td>
                        <td>
                            {{-- @dd($purchaseorder->mpr) --}}
                            @if ($purchaseorder->mpr)
                                <a
                                    href="{{ url("/requisitions/{$purchaseorder->mpr->id}") }}">MPR-{{ $purchaseorder->mpr->mpr_no }}</a>
                            @else
                                <a href="#">MPR-{{ $purchaseorder->mpr->mpr_no }}</a>
                            @endif
                        </td>
                        <td>
                            @if ($purchaseorder->cs)
                                <a
                                    href="{{ url("/comparative-statements/{$purchaseorder->cs->id}") }}">{{ $purchaseorder->cs->reference_no }}</a>
                            @else
                                <a href="#">{{ $purchaseorder->cs->reference_no }}</a>
                            @endif
                        </td>
                        @php
                        $approvals = \App\Approval\ApprovalLayerDetails::with('department', 'approvalLayer')
                            ->whereHas('approvalLayer', function ($q) use ($purchaseorder) {
                                $q->where([['name', 'Purchase Order'], ['department_id', $purchaseorder->user->department_id]]);
                            })
                            ->whereDoesntHave('approvals', function ($q) use ($purchaseorder) {
                                $q->where('approvable_id', $purchaseorder->id)->where('approvable_type', \App\Procurement\PurchaseOrder::class);
                            })
                            ->orderBy('order_by', 'asc')
                            ->get();

                        $TotalApproval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($purchaseorder) {
                            $q->where([['name', 'Purchase Order'], ['department_id', $purchaseorder->user->department_id]]);
                        })
                            ->orderBy('order_by', 'asc')
                            ->get()
                            ->count();
                    @endphp

                    <td>
                        @if ($purchaseorder->approval()->exists())
                            @foreach ($purchaseorder->approval as $approval1)
                                <span
                                    class="badge @if ($approval1->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                    {{ $approval1->status }} - {{ $approval1->user->employee->department->name ?? '' }}
                                    - {{ $approval1->user->employee->designation->name ?? '' }}
                                </span><br>
                            @endforeach
                            @if ($purchaseorder->approval->count() != $TotalApproval)
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
                                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($purchaseorder) {
                                            $q->where([['name', 'Purchase Order'], ['department_id', $purchaseorder->user->department_id]]);
                                        })
                                            ->whereDoesntHave('approvals', function ($q) use ($purchaseorder) {
                                                $q->where('approvable_id', $purchaseorder->id)->where('approvable_type', \App\Procurement\PurchaseOrder::class);
                                            })
                                            ->orderBy('order_by', 'asc')
                                            ->first();
                                    @endphp

                                    @if (
                                        ((!empty($approval) &&
                                            $approval->designation_id == auth()->user()->designation?->id &&
                                            $approval->department_id == auth()->user()->department_id)) ||
                                            ((!empty($approval) &&
                                                auth()->user()->hasAnyRole(['admin', 'super-admin']))))
                                        <a href="{{ url("purchaseOrders/approved/$purchaseorder->id/1") }}"
                                            data-toggle="tooltip" title="Approve PO" class="btn btn-success"><i
                                                class="fa fa-check" aria-hidden="true"></i></a>
                                        <!-- <a href="{{ url("purchaseOrders/approved/$purchaseorder->id/0") }}"
                                            data-toggle="tooltip" title="Reject PO" class="btn btn-danger"><i
                                                class="fa fa-times" aria-hidden="true"></i></a> -->
                                    @endif
                                    @if (
                                        $purchaseorder->approval()->doesntExist() ||
                                            auth()->user()->hasAnyRole(['admin', 'super-admin']))
                                        @can('purchase-order-create')
                                            <a href="{{ url("purchaseOrders/$purchaseorder->id/edit") }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                            @if ($purchaseorder->approval()->doesntExist())
                                                {!! Form::open([
                                                    'url' => "purchaseOrders/$purchaseorder->id",
                                                    'method' => 'delete',
                                                    'class' => 'd-inline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => 'Delete',
                                                ]) !!}
                                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                                {!! Form::close() !!}
                                            @endif
                                        @endcan
                                    @endif()
                                    <a href="{{ url("purchaseOrders/$purchaseorder->id") }}" data-toggle="tooltip"
                                        title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('purchase_order_pdf', [$purchaseorder->id, 'accounts-copy']) }}"
                                        data-toggle="tooltip" title="Account's PDF" class="btn btn-outline-primary"><i
                                            class="fas fa-file-pdf"></i></a>
                                    <a href="{{ route('purchase_order_pdf', [$purchaseorder->id, 'projects-copy']) }}"
                                        data-toggle="tooltip" title="Project's PDF" class="btn btn-outline-primary"><i
                                            class="fas fa-file-pdf"></i></a>
                                    <a href="{{ route('purchase_order_pdf', [$purchaseorder->id, 'suppliers-copy']) }}"
                                        data-toggle="tooltip" title="Supplier's PDF" class="btn btn-outline-primary"><i
                                            class="fas fa-file-pdf"></i></a>
                                    <a href="{{ url("purchaseOrderLog/$purchaseorder->id/log") }}" data-toggle="tooltip"
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
        });
    </script>

@endsection
