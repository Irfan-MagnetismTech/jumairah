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
            background-color: #116A7B;
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

        .text-center{
            text-align: center;
        }

        /* Page break */
        @page { margin: 30px 20px 20px 20px; }

        @media print {
            body{
                margin: 30px 20px 20px 20px;
            }
        }

        footer{
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            width: 100%;
            display: block;
            margin-left: 20px;
        }

    </style>
    <title>MS ROD</title>
</head>
<body>


<div id="logo" class="pdflogo">
    <img src="{{ asset('images/ranksfc_log.png')}}" alt="Logo" class="pdfimg">
    <h5>Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road, Agrabad C/A, Chattogram.</h5>
    <h2>{{ $project->name }}</h2>
</div>

<div class="container">
    <div class="row">
        <table id="table" class="text-center">
            <thead>
            <tr>
                <th>SL.</th>
                <th>Location</th>
                <th>8 mm</th>
                <th>10 mm</th>
                <th>12 mm</th>
                <th>16 mm</th>
                <th>20 mm</th>
                <th>22 mm</th>
                <th>25 mm</th>
                <th>32 mm</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @php
                $grand_total = 0;
            @endphp
            @if(isset($reinforcement_sheet) && count($reinforcement_sheet) > 0)
                @foreach ($reinforcement_sheet as $ms_sheet)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $ms_sheet['floor_name'] ?? '---' }}</strong></td>
                        @foreach($ms_sheet['dia_totals'] as $dia_total)
                            <td>{{ $dia_total['total_quantity'] }}</td>
                        @endforeach
                        <td><strong>{{ $ms_sheet['floorwise_dia_totals'] }}</strong></td>
                    </tr>
                    @php
                        $grand_total += $ms_sheet['floorwise_dia_totals'];
                    @endphp
                @endforeach
                <tr>
                    <th>SL.</th>
                    <th>Location</th>
                    @foreach($diaWiseTotal as $dia_total)
                        <th>{{ $dia_total?->total_quantity ?? $dia_total['total_quantity'] }}</th>
                    @endforeach
                    <th>@money($grand_total)</th>
                </tr>
            @else
                <tr>
                    <td colspan="11" class="text-center">No Data Found</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>

<footer>
    <p>Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}}</p>
</footer>

</body>
</html>
