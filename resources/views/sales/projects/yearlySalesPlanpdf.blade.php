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
        @page { margin: 50px 20px 20px 50px; }
    </style>
</head>
<body>

<div id="logo" class="pdflogo">
    <img src="{{ asset('images/Jumairah.png')}}" alt="Logo" class="pdfimg">
    <div class="clearfix"></div>
    <h5>JHL Address.</h5>
</div>

<div class="container" style="margin-top: 10px; clear: both; display: block; width: 95%;">
    <h3 class="text-center"> Yearly Sales Plan - {{$request->year ? $request->year : now()->format('Y')}}</h3>

    <table id="table" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Project</th>
            <th>Particular</th>
            <th>Hand <br> Over</th>
            <th>Unsold</th>
            <th>Closing <br> Inventory</th>
            @foreach($months as $month)
                <th>{{date('M', strtotime("$year-$month"))}}</th>
            @endforeach
            <th>Total</th>
        </tr>
        </thead>
        <tbody class="text-right">
        @foreach($budgets as $key => $budget)
            @php $totalSales = 0; $totalBooking = 0; @endphp
            <tr>
                <td class="text-left" rowspan="2">{{$budget['projects']}}</td>
                <td class="text-left">Sales Value</td>
                <td class="text-center" rowspan="2">{{date('M Y', strtotime($budget['hand_over']))}}</td>
                <td class="text-center" rowspan="2">{{$budget['unsold']}}</td>
                <td class="text-left" rowspan="2"></td>
                @foreach($budget['yearlyBudgets'] as $yearlyBudget)
                    <td>@money($yearlyBudget["sales_value"])</td>
                    @php($totalSales += $yearlyBudget["sales_value"])
                @endforeach
                <td class="text-right"><strong>@money($totalSales)</strong></td>
            </tr>
            <tr>
                <td class="text-left">Booking Money</td>
                @foreach($budget['yearlyBudgets'] as $yearlyBudget)
                    <td>@money($yearlyBudget["bm"])</td>
                    @php($totalBooking += $yearlyBudget["bm"])
                @endforeach
                <td class="text-right"><strong>@money($totalBooking)</strong></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5" class="text-center"><strong>Total Sales Value</strong></td>
            @php($grandTotal =0)
            @foreach($months as $month)
                <td class="text-right">
                    @if(array_key_exists($month,$monthWiseTotals->toArray()))
                        <strong>@money($monthWiseTotals[$month]['total_sales_value'])</strong>
                        @php($grandTotal += $monthWiseTotals[$month]['total_sales_value'])
                    @else
                        <strong>0.00</strong>
                    @endif
                </td>
            @endforeach
            <td class="text-right"> <strong>@money($grandTotal)</strong></td>
        </tr>
        <tr>
            <td colspan="5" class="text-center"><strong>Total Booking Money</strong></td>
            @php($grandTotalBM =0)
            @foreach($months as $month)
                <td class="text-right">
                    @if(array_key_exists($month,$monthWiseTotals->toArray()))
                        <strong>@money($monthWiseTotals[$month]['total_bm'])</strong>
                        @php($grandTotalBM += $monthWiseTotals[$month]['total_bm'])
                    @else
                        <strong>0.00</strong>
                    @endif
                </td>
            @endforeach
            <td class="text-right"> <strong>@money($grandTotalBM)</strong></td>
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
