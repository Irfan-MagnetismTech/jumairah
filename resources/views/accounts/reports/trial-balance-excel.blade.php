<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            font-size: 12px;
        }

        table {
            font-family: Arial, Helvetica, sans-serif;
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid black;
        }

        th {
            background-color: #116A7B;
            color: white;
        }


        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #0e2b4e;
            color: white;
        }

        .tableHead {
            text-align: center;
            font-weight: bold;
            font-size: 15px;
        }

        p {
            margin: 0;
        }

        h1 {
            margin: 0;
        }

        h2 {
            margin: 0;
        }

        .container {
            margin: 20px;
        }

        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
            position: relative;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <div style="text-align: center">
        <h1 style="margin:0; padding:0">Trial Balance</h1>
        <strong>{{$fromDate}} - {{$tillDate}}</strong>
    </div>
    <br>

    <div>
        <table style="width: 100%">
            <thead>
                <tr style="text-align: center; background:#116A7B; color: white; font-weight: bold">
                    <td rowspan="2"> Particulars </td>
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
                    <td class="balance_line_style balance_line"> {{$balanceLine->line_text}} </td>
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

                <tr>
                    <td style="font-size: 12px; font-weight:bold;"> {{$parentaccount->account_name}} </td>
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

                <tr style="background-color: #caf1f1">
                    <td> {{$account->account_name}} </td>
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
                <tr style="background-color: #d9e7fa">
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

</body>

</html>