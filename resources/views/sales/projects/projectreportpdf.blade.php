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
    <img src="{{ asset(config('company_info.logo'))}}" alt="Logo" class="pdfimg">
    <div class="clearfix"></div>
    <h5>JHL Address</h5>
{{--    <h3>{{$apartments ? $apartments->first()->project->name : null}}</h3>--}}
</div>

<div class="container" style="margin-top: 10px; clear: both; display: block; width: 100%;">
    <table id="table" style="text-align: right">
        <thead>
        <tr>
            <th>Sl.<br>No.</th>
            <th>Customer<br>Name</th>
            <th>Apartment<br>No.</th>
            <th>Size</th>
            <th>Per Sft.<br>Rate</th>
            <th>Apartment<br>Value</th>
            <th>Car<br>Parking</th>
            <th>Utility</th>
            <th>Reserve<br>Fund</th>
            <th>Delay<br>Charge</th>
            <th>Others</th>
            <th>Modification</th>
            <th>Total<br>Value</th>
            <th>Payable<br>Till Date</th>
            <th>Paid<br>Amount</th>
            <th>Due<br>Till<br>Date</th>
            <th>Balance</th>
            <th>Sold<br>By</th>
            <th>Sold<br>Date</th>
        </tr>
        </thead>
        <tbody>
        @php
            $totalPaid = 0;
            $totalDueTillDate = 0;
        @endphp
        @forelse($apartments as $apartment)
            <tr>
                <td style="text-align: center">{{$loop->iteration}}</td>
                <td style="text-align: left"><strong>{{$apartment->sell ? $apartment->sell->sellClient->client->name : null}}</strong></td>
                <td style="text-align: center">{{$apartment->name}}</td>
                <td>@money($apartment->sell->apartment_size)</td>
                <td>@money($apartment->sell->apartment_rate)</td>
                <td>@money($apartment->sell->apartment_value)</td>
                <td>@money($apartment->sell->parking_price)</td>
                <td>@money($apartment->sell->utility_fees)</td>
                <td>@money($apartment->sell->reserve_fund)</td>
                <td>Later</td>
                <td>@money($apartment->sell->others)</td>
                <td>Later</td>
                <td>@money($apartment->sell->total_value)</td>
                <td> @money($apartment->sell->DueTillToday) </td>
                <td>
                    @money($apartment->sell->salesCollections->sum('received_amount'))
                </td>
                <td>
                    @if($apartment->sell->DueTillToday > $apartment->sell->salesCollections->sum('received_amount'))
                        @php
                            $clientDueTillDate = $apartment->sell->DueTillToday - $apartment->sell->salesCollections->sum('received_amount');
                            $totalDueTillDate += $clientDueTillDate;
                        @endphp
                        @money($clientDueTillDate)
                    @endif
                </td>
                <td>
                    @money($apartment->sell->total_value - $apartment->sell->salesCollections->sum('received_amount'))
                </td>
                <td>
                    {{$apartment->sell->user->name}}
                </td>
                <td>
                    {{$apartment->sell->sell_date}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="15"> <h5 class="text-muted my-3"> No Data Found Based on your query. </h5> </td>
            </tr>
        @endforelse

        </tbody>
        <tfoot style="font-weight: bold; text-align: right; background: #e3e3e3">
        <tr>
            <td colspan="5" class="">Total</td>
            <td>@money($apartments->sum('sell.apartment_value'))</td>
            <td>@money($apartments->sum('sell.parking_price'))</td>
            <td>@money($apartments->sum('sell.utility_fees'))</td>
            <td>@money($apartments->sum('sell.reserve_fund'))</td>
            <td>Later</td>
            <td>@money($apartments->sum('sell.others'))</td>
            <td>Later</td>
            <td>@money($apartments->sum('sell.total_value'))</td>
            <td>@money($apartments->sum('sell.dueTillToday'))</td>
            <td> @money($apartments->sum('sales_collections_sum_received_amount')) </td>
            <td>
                @money($totalDueTillDate)
            </td>
            <td>
                @php($balance = $apartments->sum('sell.total_value') - $apartments->sum('sales_collections_sum_received_amount'))
                @money($balance)
            </td>
            <td></td>
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
