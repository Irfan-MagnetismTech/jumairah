@extends('layouts.backend-layout')
@section('title', 'vouchers')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of vouchers
@endsection


@section('breadcrumb-button')
    <a href="{{ route('vouchers.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($transactions) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Cost Center</th>
                    <th>Voucher Type</th>
                    <th>Account Head</th>
                    <th>Bill / MR</th>
                    <th>Debit Amount</th>
                    <th>Credit Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Cost Center</th>
                    <th>Voucher Type</th>
                    <th>Account Head</th>
                    <th>Bill / MR</th>
                    <th>Debit Amount</th>
                    <th>Credit Amount</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($transactions as $key => $data)
                    {{--            @php($rows = $data->ledgerEntries->count()) --}}
                    {{--                @foreach ($data->ledgerEntries as $ledgerEntry) --}}
                    <tr>
                        {{--                        @if ($loop->first) --}}
                        <td rowspan="">{{ 1 + $key }}</td>
                        <td rowspan="">
                            {{ $data->transaction_date ? date('d-m-Y', strtotime($data->transaction_date)) : null }}</td>
                        <td rowspan="">
                            @foreach ($data->ledgerEntries as $ledgerEntry)
                                {{ $ledgerEntry->costCenter->name ?? '' }} 
                                <br>
                            @endforeach
                        </td>
                        <td rowspan=""> {{ $data->voucher_type }}</td>
                        {{--                        @endif --}}
                        <td class="text-left">
                            @foreach ($data->ledgerEntries as $ledgerEntry)
                                @php($id = $ledgerEntry->account->id ?? '')
                                <a href="{{ url('ledgers?account_id=' . $id) }}"
                                    target="blank">{{ $ledgerEntry->account->account_name ?? '' }}
                                    <span style="color: black">
                                        {{ $ledgerEntry->pourpose ? '- ( ' . $ledgerEntry->pourpose . ' )' : '' }} </span>
                                </a>
                                <br>
                            @endforeach
                        </td>
                        <td>{{ $data->voucher_type == 'Receipt' ? $data->mr_no : $data->bill_no }} </td>
                        <td class="text-right">
                            @foreach ($data->ledgerEntries as $ledgerEntry)
                                @if ($ledgerEntry->dr_amount)
                                    @money($ledgerEntry->dr_amount)
                                @endif <br>
                            @endforeach
                        </td>
                        <td class="text-right">
                            @foreach ($data->ledgerEntries as $ledgerEntry)
                                @if ($ledgerEntry->cr_amount)
                                    @money($ledgerEntry->cr_amount)
                                @endif <br>
                            @endforeach
                        </td>
                        {{--                        @if ($loop->first) --}}
                        <td rowspan="">
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('vouchers.show', $data->id) }}" data-toggle="tooltip" title="View"
                                        class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('vouchers.edit', $data->id) }}" data-toggle="tooltip" title="Edit"
                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open([
                                        'url' => "accounts/vouchers/$data->id",
                                        'method' => 'delete',
                                        'class' => 'd-inline',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Delete',
                                    ]) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                    {!! Form::close() !!}
                                </nobr>
                            </div>
                        </td>
                        {{--                        @endif --}}
                    </tr>
                    {{--                @endforeach --}}
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
