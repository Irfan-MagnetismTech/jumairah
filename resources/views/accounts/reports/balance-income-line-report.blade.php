@extends('layouts.backend-layout')
@section('title', 'Project-wise WIP')

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

    .balance_line {
        font-weight: bold;
        padding-left: 50px;
        text-align: left;
    }

    .account_line {
        padding-left: 80px;
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
</style>

@endsection

@section('breadcrumb-title')
Ledger Group Report
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
                <option value="excel"> Excel </option>
            </select>
        </div>
        <div class="col-md-3 px-1 my-1">
            <input type="text" id="line_name" name="line_name" class="form-control form-control-sm" value="{{request()->line_name ?? null}}" placeholder="Balance and Income Lines" autocomplete="off">
            <input type="hidden" id="line_id" name="line_id" class="form-control form-control-sm" value="{{request()->line_id ?? null}}">
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

@if($parentAccounts->isNotEmpty())
<h2 class="text-center"> {{request()->line_name ?? null}} </h2>
<div class="table-responsive">
    <table style="width: 100%">
        <thead>
            <tr style="text-align: center; background:#116A7B; color: white; font-weight: bold">
                <td rowspan="2"> Primary Cost Category </td>
                <td rowspan="2"> Opening Balance </td>
                <td colspan="2"> Transactions </td>
                <td rowspan="2"> Closing Balance </td>
            </tr>
            <tr style="text-align: center; background:#116A7B; color: white; font-weight: bold">
                <td> Debit </td>
                <td> Credit </td>
            </tr>
        </thead>
        <tbody>
            @php $opGrandTotal =0;$drGrandTotal =0;$crGrandTotal =0;$closingGrandTotal =0; @endphp
            @foreach ($parentAccounts as $parentAccount)
            <tr style="text-align: right">
                <td class="text-left"> {{$parentAccount->account_name}} </td>
                <td>
                    @php
                    $previousYearTotalDebit = $parentAccount->previousYearLedger->sum('dr_amount');
                    $previousYearTotalCredit = $parentAccount->previousYearLedger->sum('cr_amount');
                    $drAmount = $parentAccount->ledgers->sum('dr_amount');
                    $crAmount = $parentAccount->ledgers->sum('cr_amount');
                    $lineType = $parentAccount->balanceIncome->value_type;
                    $openingBalanceDr = $parentAccount->openingBalance->sum('dr_amount');
                    $openingBalanceCr = $parentAccount->openingBalance->sum('cr_amount');

                    if ($lineType == 'D') {
                    $OPTotal = $previousYearTotalDebit - $previousYearTotalCredit + $openingBalanceDr;
                    $opType = $OPTotal >= 0 ? 'Dr' : 'Cr';
                    $closingBalance = $drAmount - $crAmount + $OPTotal;
                    $closingType = $closingBalance >= 0 ? 'Dr' : 'Cr' ;
                    }else{
                    $OPTotal = $previousYearTotalCredit - $previousYearTotalDebit + $openingBalanceCr;
                    $opType = $OPTotal >= 0 ? 'Cr' : 'Dr';
                    $closingBalance = $crAmount - $drAmount + $OPTotal;
                    $closingType = $closingBalance >= 0 ? 'Cr' : 'Dr' ;
                    }
                    $opGrandTotal += $OPTotal;
                    $drGrandTotal += $parentAccount->ledgers->sum('dr_amount');
                    $crGrandTotal += $parentAccount->ledgers->sum('cr_amount');
                    $closingGrandTotal += $closingBalance;

                    //dump($drOPTotal);
                    @endphp
                    @money(abs($OPTotal)) {{$opType}}
                </td>
                <td> @money($parentAccount->ledgers->sum('dr_amount')) </td>
                <td> @money($parentAccount->ledgers->sum('cr_amount')) </td>
                <td> @money(abs($closingBalance)) {{$closingType}}</td>
            </tr>
            @endforeach
            <tr>
                <th> Total </th>
                <th class="text-right"> @money(abs($opGrandTotal)) </th>
                <th class="text-right"> @money(abs($drGrandTotal)) </th>
                <th class="text-right"> @money(abs($crGrandTotal)) </th>
                <th class="text-right"> @money(abs($closingGrandTotal)) </th>
            </tr>
            {{-- {{die()}} --}}
        </tbody>
    </table>
</div>
@endif

@endsection