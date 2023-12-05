<!DOCTYPE html>
<html>

<head>

</head>

<body>



    <table style="width: 49%; float: left; margin-right: 2%">
        <thead style="background:#e3e3e3">
            <tr>
                <td colspan="3" class="base_header">Expenses</td>
            </tr>
        </thead>
        <tbody>
            @php $totalExpenses=0; $totaldirectIncome=0; $totalIndirectExpense=0 @endphp

            @foreach($directIncomes as $directIncomeHeader)
            @foreach($directIncomeHeader->descendants as $expenseLine)
            @php $totaldirectIncome += $expenseLine->accounts->sum('creditBalance'); @endphp
            @endforeach
            @endforeach

            @foreach($directExpenses as $expenseHeader)
            <tr>
                <td class="balance_header">{{$expenseHeader->line_text}}</td>
                <td style="text-align: right"></td>
                <td style="text-align: right;font-weight:bold;">
                    @php
                    $headerTotal = $expenseHeader->descendants->map(function($item){
                    return $item->accounts->sum('debitBalance');
                    })->sum()
                    @endphp
                    @money(abs($headerTotal))
                    @php
                    $totalExpenses +=$headerTotal;
                    @endphp
                </td>
            </tr>
            @foreach($expenseHeader->descendants as $expenseLine)
            <tr>
                <td class="balance_line">
                    {{$expenseLine->line_text}}
                </td>
                <td style="text-align: right">
                    @money(abs($expenseLine->accounts->sum('debitBalance')))
                    {{-- {{}} --}}
                    {{-- {{dd($expenseLine->accounts->pluck('debitBalance', 'id')->toArray())}} --}}
                </td>
            </tr>
            @php $totalIndirectExpense += $expenseLine->accounts->sum('debitBalance'); @endphp

            @foreach ($expenseLine->accounts as $account)
            <tr class="account_row balance_account_{{$expenseLine->id}}">
                <td class="account_name">{{$account->account_name}}</td>
                <td style="text-align: right"> @money(abs($account->debitBalance)) </td>
            </tr>
            @endforeach

            @endforeach
            @endforeach
            <tr>
                <td class="balance_header"> Gross Profit c/o </td>
                <td style="text-align: right"> </td>
                <th style="text-align: right">
                    @php $grossProfit = $totaldirectIncome-$totalIndirectExpense;
                    $totalGrossProfit = $grossProfit + $totalExpenses;
                    @endphp
                    @money(abs($grossProfit))
                </th>
            </tr>
            <tr>
                <td class="balance_header"> </td>
                <td style="text-align: right; font-weight:bold">{{number_format($totalGrossProfit, 2)}}</td>
                <td style="text-align: right">0.00 </td>
            </tr>
            @php $totalIndirectExp=0 @endphp
            @foreach($indirectExpenses as $indirectExpHeader)
            <tr>
                <td class="balance_header">{{$indirectExpHeader->line_text}}</td>
                <td style="text-align: right"></td>
                <td style="text-align: right; font-weight:bold;">
                    @php
                    $headerTotal = $indirectExpHeader->descendants->map(function($item){
                    return $item->accounts->sum('debitBalance');
                    })->sum()
                    @endphp
                    @money(abs($headerTotal))
                    @php $totalIndirectExp += $headerTotal; @endphp
                </td>
            </tr>
            @foreach($indirectExpHeader->descendants as $expenseLine)
            <tr>
                <td class="balance_line">
                    {{$expenseLine->line_text}}
                </td>
                <td style="text-align: right">
                    @money(abs($expenseLine->accounts->sum('debitBalance')))
                    {{-- {{dd($expenseLine->accounts->pluck('debitBalance', 'id')->toArray())}} --}}
                </td>
            </tr>
            @foreach ($expenseLine->accounts as $account)
            <tr class="account_row balance_account_{{$expenseLine->id}}">
                <td class="account_name">
                    {{$account->account_name}}
                </td>
                <td style="text-align: right"> @money(abs($account->debitBalance))</td>
            </tr>
            @endforeach
            @endforeach
            @endforeach
            @php $finalIndirectExp = $totalIndirectExp + $grossProfit @endphp
        </tbody>
        <tfoot>
            <tr>
                <td>Total Expenses</td>
                <td></td>
                <td style="text-align: right; font-weight:bold;">@money(abs($totalIndirectExp))</td>

            </tr>
        </tfoot>
    </table>
    <table style="width: 49%; float: left;">
        <thead style="background:#e3e3e3">
            <tr>
                <td colspan="3" class="base_header">Income</td>
            </tr>
        </thead>
        <tbody>
            @php $totalDirectIncomes=0; $totaldirectInc=0 @endphp
            @foreach($directIncomes as $directIncomeHeader)
            <tr>
                <td class="balance_header">{{$directIncomeHeader->line_text}}</td>
                <td style="text-align: right; font-weight:bold;">
                    @php
                    $headerTotal = $directIncomeHeader->descendants->map(function($item){
                    return $item->accounts->sum('creditBalance');
                    })->sum()
                    @endphp
                    @money(abs($headerTotal))
                    @php
                    $totalDirectIncomes +=$headerTotal;
                    @endphp
                </td>
            </tr>
            @foreach($directIncomeHeader->descendants as $incomeLine)
            <tr>
                <td class="balance_line"> {{$incomeLine->line_text}} </td>
                <td style="text-align: right"></td>
                <td style="text-align: right"> @money(abs($incomeLine->accounts->sum('creditBalance')))</td>
            </tr>
            @php $totaldirectInc += $incomeLine->accounts->sum('creditBalance'); @endphp

            @foreach ($incomeLine->accounts as $account)
            <tr class="account_row balance_account_{{$incomeLine->id}}">
                <td class="account_name">
                    {{$account->account_name}}
                </td>
                <td style="text-align: right"> @money(abs($account->debitBalance))</td>
            </tr>
            @endforeach
            @endforeach
            @endforeach
            <tr>
                <td class="balance_header"> </td>
                <td style="text-align: right"> </td>
                <td class="balance_header"> @money(abs($totaldirectInc)) </td>
            </tr>

            <tr>
                <td class="balance_header"> Gross Profit b/f </td>
                <td style="text-align: right"> <b>@money(abs($grossProfit)) </b></td>
                <th style="text-align: right"> </th>
            </tr>
            @php $totalInDirectIncomes=0 ; @endphp
            @foreach($indirectIncomes as $indirectIncomeHeader)
            <tr>
                <td class="balance_header">{{$indirectIncomeHeader->line_text}}</td>
                <td></td>
                <td style="text-align: right; font-weight:bold;">

                    @php
                    $headerTotal = $indirectIncomeHeader->descendants->map(function($item){
                    return $item->accounts->sum('creditBalance');
                    })->sum()
                    @endphp
                    @money(abs($headerTotal))
                    @php
                    $totalInDirectIncomes += $headerTotal;
                    @endphp

                </td>
            </tr>
            @foreach($indirectIncomeHeader->descendants as $incomeLine)
            <tr>
                <td class="balance_line"> {{$incomeLine->line_text}} </td>
                <td style="text-align: right"> @money(abs($incomeLine->accounts->sum('creditBalance'))) </td>
                <td style="text-align: right"></td>
            </tr>
            @foreach ($incomeLine->accounts as $account)
            <tr class="account_row balance_account_{{$incomeLine->id}}">
                <td class="account_name">
                    {{$account->account_name}}
                </td>
                <td style="text-align: right"> @money(abs($account->debitBalance)) </td>
            </tr>
            @endforeach
            @endforeach
            @endforeach
            @php $finalIndirectIncome = $totalInDirectIncomes + $grossProfit ;
            $profitLoss = $finalIndirectIncome - $finalIndirectExp;
            @endphp
        </tbody>
        <tfoot>
            <tr>
                <td>Profit / Loss</td>
                <td></td>
                <td style="text-align: right"> @money(abs($profitLoss)) </td>
            </tr>
            <tr>
                <td>Total Income </td>
                <td></td>
                <td style="text-align: right"> @money(abs($totalInDirectIncomes))</td>
            </tr>
        </tfoot>
    </table>

</body>

</html>