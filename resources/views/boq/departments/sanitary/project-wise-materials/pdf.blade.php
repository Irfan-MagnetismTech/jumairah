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
        @page { margin: 20px 0 0 0; }
    </style>
</head>
<body>

<div id="logo" class="pdflogo">
    <img src="{{ asset('images/ranksfc_log.png')}}" alt="Logo" class="pdfimg">
    <div class="clearfix"></div>
    <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
</div>

<div class="container" style="margin-top: 10px; clear: both; display: block; width: 97%;">
    <table id="table" width="100%">
        <thead>
        <tr>
            <td colspan="@if(request()->reportType == 'details_pdf') 8 @else 4 @endif " class="tableHead" style="">Material Summery Sheet for - {{$project->name}}</td>
        </tr>
        <tr>
            <th>Sl</th>
            <th>Material</th>
            @if(request()->reportType == 'details_pdf')
                <th>Type</th>
            @endif
            <th>Unit</th>
            <th>Quantity</th>
            @if(request()->reportType == 'details_pdf')
                <th>Unit Price</th>
                <th>Amount</th>
                <th>Total Amount</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($materialRateData as $key => $data)
            <tr style="background-color: #c9e8dd">
                <td class="text-center">{{$psl = $loop->iteration}}</td>
                <td class="text-left"><b>{{$data->materialSecond->name}} - {{$data->floorProject->floor->name}}</b></td>
                <td class=""></td>
                <td class=""></td>
                @if(request()->reportType == 'details_pdf')
                    <td colspan="4"></td>
                @endif
            </tr>
            @php
                $totalRate=0;
            @endphp
            @foreach($data->projectWiseMaterialDetails as  $projectRateDetails)
                @php
                    $totalRate += $projectRateDetails->material_rate * $projectRateDetails->quantity;
                @endphp
                <tr>
                    <td class="text-center">{{$psl}}.{{$loop->iteration}}</td>
                    <td class="text-left" style="padding-left: 20px">{{$projectRateDetails->material->name}}</td>
                    @if(request()->reportType == 'details_pdf')
                        <td class="text-center">{{$projectRateDetails->rate_type}}</td>
                    @endif
                    <td class="text-center">{{$projectRateDetails->material->unit->name}}</td>
                    <td class="text-center">{{$projectRateDetails->quantity}}</td>
                    @if(request()->reportType == 'details_pdf')
                        <td class="text-center">{{$projectRateDetails->material_rate}}</td>
                        <td class="text-center">{{$projectRateDetails->material_rate * $projectRateDetails->quantity}}</td>
                        <td></td>
                    @endif
                </tr>
            @endforeach
            @if(request()->reportType == 'details_pdf')
                <tr>
                    <td class="text-right" colspan="7"><b>Total Cost of {{$data->materialSecond->name}}</b></td>
                    <td class="text-right"><b>@money($totalRate)</b></td>
                </tr>
            @endif
        @endforeach
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
