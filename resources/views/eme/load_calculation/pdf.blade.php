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
            font-size: 12px;
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
            font-size: 12px;
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
            bottom: 20;
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
    @endphp

@php $price_index = 0; @endphp
    <div>
    <div>
        <div id="logo" class="pdflogo" id="fixed_header">
            <img src="{{ asset('images/ranksfc_log.png') }}" alt="Logo" class="pdfimg">
            <div class="clearfix"></div>
            <h5>Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road, Agrabad C/A, Chattogram.</h5>
        </div>

        <div id="pageTitle" style="display: block; width: 100%;">
            <h2 style="text-align: center; width: 65%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">
                Load Calculation</h2>
        </div>
        <div class="container" style="margin-top: 10px; clear: both; display: block; width: 96%;">
            <div style="text-align: center !important; position: relative;">
                <table id="table" style="text-align: right">
                    <tr>
                        <td>
                            <b>Projects:</b>
                                {{ $boqemeloadcalculation->first()->first()->first()->project->name }}
                        </td>
                        {{-- <td><b>CS Ref# - {{ $labor_rate->reference_no }}</b></td>
                        <td><b>Effective Date:</b> {{ $labor_rate->effective_date }}</td> --}}
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @php
         $calculation_type = ['Common','typical','generator'];
    $project_type = ['Residential','Commercial','Residential_cum_commercial'];
    @endphp
   
@endphp
@foreach ($boqemeloadcalculation as $key => $grpvalues)
@foreach ($grpvalues as $key1 => $values)
@php
    $total_connected_load = 0;
@endphp
<div class="container" style="margin-top: 10px; clear: both; display: block; width: 96%;">
    <table id="table">
        <thead>
        <tr>
            <th colspan="6" class="text-center">
                <span>
                    {{ $project_type[$values->first()->project_type] }} - {{ $calculation_type[$values->first()->calculation_type] }}
                </span>
                <span class='float-right pr-5 mr-5 d-flex'>
                     {{-- @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.electrical.load_calculations', 'route_key' => ['project' => $project,'load_calculation' => $values->first()]]) --}}
                     <div class="icon-btn">
                       
                    </div> 
                </span>
            </th>
        </tr>
        <tr>
            <th>SL</th>
            <th style="word-wrap:break-word">Floor</th>
            <th style="word-wrap:break-word">Material</th>
            <th style="word-wrap:break-word">Load</th>
            <th style="word-wrap:break-word">Quantity</th>
            <th style="word-wrap:break-word">Connected Load</th>
        </tr>
        </thead>
        <tbody>
        @foreach($values->first()->boq_eme_load_calculations_details as $key1 => $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->floor->name }}</td>
                <td>{{ $data->material->name }}</td>
                <td>{{ $data->load }}</td>
                <td>{{ $data->qty }}</td>
                <td>{{ $data->connected_load }}</td>
                @php
                    $total_connected_load += $data->connected_load;
                @endphp
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"></td>
                <td class="text-center">Total</td>
                <td class="text-center">{{ $total_connected_load }}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="5">Asuuming {{ $values->first()->demand_percent }}% demand load</td>
                <td class="text-center">{{ $values->first()->total_demand_wattage }}</td>
            </tr>
        </tfoot>
    </table>
    <div class="float-right">

    </div>
</div>
@endforeach
@endforeach
{{-- <div class="table-responsive">
    <table id="dataTable" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>SL</th>
            <th style="width: 250px;word-wrap:break-word">Calculation Type</th>
            <th style="width: 250px;word-wrap:break-word">Project Type</th>
            <th style="width: 250px;word-wrap:break-word">Connected Wattage</th>
            <th style="width: 250px;word-wrap:break-word">Demand Wattage</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($boqemeloadcalculation as $key => $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $calculation_type[$data->calculation_type] }}</td>
                <td>{{ $project_type[$data->project_type] }}</td>
                <td class="text-right">{{ $data->total_connecting_wattage }}</td>
                <td class="text-right">{{ $data->total_demand_wattage }}</td>
                <td>
                    @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.electrical.load_calculations', 'route_key' => ['project' => $project,'load_calculation' => $data]])
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="float-right">

    </div>
</div> --}}

    <br><br><br>
    <div style="display: block; width: 100%;" id="fixed_footer">
        <table style="text-align: center; width: 100%;">
            <tr>
                <td>
                    <span>----------------------</span>
                    <p>Prepared By</p>
                </td>
                <td>
                    <span>----------------------</span>
                    <p>Authorised By</p>
                </td>
                <td>
                    <span>----------------------</span>
                    <p>Checked By</p>
                </td>
                <td>
                    <span>----------------------</span>
                    <p>Verified By</p>
                </td>
                <td>
                    <span>----------------------</span>
                    <p>Approved By</p>
                </td>
            </tr>
        </table>
    </div>
</div>

   
    {{-- @if (!$loop->last)
            <div class="page_break"></div>
        @endif --}}


</body>

</html>
