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
            font-size: 9px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #ddd;
            padding: 5px;
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
        }

        .pdflogo a {
            font-size: 18px;
            font-weight: bold;
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

        @page {
            margin: 20px 0 0 0;
        }
    </style>
</head>

<body>

    <div id="logo" class="pdflogo">
        <img src="{{ asset(config('company_info.logo'))}}" alt="Logo" class="pdfimg">
        <div class="clearfix"></div>
        <h5>JHL Address.</h5>
    </div>
    <h2 class="text-center"> Project Wise Categories Report </h2>
    {{-- <h4 class="text-center"> Month : {{ $request->month ? \Carbon\Carbon::parse($request->month)->monthName : null }} </h4> --}}
    <div class="container" style="margin-top: 10px; clear: both; display: block; width: 97%;">
        <table style="width: 100%">
            <thead>
                <tr style="text-align: center; background:#227447; color: white; font-weight: bold">
                    <td>#</td>
                    <td>Client Name </td>
                    <td>Project Name </td>
                    <td>Unit No. </td>
                    <td> Size </td>
                    <td> Car Parking </td>
                    <td> Utilities </td>
                    <td> Total Value </td>
                    <td> Booking Money </td>
                    <td> Sold by </td>
                    <td> Month </td>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $key => $sale_items)
                @foreach ($sale_items as $sale_item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $sale_item->sellClient->client->name }}</td>
                    <td>{{ $sale_item->apartment->project->name }}</td>
                    <td>{{ $sale_item->apartment->name }}</td>
                    <td>{{ $sale_item->apartment_size }}</td>
                    <td>{{ $sale_item->parking_price }}</td>
                    <td>{{ $sale_item->utility_price }}</td>
                    <td>{{ $sale_item->total_value }}</td>
                    <td>{{ $sale_item->booking_money }}</td>
                    <td>{{ $sale_item->user->name }}</td>
                    <td>{{ Carbon\Carbon::parse($sale_item->created_at)->format('M') }}</td>
                </tr>
                @endforeach
                <tr>
                    @if($key == '1')
                    <td colspan="7" class="text-center font-weight-bold">Total(1st Quarter, January-March {{$year}})</td>
                    @elseif($key == '2')
                    <td colspan="7" class="text-center font-weight-bold">Total(2nd Quarter, April-June {{$year}})</td>
                    @elseif($key == '3')
                    <td colspan="7" class="text-center font-weight-bold">Total(3rd Quarter, July-September {{$year}})</td>
                    @elseif($key == '4')
                    <td colspan="7" class="text-center font-weight-bold">Total(4th Quarter, October-December {{$year}})</td>
                    @endif
                    <td class="text-center font-weight-bold">{{ $sale_items->sum('total_value') }}</td>
                    <td class="text-center font-weight-bold">{{ $sale_items->sum('booking_money') }}</td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table style="width: 50%; margin-top:20px;">
            <thead>
                <tr>
                    <th>In(%)</th>
                    <th>Team</th>
                    <th>Sales Achievement</th>
                    <th>Sales Targent</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($team_wise_sales as $key => $team_wise_sale)
                <tr>
                    <td></td>
                    <td>{{ $key }}</td>
                    <td>{{ $team_wise_sale->sum('total_value') }}</td>
                    <td>0</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <footer style="position: absolute; bottom: 30px;">
        <p style="text-align: center;">
            <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}}</small>
        </p>
    </footer>

</body>

</html>
