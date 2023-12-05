@extends('layouts.backend-layout')
@section('title', 'MPR List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Material Purchase Requisition (MPR)
@endsection


@section('breadcrumb-button')
    <a href="{{ url('requisitions/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($requisitions) }}
@endsection


@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Requisition No.</th>
                    <th>Requisition For</th>
                    <th>Note</th>
                    <th>Applied Date</th>
                    <th>Material Name</th>
                    <th>Requisition By</th>
                    <th>Created at</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Requisition No.</th>
                    <th>Requisition For</th>
                    <th>Note</th>
                    <th>Applied Date</th>
                    <th>Material Name</th>
                    <th>Requisition By</th>
                    <th>Created at</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                    @php
                        $indx = 1;
                    @endphp
                @foreach ($requisitions as $key => $requisition)
                    @if (auth()->user()->project_assigned == 0 ||
                            (auth()->user()->project_assigned == 1 &&
                                in_array(
                                    $requisition->cost_center_id,
                                    auth()->user()->assignedProject->pluck('cost_center_id')->toArray())))
                     
                   
                        <tr>
                            @php
                                $po_no = count($requisition->purchase_order);
                            @endphp
                            <td>{{ $indx++ }}</td>
                            <td @if ($po_no) class="text-success" @endif> MPR -
                                {{ $requisition->mpr_no }}</td>
                            <td>
                                {{ $requisition->costCenter->name }}
                            </td>
                            <td class="breakWords text-center" width="140px"> {{ $requisition->note }}</td>
                            <td> {{ $requisition->applied_date }}</td>
                            <td>
                                @foreach ($requisition->requisitiondetails as $kk => $val)
                                    {{ $val->nestedMaterial->name }}
                                    @if (!$loop->last)
                                        <br>
                                    @endif
                                @endforeach
                            </td>
                            <td> {{ $requisition->requisitionBy->name }}</td>
                            <td> {{ $requisition->created_at }}</td>
                            @php
                                $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($requisition) {
                                                $q->where('id', $requisition->approval_layer_id);
                                            })
                                                ->whereDoesntHave('approvals', function ($q) use ($requisition) {
                                                    $q->where('approvable_id', $requisition->id)->where('approvable_type', \App\Procurement\Requisition::class);
                                                })
                                                ->orderBy('order_by', 'asc')
                                                ->first();
                            @endphp
                            <td>
                                @if ($requisition->approval()->exists())
                                    @foreach ($requisition->approval as $approval)
                                        <span
                                            class="badge @if ($approval->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                            {{ $approval->status }} -
                                            {{ $approval->user->employee->department->name ?? '' }} -
                                            {{ $approval->user->employee->designation->name ?? '' }}
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
                                            $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($requisition) {
                                                $q->where('id', $requisition->approval_layer_id);
                                            })
                                                ->whereDoesntHave('approvals', function ($q) use ($requisition) {
                                                    $q->where('approvable_id', $requisition->id)->where('approvable_type', \App\Procurement\Requisition::class);
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
                                            <a href="{{ url("requisitions/approved/$requisition->id/1") }}"
                                                data-toggle="tooltip" title="Approve Requisition" class="btn btn-success"><i
                                                    class="fa fa-check" aria-hidden="true"></i></a>
                                        @endif
                                        @if (
                                            $requisition->approval()->doesntExist() ||
                                                auth()->user()->hasAnyRole(['admin', 'super-admin']))
                                            <a href="{{ url("requisitions/$requisition->id/edit") }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning"><i
                                                    class="fas fa-pen"></i></a>
                                            @if ($requisition->approval()->doesntExist())
                                                {!! Form::open([
                                                    'url' => "requisitions/$requisition->id",
                                                    'method' => 'delete',
                                                    'class' => 'd-inline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => 'Delete',
                                                ]) !!}
                                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                                {!! Form::close() !!}
                                            @endif
                                        @endif
                                        <a href="{{ url('requisition-pdf') }}/{{ $requisition->id }}" title="PDF"
                                            class="btn btn-out-dashed btn-sm btn-success"><i
                                                class="fas fa-file-pdf"></i></a>
                                        <a href="{{ url("requisitions/$requisition->id") }}" data-toggle="tooltip"
                                            title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                        <a href="{{ url("requisitionLog/$requisition->id/log") }}" data-toggle="tooltip"
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
