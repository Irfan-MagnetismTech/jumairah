<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        #tableArea{margin-top: 10px;margin-bottom: 10px;}
        table, table th, table td {border-spacing: 0;border: 0px solid #000;}
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
    <img src="{{asset(config('company_info.logo'))}}" alt="{{ asset(config('company_info.altText')) }}">
    <h1 style="margin:0; padding:0">Income Statement</h1>
    <strong>December 31, {{now()->format('Y')}}</strong>
</div>
<br>

<div>
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
                <td style="text-align: right">
                    <strong>
                        @php
                            $headerTotal = $expenseHeader->descendants->map(function($item){
                                return $item->accounts->sum('debitBalance');
                            })->sum()
                        @endphp
                        @money(abs($headerTotal))
                        @php
                            $totalExpenses +=$headerTotal;
                        @endphp
                    </strong>
                </td>
            </tr>
            @foreach($expenseHeader->descendants as $expenseLine)
                <tr>
                    <td class="balance_line" id="{{$expenseLine->id}}">
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
                        <td class="account_name"><a href="{{url("ledgers?account_id=$account->id")}}" target="blank">{{$account->account_name}} </a></td>
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
            <td class="balance_header">  </td>
            <td style="text-align: right"> <b> {{number_format($totalGrossProfit, 2)}} </b> </td>
            <td style="text-align: right">0.00 </td>
        </tr>
        @php $totalIndirectExp=0 @endphp
        @foreach($indirectExpenses as $indirectExpHeader)
            <tr>
                <td class="balance_header">{{$indirectExpHeader->line_text}}</td>
                <td style="text-align: right"></td>
                <td style="text-align: right">
                    <strong>
                        @php
                            $headerTotal = $indirectExpHeader->descendants->map(function($item){
                                return $item->accounts->sum('debitBalance');
                            })->sum()
                        @endphp
                        @money(abs($headerTotal))
                        @php $totalIndirectExp += $headerTotal;   @endphp
                    </strong>
                </td>
            </tr>
            @foreach($indirectExpHeader->descendants as $expenseLine)
                <tr>
                    <td class="balance_line" id="{{$expenseLine->id}}">
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
                            <a href="{{url("ledgers?account_id=$account->id")}}" target="blank">{{$account->account_name}} </a>
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
            <td style="text-align: right"><b> @money(abs($totalIndirectExp)) </b></td>

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
                <td style="text-align: right">
                    <strong>
                        @php
                            $headerTotal = $directIncomeHeader->descendants->map(function($item){
                                return $item->accounts->sum('creditBalance');
                            })->sum()
                        @endphp
                        @money(abs($headerTotal))
                        @php
                            $totalDirectIncomes +=$headerTotal;
                        @endphp
                    </strong>
                </td>
            </tr>
            @foreach($directIncomeHeader->descendants as $incomeLine)
                <tr>
                    <td class="balance_line" id="{{$incomeLine->id}}"> {{$incomeLine->line_text}} </td>
                    <td style="text-align: right"></td>
                    <td style="text-align: right"> @money(abs($incomeLine->accounts->sum('creditBalance')))</td>
                </tr>
                @php $totaldirectInc += $incomeLine->accounts->sum('creditBalance'); @endphp

                @foreach ($incomeLine->accounts as $account)
                    <tr class="account_row balance_account_{{$incomeLine->id}}">
                        <td class="account_name">
                            <a href="{{url("ledgers?account_id=$account->id")}}" target="blank">{{$account->account_name}} </a>
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
                <td style="text-align: right">
                    <strong>
                        @php
                            $headerTotal = $indirectIncomeHeader->descendants->map(function($item){
                                return $item->accounts->sum('creditBalance');
                            })->sum()
                        @endphp
                        @money(abs($headerTotal))
                        @php
                            $totalInDirectIncomes += $headerTotal;
                        @endphp
                    </strong>
                </td>
            </tr>
            @foreach($indirectIncomeHeader->descendants as $incomeLine)
                <tr>
                    <td class="balance_line" id="{{$incomeLine->id}}"> {{$incomeLine->line_text}} </td>
                    <td style="text-align: right"> @money(abs($incomeLine->accounts->sum('creditBalance'))) </td>
                    <td style="text-align: right"></td>
                </tr>
                @foreach ($incomeLine->accounts as $account)
                    <tr class="account_row balance_account_{{$incomeLine->id}}">
                        <td class="account_name">
                            <a href="{{url("ledgers?account_id=$account->id")}}" target="blank">{{$account->account_name}} </a>
                        </td>
                        <td style="text-align: right"> @money(abs($account->debitBalance)) </td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
        @php  $finalIndirectIncome = $totalInDirectIncomes + $grossProfit ;
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
</div>


<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
    $(function(){
        $(document).on('click', '.balance_line', function(){
            let currentLine = $(this).attr('id');
            $(".balance_account_"+currentLine).toggle();
        });
    });
</script>

</body>
</html>
