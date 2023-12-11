<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        #tableArea {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        table,
        table th,
        table td {
            border-spacing: 0;
            border: 1px solid #e3e3e3;
        }

        table th,
        table td {
            padding: 5px;
        }

        .base_header {
            font-weight: bold
        }

        .balance_header {
            font-weight: bold;
            padding-left: 20px;
        }

        .balance_line {
            font-weight: bold;
            padding-left: 50px;
        }

        .account_line {
            padding-left: 80px;
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
</head>

<body>
    <div style="text-align: center">
        <img src="{{asset(config('company_info.logo'))}}" alt="">
        <h1 style="margin:0; padding:0">Trial Balance</h1>
        <strong>December 31, {{now()->format('Y')}}</strong>
    </div>
    <br>

    <table style="width: 100%">
        <thead>
            <tr style="text-align: center; background:#e3e3e3">
                <td rowspan="2"> Particulars </td>
                <td rowspan="2"> Opening Balance </td>
                <td colspan="2"> Transactions </td>
                <td rowspan="2"> Closing Balance </td>
            </tr>
            <tr style="text-align: center; background:#e3e3e3">
                <td> Debit </td>
                <td> Credit </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($trialBalances as $trialBalance)
            <tr>
                <td class="balance_header">{{$trialBalance->line_text}}</td>
                <td style="text-align: right">
                    <strong>
                        @php
                        $headerTotal = $trialBalance->descendants->map(function($item){
                        return $item->accounts->sum('debitBalance');
                        })->sum()
                        @endphp
                    </strong>
                </td>
                <td style="text-align: right"> </td>
                <td style="text-align: right"> </td>
                <td style="text-align: right"> </td>
            </tr>
            @foreach($trialBalance->descendants as $balanceLine)
            <tr>
                <td class="balance_line"> {{$balanceLine->line_text}} </td>
                <td style="text-align: right"> </td>
                <td style="text-align: right"> </td>
                <td style="text-align: right"> </td>
                <td style="text-align: right"> </td>
            </tr>
            @foreach ($balanceLine->accounts as $account)
            <tr>
                <td class="account_line">
                    {{$account->account_name}}
                </td>
                <td style="text-align: right">
                    @if(in_array($account->account_type, [1, 5]))
                    {{$resultDebit = $account->PreviousYearTotalDebit - $account->PreviousYearTotalCredit}}
                    {{($resultDebit >= 0) ? "Dr" : "Cr" }}
                    @elseif(in_array($account->account_type, [2, 4]))
                    {{$previousYearCredit = $account->PreviousYearTotalCredit - $account->PreviousYearTotalDebit}}
                    {{($previousYearCredit >= 0) ? "Cr" : "Dr" }}
                    @endif
                </td>
                <td style="text-align: right">
                    {{$account->CurrentYearTotalDebit}}
                </td>
                <td style="text-align: right">
                    {{$account->CurrentYearTotalCredit}}
                </td>
                <td style="text-align: right">
                    @if(in_array($account->account_type, [1, 5]))
                    @php
                    $currentYearDebit = $account->CurrentYearTotalDebit - $account->CurrentYearTotalCredit
                    @endphp
                    {{$debitCurrentStatus = ($resultDebit >= 0) ? $currentYearDebit + $resultDebit : $currentYearDebit}}
                    {{($debitCurrentStatus >= 0) ? "Dr" : "Cr" }}

                    @elseif(in_array($account->account_type, [2, 4]))
                    @php
                    $currentYearCredit = $account->CurrentYearTotalCredit - $account->CurrentYearTotalDebit
                    @endphp
                    {{ $creditCurrentStatus = ($previousYearCredit >= 0) ?  $currentYearCredit + $previousYearCredit : $currentYearCredit + $previousYearCredit}}
                    {{($creditCurrentStatus >= 0) ? "Cr" : "Dr" }}
                    @endif
                </td>
            </tr>
            @endforeach
            @endforeach
            @endforeach

        </tbody>


    </table>
</body>

</html>