@extends('layouts.backend-layout')
@section('title', 'Balancesheet')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
    <style>

        #tableArea{margin-top: 10px;margin-bottom: 10px;}
        table, table th, table td {border-spacing: 0;border: 1px solid #a09e9e;}
        table th, table td{padding:5px;}
        .base_header{font-weight: bold; text-align: left;}
        .balance_header{font-weight: bold; padding-left:10px; text-align: left; }
        .balance_line{ font-weight: bold; padding-left:35px; text-align: left; }
        .balance_line:hover{ background: #c5c5c5;}
        .parent_account_line{ padding-left:50px;  text-align: left; }
        .parent_account_line:hover{ background: #afecec;}
        .child_account_line{ padding-left:80px;  text-align: left; }
        .child_account_line:hover{ background: #afdcec;}
        .account_line{ padding-left:100px;  text-align: left; }
        table tbody td:nth-child(4),table tbody td:nth-child(3){
            text-align: right;
        }
        .text-right{
            text-align: right;
        }
        .text-right{
            text-align: left;
        }
        .account_row{display: none}
    </style>

@endsection

@section('breadcrumb-title')
    {{--    Breakup of Cost Center--}}
@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
    {{--Total: {{ count($projects) }}--}}
@endsection

@section('content')

    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            <div class="col-md-2 px-1 my-1" id="fromDateArea">
                <input type="text" id="fromDate" name="fromDate" class="form-control form-control-sm" value="{{!empty($fromDate) ? date('d-m-Y', strtotime($fromDate)) : date('01-m-Y',strtotime(now()))}}" placeholder="From Date" autocomplete="off">
            </div>
            <div class="col-md-2 px-1 my-1" id="tillDateArea">
                <input type="text" id="tillDate" name="tillDate" class="form-control form-control-sm" value="{{!empty($tillDate) ? date('d-m-Y', strtotime($tillDate)) : date('t-m-Y',strtotime(now()))}}" placeholder="Till Date" autocomplete="off">
            </div>
            <div class="col-md-1 px-1 my-1">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    <div>
        <h2 class="text-center">Receipt & Payment  Statement </h2>
        <hr>
        <div class="table-responsive">
            <table style="width: 100%">
                <tr>
                    <td style="vertical-align: top;" colspan="3">
                        <table style="width: 100%; ">
                            <thead style="background:#227447; color: white; font-weight: bold; font-size: 14px">
                            <tr>
                                <td colspan="3" class="base_header text-center">Receipt</td>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $bankAmount = $openingBank->sum('dr_amount') - $openingBank->sum('cr_amount');
                                $cashAmount = $openingCash->sum('dr_amount') - $openingCash->sum('cr_amount') ;
                            @endphp
                            <tr style="background-color: #dbecdb">
                                <td class="balance_header">Opening Balance</td>
                                <td></td>
                                <td><b>@money($openingAmount = $bankAmount + $cashAmount)</b></td>
                            </tr>
                            <tr >
                                <td class="balance_line" style="text-align: left">Bank Account</td>
                                <td  style="text-align: right">
                                    @money(abs($bankAmount))
                                </td>
                                <td></td>
                            </tr>
                            <tr >
                                <td class="balance_line" style="text-align: left">Cash Account</td>
                                <td  style="text-align: right">
                                    @money(abs($cashAmount))
                                </td>
                                <td></td>
                            </tr>
                            @php $receiptTotal =0 ; @endphp
                            @foreach($receipts as $key => $receipt)
                                @php
                                    $lines = \App\Accounts\BalanceAndIncomeLine::where('id',$key)->first();
                                    $receiptTotal += $receipt->flatten()->sum('cr_amount');
                                @endphp
                                <tr style="background-color: #dbecdb">
                                    <td class="balance_header" style="text-align: left">{{$lines->line_text}}</td>
                                    <td></td>
                                    <td  style="text-align: right">
                                        <b>@money($receipt->flatten()->sum('cr_amount'))</b>
                                    </td>
                                </tr>
                                @foreach($receipt as $ledger)
                                    <tr>
                                        <td class="balance_line">{{$ledger->account->account_name}}</td>
                                        <td style="text-align: right">@money($ledger->cr_amount )</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @endforeach

                            </tbody>
                            <tfoot>
                                @php
                                    $closingBank = $closingBank->sum('dr_amount') - $closingBank->sum('cr_amount');
                                    $closingCash = $closingCash->sum('dr_amount') - $closingCash->sum('cr_amount') ;
                                    $closingBankAmount = $bankAmount + $closingBank ;
                                    $closingCashAmount = $cashAmount + $closingCash ;
                                @endphp
{{--                                <tr>--}}
{{--                                    <td class="balance_header">Closing Balance</td>--}}
{{--                                    <td></td>--}}
{{--                                    <td style="text-align: right">@money($closingBankAmount + $closingCashAmount)</td>--}}
{{--                                </tr>--}}
                                @if($closingBankAmount < 0)
                                <tr style="background-color: #dbecdb">
                                    <td class="balance_header">Closing Bank Balance</td>
                                    <td></td>
                                    <td style="text-align: right">@money($closingBankAmount)</td>
                                </tr>
                                @endif
                                @if($closingCashAmount < 0)
                                <tr style="background-color: #dbecdb">
                                    <td class="balance_header">Closing Cash Balance</td>
                                    <td></td>
                                    <td style="text-align: right">@money($closingCashAmount)</td>
                                </tr>
                                @endif

                            </tfoot>
                        </table>
                    </td>
                    <td style="vertical-align: top" colspan="3">
                        <table style="width: 100%">
                            <thead style="background:#227447; color: white; font-weight: bold; font-size: 14px">
                            <tr>
                                <td colspan="3" class="base_header text-center">Payment</td>
                            </tr>
                            </thead>
                            <tbody>
                                @php $totalPaypent = 0; @endphp
                                @foreach($payments as $key => $payment)
                                    @php
                                        $lines = \App\Accounts\BalanceAndIncomeLine::where('id',$key)->first();
                                        $totalPaypent += $payment->flatten()->sum('dr_amount')
                                    @endphp
                                    <tr style="background-color: #dbecdb">
                                        <td class="balance_header" style="text-align: left">{{$lines->line_text}}</td>
                                        <td></td>
                                        <td  style="text-align: right">
                                           <b> @money($payment->flatten()->sum('dr_amount'))</b>
                                        </td>
                                    </tr>
                                    @foreach($payment as $ledger)
                                        <tr>
                                            <td class="balance_line">{{$ledger->account->account_name}}</td>
                                            <td style="text-align: right">@money($ledger->dr_amount)</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                            @if($closingBankAmount > 0)
                                <tr style="background-color: #dbecdb">
                                    <td class="balance_header">Closing Bank Account</td>
                                    <td></td>
                                    <td style="text-align: right"><b>@money($closingBankAmount)</b></td>
                                </tr>
                            @endif
                            @if($closingCashAmount > 0)
                                <tr style="background-color: #dbecdb">
                                    <td class="balance_header">Closing Cash Account</td>
                                    <td></td>
                                    <td style="text-align: right"><b>@money($closingCashAmount)</b></td>
                                </tr>
                            @endif
                            </tfoot>
                        </table>
                    </td>
                </tr>
                <tr style="background:#e3e3e3">
                    @php
                        $positiveClosingBank = $closingBankAmount < 0 ? $closingBankAmount + $openingAmount + $receiptTotal: $openingAmount + $receiptTotal;
                        $positiveClosingCash = $closingCashAmount < 0 ? $closingCashAmount + $positiveClosingBank: $positiveClosingBank ;
                        $negativeClosingBank = $closingBankAmount > 0 ? $closingBankAmount + $totalPaypent: $totalPaypent;
                        $negativeClosingCash = $closingCashAmount > 0 ? $closingCashAmount + $negativeClosingBank: $negativeClosingBank ;
                    @endphp
                    <th colspan="2" class="text-right" style="width: 60%; border-right: none"> Total </th>
                    <th class="text-right" style="border-left: none"> @money($positiveClosingCash  )
                    </th>
                    <th colspan="2" class="text-right" style="width: 60%; border-right: none">Total </th>
                    <th class="text-right" style="border-left: none">
                        @money(abs($negativeClosingCash))
                    </th>
                </tr>
            </table>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function(){
            $(document).on('click', '.balance_line', function(){
                let currentLine = $(this).attr('id');
                $(".balance_account_"+currentLine).toggle();
                $(".hide_balance_account_"+currentLine).hide();
            });
            $(document).on('click', '.parent_account_line', function(){
                let parentAccountLine = $(this).attr('id');
                $(".parent_account_"+parentAccountLine).toggle();
                $(".hide_parent_account_"+parentAccountLine).hide();
            });
            $(document).on('click', '.child_account_line', function(){
                let childAccountLine = $(this).attr('id');
                $(".account_"+childAccountLine).toggle();
            });
        });

        $('#fromDate').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true});
        $('#tillDate').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true});
    </script>
@endsection
