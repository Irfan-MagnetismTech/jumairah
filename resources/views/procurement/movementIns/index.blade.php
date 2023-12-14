@extends('layouts.backend-layout')
@section('title', ' Material Movements (IN)')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of material movement (IN)
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
                    <th>MTI</th>
                    <th>MTO</th>
                    <th>Material </th>
                    <th>MTI Quantity</th>
                    <th>Damage</th>
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
                        <td> {{ $data->receive_date }}</td>
                        <td> {{ $data->mti_no }}</td>
                        <td> {{ $data->materialMovement->mto_no ?? '' }}</td>
                        <td class="text-left">
                            @foreach ($data->movementInDetails as $key => $detail)
                                {{ $detail->nestedMaterial->name ?? '' }} -
                                {{ $detail->nestedMaterial->unit->name ?? '' }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($data->movementInDetails as $key => $detail)
                                {{ $detail->mti_quantity ?? '' }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($data->movementInDetails as $key => $detail)
                                {{ $detail->damage_quantity ?? '' }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($data->movementInDetails as $key => $detail)
                                {{ $detail->remarks ?? '' }}<br>
                            @endforeach
                        </td>
                        @php
                            $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($data) {
                                $q->where([['name', 'Movement In'], ['department_id', $data->appliedBy->department_id]]);
                            })
                                ->whereDoesntHave('approvals', function ($q) use ($data) {
                                    $q->where('approvable_id', $data->id)->where('approvable_type', \App\Procurement\MovementIn::class);
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
                                    {{ $approval->designation->name ?? '' }} -
                                    {{ $approval->department->name ?? '' }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    @php
                                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($data) {
                                            $q->where([['name', 'Movement In'], ['department_id', $data->appliedBy->department_id]]);
                                        })
                                            ->whereDoesntHave('approvals', function ($q) use ($data) {
                                                $q->where('approvable_id', $data->id)->where('approvable_type', \App\Procurement\MovementIn::class);
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
                                        <a href="{{ url("movementIns/approved/$data->id/1") }}" data-toggle="tooltip"
                                            title="Approve MTI" class="btn btn-success"><i class="fa fa-check"
                                                aria-hidden="true"></i></a>
                                        <a href="{{ url("movementIns/approved/$data->id/0") }}" data-toggle="tooltip"
                                            title="Reject MTI" class="btn btn-danger"><i class="fa fa-times"
                                                aria-hidden="true"></i></a>
                                    @endif

                                    @if (
                                        $data->approval()->doesntExist() ||
                                            auth()->user()->hasAnyRole(['admin', 'super-admin']))
                                        <a href="{{ url("movement-ins/$data->id/edit") }}" data-toggle="tooltip"
                                            title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @if ($data->approval()->doesntExist())
                                            {!! Form::open([
                                                'url' => "movement-ins/$data->id",
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
                                    <a href="{{ url("movementInLog/$data->id/log") }}" data-toggle="tooltip" title="Logs"
                                        class="btn btn-dark"><i class="fas fa-history"></i></a>

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
