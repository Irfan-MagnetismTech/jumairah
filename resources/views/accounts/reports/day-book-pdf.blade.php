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
            background-color: #227447;
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
        <img src="{{asset('images/ranksfc_log.png')}}" alt="">
        <h1 style="margin:0; padding:0">Day Book</h1>
        <strong>{{$fromDate}} - {{$tillDate}}</strong>
    </div>
    <br>

    <div>
        <table class="">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Particulars</th>
                    <th>Voucher Type</th>
                    <th>Voucher No</th>
                    <th>Debit Amount</th>
                    <th>Credit Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ledgetEntries as $ledgerEntry)
                <tr>
                    <td style="text-align: center"> {{$ledgerEntry->transaction->transaction_date}}</td>
                    <td> {{$ledgerEntry->account->account_name}} </td>
                    <td> {{$ledgerEntry->transaction->voucher_type}} </td>
                    <td> {{$ledgerEntry->transaction->id}} </td>
                    <td style="text-align: right"> {{$ledgerEntry->dr_amount}} </td>
                    <td style="text-align: right"> {{$ledgerEntry->cr_amount}} </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>