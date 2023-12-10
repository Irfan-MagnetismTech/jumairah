@extends('layouts.backend-layout')
@section('title', 'Sales Cancellations')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Sales Cancellations
@endsection

@section('breadcrumb-button')
    @can('saleCancellation-create')
        <a href="{{ url('saleCancellations/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i
                class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($saleCancellations) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Client</th>
                    <th>Apartment ID</th>
                    <th>Project </th>
                    <th>Sold <br> Price </th>
                    <th>Paid <br> Amount </th>
                    <th>Service <br> Charge </th>
                    <th>Deducted <br> Amount </th>
                    <th>Refund <br> Amount </th>
                    <th>Applied <br> Date </th>
                    <th>Cancelled <br> By </th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Client</th>
                    <th>Apartment ID</th>
                    <th>Project </th>
                    <th>Sold <br> Price </th>
                    <th>Paid <br> Amount </th>
                    <th>Service <br> Charge </th>
                    <th>Deducted <br> Amount </th>
                    <th>Refund <br> Amount </th>
                    <th>Applied <br> Date </th>
                    <th>Cancelled <br> By </th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($saleCancellations as $saleCancellation)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="breakWords text-left">
                            <a href="{{ route('clients.show', $saleCancellation->sell->sellClient->Client->id) }}"
                                data-toggle="tooltip" title="Check Client Profile">
                                <strong>{{ $saleCancellation->sell->sellClient->Client->name }}</strong>
                            </a><br>
                            {{ $saleCancellation->sell->sellClient->Client->contact }} <br>
                            {{ $saleCancellation->sell->sellClient->Client->email }}
                        </td>
                        <td>
                            <h6 class="m-0">
                                <a href="{{ route('sells.show', $saleCancellation->sell->id) }}" data-toggle="tooltip"
                                    title="Check Sale Information">
                                    {{ $saleCancellation->sell->apartment->name }}
                                </a>
                            </h6>
                        </td>
                        <td>
                            {{ $saleCancellation->sell->apartment->project->name }}
                        </td>

                        <td class="text-right"> @money($saleCancellation->sell->total_value) </td>
                        <td class="text-right"> @money($saleCancellation->paid_amount) </td>
                        <td> {{ $saleCancellation->service_charge }}% </td>
                        <td class="text-right"> @money($saleCancellation->deducted_amount) </td>
                        <td class="text-right"> @money($saleCancellation->refund_amount) </td>
                        <td>{{ $saleCancellation->applied_date }}</td>
                        <td>{{ $saleCancellation->user->name }}</td>
                        @php
                            $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) {
                                $q->where('name', 'Sale Cancellation');
                            })
                                ->wheredoesnthave('approvals', function ($q) use ($saleCancellation) {
                                    $q->where('approvable_id', $saleCancellation->id)->where('approvable_type', \App\Sells\SaleCancellation::class);
                                })
                                ->orderBy('order_by', 'asc')
                                ->first();
                            //dump($approval->designation_id, auth()->user()->designation->id)
                        @endphp
                        <td>
                            @if ($saleCancellation->approval()->exists())
                                @php $approvalstatus = '' @endphp
                                @foreach ($saleCancellation->approval as $approval)
                                    <span
                                        class="badge @if ($approval->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                        {{ $approvalstatus = $approval->status }} -
                                        {{ $approval->user->employee->designation->name }}
                                    </span><br>
                                @endforeach
                            @else
                                <span class="badge bg-warning badge-sm">Pending in {{ $approval->designation->name ?? '' }}
                                    - {{ $approval->department->name ?? '' }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    @php
                                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) {
                                            $q->where('name', 'Sale Cancellation');
                                        })
                                            ->wheredoesnthave('approvals', function ($q) use ($saleCancellation) {
                                                $q->where('approvable_id', $saleCancellation->id)->where('approvable_type', \App\Sells\SaleCancellation::class);
                                            })
                                            ->orderBy('order_by', 'asc')
                                            ->first();
                                        //dump($approval->designation_id, auth()->user()->designation->id)
                                    @endphp
                                    {{--                                    {{$approvalstatus}} --}}
                                    {{-- @dump($approvalstatus); --}}
                                    @if (!empty($approval) && $approval->designation_id == auth()->user()->designation?->id)
                                        {{-- @if (@$approvalstatus == 'Pending' || @$approvalstatus == 'Approved') --}}
                                            <a href="{{ url("saleCancellations/{$saleCancellation->id}/approve") }}"
                                                data-toggle="tooltip" title="Approve Request" class="btn btn-primary"><i
                                                    class="fas fa-check"></i></a>
                                        {{-- @endif --}}
                                    @endif

                                    @can('sell-view')
                                        <a href="{{ url("saleCancellations/$saleCancellation->id") }}" data-toggle="tooltip"
                                            title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    {{--                                    {{$approvalstatus}}<br> --}}
                                    @if ($saleCancellation->approval()->doesntExist())
                                        @can('sell-edit')
                                            <a href="{{ url("saleCancellations/$saleCancellation->id/edit") }}"
                                                data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                                    class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('sell-delete')
                                            {!! Form::open([
                                                'url' => "saleCancellations/$saleCancellation->id",
                                                'method' => 'delete',
                                                'class' => 'd-inline',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Delete',
                                            ]) !!}
                                            {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                        @endcan
                                    @elseif($approvalstatus == 'Rejected')
                                        @can('sell-edit')
                                            <a href="{{ url("saleCancellations/$saleCancellation->id/edit") }}"
                                                data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                                    class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('sell-delete')
                                            {!! Form::open([
                                                'url' => "saleCancellations/$saleCancellation->id",
                                                'method' => 'delete',
                                                'class' => 'd-inline',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Delete',
                                            ]) !!}
                                            {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                        @endcan
                                    @endif
                                    {!! Form::close() !!}
                                    <a href="{{ url("saleCancellations/$saleCancellation->id/log/") }}"
                                        data-toggle="tooltip" title="Log" class="btn btn-dark"><i
                                            class="fas fa-history"></i></a>
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
