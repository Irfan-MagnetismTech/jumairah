@extends('layouts.backend-layout')
@section('title', 'Fixed Asset')

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

    .account_row {
        display: none
    }
</style>

@endsection

@section('breadcrumb-title')
Fixed Asset Statement
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
        <div class="col-md-2 px-1 my-1" id="fromDateArea">
            <input type="month" id="month" name="month" class="form-control form-control-sm" value="{{!empty($request->month) ? date('Y-m', strtotime($request->month)): ''}}" placeholder="From Date" autocomplete="off">
        </div>
        <div class="col-md-2 px-1 my-1" id="fromDateArea">
            <input type="text" id="fromDate" name="fromDate" class="form-control form-control-sm" value="{{!empty($request->fromDate) ? date('d-m-Y', strtotime($request->fromDate)) : ''}}" placeholder="From Date" autocomplete="off">
        </div>
        <div class="col-md-2 px-1 my-1" id="tillDateArea">
            <input type="text" id="tillDate" name="toDate" class="form-control form-control-sm" value="{{!empty($request->toDate) ? date('d-m-Y', strtotime($request->toDate)) : ''}}" placeholder="Till Date" autocomplete="off">
        </div>
        <div class="col-md-1 px-1 my-1">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </div><!-- end row -->
</form>
<br>

{{-- <h2 class="text-center">Cost Center: {{$request->project_name ?? $request->project_name}}</h2>--}}
<div class="table-responsive">
    <table style="width: 100%">
        <thead>
            <tr style="text-align: center; background:#227447; color: white; font-weight: bold">
                <td rowspan="2"> Particulars </td>
                <td rowspan="" colspan="2"> Voucher Ref. </td>
                <td rowspan="2"> Dep Rate </td>
                <td rowspan="2"> Depreciation <br> Calculation <br> Month </td>
                <td rowspan="" colspan="4"> Cost </td>
                <td rowspan="" colspan="4"> Depreciation </td>
                <td rowspan="2"> WDV </td>
            </tr>
            <tr style="text-align: center; background:#227447; color: white; font-weight: bold">
                <td> No </td>
                <td> Date </td>
                <td> Opening </td>
                <td> Addition </td>
                <td> Deletion </td>
                <td> Closing </td>

                <td> Opening </td>
                <td> Addition </td>
                <td> Deletion </td>
                <td> Closing </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($fixedAssets as $key => $fixedAsset)
            {{-- {{dd($fixedAsset)}}--}}
            {{-- @php $fixedAssetAccount = $fixedAsset->asset->account()->where('balance_and_income_line_id',86)->first() @endphp--}}
            <tr>
                <td class="text-left">{{$fixedAsset->tag}}</td>
                <td> {{$fixedAsset->transaction->id}}</td>
                <td>{{$fixedAsset->transaction->transaction_date}}</td>
                <td class="text-center">{{$fixedAsset->percentage}} </td>
                <td></td>
                <td class="text-right"> @money($openingCost = $fixedAsset->previousTransection->ledgerEntries->flatten()->sum('dr_amount'))</td>
                <td class="text-right">@money($additionCost = $fixedAsset->transaction->ledgerEntries->flatten()->sum('dr_amount'))</td>
                <td class="text-right"></td>
                <td class="text-right">@money($closingCost = $openingCost + $additionCost)</td>
                <td class="text-right">@money($openingDepreciation = $fixedAsset->previousMonth->sum('amount'))</td>
                <td class="text-right"> @money($additionalDepreciation = $fixedAsset->depreciationDetails->sum('amount')) </td>
                <td class="text-right"></td>
                <td class="text-right">@money($closingDep = $openingDepreciation + $additionalDepreciation)</td>
                <td class="text-right">@money($closingCost - $closingDep)</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('script')

@endsection