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
    <img src="{{ asset(config('company_info.logo'))}}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}" class="pdfimg">
    <div class="clearfix"></div>
    <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
</div>

@if($sales)
<h2 class="text-center"> Monthly Sales Report </h2>
<h4 class="text-center"> Month : {{ $request->month ? \Carbon\Carbon::parse($request->month)->monthName : null }} </h4>
<div class="container" style="margin-top: 10px; clear: both; display: block; width: 97%;">
    <table id="table" width="100%">
        <thead>
            <tr style="text-align: center; background:#116A7B; color: white; font-weight: bold">
                <td>#</td>
                <td>Customer Name</td>
                <td>Project Name</td>
                <td>Size/Sft</td>
                <td>Aprt No.</td>
                <td>Rate/Sft</td>
                <td>Total Price</td>
                <td>Booking Money</td>
                <td>Team </td>
                <td>Sold By</td>
                <td>Ref</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $key => $sale)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left"> {{ $sale?->sellClient?->client?->name }} </td>
                    <td class="text-left"> {{ $sale?->apartment?->project?->name }} </td>
                    <td class="text-right"> @money($sale->apartment_size) </td>
                    <td class="text-center"> {{ $sale->apartment->name }}</td>
                    <td class="text-right"> @money($sale->apartment_rate) </td>
                    <td class="text-right"> @money($sale->total_value) </td>
                    <td class="text-right"> @money($sale->booking_money) </td>
                    <td class="text-left"> {{ $sale?->user?->member?->team?->user?->name }} </td>
                    <td class="text-left"> {{ $sale->user->name }} </td>
                    <td class="text-center"> -- </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-warning">
                <td class="text-right" colspan="2"> <strong> Total </strong> </td>
                <td class="text-center"> -- </td>
                <td class="text-right"> <strong> @money($sales->sum('apartment_size')) </strong> </td>
                <td class="text-center"> -- </td>
                <td class="text-center"> -- </td>
                <td class="text-right"> <strong> @money($sales->sum('total_value')) </strong> </td>
                <td class="text-right"> <strong> @money($sales->sum('booking_money')) </strong> </td>
                <td class="text-center"> -- </td>
                <td class="text-center"> -- </td>
                <td class="text-center"> -- </td>
            </tr>
        </tfoot>
    </table>
</div>
@endif

<footer style="position: absolute; bottom: 30px;">
    <p style="text-align: center;">
        <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}}</small>
    </p>
</footer>

</body>
</html>
