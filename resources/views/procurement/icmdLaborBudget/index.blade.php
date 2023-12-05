@extends('layouts.backend-layout')
@section('title', 'Labor Budget List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')

    List of Labor Budget
@endsection

@section('breadcrumb-button')
    <a href="{{ url('icmdLaborBudget/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($datas) }}
@endsection

@section('content')

    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Date.</th>
                    <th>Project Name</th>
                    <th>Month</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Date.</th>
                    <th>Project Name</th>
                    <th>Month</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($datas as $key => $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->date }}</td>
                        <td>{{ $data->costCenter->name }} </td>
                        <td>{{ $data->month }}</td>
                        <td>{{ $data->total_amount }}</td>
                        @php
                            $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($data){
                                $q->where([['name','MASTER ROLE'],['department_id',$data->appliedBy->department_id]]);
                            })->whereDoesntHave('approvals',function ($q) use($data){
                                $q->where('approvable_id',$data->id)->where('approvable_type',\App\Billing\IcmdLaborBudget::class);
                            })->orderBy('order_by','asc')->get();
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
                                <span class="badge bg-warning badge-sm">Pending in {{$approval->first()->designation->name ?? ''}} - {{$approval->first()->department->name ?? ''}}</span>
                            @endif
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    @php
                                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($data) {
                                            $q->where([['name', 'MASTER ROLE'], ['department_id', $data->appliedBy->department_id]]);
                                        })
                                            ->whereDoesntHave('approvals', function ($q) use ($data) {
                                                $q->where('approvable_id', $data->id)->where('approvable_type', \App\Procurement\IcmdLaborBudget::class);
                                            })
                                            ->orderBy('order_by', 'asc')
                                            ->first();
                                    @endphp
                                    @if ((!empty($approval) &&
                                        $approval->designation_id == auth()->user()->designation?->id &&
                                        $approval->department_id == auth()->user()->department_id) ||
                                        (!empty($approval) &&
                                            auth()->user()->hasAnyRole(['admin', 'super-admin'])))
                                        <a href="{{ url("icmdLaborBudget/approve/$data->id/1") }}"
                                            data-toggle="tooltip" title="Approve" class="btn btn-success"><i
                                                class="fa fa-check" aria-hidden="true"></i></a>
                                    @endif
                                    @if ($data->approval()->doesntExist() ||
                                        auth()->user()->hasAnyRole(['admin', 'super-admin']))
                                                <a href="{{ url("icmdLaborBudget/$data->id/edit") }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                            @if ($data->approval()->doesntExist())
                                                {!! Form::open([
                                                    'url' => "icmdLaborBudget/$data->id",
                                                    'method' => 'delete',
                                                    'class' => 'd-inline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => 'Delete',
                                                ]) !!}
                                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                                {!! Form::close() !!}
                                            @endif
                                    @endif
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
