<!DOCTYPE html>
<html>
<head>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size:12px;
            margin: 0;
            padding: 0;
        }
        table{
            font-size:9px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td, #table th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #table tr:nth-child(even){
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
        @page { margin: 20px 0 0 0; }
    </style>
</head>
<body>

<div id="logo" class="pdflogo">
    <img src="{{ asset('images/Jumairah.png')}}" alt="Logo" class="pdfimg">
    <div class="clearfix"></div>
    <h5>JHL Address.</h5>
</div>

<div class="container" style="margin-top: 10px; clear: both; display: block; width: 97%;">
    <table id="table" width="100%">
        <thead>
            <tr>
                <td colspan="12" class="tableHead">Projected Collection Inflow for the Month : {{now()->format('F-Y')}}</td>
            </tr>
            <tr>
                <th rowspan="2">Project Name</th>
                <th rowspan="2">Client's Name</th>
                <th rowspan="2">Apartment ID</th>
                <th colspan="4">Regular </th>
                <th rowspan="2">Over Due</th>
                <th rowspan="2">Total Due</th>
                <th rowspan="2">Due Date</th>
                <th rowspan="2">Received</th>
                <th rowspan="2">Balance</th>
            </tr>

            <tr>
                <th> Inst. No</th>
                <th> Inst. Amount </th>
                <th> Prev. Paid </th>
                <th> Inst. Due </th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects['clients'] as $key =>$client)
                 <tr class="{{$loop->even ? "bg-light" : null}}">
                    <td>
                        {{$client->project_name}}
                    </td>
                    <td class="text-left breakWords">
                        {{$client->client_name}}
                    </td>
                    <td>{{$client->apartment_name}}</td>
                    <td> {{$client->curr_inst_no}} </td>
                    <td class="text-right"> @money($client->curr_inst_amount) </td>
                    <td class="text-right"> @money($client->curr_inst_prev_paid_amount) </td>
                    <td class="text-right"> @money($client->curr_inst_due) </td>
                    <td class="text-right"> @money($client->over_due) </td>
                    <td class="text-right"> @money($client->total_due) </td>
                    <td class="text-center">
                        {{$client->curr_inst_date ?? null}}
                    </td>
                    <td class="text-right">
                        <strong>
                            @money($client->curr_month_received_amount)
                        </strong>
                    </td>
                    <td class="text-right">
                        @money($client->balance_amount)
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="font-weight-bold text-right bg-info">
            <tr>
                <td colspan="4" class="">Total</td>
                <td> @money($projects['ttl_curr_inst_amount'] ) </td>
                <td> @money($projects['ttl_curr_inst_prev_paid'] ) </td>
                <td> @money($projects['ttl_curr_inst_due'] ) </td>
                <td> @money($projects['ttl_curr_over_due'] ) </td>
                <td> @money($projects['ttl_curr_total_due'] ) </td>
                <td> -- </td>
                <td> @money($projects['ttl_curr_month_received_amount'] ) </td>
                <td> @money($projects['balance_amount'] ) </td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

<footer style="position: absolute; bottom: 30px;">
    <p style="text-align: center;">
        <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}}</small>
    </p>
</footer>

</body>
</html>
