<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        #tableArea{margin-top: 10px;margin-bottom: 10px;}
        table, table th, table td {border-spacing: 0;border: 0px solid #000; vertical-align: top}
        table th, table td{padding:5px;}
        .base_header{font-weight: bold }
        .balance_header{font-weight: bold; padding-left:15px; }
        .balance_line{ padding-left:30px; cursor: pointer;}
        .balance_line:hover{ background: #c5c5c5;}
        .account_name{padding-left:50px;}
        .account_row{display: none}
    </style>
</head>

<body>
<div style="text-align: center">
    <img src="{{asset(config('company_info.logo'))}}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}">
    <h1 style="margin:0; padding:0">Balance Sheet</h1>
    <strong>December 31, {{now()->format('Y')}}</strong>
</div>
<br>

<div >
    <table style="width: 100%; ">
        <tr>
            <td>
                <table style="width: 100%">
                    <thead style="background:#e3e3e3">
                    <tr>
                        <td colspan="2" class="base_header">Liabilities</td>
                    </tr>
                    </thead>
                    <tbody>
                    @php $totalLiabilities=0 @endphp
                    @foreach($liabilities as $liabilityHeader)
                        @php
                            $liabilityHeaderOB = $liabilityHeader->descendants->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten();
                            $liabilityHeaderOBAmount = $liabilityHeaderOB->sum('cr_amount') - $liabilityHeaderOB->sum('dr_amount');
                            $liabilityHeaderAmount = $liabilityHeader->descendants->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
                            $liabilityHeaderCls = $liabilityHeaderAmount->sum('cr_amount') - $liabilityHeaderAmount->sum('dr_amount') + $liabilityHeaderOBAmount;
                        @endphp
                        <tr>
                            <td class="balance_header" >{{$liabilityHeader->line_text}}</td>
                            <td style="text-align: right">
                                <strong>
                                    @money(abs($liabilityHeaderCls))
                                    @php
                                        $totalLiabilities += $liabilityHeaderCls;
                                    @endphp
                                </strong>
                            </td>
                        </tr>
                        @foreach($liabilityHeader->descendants as $balanceLine)
                            <tr>
                                <td class="balance_line" id="{{$balanceLine->id}}">
                                    {{$balanceLine->line_text}}
                                </td>
                                <td style="text-align: right">
                                    @php
                                        $balanceLineOB = $balanceLine->accounts->flatten()->pluck('previousYearLedger')->flatten();
                                        $balanceLineOBAmount = $balanceLineOB->sum('cr_amount') - $balanceLineOB->sum('dr_amount');
                                        $balanceLineAmount = $balanceLine->accounts->flatten()->pluck('currentYearLedger')->flatten()->sum('cr_amount') -
                                                              $balanceLine->accounts->flatten()->pluck('currentYearLedger')->flatten()->sum('dr_amount') ;
                                        $balanceLineCls = $balanceLineAmount + $balanceLineOBAmount;
                                    @endphp
                                    @money(abs($balanceLineCls))
                                </td>
                            </tr>
                            @foreach ($balanceLine->accounts as $account)
                                <tr class="account_row balance_account_{{$balanceLine->id}}">
                                    <td class="account_name">
                                        <a href="{{url("ledgers?account_id=$account->id")}}" target="blank">{{$account->account_name}} </a>
                                    </td>
                                    <td style="text-align: right"> {{abs($account->debitBalance)}} </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                    @php
                        $directIncomeOPB = $directIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('cr_amount')
                            - $directIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('dr_amount');

                        $indirectIncomeOPB = $indirectIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('cr_amount')
                            - $indirectIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('dr_amount');


                        $directExpensesOPB = $directExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('dr_amount')
                            - $directExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('cr_amount')
                            ;

                        $indirectExpensesOPB = $indirectExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('dr_amount')
                            - $indirectExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('cr_amount')
                            ;
                        $grossProfitOPB = $directIncomeOPB - $directExpensesOPB;
                        $netProfitOPB = $grossProfitOPB +  $indirectIncomeOPB - $indirectExpensesOPB;

                        $directIncome = $directIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('cr_amount')
                            - $directIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('dr_amount');

                        $indirectIncome = $indirectIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('cr_amount')
                            - $indirectIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('dr_amount');

                        $directExpenses = $directExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('dr_amount')
                            - $directExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('cr_amount')
                            ;

                        $indirectExpenses = $indirectExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('dr_amount')
                            - $indirectExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('cr_amount')
                            ;

                        $grossProfit = $directIncome - $directExpenses;
                        $netProfit = $grossProfit +  $indirectIncome - $indirectExpenses;
                    @endphp
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="balance_line" id=""> Opening </th>
                        <th style="text-align: right"><b>@money(abs($netProfitOPB)) </b> </th>
                    </tr>
                    <tr>
                        <th class="balance_line" id=""> <b>{{$netProfit >= 0 ? 'Profit' : 'Loss'}} </b> </th>
                        <th style="text-align: right"><b>@money(abs($netProfit)) </b> </th>
                    </tr>
                    <tr>
                        <td><b>Total Liabilities</b></td>
                        <td style="text-align: right"><strong>{{abs($totalLiabilities)}}</strong></td>
                    </tr>
                    </tfoot>
                </table>
            </td>
            <td>
                <table style="width: 100%">
                    <thead style="background:#e3e3e3">
                    <tr>
                        <td colspan="2" class="base_header">Assets</td>
                    </tr>
                    </thead>
                    <tbody>
                    @php $totalAssests=0 @endphp
                    @foreach($assets as $assetHeader)
                        <tr>
                            <td class="balance_header">{{$assetHeader->line_text}}</td>
                            <td style="text-align: right">
                                <strong>
                                    @php
                                        $assetHeaderOB = $assetHeader->descendants->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten();
                                        $assetHeaderOBAmount = $assetHeaderOB->sum('dr_amount') -$assetHeaderOB->sum('cr_amount');
                                        $assetHeaderAmount = $assetHeader->descendants->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
                                        $assetHeaderCls = $assetHeaderAmount->sum('dr_amount') - $assetHeaderAmount->sum('cr_amount') + $assetHeaderOBAmount;
                                    @endphp
                                    @money(abs($assetHeaderCls))
                                    @php  $totalAssests += $assetHeaderCls; @endphp
                                </strong>
                            </td>
                        </tr>
                        @foreach($assetHeader->descendants as $assetBalanceLine)
                            @php
                                $assetBalanceLineOB = $assetBalanceLine->accounts->flatten()->pluck('previousYearLedger')->flatten();
                                $assetBalanceLineOBAmount = $assetBalanceLineOB->sum('dr_amount') - $assetBalanceLineOB->sum('cr_amount');
                                $assetBalanceLineAmount = $assetBalanceLine->accounts->flatten()->pluck('currentYearLedger')->flatten();
                                $assetBalanceLineCls = $assetBalanceLineAmount->sum('dr_amount') - $assetBalanceLineAmount->sum('cr_amount') + $assetBalanceLineOBAmount;
                            @endphp
                            <tr>
                                <td class="balance_line" id="{{$balanceLine->id}}">{{$assetBalanceLine->line_text}}</td>
                                <td style="text-align: right">@money(abs($assetBalanceLineCls))</td>
                            </tr>
                            @foreach ($assetBalanceLine->accounts as $account)
                                <tr class="account_row balance_account_{{$assetBalanceLine->id}}">
                                    <td class="account_name"><a href="{{url("ledgers?account_id=$account->id")}}" target="blank">{{$account->account_name}} </a></td>
                                    <td style="text-align: right"> @money(abs($account->debitBalance)) </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>Total Assets</td>
                        <td style="text-align: right"><strong>@money(abs($totalAssests))</strong></td>
                    </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
