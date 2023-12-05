<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        table {
            font-size: 11px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid ;
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
            background-color: #fff;
            color: black;
        }

        .tableHead {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
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
            position: relative;
        }

        #client {
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            top: 0;
            line-height: 18px;
            padding: 5px;
        }

        #apartment {
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            right: 20px;
            top: 20px;
            line-height: 18px;
            padding: 5px;
        }

        .infoTable {
            font-size: 14px;
            width: 100%;
        }

        .infoTableTable td:nth-child(2) {
            text-align: center;
            width: 20px;
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
            margin: 40px 0 0 0;
        }

    </style>
</head>

<body>
    <div id="logo" class="pdflogo">
        <img src="{{ asset('images/ranksfc_log.png') }}" alt="Logo" class="pdfimg">
        <div class="clearfix"></div>
        <h5>Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road, Agrabad C/A, Chattogram.</h5>
    </div>

    <div class="container" style="margin-top: 10px; clear: both; display: block; width: 100%;">
        <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Contractor Name</th>
                        <th>Type of work</th>
                        <th>Bill no.</th>
                        <th>Billing Dept.</th>
                        <th>Bill in Audit Dept.</th>
                        <th>Bill in A/C Dept.</th>
                        <th>1st Week</th>
                        <th>2nd Week</th>
                        <th>3rd Week</th>
                        <th>4th Week</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                
                <tbody>
                    @php
                        $bill_total = $week_total = $bill_sum = $audit_sum = $accounts_sum = $first_week = $second_week = $third_week = $fourth_week = 0;
                        $listing_project = 0;
                        $listing_project_details = count($budget_details);
                    @endphp
                    @forelse ($budget_details as $key => $budget_detail)
                    
                        @foreach ($budget_detail as $data)
                            @php
                                $bill_total += $data->bill_amount;
                                if ($data->week == 1 || $data->week == 2 || $data->week == 3 || $data->week == 4)
                                $week_total += $data->bill_amount;
                            @endphp
                            @if ($data->status == "")
                                @php
                                    $bill_sum += $data->bill_amount;
                                @endphp
                            @elseif ($data->status == "Accepted")
                                @php
                                    $audit_sum += $data->bill_amount;
                                @endphp
                            @else
                                @php
                                    $accounts_sum += $data->bill_amount;
                                @endphp
                            @endif

                            @if ($data->week === 1)
                                @php
                                    $first_week += $data->bill_amount;
                                @endphp
                            @elseif ($data->week === 2)
                                @php
                                    $second_week += $data->bill_amount;
                                @endphp
                            @elseif ($data->week === 3)
                                @php
                                    $third_week += $data->bill_amount;
                                @endphp
                            @elseif ($data->week === 4)
                                @php
                                    $fourth_week += $data->bill_amount;
                                @endphp
                            @endif
                            
                        @endforeach
                        @foreach ($budget_detail as $data)

                            <tr >
                                @if ($loop->first)
                                    <td rowspan="{{count($budget_detail)}}" >{{$data->project->name}}</td>
                                @endif
                                <td>{{$data->supplier->name}}</td>
                                <td>{{$data->work_type}}</td>
                                @if (empty($data->bill_no))
                                    <td>{{ "Upcome" }}</td>
                                @else
                                    <td>{{ $data->bill_no }}</td>
                                @endif
                                @if ($data->status == "")
                                    <td >{{$data->bill_amount}}</td>
                                @else
                                    <td></td>
                                @endif
                                
                                @if ($data->status == "Accepted")
                                    <td>{{$data->bill_amount}}</td>
                                @else
                                    <td></td>
                                @endif

                                @if ($data->status == "Checked")
                                    <td>{{$data->bill_amount}}</td>
                                @else
                                <td></td>
                                @endif

                                @if ($data->week == 1)
                                <td>{{$data->bill_amount}}</td>
                                @else
                                <td></td>
                                @endif
                                @if ($data->week == 2)
                                <td>{{$data->bill_amount}}</td>
                                @else
                                <td></td>
                                @endif
                                @if ($data->week == 3)
                                <td>{{$data->bill_amount}}</td>
                                @else
                                <td></td>
                                @endif
                                @if ($data->week == 4)
                                <td>{{$data->bill_amount}}</td>
                                @else
                                <td></td>
                                @endif
                                <td>Unpaid</td>
                            </tr>
                        @endforeach

                        @php
                        $listing_project++;
                        @endphp
                        @if($listing_project_details == $listing_project)
                            @foreach ($project_data as $project)
                                <tr>
                                    <td >{{ $project->name }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        @endif
                        
                    @empty
                        
                    @endforelse
                    <tr class="bg-primary">
                        <td colspan="4">Total</td>
                        <td>{{ ($bill_sum > 0) ? $bill_sum : null }}</td>
                        <td>{{ ($audit_sum > 0) ? $audit_sum : null }}</td>
                        <td>{{ ($accounts_sum > 0) ? $accounts_sum : null }}</td>
                        <td>{{ ($first_week > 0) ? $first_week : null }}</td>
                        <td>{{ ($second_week > 0) ? $second_week : null }}</td>
                        <td>{{ ($third_week > 0) ? $third_week : null }}</td>
                        <td>{{ ($fourth_week > 0) ? $fourth_week : null }}</td>
                        <td></td>
                    </tr>
                    <tr class="bg-primary">
                        <td colspan="4">Total Bill Amount, Tk</td>
                        <td colspan="3">{{ ( $bill_total > 0 ) ? $bill_total : null }}</td>
                        <td colspan="5">{{ ( $week_total > 0 ) ? $week_total : null }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
</body>

</html>
