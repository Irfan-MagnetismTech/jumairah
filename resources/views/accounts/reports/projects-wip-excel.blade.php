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
        <h1 style="margin:0; padding:0">Cost Center Wise Report</h1>
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

</body>

</html>