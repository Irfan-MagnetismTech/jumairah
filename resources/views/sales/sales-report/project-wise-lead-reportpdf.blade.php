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
    <img src="{{ asset(config('company_info.logo'))}}" alt="Logo" class="pdfimg">
    <div class="clearfix"></div>
    <h5>JHL Address.</h5>
</div>

@if($projectleads)
<h2 class="text-center"> Project Wise Categories Report </h2>
{{-- <h4 class="text-center"> Month : {{ $request->month ? \Carbon\Carbon::parse($request->month)->monthName : null }} </h4> --}}
<div class="container" style="margin-top: 10px; clear: both; display: block; width: 97%;">
    <table id="table" width="100%">
        <thead>
            <tr style="text-align: center; background:#227447; color: white; font-weight: bold">
                <td>#</td>
                <td>Project Name </td>
                <td>Location </td>
                <td> Stage - A </td>
                <td> Stage - B </td>
                <td> Stage - C </td>
                <td> Stage - D </td>
                <td> Total Leads </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($projectleads as $key => $lead)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left"> {{ $lead['projectName'] }} </td>
                    <td class="text-left"> {{ $lead['projectLocation'] }} </td>
                    <td class="text-right"> {{ $lead['leadStages']->has('A') ? $lead['leadStages']['A'] : 0 }} </td>
                    <td class="text-right"> {{ $lead['leadStages']->has('B') ? $lead['leadStages']['B'] : 0 }} </td>
                    <td class="text-right"> {{ $lead['leadStages']->has('C') ? $lead['leadStages']['C'] : 0 }} </td>
                    <td class="text-right"> {{ $lead['leadStages']->has('D') ? $lead['leadStages']['D'] : 0 }} </td>
                    <td class="text-right"> {{ $lead['projectTotalLeads'] }} </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-warning">
                <td class="text-right" colspan="3"> <strong> Total </strong> </td>
                <td class="text-right"> {{ $projectleads->pluck('leadStages')->pluck('A')->sum() }}</td>
                <td class="text-right"> {{ $projectleads->pluck('leadStages')->pluck('B')->sum() }}</td>
                <td class="text-right"> {{ $projectleads->pluck('leadStages')->pluck('C')->sum() }}</td>
                <td class="text-right"> {{ $projectleads->pluck('leadStages')->pluck('D')->sum() }}</td>
                <td class="text-right"> {{ $projectleads->pluck('projectTotalLeads')->sum() }} </td>
            </tr>
        </tfoot>
    </table>
</div>
@endif

<footer style="position: absolute; bottom: 30px;">
    <p style="text-align: center;">
        <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}}</small>
    </p>
</footer>

</body>
</html>
