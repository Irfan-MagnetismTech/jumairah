@extends('layouts.backend-layout')
@section('title', ' Material Movements')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of material movement
@endsection


@section('breadcrumb-button')
    <a href="{{ url('materialmovements/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i
            class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($movements) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Transfer Date</th>
                    <th>MTO </th>
                    <th>MTRF </th>
                    <th>From(Location)</th>
                    <th>TO(Location)</th>
                    <th>Material</th>
                    <th>Quantity</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
                @foreach ($movements as $key => $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td> {{ $data->transfer_date }}</td>
                        <td> {{ $data->mto_no }}</td>
                        <td>
                            @foreach ($data->movementdetails as $key => $detail)
                                {{ $detail->movementRequisition->mtrf_no ?? '' }} <br>
                            @endforeach
                        </td>
                        <td> {{ $data->movementdetails[0]->movementRequisition->fromCostCenter->name }} </td>
                        <td> {{ $data->movementdetails[0]->movementRequisition->toCostCenter->name }} </td>
                        <td>
                            @foreach ($data->movementdetails as $key => $detail)
                                {{ $detail->nestedMaterial->name }} <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($data->movementdetails as $key => $detail)
                                {{ $detail->quantity }} <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($data->movementdetails as $key => $detail)
                                {{ $detail->remarks ?? '' }} <br>
                            @endforeach
                        </td>
                        @php
                            $approvals = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) {
                                $q->where('name', 'Movement Out');
                            })
                                ->whereDoesntHave('approvals', function ($q) use ($data) {
                                    $q->where('approvable_id', $data->id)->where('approvable_type', \App\Procurement\Materialmovement::class);
                                })
                                ->orderBy('order_by', 'asc')
                                ->first();
                        @endphp
                        <td>
                            @if ($data->approval()->exists())
                                @foreach ($data->approval as $approval)
                                    <span
                                        class="badge @if ($approval->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                        {{ $approval->status }} - {{ $approval->user->employee->department->name ?? '' }}
                                        - {{ $approval->user->employee->designation->name ?? '' }}
                                    </span><br>
                                @endforeach
                            @else
                                <span class="badge bg-warning badge-sm">Pending in
                                    {{ $approvals->designation->name ?? '' }} -
                                    {{ $approvals->department->name ?? '' }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    @php
                                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) {
                                            $q->where('name', 'Movement Out');
                                        })
                                            ->whereDoesntHave('approvals', function ($q) use ($data) {
                                                $q->where('approvable_id', $data->id)->where('approvable_type', \App\Procurement\Materialmovement::class);
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
                                        <a href="{{ url("materialmovment/approved/$data->id/1") }}" data-toggle="tooltip"
                                            title="Approve Requisition" class="btn btn-success"><i class="fa fa-check"
                                                aria-hidden="true"></i></a>
                                        {{-- <a href="{{ url("materialmovment/approved/$data->id/0") }}" data-toggle="tooltip"
                                            title="Reject Requisition" class="btn btn-danger"><i class="fa fa-times"
                                                aria-hidden="true"></i></a> --}}
                                    @endif
                                    @if (
                                        $data->approval()->doesntExist() ||
                                            auth()->user()->hasAnyRole(['admin', 'super-admin']))
                                        <a href="{{ url("materialmovements/$data->id/edit") }}" data-toggle="tooltip"
                                            title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @if ($data->approval()->doesntExist())
                                            {!! Form::open([
                                                'url' => "materialmovements/$data->id",
                                                'method' => 'delete',
                                                'class' => 'd-inline',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Delete',
                                            ]) !!}
                                            {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                            {!! Form::close() !!}
                                        @endif
                                    @endif
                                    <a href="{{ route('material-movements-pdf', $data->id) }}" data-toggle="tooltip"
                                        title="PDF" class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></a>
                                    <a href="{{ url("materialmovementLog/$data->id/log") }}" data-toggle="tooltip"
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
