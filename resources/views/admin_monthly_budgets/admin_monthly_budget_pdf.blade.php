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
            <img src="{{ asset(config('company_info.logo'))}}" alt="Logo" class="pdfimg">
            <div class="clearfix"></div>
            <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
        </div>
        <div class="container" style="margin-top: 10px; clear: both; display: block; width: 95%;">
            <!-- <h3 class="text-center"> Yearly Sales Plan - {{$request->year ? $request->year : now()->format('Y')}}</h3> -->
            <table id="table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Particular</th>
                        <th>Week One</th>
                        <th>Week Two</th>
                        <th>Week Three</th>
                        <th>Week Four</th>
                        <th>Week Five</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="text-right">
                    @php $total = 0; @endphp
                    @foreach($budgets->adminMonthlyBudgetDetails as $key => $budget)
                    @php $totalSales = 0; $totalBooking = 0; @endphp
                    <tr>
                        <td class="text-left">{{$budget->budgetHead->name}}</td>
                        <td class="text-left">{{$budget->week_one}}</td>
                        <td class="text-left">{{$budget->week_two}}</td>
                        <td class="text-left">{{$budget->week_three}}</td>
                        <td class="text-left">{{$budget->week_four}}</td>
                        <td class="text-left">{{$budget->week_five}}</td>
                        <td>@money($budget->week_one + $budget->week_two + $budget->week_three + $budget->week_four + $budget->week_five)</td>
                    </tr>
                    @endforeach
                    <tr>
                    </tbody>
                    {{--        <tfoot>--}}
                    {{--        <tr>--}}
                        {{--            <th colspan="4" class="text-right">Total</th>--}}
                        {{--            <th class="text-right"></th>--}}
                    {{--        </tr>--}}
                    {{--        </tfoot>--}}
                </table>
            </div>
            <footer style="position: absolute; bottom: 30px;">
                <p style="text-align: center;">
                    <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}}</small>
                </p>
            </footer>
        </body>
    </html>
