<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Print - Ongoing Projects Report</title>
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

        #table td,
        #table th {
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
        <img src="{{ asset(config('company_info.logo'))}}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}" class="pdfimg">
        <div class="clearfix"></div>
        <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
        <h3>{{$current_status}} Project Report</h3>
    </div>

    <div class="container" style="margin-top: 10px; clear: both; display: block; width: 95%;">
        <table id="table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Project Name</th>
                    <th>Land Size</th>
                    <th>Story</th>
                    <th>Agreement Date</th>
                    <th>Cash</th>
                    <th>Rent</th>
                    <th>Ratio <br> (LO/Dev)</th>
                    <th>Plan Approval</th>
                    <th>Work Start Date</th>
                    <th>Proposed Handover</th>
                    <th>Construction<br> Area</th>
                    <th>Saleable <br>Area</th>
                    <th>Saleable <br>Area(Dev)</th>
                    <th>Saleable <br>Unit (Dev)</th>
                    <th>Unit<br> Sold</th>
                    <th>Balance</th>
                    <th>% of Sales</th>
                    <th>Cash Inflow</th>
                    <th>Cash Outflow</th>
                    <th>Diff<br>(in & out)</th>
                    <th>%<br>Construction</th>
                    <th>% inflow</th>
                    <th>Project<br> Value</th>
                    <th>Unsold<br> Inventory</th>
                    <th>Yet to<br>Receive</th>
                    <th>Expected<br>Profit</th>
                    <th>Cost</th>
                    <th>%<br>Profit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $key => $project)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td><strong> {{ $project->name}}</strong></td>
                    <td>{{$project->landsize}}</td>
                    <td>{{$project->storied}}</td>
                    <td>{{$project->signing_date}}</td>
                    <td style="text-align: right">@money($project->landowner_cash_benefit)</td>
                    <td> Later </td>
                    <td> {{$project->landowner_share}} / {{$project->developer_share}} </td>
                    <td>{{$project->cda_approval_date}}</td>
                    <td>{{$project->innogration_date}}</td>
                    <td>{{$project->handover_date}}</td>
                    <td style="text-align: right">@money($project->buildup_area)</td>
                    <td style="text-align: right">@money($project->sellable_area)</td>
                    <td style="text-align: right">@money($project->developer_sellable_area)</td>
                    <td>{{$project->apartments_count}}</td>
                    <td>{{$project->sell_count}}</td>
                    <td>{{$project->apartments_count - $project->sell_count}} </td>
                    <td>{{ $project->apartments_count ? number_format((($project->sell_count / $project->apartments_count) * 100), 2)."%" : null}}</td>
                    <td class="text-right">
                        @if($project->sells)
                        @money($project->sells->sum('sales_collections_sum_received_amount'))
                        @endif
                    </td>
                    <td>Later</td>
                    <td>Later</td>
                    <td>Later</td>
                    <td>Later</td>
                    <td style="text-align: right">@money($project->apartments_sum_total_value)</td>
                    <td style="text-align: right">@money($project->unsold_apartments_sum_total_value)</td>
                    <td style="text-align: right">
                        @if($project->sell && $project->sell->salesCollections)
                        @money($project->apartments_sum_total_value - $project->sell->salesCollections->sum('received_amount'))
                        @else
                        @money($project->apartments_sum_total_value)
                        @endif
                    </td>
                    <td>
                        Later
                    </td>
                    <td style="text-align: right">
                        @money($project->project_cost)
                    </td>
                    <td>Later</td>
                </tr>
                @empty
                <tr>
                    <td></td>
                </tr>
                @endforelse

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
