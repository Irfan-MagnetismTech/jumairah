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
        $iteration = 1;
        $itemCount = 0;
    @endphp
    @foreach ( $priority_land as $chunk )

    <div>
        <div class="container" id="fixed_header">
            <div class="row">
                <div class="head1" style="padding-left: 260px; text-align: center">
                    <img src="{{ asset(config('company_info.logo')) }}" alt="Rangsfc">
                    <p>
                        Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road,<br> Agrabad C/A, Chattogram.
                        Phone: 2519906-8; 712023-5<br>
                        <a style="color:#000;" target="_blank">www.ranksfc.com</a>
                    </p>
                    <h3>
                        Priority Land:
                        {{ DateTime::createFromFormat('!m', $chunk->month)->format('F') . ', ' . $chunk->year }}
                    </h3>
                </div>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>


    <div class="container" style="margin-top: 25px;">
        <table class="customers">
            <thead>
                <tr>
                    <th>SL No</th>
                    <th>Plot Reference</th>
                    <th>Location</th>
                    <th>Category</th>
                    <th>Margin (%)</th>
                    <th>Cash Benefit (Crore)</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Expected Date<br> for Deal Closing</th>
                    <th>Land Size (katha)</th>
                    <th>Estimated Total Cost</th>
                    <th>Estimated Sales Value</th>
                    <th>Expected Profit</th>
                </tr>
            </thead>
            <tbody style="text-align: center">

                @foreach ($chunk->BdPriorityLandDetails as  $BdPriorityLandDetail)
                <tr>
                    <td> {{$iteration++}} </td>

                    <td> {{ $BdPriorityLandDetail->BdLeadGenerationDetail->name }} </td>
                    <td> {{ $BdPriorityLandDetail->BdLeadGenerationDetail->bdLeadGeneration->land_location }} </td>
                    <td> {{ $BdPriorityLandDetail->category }} </td>
                    <td> {{ $BdPriorityLandDetail->margin }} </td>
                    <td> {{ $BdPriorityLandDetail->cash_benefit }} </td>
                    <td> {{ $BdPriorityLandDetail->type }} </td>
                    <td> {{ $BdPriorityLandDetail->status }} </td>
                    <td> {{ $BdPriorityLandDetail->expected_date }} </td>
                    <td> {{ $BdPriorityLandDetail->BdLeadGenerationDetail->bdLeadGeneration->land_size }} </td>
                    <td> {{ $BdPriorityLandDetail->estimated_cost }} </td>
                    <td> {{ $BdPriorityLandDetail->estimated_sales_value }} </td>
                    <td> {{ $BdPriorityLandDetail->expected_profit }} </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10" style="text-align: center">Total</td>
                    <td style="text-align: center">{{ $chunk->estimated_total_cost }}</td>
                    <td style="text-align: center">{{ $chunk->estimated_total_sales_value }}</td>
                    <td style="text-align: center">{{ $chunk->expected_total_profit }}</td>
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
