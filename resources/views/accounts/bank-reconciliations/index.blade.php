@extends('layouts.backend-layout')
@section('title', 'vouchers')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Receipt and Payment
@endsection


@section('breadcrumb-button')
    <a href="{{ route('bank-reconciliations-pdf') }}" class="btn btn-out-dashed btn-sm btn-danger"><i
            class="fa fa-file-pdf"></i></a>
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
                    <th>V. Date</th>
                    <th> Type</th>
                    <th>Account Head</th>
                    <th>Bill/MR</th>
                    <th>Cheque Type</th>
                    <th>Cheque Number</th>
                    <th>Cheque Date</th>
                    <th>T. Date</th>
                    <th>Debit Amount</th>
                    <th>Credit Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>V. Date</th>
                    <th> Type</th>
                    <th>Account Head</th>
                    <th>Bill/MR</th>
                    <th>Cheque Type</th>
                    <th>Cheque Number</th>
                    <th>Cheque Date</th>
                    <th>T. Date</th>
                    <th>Debit Amount</th>
                    <th>Credit Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($transactions as $key => $data)
                    <tr>
                        <td>{{ 1 + $key }}</td>
                        <td> {{ $data->transaction_date ? date('d-m-Y', strtotime($data->transaction_date)) : null }}</td>
                        <td> {{ $data->voucher_type }}</td>
                        <td class="text-left" style="word-wrap: break-word!important;">
                            @foreach ($data->ledgerEntries as $ledgerEntry)
                                @if ($ledgerEntry->account->balance_and_income_line_id != 8)
                                    <a href="{{ url('ledgers?account_id=' . $ledgerEntry->account->id) }}"
                                        target="blank">{{ $ledgerEntry->account->account_name }}
                                        <br>
                                        <span style="color: black">
                                            {{ $ledgerEntry->pourpose ? ' ( ' . $ledgerEntry->pourpose . ' )' : '' }}
                                        </span></a>
                                    <br>
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $data->bill_no }}</td>
                        <td>{{ $data->cheque_type }}</td>
                        <td>{{ $data->cheque_number }}</td>
                        <td>{{ $data->cheque_date }}</td>
                        {!! Form::open(['url' => 'accounts/bank-reconciliations', 'method' => 'post']) !!}
                        <td>
                            @if (!empty($data->bankReconciliation))
                                @if ($data->bankReconciliation->status == 'Complete')
                                    {{ $data->bankReconciliation->date }}
                                @endif
                            @else
                                <input type="text" name="date" class="trans_date"
                                    value="{{ date('d-m-Y', strtotime(now())) }}" style="width: 70px">
                            @endif
                            <input type="hidden" name="transaction_id" class="transaction_id" value="{{ $data->id }}">
                        </td>
                        <td class="text-right">
                            @foreach ($data->ledgerEntries as $ledgerEntry)
                                @if ($ledgerEntry->account->balance_and_income_line_id == 8)
                                    @if ($ledgerEntry->dr_amount)
                                        @money($ledgerEntry->dr_amount)
                                    @endif <br>
                                @endif
                            @endforeach
                        </td>
                        <td class="text-right">
                            @foreach ($data->ledgerEntries as $ledgerEntry)
                                @if ($ledgerEntry->account->balance_and_income_line_id == 8)
                                    @if ($ledgerEntry->cr_amount)
                                        @money($ledgerEntry->cr_amount)
                                    @endif <br>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <div class="icon-btn">
                                @if (!empty($data->bankReconciliation))
                                    @if ($data->bankReconciliation->status == 'Complete')
                                        <span class="badge bg-success badge-sm"> {{ $data->bankReconciliation->status }}
                                        </span>
                                    @endif
                                @else
                                    <span class="badge bg-warning badge-sm"> Pending</span>
                                @endif
                            </div>
                        </td>

                        {{--                        @if ($loop->first) --}}
                        <td rowspan="">
                            <div class="icon-btn">
                                <nobr>
                                    @if (empty($data->bankReconciliation))
                                        <button type="submit" data-toggle="tooltip" title="Posting"
                                            class="btn btn-outline-warning"><i class="fas fa-check"></i></button>
                                    @endif
                                    {!! Form::close() !!}
                                    {{-- <button type="button" class="btn btn-default modalShow" data-toggle="modal"
                                        data-target="" onclick="modalShow()">Static</button> --}}
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


        <div class="modal fade" id="dateModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Modal title</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Static Modal</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing lorem impus dolorsit.onsectetur adipiscing</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary waves-effect waves-light ">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

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

            $(document).on('click', ".modalShow", function() {
                let transactionId = $(this).closest('tr').find('.trans_id').val();
                alert(transactionId);
                // $('#dateModal').modal('show');
            });
        });
        $(function() {
            $('.trans_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        })
    </script>
@endsection
