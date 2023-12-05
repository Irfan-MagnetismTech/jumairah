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
@foreach ($labor_rate->labor_rate_details->chunk(5) as $chunk)
@if($loop->first)
    <div>
    <div>
        <div id="logo" class="pdflogo" id="fixed_header">
            <img src="{{ asset('images/ranksfc_log.png') }}" alt="Logo" class="pdfimg">
            <div class="clearfix"></div>
            <h5>Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road, Agrabad C/A, Chattogram.</h5>
        </div>

        <div id="pageTitle" style="display: block; width: 100%;">
            <h2 style="text-align: center; width: 65%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">
                Labor Rate</h2>
        </div>
        <div class="container" style="margin-top: 10px; clear: both; display: block; width: 96%;">
            <div style="text-align: center !important; position: relative;">
                <table id="table" style="text-align: right">
                    <tr>
                        <td>
                            <b>Projects:</b>
                                {{ $labor_rate->project->name }}
                        </td>
                        {{-- <td><b>CS Ref# - {{ $labor_rate->reference_no }}</b></td>
                        <td><b>Effective Date:</b> {{ $labor_rate->effective_date }}</td> --}}
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endif

<div class="container" style="margin-top: 10px; clear: both; display: block; width: 96%;">
    <table id="table">
        <thead>
            <tr style="vertical-align: middle" class="text-center">
                <th width="20px">SL No</th>
                @if ($labor_rate->type == 1)
                        <th width="100px">Work's Name</th>
                    @else
                        <th width="100px">Material's Name</th>
                    @endif
                
                <th width="30px">Unit</th>
                <th width="30px">Qty</th> 
                <th width="30px">Amount</th> 
            </tr>
        </thead>
        <tbody>
            @php $price_index = 0; @endphp
            @foreach ($chunk as $data)
                    
                <tr>
                    <td style="text-align: center">{{ $iteration++ }}</td>
                    @if ($labor_rate->type == 1)
                        <td style="text-align: center"><b>{{ $data->boqWork->name }}</b></td>
                    @else
                        <td style="text-align: center"><b>{{ $data->NestedMaterial->name }}</b></td>
                    @endif
                    
                    <td style="text-align: center"><b>{{ $data->labor_rate }}</b></td>
                    <td style="text-align: center"><b>{{ $data->qty }}</b></td>
                    <td style="text-align: center"><b>{{ $data->qty * $data->labor_rate}}</b></td>
{{-- 
                    @if ($loop->last) <td style="text-align: center">{{ $labor_rate->remarks }}</td> @endif --}}
                </tr>
            @endforeach
          
          
        </tbody>
    </table>
    <br>
    <span style="font-size: 12px">We May select all suppliers for contingency price</span>
    <br>

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

   
    @if (!$loop->last)
            <div class="page_break"></div>
        @endif
 @endforeach

</body>

</html>
