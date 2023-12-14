<!DOCTYPE html>
<html>
<head>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size:11px;
            margin: 15px;
            padding: 0;
        }
        table{
            font-size:11px;
        }

        .table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }

        .table td, .table th {
            border: 1px solid #000000;
            padding: 5px;
        }

        .table th {
            text-align: left;
            background-color: #ddd;
            color: #000000;
        }
        .tableHead{
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }

        p{
            margin:0;
        }
        h1{
            margin:0;
        }
        h2{
            margin:0;
        }
        .container{
            margin: 20px;
        }
        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
        }
        .pdflogo a{
            font-size: 18px;
            font-weight: bold;
        }
        .text-right{
            text-align: right;
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
        }
        @page { margin: 30px; }
    </style>
    <title>Reconciliations</title>
</head>
<body>

<div id="logo" class="pdflogo">
    <img src="{{ asset(config('company_info.logo'))}}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}" class="pdfimg">
    <div class="clearfix"></div>
    <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
</div>


<div class="container">
    <h2 style="text-align: center">Bank Reconciliation Report</h2>
{{--    <p><strong>We hereby acknowledge the receipt of the following payment with thanks:</strong></p>--}}
    <table class="table">
        <tbody>
            <tr>
                <th>Date</th>
                <th>Particular</th>
                <th>Vch Type</th>
                <th>Transaction Type</th>
                <th>Instrument No</th>
                <th>Instrument Date</th>
                <th>Bank Date</th>
                <th>Debit</th>
                <th>Credit</th>
            </tr>
            @php
                $drAmount = 0;
                $crAmount = 0;
            @endphp
            @foreach($transactions as $key => $data)
                <tr>
                    <td style="text-align: center" > <nobr>{{ $data->transaction_date ? date('d-m-Y', strtotime($data->transaction_date)):null }}</nobr></td>
                    <td class="text-left" style="word-wrap: break-word!important;">
                        @foreach ($data->ledgerEntries as $ledgerEntry)
                            @if($ledgerEntry->account->balance_and_income_line_id != 8)
                                {{$ledgerEntry->account->account_name}}
                                {{$ledgerEntry->pourpose ? ' ' .$ledgerEntry->pourpose. ' ' :  ''}}
                            @endif
                        @endforeach
                    </td>
                    <td> {{ $data->voucher_type }}</td>
                    <td>{{$data->cheque_type}}</td>
                    <td>{{$data->cheque_number}}</td>
                    <td style="text-align: center"><nobr>{{$data->cheque_date}}</nobr></td>
                   <td style="text-align: center"><nobr>{{$data->bankReconciliation->date ??''}}</nobr></td>
                    <td class="text-right">
                        @foreach ($data->ledgerEntries as $ledgerEntry)
                            @if($ledgerEntry->account->balance_and_income_line_id == 8)
                                @php $drAmount += $ledgerEntry->dr_amount; @endphp
                                @if($ledgerEntry->dr_amount) @money($ledgerEntry->dr_amount) @endif <br>
                            @endif
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach ($data->ledgerEntries as $ledgerEntry)
                            @if($ledgerEntry->account->balance_and_income_line_id == 8)
                                @php $crAmount += $ledgerEntry->cr_amount; @endphp
                                @if($ledgerEntry->cr_amount) @money($ledgerEntry->cr_amount) @endif <br>
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
            @php $bankCrAmount = 0; $bankDrAmount = 0; @endphp
            @foreach($transactionBanks as $key => $bankdata)
{{--                {{$bankdata->ledgerEntries->flatten()->sum('cr_amount')}}--}}
{{--                {{$bankdata->ledgerEntries->flatten()->sum('dr_amount')}}--}}
                @foreach ($bankdata->ledgerEntries as $bankledgerEntry)
                    @if($bankledgerEntry->account->balance_and_income_line_id == 8)
                        @php $bankCrAmount +=  $bankledgerEntry->dr_amount @endphp
                        @php $bankDrAmount +=  $bankledgerEntry->cr_amount @endphp
                    @endif
                @endforeach

            @endforeach
{{--            {{die()}}--}}
            <tr>

            <th colspan="7" style="text-align: right">Balance as per Company Books :</th>
            <th style="text-align: right"></th>
            <th style="text-align: right">@money($drAmount-$crAmount)</th>
        </tr>
        <tr>

            <th colspan="7" style="text-align: right">Amounts not reflected in Bank :</th>
            <th style="text-align: right"> @money(abs($bankCrAmount))</th>
            <th style="text-align: right"> @money(abs($bankDrAmount))</th>
        </tr>
        <tr>

            <th colspan="7" style="font-size: 12px ; text-align: right">Balance as per Bank :</th>
            <th></th>
            <th style="text-align: right">@money($drAmount - $crAmount - $bankCrAmount + $bankDrAmount)</th>
        </tr>
        </tbody>
    </table>
</div>

<footer style="position: absolute; bottom: 0;">
    <p style="text-align: center;">
        <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}};</small>
    </p>
</footer>
</body>
</html>
