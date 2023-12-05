@extends('layouts.backend-layout')
@section('title', 'Profit & Loss')

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
        padding-left: 10px;
        text-align: left;
    }

    .balance_line {
        font-weight: bold;
        padding-left: 25px;
        text-align: left;
    }

    .balance_line:hover {
        background: #c5c5c5;
    }

    .account_line {
        padding-left: 50px;
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
{{-- Breakup of Cost Center--}}
@endsection

@section('breadcrumb-button')
{{-- <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
{{--Total: {{ count($projects) }}--}}
@endsection


@section('content')
<div>
    <h2 class="text-center">Profit & Loss ({{date('Y', strtotime(now()))}})</h2>
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
                {{ Form::text('year', old('year') ? old('year') : (!empty(request()->year) ? request()->year : now()->format('Y')), ['class' => 'form-control form-control-sm', 'id' => 'applied_date', 'autocomplete' => 'off', 'required', 'placeholder' => 'Date', 'readonly']) }}
            </div>
            <div class="col-md-1 px-1 my-1">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>
    @php
    $directExpenseLedgers = $directExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
    $totalDirectExpense = $directExpenseLedgers->sum('dr_amount') - $directExpenseLedgers->sum('cr_amount');

    $expenseServiceLedgers = $directExpServices->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
    $totalExpenseService = $expenseServiceLedgers->sum('dr_amount') - $expenseServiceLedgers->sum('cr_amount');

    $incomeServiceLedgers = $directIncomeServices->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
    $totalIncomeService = $incomeServiceLedgers->sum('cr_amount') - $incomeServiceLedgers->sum('dr_amount');

    $indirectExpenseLedgers = $indirectExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
    $totalIndirectExpense = abs($indirectExpenseLedgers->sum('dr_amount') - $indirectExpenseLedgers->sum('cr_amount'));

    // dd($totalIndirectExpense);

    $directIncomeLedgers = $directIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
    $totalDirectIncome = $directIncomeLedgers->sum('cr_amount') - $directIncomeLedgers->sum('dr_amount');

    $indirectIncomesLedgers = $indirectIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
    $totalIndirectIncome = $indirectIncomesLedgers->sum('cr_amount') - $indirectIncomesLedgers->sum('dr_amount');

    // @dd($totalDirectIncome, $totalIncomeService, $totalDirectExpense , $totalExpenseService);
    $grossProfitSale = ($totalDirectIncome - $totalIncomeService) -( $totalDirectExpense - $totalExpenseService);
    $grossProfitService = $totalIncomeService- $totalExpenseService;
    $grossProfit = $totalDirectIncome - $totalIndirectExpense;
    $totalGrossProfit = $grossProfitSale + $grossProfitService + $totalDirectExpense;
    @endphp 


    <div class="table-responsive">
        <table style="width: 100%">
            <tr>
                <td style="vertical-align: top;" colspan="3">
                    <table style="width: 100%">
                        <thead style="background:#227447; color: white; font-weight: bold; font-size: 14px">
                            <tr>
                                <td colspan="3" class="base_header text-center">Expenses</td>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($directExpenses as $expenseHeader)
                            <tr style="background-color: #dbecdb">
                                <td class="balance_header">{{$expenseHeader->line_text}}</td>
                                <td style="text-align: right"></td>
                                <td style="text-align: right">
                                    <strong>
                                        @php
                                        $headerTotal = $expenseHeader->descendants->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
                                        @endphp
                                        @money(abs($headerTotal->sum('dr_amount')- $headerTotal->sum('cr_amount')))
                                    </strong>
                                </td>
                            </tr>
                            @foreach($expenseHeader->descendants as $expenseLine)
                            @php
                            $expenseLineAmount = $expenseLine->accounts->pluck('currentYearLedger')->flatten()->sum('dr_amount') - $expenseLine->accounts->pluck('currentYearLedger')->flatten()->sum('cr_amount')
                            @endphp
                            {{-- @if(!empty($expenseLineAmount))--}}
                            <tr>
                                <td class="balance_line" id="{{$expenseLine->id}}">
                                    {{$expenseLine->line_text}}
                                </td>
                                <td style="text-align: right">
                                    @money(abs($expenseLineAmount))
                                </td>
                                <td></td>
                            </tr>
                            {{-- @endif--}}
                            @foreach ($expenseLine->accounts as $account)
                            <tr class="account_row balance_account_{{$expenseLine->id}}">
                                <td class="account_name account_line"><a href="{{url("ledgers?account_id=$account->id")}}" target="blank">{{$account->account_name}} </a></td>
                                <td style="text-align: right">
                                    @money(abs($account->currentYearLedger->sum('dr_amount') - $account->currentYearLedger->sum('cr_amount') ))
                                </td>
                            </tr>
                            @endforeach
                            @endforeach

                            @if($loop->first)
                            {{-- @if($grossProfitSale > 0)--}}
                            <tr style="background-color: #dbecdb">
                                <td class="balance_header"> Gross {{$grossProfitSale > 0 ? 'Profit' : 'Loss' }} on Sale </td>
                                <td style="text-align: right"> </td>
                                <th style="text-align: right">
                                    @money(abs($grossProfitSale))
                                </th>
                            </tr>
                            {{-- @endif--}}
                            @endif

                            @endforeach

                            {{-- @if($grossProfitService > 0)--}}
                            <tr style="background-color: #dbecdb">
                                <td class="balance_header"> Gross {{$grossProfitService > 0 ? 'Profit' : 'Loss' }} on Service </td>
                                <td style="text-align: right"> </td>
                                <th style="text-align: right">
                                    @money(abs($grossProfitService))
                                </th>
                            </tr>
                            {{-- @endif--}}
                            <tr>
                                <td class="balance_header"> </td>
                                <td style="text-align: right"> <b> {{number_format($totalGrossProfit, 2)}} </b> </td>
                                <td style="text-align: right">0.00 </td>
                            </tr>
                            @foreach($indirectExpenses as $indirectExpHeader)
                            <tr style="background-color: #dbecdb">
                                <td class="balance_header">{{$indirectExpHeader->line_text}}</td>
                                <td style="text-align: right"></td>
                                <td style="text-align: right">
                                    <strong>
                                        @php
                                        $headerTotal = $indirectExpHeader->descendants->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
                                        @endphp
                                        @money( abs($headerTotal->sum('dr_amount') - $headerTotal->sum('cr_amount')) )
                                    </strong>
                                </td>
                            </tr>
                            @foreach($indirectExpHeader->descendants as $expenseLine)
                            <tr>
                                <td class="balance_line" id="{{$expenseLine->id}}">
                                    {{$expenseLine->line_text}}
                                </td>
                                <td style="text-align: right">
                                    @money(abs($expenseLine->accounts->pluck('currentYearLedger')->flatten()->sum('dr_amount') - $expenseLine->accounts->pluck('currentYearLedger')->flatten()->sum('cr_amount')))
                                </td>
                                <td></td>
                            </tr>
                            @foreach ($expenseLine->accounts as $account)
                            <tr class="account_row balance_account_{{$expenseLine->id}}">
                                <td class="account_name account_line">
                                    <a href="{{url("ledgers?account_id=$account->id")}}" target="blank">{{$account->account_name}} </a>
                                </td>
                                <td style="text-align: right"> @money(abs($account->currentYearLedger->flatten()->sum('dr_amount') - $account->currentYearLedger->flatten()->sum('cr_amount')))</td>
                            </tr>
                            @endforeach
                            @endforeach
                            @endforeach
                            @php
                            //$profit = $totalIndirectIncome - $totalIndirectExp;
                            //$profitLoss = $totalIndirectIncome + $grossProfit - $totalIndirectExp;
                            $profitLoss = $grossProfitSale + $grossProfitService + $totalIndirectIncome - $totalIndirectExpense;
                            @endphp
                        </tbody>
                        <tfoot>
                            @if($profitLoss >=0 )
                            <tr style="font-weight: bold">
                                <td>Net Profit </td>
                                <td></td>
                                <td class="text-right"> @money(abs($profitLoss))</td>
                            </tr>
                            @endif
                        </tfoot>
                    </table>
                </td>
                <td style="vertical-align: top" colspan="3">
                    <table style="width: 100%">
                        <thead style="background:#227447; color: white; font-weight: bold; font-size: 14px">
                            <tr>
                                <td colspan="3" class="base_header text-center">Income</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalDirectIncomes=0; $totaldirectInc=0 @endphp
                            @foreach($directIncomes as $directIncomeHeader)
                            <tr style="background-color: #dbecdb">
                                <td class="balance_header">{{$directIncomeHeader->line_text}}</td>
                                <td style="text-align: right"></td>
                                <td style="text-align: right">
                                    <strong>
                                        @php
                                        $headerTotal = $directIncomeHeader->descendants->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
                                        @endphp
                                        @money( abs($headerTotal->sum('cr_amount') - $headerTotal->sum('dr_amount')) )
                                    </strong>
                                </td>
                            </tr>
                            @foreach($directIncomeHeader->descendants as $incomeLine)
                            @php
                            $incomeLineAmount = $incomeLine->accounts->pluck('currentYearLedger')->flatten()->sum('cr_amount') - $incomeLine->accounts->pluck('currentYearLedger')->flatten()->sum('dr_amount');
                            @endphp
                            {{-- @if(!empty($incomeLineAmount))--}}
                            <tr>
                                <td class="balance_line" id="{{$incomeLine->id}}"> {{$incomeLine->line_text}} </td>
                                <td style="text-align: right">
                                    @money(abs($incomeLineAmount))
                                </td>
                                <td style="text-align: right"></td>
                            </tr>
                            {{-- @endif--}}
                            @php $totaldirectInc += $incomeLineAmount; @endphp

                            @foreach ($incomeLine->accounts as $account)
                            <tr class="account_row balance_account_{{$incomeLine->id}}">
                                <td class="account_name account_line">
                                    <a href="{{url("ledgers?account_id=$account->id")}}" target="blank">{{$account->account_name}} </a>
                                </td>
                                <td style="text-align: right"> @money(abs($account->currentYearLedger->flatten()->sum('cr_amount') - $account->currentYearLedger->flatten()->sum('dr_amount')))</td>
                            </tr>
                            @endforeach
                            @endforeach
                            @endforeach
                            <tr>
                                <td class="balance_header"> </td>
                                <td class="balance_header text-right"> @money(abs($totaldirectInc)) </td>
                                <td style="text-align: right"> </td>
                            </tr>

                            {{--@if($grossProfitSale < 0)
                                <tr style="background-color: #dbecdb">
                                    <td class="balance_header"> Gross Loss on Sale </td>
                                    <th style="text-align: right"> </th>
                                    <td style="text-align: right"> <b>@money(abs($grossProfitSale)) </b></td>
                                </tr>
                            @endif
                            @if($grossProfitService < 0)
                                <tr style="background-color: #dbecdb">
                                    <td class="balance_header"> Gross Loss on Service </td>
                                    <td style="text-align: right"> </td>
                                    <th style="text-align: right">
                                        @money(abs($grossProfitService))
                                    </th>
                                </tr>
                            @endif--}}
                            @php $totalInDirectIncomes=0 ; @endphp
                            @foreach($indirectIncomes as $indirectIncomeHeader)
                            <tr style="background-color: #dbecdb">
                                <td class="balance_header">{{$indirectIncomeHeader->line_text}}</td>
                                <td></td>
                                <td style="text-align: right">
                                    <strong>
                                        @php
                                        $headerTotal = $indirectIncomeHeader->descendants->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
                                        @endphp
                                        @money( abs($headerTotal->sum('cr_amount') - $headerTotal->sum('dr_amount')) )
                                    </strong>
                                </td>
                            </tr>
                            @foreach($indirectIncomeHeader->descendants as $incomeLine)
                            <tr>
                                <td class="balance_line" id="{{$incomeLine->id}}"> {{$incomeLine->line_text}} </td>
                                <td style="text-align: right">
                                    @money(abs($incomeLine->accounts->pluck('currentYearLedger')->flatten()->sum('cr_amount') - $incomeLine->accounts->pluck('currentYearLedger')->flatten()->sum('dr_amount')))
                                </td>
                                <td style="text-align: right"></td>
                            </tr>
                            @foreach ($incomeLine->accounts as $account)
                            <tr class="account_row balance_account_{{$incomeLine->id}}">
                                <td class="account_name account_line">
                                    <a href="{{url("ledgers?account_id=$account->id")}}" target="blank">{{$account->account_name}} </a>
                                </td>
                                <td style="text-align: right"> @money(abs($account->currentYearLedger->flatten()->sum('cr_amount') - $account->currentYearLedger->flatten()->sum('dr_amount'))) </td>
                            </tr>
                            @endforeach
                            @endforeach
                            @endforeach
                            @php $finalIndirectIncome = $totalInDirectIncomes + $grossProfit ;
                            @endphp
                        </tbody>
                        <tfoot>
                            @if($profitLoss < 0 ) <tr>
                                <td> Loss</td>
                                <td></td>
                                <td style="text-align: right"> @money(abs($profitLoss)) </td>
            </tr>
            @endif
            </tfoot>
        </table>
        </td>
        </tr>
        <tr style="background:#e3e3e3">
            @php
            $totalExp = $profitLoss >=0 ? $totalIndirectExpense + $profitLoss : $totalIndirectExpense;
            //$totalInc = $profitLoss < 0 ? $totalInDirectIncomes + $grossProfit + abs($profit) : $totalInDirectIncomes + $grossProfit; @endphp <th colspan="2" class="text-right" style="width: 60%; border-right: none">Total Expenses</th>
                <th class="text-right" style="border-left: none">@money(abs($totalExp)) </th>
                <th colspan="2" class="text-right" style="width: 60%; border-right: none"> Total Income</th>
                <th class="text-right" style="border-left: none">@money(abs($totalIndirectIncome + $grossProfitSale + $grossProfitService))</th>
        </tr>
        </table>

    </div>
</div>

@endsection

@section('script')
<script>
    $(function() {
        $(document).on('click', '.balance_line', function() {
            let currentLine = $(this).attr('id');
            $(".balance_account_" + currentLine).toggle();
        });
        $('#applied_date').datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: false,
            showOtherMonths: false,
            minViewMode: 2
        });
    });
</script>
@endsection