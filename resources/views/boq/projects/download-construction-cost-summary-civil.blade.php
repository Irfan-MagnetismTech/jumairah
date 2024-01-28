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
            padding-top: 15px;
            padding-bottom: 5px;
            text-align: center;
            background-color: #116A7B;
            color: white;
            line-height: 5px;
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
        @page { margin: 50px 20px 20px 20px; }

        @media print {
            body{
                margin: 50px 20px 20px 20px;
            }
        }

        footer{
            position: fixed;
            bottom: -35px;
            left: 0;
            right: 0;
            height: 50px;
            width: 100%;
            display: block;
            margin-left: 20px;
        }

        .numSpan{
            float: right;
            margin-right: 5px;
        }

    </style>
    <title>CONSTRUCTION ABSTRACT SHEET</title>
</head>
<body>


<div id="logo" class="pdflogo">
    <img src="{{ asset('images/ranksfc_log.png')}}" alt="Logo" class="pdfimg">
    <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
    <h2>{{ $project->name }}</h2>
    <h4 style="line-height: 5px">{{ $project->location }}</h4>
</div>

<div class="container">
    <div class="row">
        <table id="table" class="text-center">
            <thead>
            <tr>
                <th colspan="3">
                    <h2>Cost Summary</h2> <br>
                    <h3>Total Land Area - {{ $project->landsize }} Kata , Total Construction Area - {{ number_format($project->boqFloorProjects()->sum('area'),2) }}  Sft</h3>
                </th>
            </tr>

            <tr>
                <th width="10%">SL NO</th>
                <th>NAME OF ITEM</th>
                <th>AMOUNT IN (TK)</th>
            </tr>
            </thead>
            <tbody style="text-align: left">
            <tr style="font-weight: bold">
                <td>A.</td>
                <td>PILING WORKS</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>
                    PILING WORKS (Materials)
                </td>
                <td class="numSpan" style="text-align: right">@money($material_piling_amount)</td>
            </tr>
            <tr>
                <td>2</td>
                <td>
                    PILING WORKS (Labour)
                </td>
                <td class="numSpan" style="text-align: right">@money($labour_piling_amount)</td>
            </tr>
            <tr style="font-weight: bold">
                <td>B.</td>
                <td>CIVIL WORKS</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>
                    CIVIL WORKS (Material Cost)
                </td>
                <td class="numSpan" style="text-align: right">@money($all_cost_summary?->material_total_amount)</td>
            </tr>
            <tr>
                <td>2</td>
                <td>
                    CIVIL WORKS (Labour Cost)
                </td>
                <td class="numSpan" style="text-align: right">@money($all_cost_summary?->labour_total_amount)</td>
            </tr>
            <tr>
                <td>3</td>
                <td>
                    CIVIL WORKS (Material & Labour Cost)
                </td>
                <td class="numSpan" style="text-align: right">@money($all_cost_summary?->material_labour_total_amount)</td>
            </tr>
            <tr style="font-weight: bold">
                <td>C.</td>
                <td>OTHER COST</td>
                <td></td>
            </tr>

            @foreach($other_related_costs as $costHead => $amount)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                        <span style="text-transform: uppercase">{{ $costHead }}</span>
                    </td>
                    <td class="numSpan" style="text-align: right">{{ number_format($amount,2) }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th colspan="3">COST SUMMARY</th>
            </tfoot>
        </table>
    </div>
</div>

<footer>
    <p>Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}}</p>
</footer>

</body>
</html>
