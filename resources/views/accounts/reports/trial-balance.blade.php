@extends('layouts.backend-layout')
@section('title', 'Collections Report')

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
<style>
    #tableArea {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    table,
    table th,
    table td {
        border-spacing: 0;
        border: 1px solid #a09e9e;
    }

    table th,
    table td {
        padding: 5px;
    }

    .base_header {
        font-weight: bold;
        text-align: left;
    }

    .balance_header {
        font-weight: bold;
        padding-left: 20px;
        text-align: left;
    }

    .balance_line_style {
        font-weight: bold;
        padding-left: 50px;
        text-align: left;
    }

    .account_line {
        padding-left: 80px;
        text-align: left;
    }

    .account {
        padding-left: 110px;
        text-align: left;
    }

    .child_account_style {
        padding-left: 130px;
        text-align: left;
    }

    table tbody td:nth-child(4),
    table tbody td:nth-child(3) {
        text-align: right;
    }

    .text-right {
        text-align: right;
    }

    .text-right {
        text-align: left;
    }

    .account_row {
        display: none
    }
</style>

@endsection

@section('breadcrumb-title')

@endsection

@section('breadcrumb-button')
{{-- <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
{{--Total: {{ count($projects) }}--}}
@endsection


@section('content')

<br>
<h2 class="text-center">Trial Balance</h2>
<br>
<hr>
<form action="" method="get">
    <div class="row px-2">
        <div class="col-md-1 px-1 my-1" data-toggle="tooltip" title="Output">
            <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                <option value="list" selected> List </option>
                <option value="pdf"> PDF </option>
                <option value="excel"> Excel </option>
            </select>
        </div>
        <div class="col-md-2 px-1 my-1" id="fromDateArea">
            <input type="text" id="fromDate" name="fromDate" class="form-control form-control-sm" value="{{!empty($fromDate) ? date('d-m-Y', strtotime($fromDate)) : ''}}" placeholder="From Date" autocomplete="off">
        </div>
        <div class="col-md-2 px-1 my-1" id="tillDateArea">
            <input type="text" id="tillDate" name="tillDate" class="form-control form-control-sm" value="{{!empty($tillDate) ? date('d-m-Y', strtotime($tillDate)) : ''}}" placeholder="Till Date" autocomplete="off">
        </div>
        <div class="col-md-1 px-1 my-1">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </div><!-- end row -->
</form>
<div class="table-responsive">
    <table style="width: 100%">
        <thead>
            <tr style="text-align: center; background:#227447; color: white; font-weight: bold">
                <td rowspan="2"> Particulars </td>
                <td rowspan="2"> Opening Balance </td>
                <td colspan="2"> Transactions </td>
                <td rowspan="2"> Closing Balance </td>
            </tr>
            <tr style="text-align: center; background:#227447; color: white; font-weight: bold">
                <td> Debit </td>
                <td> Credit </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($balanceIncomeHeaders as $balanceIncomeHeader)
            @php
            $previousYearLedgersHeader = $balanceIncomeHeader->descendants->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten();
            $currentYearLedgersHeader = $balanceIncomeHeader->descendants->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
            $previousYearTotalDebitHeader = $previousYearLedgersHeader->sum('dr_amount');
            $previousYearTotalCreditHeader = $previousYearLedgersHeader->sum('cr_amount');
            $currentYearTotalDebitHeader = $currentYearLedgersHeader->sum('dr_amount');
            $currentYearTotalCreditHeader = $currentYearLedgersHeader->sum('cr_amount');
            if($balanceIncomeHeader->value_type == 'D'){
            $opHeader = $previousYearTotalDebitHeader - $previousYearTotalCreditHeader;
            $OpHeaderType = $opHeader >= 0 ? 'Dr' : 'Cr';
            $ClosingHeader = $currentYearTotalDebitHeader - $currentYearTotalCreditHeader + $opHeader;
            $closingHeaderType = $ClosingHeader >= 0 ? 'Dr' : 'Cr' ;
            }else{
            $opHeader = $previousYearTotalCreditHeader - $previousYearTotalDebitHeader;
            $OpHeaderType = $opHeader >= 0 ? 'Cr' : 'Dr' ;
            $ClosingHeader = $currentYearTotalCreditHeader - $currentYearTotalDebitHeader + $opHeader;
            $closingHeaderType = $ClosingHeader >= 0 ? 'Cr' : 'Dr' ;
            }
            @endphp
            <tr style="background-color: #dbecdb ">
                <td class="balance_header">{{$balanceIncomeHeader->line_text}}</td>
                <td style="text-align: right">
                    <strong> @money(abs($opHeader)) {{$OpHeaderType}}</strong>
                </td>
                <td style="text-align: right">@money($currentYearTotalDebitHeader) </td>
                <td style="text-align: right"> @money($currentYearTotalCreditHeader) </td>
                <td style="text-align: right"> @money(abs($ClosingHeader)) {{$closingHeaderType}}</td>
            </tr>
            @foreach($balanceIncomeHeader->descendants as $balanceLine)
            @php
            $previousYearLedgersLine = $balanceLine->accounts->flatten()->pluck('previousYearLedger')->flatten();
            $currentYearLedgersLine = $balanceLine->accounts->flatten()->pluck('currentYearLedger')->flatten();
            $previousYearTotalDebitLine = $previousYearLedgersLine->sum('dr_amount');
            $previousYearTotalCreditLine = $previousYearLedgersLine->sum('cr_amount');
            $currentYearTotalDebitLine = $currentYearLedgersLine->sum('dr_amount');
            $currentYearTotalCreditLine = $currentYearLedgersLine->sum('cr_amount');

            if($balanceLine->value_type == 'D'){
            $opLine = $previousYearTotalDebitLine - $previousYearTotalCreditLine;
            $OplineType = $opLine >= 0 ? 'Dr' : 'Cr';
            $ClosingLine = $currentYearTotalDebitLine - $currentYearTotalCreditLine + $opLine;
            $ClosingLineType = $ClosingLine >= 0 ? 'Dr' : 'Cr' ;
            }else{
            $opLine = $previousYearTotalCreditLine - $previousYearTotalDebitLine;
            $OplineType = $opLine >= 0 ? 'Cr' : 'Dr' ;
            $ClosingLine = $currentYearTotalDebitLine - $currentYearTotalCreditLine + $opLine;
            $ClosingLineType = $ClosingLine >= 0 ? 'Cr' : 'Dr' ;
            }
            @endphp
            <tr style="background-color: #f0f5f5 ">
                <td class="balance_line_style balance_line" id="{{$balanceLine->id}}"> {{$balanceLine->line_text}} </td>
                <td style="text-align: right"> @money(abs($opLine)) {{$OplineType}}</td>
                <td style="text-align: right"> @money($currentYearTotalDebitLine)</td>
                <td style="text-align: right"> @money($currentYearTotalCreditLine)</td>
                <td style="text-align: right"> @money(abs($ClosingLine)) {{$ClosingLineType}}</td>
            </tr>
            @php
            $parentaccounts = $balanceLine->accounts()->whereNull('parent_account_id')->get();
            @endphp
            @foreach ($parentaccounts as $parentaccount)
            @php
            if ($parentaccount->accountChilds->pluck('accountChilds')->collapse()->isNotEmpty()){
            $parentAccountDebit = $parentaccount->accountChilds->pluck('accountChilds')->collapse()->pluck('currentYearLedger')->flatten()->sum('dr_amount');
            $parentAccountCredit = $parentaccount->accountChilds->pluck('accountChilds')->collapse()->pluck('currentYearLedger')->flatten()->sum('cr_amount');
            $parentaccountPreviousDebit = $parentaccount->accountChilds->pluck('accountChilds')->collapse()->pluck('previousYearLedger')->flatten()->sum('dr_amount');
            $parentaccountPreviousCredit = $parentaccount->accountChilds->pluck('accountChilds')->collapse()->pluck('previousYearLedger')->flatten()->sum('cr_amount');
            }elseif ($parentaccount->accountChilds()->exists()){
            $parentAccountDebit = $parentaccount->accountChilds->pluck('currentYearLedger')->flatten()->sum('dr_amount');
            $parentAccountCredit = $parentaccount->accountChilds->pluck('currentYearLedger')->flatten()->sum('cr_amount');
            $parentaccountPreviousDebit = $parentaccount->accountChilds->pluck('previousYearLedger')->flatten()->sum('dr_amount');
            $parentaccountPreviousCredit = $parentaccount->accountChilds->pluck('previousYearLedger')->flatten()->sum('cr_amount');
            }else{
            $parentAccountDebit = $parentaccount->currentYearLedger->sum('dr_amount');
            $parentAccountCredit = $parentaccount->currentYearLedger->sum('cr_amount');
            $parentaccountPreviousDebit = $parentaccount->previousYearLedger->sum('dr_amount');
            $parentaccountPreviousCredit = $parentaccount->previousYearLedger->sum('cr_amount');
            }

            if(in_array($parentaccount->account_type, [1, 5])){
            $parentAccountOP = $parentaccountPreviousDebit - $parentaccountPreviousCredit;
            $parentaccountType = ($parentAccountOP >= 0) ? "Dr" : "Cr";
            $parentAccountTotalClosing = $parentAccountDebit - $parentAccountCredit + $parentAccountOP;
            $parentAccountClosingType = ($parentAccountTotalClosing >= 0) ? "Dr" : "Cr";
            }elseif(in_array($parentaccount->account_type, [2, 4])){
            $parentAccountOP = $parentaccountPreviousCredit - $parentaccountPreviousDebit;
            $parentaccountType = ($parentAccountOP >= 0) ? "Cr" : "Dr" ;
            $parentAccountTotalClosing = $parentAccountCredit - $parentAccountDebit + $parentAccountOP;
            $parentAccountClosingType = $parentAccountTotalClosing >= 0 ? "Cr" : "Dr";
            }
            @endphp

            <tr class="account_row balance_account_{{$balanceLine->id}}">
                <td class="account_line parent_account" id="{{$parentaccount->id}}"> {{$parentaccount->account_name}} </td>
                <td style="text-align: right"> @money(abs($parentAccountOP)) {{$parentaccountType}}</td>
                <td style="text-align: right"> @money(abs($parentAccountDebit)) </td>
                {{-- <td style="text-align: right"> @money(abs($parentAccountDebit > 0 ? $parentAccountDebit : ($topParentDebit > 0 ? $topParentDebit : 0))) </td>--}}
                <td style="text-align: right"> @money(abs($parentAccountCredit)) </td>
                <td style="text-align: right"> @money(abs($parentAccountTotalClosing)) {{$parentAccountClosingType}}</td>
            </tr>
            @php
            $accounts = $balanceLine->accounts()->where('parent_account_id', $parentaccount->id)->get();
            //$accounts = $balanceLine->accounts()->where('parent_account_id', $parentaccount->id)->get();
            @endphp
            @foreach($accounts as $account)
            @php
            if ($account->accountChilds()->exists()){
            $accountDebit = $account->accountChilds->pluck('currentYearLedger')->flatten()->sum('dr_amount');
            $accountCredit = $account->accountChilds->pluck('currentYearLedger')->flatten()->sum('cr_amount');
            }else{
            $accountDebit = $account->currentYearLedger->sum('dr_amount');
            $accountCredit = $account->currentYearLedger->sum('cr_amount');
            }

            if (in_array($account->account_type, [1, 5])){
            $accountOP = $account->accountChilds()->exists() ?
            $account->accountChilds->pluck('previousYearLedger')->flatten()->sum('dr_amount') -
            $account->accountChilds->pluck('previousYearLedger')->flatten()->sum('cr_amount') :
            $account->previousYearLedger->sum('dr_amount') - $account->previousYearLedger->sum('cr_amount');
            $accountType =($accountOP >= 0) ? "Dr" : "Cr";
            $accountClosing = $accountDebit - $accountCredit + $accountOP;
            $accountClosingType = $accountClosing >= 0 ? "Dr" : "Cr";
            }elseif(in_array($account->account_type, [2, 4])){
            $accountOP = $account->accountChilds()->exists() ?
            $account->accountChilds->pluck('previousYearLedger')->flatten()->sum('cr_amount') -
            $account->accountChilds->pluck('previousYearLedger')->flatten()->sum('dr_amount') :
            $account->previousYearLedger->sum('cr_amount') - $account->previousYearLedger->sum('dr_amount');
            $accountType =($accountOP >= 0) ? "Cr" : "Dr";
            $accountClosing = $accountCredit - $accountDebit + $accountOP;
            $accountClosingType = $accountClosing >= 0 ? "Cr" : "Dr";
            }
            @endphp

            <tr class="account_row parent_account_{{$parentaccount->id}} hide_parent_account_{{$balanceLine->id}} hide_child_account_{{$balanceLine->id}}" style="background-color: #caf1f1">
                <td class="account child_account" id="{{$account->id}}"> {{$account->account_name}} </td>
                <td style="text-align: right"> @money(abs($accountOP)) {{$accountType}}</td>
                {{-- <td style="text-align: right"> @money($opLine) {{$OplineType}}</td>--}}
                <td style="text-align: right"> @money(abs($accountDebit)) </td>
                <td style="text-align: right"> @money(abs($accountCredit)) </td>
                <td style="text-align: right"> @money(abs($accountClosing)) {{$accountClosingType}}</td>
            </tr>
            @php $childAccounts = $account->where('parent_account_id', $account->id)->get(); @endphp
            @foreach($childAccounts as $childAccount)
            @php
            if (in_array($childAccount->account_type, [1, 5])){
            $childAccountOP = $childAccount->previousYearLedger->sum('dr_amount') - $childAccount->previousYearLedger->sum('cr_amount');
            $childAccountType =($childAccountOP >= 0) ? "Dr" : "Cr";
            $childAccountClosing = $childAccount->currentYearLedger->sum('dr_amount') - $childAccount->currentYearLedger->sum('cr_amount') + $childAccountOP;
            $childAccountClosingType = $childAccountClosing >= 0 ? "Dr" : "Cr";
            }elseif(in_array($childAccount->account_type, [2, 4])){
            $childAccountOP = $childAccount->previousYearLedger->sum('cr_amount') - $childAccount->previousYearLedger->sum('dr_amount');
            $childAccountType =($childAccountOP >= 0) ? "Cr" : "Dr";
            $childAccountClosing = $childAccount->currentYearLedger->sum('cr_amount') - $childAccount->currentYearLedger->sum('dr_amount') + $childAccountOP;
            $childAccountClosingType = $childAccountClosing >= 0 ? "Cr" : "Dr";
            }
            @endphp
            <tr class="account_row child_account_{{$account->id}} hide_parent_account_{{$balanceLine->id}} hide_child_account_{{$parentaccount->id}}" style="background-color: #d9e7fa">
                <td class="account child_account_style"> {{$childAccount->account_name}} </td>
                <td style="text-align: right"> @money(abs($childAccountOP)) {{$childAccountType}}</td>
                <td style="text-align: right"> @money(abs($childAccount->currentYearLedger->sum('dr_amount'))) </td>
                <td style="text-align: right"> @money(abs($childAccount->currentYearLedger->sum('cr_amount'))) </td>
                <td style="text-align: right"> @money(abs($childAccountClosing)) {{$childAccountClosingType}}</td>
            </tr>
            @endforeach
            @endforeach
            @endforeach
            @endforeach
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')
<script>
    $(function() {
        $(document).on('click', '.balance_line', function() {
            let currentLine = $(this).attr('id');
            $(".balance_account_" + currentLine).toggle();
            $(".hide_parent_account_" + currentLine).hide();
        });
        $(document).on('click', '.parent_account', function() {
            let parentAccount = $(this).attr('id');
            $(".parent_account_" + parentAccount).toggle();
            $(".hide_child_account_" + parentAccount).hide();
        });
        $(document).on('click', '.child_account', function() {
            let childAccount = $(this).attr('id');
            $(".child_account_" + childAccount).toggle();
        });
        $('#fromDate').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });
        $('#tillDate').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });
    }); //document.ready
</script>
@endsection