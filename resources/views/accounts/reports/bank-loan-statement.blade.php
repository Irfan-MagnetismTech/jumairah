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
    <title>Loan Statement</title>
</head>
<body>

<div id="logo" class="pdflogo">
    <div class="clearfix"></div>
    <h5>JHL Address.</h5>
</div>


<div class="container">
    <h2 style="text-align: center">Bank Loan Statement </h2>
{{--    <p><strong>We hereby acknowledge the receipt of the following payment with thanks:</strong></p>--}}
    <table class="table">
        <tbody>
            <tr>
                <th rowspan="2" style="text-align: center">Name of Lander</th>
                <th rowspan="2" style="text-align: center">Type of Facility</th>
                <th rowspan="2" style="text-align: center">Loan Purpose</th>
                <th rowspan="2" style="text-align: center">Maturity Date</th>
                <th rowspan="2" style="text-align: center">Rate</th>
                <th rowspan="2" style="text-align: center">Inst.</th>
                <th colspan="3" style="text-align: center">Limit</th>
                <th rowspan="2" style="text-align: center">Outstanding Balance <br> (at actual)</th>
                <th colspan="2" style="text-align: center">EMI</th>
            </tr>
            <tr>
                <th style="text-align: center">Sanctioned Limit</th>
                <th style="text-align: center">Facilitated Limit</th>
                <th style="text-align: center">Available Limit</th>
                <th style="text-align: center">Amount </th>
                <th style="text-align: center">Due Date </th>
            </tr>

            @foreach($loans as $loan)
                @php
                    $loanAmount = $loan->loanReceives->flatten()->sum('receipt_amount');
                    $r = $loan->interest_rate/100;
                    $n = $loan->total_installment;
                    $upData = $loanAmount * $r * pow((1 + $r), $n);
                    $emi = $upData > 0 ? $upData/(pow((1 + $r),  $n) - 1) : 0;
                    //$num1 = $r*$pv;
                    //$num2 = 1-pow(1+$r, -$n);
                    //echo $num1/$num2;
                    //echo 0/(pow((1 + $r),  $n) - 1);
                @endphp
                <tr>
                    <td>{{$loan->account->account_name}}</td>
                    <td style="text-align: center">{{$loan->loan_type}}</td>
                    <td>{{$loan->description}}</td>
                    <td style="text-align: center">{{$loan->maturity_date}}</td>
                    <td style="text-align: center">{{$loan->interest_rate}}</td>
                    <td style="text-align: center">{{$loan->total_installment}}</td>
                    <td style="text-align: right">@money($loan->sanctioned_limit)</td>
                    <td style="text-align: right">@money($loan->loan_amount)</td>
                    <td style="text-align: right">@money($loan->sanctioned_limit - $loan->loan_amount)</td>
                    <td style="text-align: right">@money($loan->loan_outstanding)</td>
                    <td class="text-right">{{number_format($loan->emi_amount,2)}}</td>
                    <td></td>
                </tr>
            @endforeach
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
