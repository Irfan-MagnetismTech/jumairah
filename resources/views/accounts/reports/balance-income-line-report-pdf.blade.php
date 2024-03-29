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
            font-size: 13px;
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
        <img src="{{asset(config('company_info.logo'))}}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}">
        <h1 style="margin:0; padding:0">Ledger Group Report</h1>
        <strong>{{$fromDate}} - {{$tillDate}}</strong>
    </div>
    <br>

    <div>
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

</body>

</html>
