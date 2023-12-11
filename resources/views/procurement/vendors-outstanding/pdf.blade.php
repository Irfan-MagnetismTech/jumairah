<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            font-size: 10px;
        }

        #detailsTable {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #detailsTable td,
        #detailsTable th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #detailsTable tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #detailsTable tr:hover {
            background-color: #ddd;
        }

        #detailsTable th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #5387db;
            color: white;
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
            margin: 10px;
        }

        .row {
            clear: both;
        }

        .head1 {
            width: 45%;
            float: left;
            margin: 0;
        }

        .head2 {
            width: 55%;
            float: right;
            margin: 0;
        }

        .head3 {
            width: 45%;
            float: left;
            padding-bottom: 20px;
        }

        .head4 {
            width: 45%;
            float: right;
            padding-bottom: 20px;
        }

        .textarea {
            width: 100%;
            float: left;
        }

        .customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .customers td, .customers th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        .customers tr:nth-child(even){
            background-color: #f2f2f2;
        }

        .customers tr:hover {
            background-color: #ddd;
        }

        .customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #ddd;
            color: black;
        }

        .approval {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .approval td, .approval th {
            border: 1px solid #fff;
            padding: 5px;
        }

        /*header - position: fixed */
        #fixed_header {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            right: 0;
        }

        /*fixed_footer - position: fixed */
        #fixed_footer {
            position: fixed;
            width: 94.4%;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .page_break {
            page-break-before: always;
        }

    </style>
</head>

<body>
    @php
    $iteration1 = 1;
    $iteration2 = 1;
@endphp
@foreach ($totalBillOutstanding->chunk(15) as $chunk_data )

            <div>
                <div class="container" id="fixed_header">
                    <div class="row">
                        <div class="head1" style="padding-left: 180px; text-align: center">
                            <img src="{{ asset(config('company_info.logo')) }}" alt="Rangsfc">
                            <p>
                                JHL Address.<br>
                                Phone: 2519906-8; 712023-5<br>
                                <a style="color:#000;" target="_blank">www.ranksfc.com</a>
                            </p>
                            <h3>
                                Vendor's Outstanding Statement <br>From {{ $fromdate }} To {{ $todate }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div style="clear: both"></div>
            </div>


            <div class="container" >
                <table class="customers">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Supplier Name</th>
                            <th>Amount</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center">

                        @php
                            $grand_total_balance = 0;
                            $grand_total_payment = 0;
                            $total_balance = 0;
                        @endphp
                        @foreach($chunk_data as $data)
                        @php
                            $total_balance += $data['total_amount'];
                        @endphp
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td style="text-align: left">{{ $data['account_name'] }}</td>
                            <td style="text-align: right">{{ $data['total_amount'] }}</td>
                            <td style="text-align: right">{{ $data['total_amount'] * 0.80 }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    @php
                        $grand_total_balance += $total_balance;
                    @endphp
                    <tfoot>
                        <tr>
                            <th colspan="2">Outstanding Balance</th>
                            <th style="text-align: right">{{ $grand_total_balance }}</th>
                            <th style="text-align: right"> {{ $grand_total_balance * 0.80}} </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
    @if (!$loop->last)
            <div class="page_break"></div>
        @endif
    @endforeach

</body>
</html>
