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
            border: 1px solid rgb(180, 177, 177);
            padding: 8px;
        }

        .customers tr:nth-child(even){
            background-color: #f2f2f2;
        }

        .customers tr:hover {
            background-color: #ddd;
        }

        .customers th {
            padding-top: 4px;
            padding-bottom: 4px;
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
@foreach ($materialPlans->chunk(15) as $chunk_data )

            <div>
                <div class="container" id="fixed_header">
                    <div class="row">
                        <div class="head1" style="padding-left: 280px; text-align: center">
                            <img src="{{ asset(config('company_info.logo')) }}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}">
                            <p>
                                {!! htmlspecialchars(config('company_info.company_address')) !!}<br>
                                Phone: {!! htmlspecialchars(config('company_info.company_phone')) !!}<br>
                                <a style="color:#000;" target="_blank">{!! htmlspecialchars(config('company_info.company_email')) !!}</a>
                            </p>
                            <h3>
                                Material Budget for The Month of {{ DateTime::createFromFormat('!m', $month)->format('F') . ', ' . $year }}
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
                            <th rowspan="2">SL No</th>
                            <th rowspan="2" width="200">Project Name</th>
                            <th>Week-1</th>
                            <th>Week-2</th>
                            <th>Week-3</th>
                            <th>Week-4</th>
                            <th >Total Amount</th>
                        </tr>
                        <tr>
                            <th>Required Material <br> Value (BDT.)</th>
                            <th>Required Material <br> Value (BDT.)</th>
                            <th>Required Material <br> Value (BDT.)</th>
                            <th>Required Material <br> Value (BDT.)</th>
                            <th>Required Material <br> Value (BDT.)</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center">

                        @php
                            $week_one_grand_total = 0;
                            $week_two_grand_total = 0;
                            $week_three_grand_total = 0;
                            $week_four_grand_total = 0;
                            $week_grand_total = 0;
                        @endphp
                        @foreach($chunk_data as $key => $materialPlan)
                            @php
                                $weekOne = 0;
                                $weekTwo = 0;
                                $weekThree = 0;
                                $weekFour = 0;
                            @endphp
                            @foreach($materialPlan->materialPlanDetails as $materialPlanDetail)
                                @php
                                    $weekOne += $materialPlanDetail->week_one * $materialPlanDetail->week_one_rate;
                                    $weekTwo += $materialPlanDetail->week_two * $materialPlanDetail->week_two_rate;
                                    $weekThree += $materialPlanDetail->week_three * $materialPlanDetail->week_three_rate;
                                    $weekFour += $materialPlanDetail->week_four * $materialPlanDetail->week_four_rate;
                                    $totalAmount = $weekOne + $weekTwo + $weekThree + $weekFour;
                                @endphp
                            @endforeach
                            @php
                                $week_one_grand_total += $weekOne;
                                $week_two_grand_total += $weekTwo;
                                $week_three_grand_total += $weekThree ;
                                $week_four_grand_total += $weekFour;
                                $week_grand_total += $totalAmount;
                            @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $materialPlan->projects->name }}</td>
                                <td>@money($weekOne)</td>
                                <td>@money($weekTwo)</td>
                                <td>@money($weekThree)</td>
                                <td>@money($weekFour)</td>
                                <td>@money($totalAmount)</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th colspan="2">Grand Total BDT.</th>
                        <th>@money($week_one_grand_total)</th>
                        <th>@money($week_two_grand_total)</th>
                        <th>@money($week_three_grand_total)</th>
                        <th>@money($week_four_grand_total)</th>
                        <th>@money($week_grand_total)</th>
                    </tfoot>
                </table>
            </div>
    @if (!$loop->last)
            <div class="page_break"></div>
        @endif
    @endforeach

</body>
</html>
