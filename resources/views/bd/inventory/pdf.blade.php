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
            border: 1px solid rgb(233, 6, 6);
            padding: 5px;
        }

        #detailsTable tr:nth-child(even) {
            background-color: #e40c0c;
        }

        #detailsTable tr:hover {
            background-color: rgb(221, 16, 16);
        }

        #detailsTable th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #5387db;
            color: rgb(221, 24, 24);
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
            border: 1px solid rgb(51, 50, 50);
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
    @foreach ( $bd_inventory as $chunk )

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
                        Inventory Addition/Land Signed <br>
                        For the FY {{ $chunk->year }}
                    </h3>
                </div>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>


    <div class="container" style="margin-top: 25px;">
        <table class="customers">
            <thead>
                <thead>
                    <tr >
                        <th rowspan="2">SL No</th>
                        <th rowspan="2">Project Name</th>
                        <th rowspan="2">Land Size <br>as per Feasibility <br>(katha)</th>
                        <th rowspan="2">Ratio</th>
                        <th rowspan="2">Total Units</th>
                        <th colspan="2">L/O Portion</th>
                        <th colspan="2">RFPL Portion</th>
                        <th rowspan="2">Margin(%)</th>
                        <th rowspan="2">Rate</th>
                        <th rowspan="2">Parking</th>
                        <th rowspan="2">Utility</th>
                        <th rowspan="2">Other<br> Benefit</th>
                        <th rowspan="2">Remarks</th>
                        <th rowspan="2">Signing Money<br>(crore)</th>
                        <th rowspan="2">Inventory <br>Value</th>
                    </tr>
                    <tr>
                        <th >Units</th>
                        <th >Space</th>
                        <th >Units</th>
                        <th >Space</th>
                    </tr>
                </thead>
            </thead>
            <tbody style="text-align: center">

                @foreach($chunk->BdInventoryDetails as $BdInventoryDetail)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ $BdInventoryDetail->costCenter->name }} </td>
                    <td> {{ $BdInventoryDetail->land_size }} </td>
                    <td> {{ $BdInventoryDetail->ratio }} </td>
                    <td> {{ $BdInventoryDetail->total_units }} </td>
                    <td> {{ $BdInventoryDetail->lo_units }} </td>
                    <td> {{ $BdInventoryDetail->lo_space }} </td>
                    <td> {{ $BdInventoryDetail->rfpl_units }} </td>
                    <td> {{ $BdInventoryDetail->rfpl_space }} </td>
                    <td> {{ $BdInventoryDetail->margin }} </td>
                    <td> {{ $BdInventoryDetail->rate }} </td>
                    <td> {{ $BdInventoryDetail->parking }} </td>
                    <td> {{ $BdInventoryDetail->utility }} </td>
                    <td> {{ $BdInventoryDetail->other_benefit }} </td>
                    <td> {{ $BdInventoryDetail->remarks }} </td>
                    <td> {{ $BdInventoryDetail->signing_money }} </td>
                    <td> {{ $BdInventoryDetail->inventory_value }} </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="15" style="text-align: center">Total</td>
                    <td style="text-align: center">{{ $chunk->total_signing_money }}</td>
                    <td style="text-align: center">{{ $chunk->total_inventory_value }}</td>
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
