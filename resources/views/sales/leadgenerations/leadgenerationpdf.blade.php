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
            position: relative;
        }
        #client{
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            top: 0;
            line-height: 18px;
            padding: 5px;
        }
        #apartment{
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            right: 20px;
            top: 20px;
            line-height: 18px;
            padding: 5px;
        }
        .infoTable{
            font-size: 12px;
            width: 100%;
        }
        .infoTableTable td:nth-child(2) {
            text-align: center;
            width: 20px;
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
        @page { margin: 30px 0 0 30px; }
    </style>
</head>
<body>

        <div id="logo" class="pdflogo">
            <img src="{{ asset(config('company_info.logo'))}}" alt="Logo" class="pdfimg">
            <div class="clearfix"></div>
            <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
        </div>

    <div id="pageTitle" style="display: block; width: 100%;">
        <h2 style="text-align: center; width: 25%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">Inventory Report</h2>
    </div>
<div class="container" style="margin-top: 10px; clear: both; display: block; width: 95%;">
    <table id="table">
        <thead>
        <tr style="vertical-align: middle">
            <th>SL</th>
            <th>Prospect Name</th>
            <th>Entry Date</th>
            <th>Lead Stage</th>
            <th>Project</th>
            <th>Apartment</th>
            <th>Last Followup</th>
            <th>Entry By</th>
        </tr>
        </thead>
        <tbody>
            @foreach($leadgenerations as $key => $leadGeneration)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-left breakWords">
                        {{$leadGeneration->name}}
                        {{$leadGeneration->country_code}}-{{$leadGeneration->contact}}
                    </td>
                    <td>{{$leadGeneration->lead_date}}</td>
                    <td>{{$leadGeneration->lead_stage}}</td>
                    <td class="breakWords">
                        <strong>{{$leadGeneration->apartment->project->name}}</strong>
                    </td>
                    <td><strong>{{$leadGeneration->apartment->name}}</strong></td>
                    <td class="breakWords">
                        {{-- @if($leadGeneration->followups()->exists())
                            Date: <strong>{{ $leadGeneration->followups->last()->date}}</strong> <br>
                            Duration: <strong>{{\Carbon\Carbon::now()->diffInDays($leadGeneration->followups->last()->date)}}</strong> day(s) ago.<br>
                            <hr class="m-1">
                            <strong class="text-left">{{$leadGeneration->followups->last()->feedback}}</strong>
                        @else
                            --
                        @endif --}}
                    </td>
                    <td>
                        {{$leadGeneration->createdBy->name}}
                    </td>
                </tr>
            {{-- @empty
                <tr>
                    <td colspan="29"> <h5 class="text-muted my-3 text-left"> No Data Found Based on your query. </h5> </td>
                </tr> --}}
            @endforeach
        </tbody>

    </table>
</div>

<footer style="position: absolute; bottom: 30px;">
    <p style="text-align: center;">
        <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}};</small>
    </p>
</footer>

</body>
</html>
