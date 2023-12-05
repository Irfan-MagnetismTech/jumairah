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
Cost Center Wise Report
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
        <div class="col-md-3 px-1 my-1">
            <input type="text" id="account_name" name="account_name" class="form-control form-control-sm" value="{{request()->account_name ?? null}}" placeholder="Enter Account Name" autocomplete="off">
            <input type="hidden" id="account_id" name="account_id" class="form-control form-control-sm" value="{{request()->account_id ?? null}}">
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

@if($costCenters->isNotEmpty())
<h2 class="text-center"> {{request()->line_name ?? null}} </h2>
<div class="table-responsive">
    <table style="width: 100%">
        <thead>
            <tr style="text-align: center; background:#227447; color: white; font-weight: bold">
                <td rowspan="2"> Primary Cost Category </td>
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
            @php $opGrandTotal =0;$drGrandTotal =0;$crGrandTotal =0;$closingGrandTotal =0; @endphp
            @foreach ($costCenters as $costCenter)
            @php
            $openingBalanceType = null;
            $openingBalance = 0.00;
            $drAmount = $costCenter->ledgers->sum('dr_amount');
            $crAmount = $costCenter->ledgers->sum('cr_amount');
            $openingBalanceDr = $costCenter->openingBalances->sum('dr_amount');
            $openingBalanceCr = $costCenter->openingBalances->sum('cr_amount');
            @endphp

            <tr style="text-align: right">
                <td class="text-left"> {{$costCenter->name}} <br> </td>
                <td>
                    @if($balanceIncome->value_type == "D")
                    @php
                    $openingBalance = $costCenter->previousLedgers->sum('dr_amount') - $costCenter->previousLedgers->sum('cr_amount') + $openingBalanceDr ;
                    @endphp
                    @money(abs($openingBalance)) {{$openingBalanceType = $openingBalance >= 0 ? "Dr" : "Cr"}}
                    @endif
                    @if($balanceIncome->value_type == "C")
                    @php
                    $openingBalance = $costCenter->previousLedgers->sum('cr_amount') - $costCenter->previousLedgers->sum('dr_amount') + $openingBalanceCr ;
                    @endphp
                    @money(abs($openingBalance)) {{$openingBalanceType = $openingBalance >= 0 ? "Cr" : "Dr"}}
                    @endif
                </td>
                <td> @money(abs($drAmount)) </td>
                <td> @money(abs($crAmount)) </td>
                <td>
                    @if($openingBalanceType >= 0)
                    @php
                    $closingBalance = $openingBalance + $drAmount - $crAmount;
                    @endphp
                    @money(abs($closingBalance)) {{$closingBalance >= 0 ? "Dr" : "Cr"}}
                    @else
                    @php
                    $closingBalance = $openingBalance + $crAmount - $drAmount;
                    @endphp
                    @money(abs($closingBalance)) {{$closingBalance >= 0 ? "Dr" : "Cr"}}
                    @endif
                </td>
            </tr>

            @php
            $opGrandTotal += $openingBalance;
            $drGrandTotal += $drAmount;
            $crGrandTotal += $crAmount;
            $closingGrandTotal += $closingBalance;
            @endphp
            @endforeach
            <tr>
                <th class="text-right"> Total </th>
                <th class="text-right"> @money(abs($opGrandTotal)) </th>
                <th class="text-right"> @money(abs($drGrandTotal)) </th>
                <th class="text-right"> @money(abs($crGrandTotal)) </th>
                <th class="text-right"> @money(abs($closingGrandTotal )) </th>
            </tr>
        </tbody>
    </table>
</div>
@endif

@endsection

@section('script')
<script>
    var CSRF_TOKEN = "{{csrf_token()}}";
    $(function() {
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

        $("#project_name").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{route('costCenterAutoSuggest')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#project_name').val(ui.item.label);
                $('#project_id').val(ui.item.value);
                return false;
            }
        }).change(function() {
            if (!$(this).val()) {
                $('#project_id').val(null);
            }
        });

        $("#line_name").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{route('linesAutoSuggest')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#line_name').val(ui.item.label);
                $('#line_id').val(ui.item.value);
                return false;
            }
        }).change(function() {
            if (!$(this).val()) {
                $('#project_id').val(null);
            }
        });

        $("#account_name").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{url('api/account-name')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#account_name').val(ui.item.label);
                $('#account_id').val(ui.item.value);
                $('#line_name').val(ui.item.balance_income_line_name);
                $('#line_id').val(ui.item.balance_income_line_id);
                return false;
            }
        }).change(function() {
            if (!$(this).val()) {
                $('#account_id').val(null);
            }
        });

    }); //document.ready
</script>
@endsection