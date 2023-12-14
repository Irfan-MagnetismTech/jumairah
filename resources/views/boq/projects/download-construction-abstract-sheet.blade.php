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
            background-color: #227447;
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
            text-align: right;
        }

    </style>
    <title>CONSTRUCTION ABSTRACT SHEET</title>
</head>
<body>


<div id="logo" class="pdflogo">
    <img src="{{ asset(config('company_info.logo'))}}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}" class="pdfimg">
    <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
    <h2>{{ $project->name }}</h2>
    <h4 style="line-height: 5px">{{ $project->location }}</h4>
</div>

<div class="container">
    <div class="row">
        <table id="table" class="text-center">
            <thead>
            <tr>
                <th colspan="4">
                    <h2>Abstract of Cost</h2> <br>
                    <h3>Total Land Area - {{ $project->landsize }} Kata , Total Construction Area - {{ number_format($project->boqFloorProjects()->sum('area'),2) }}  Sft</h3>
                </th>
            </tr>

            <tr>
                <th>SL</th>
                <th>Cost Head</th>
                <th>Amount</th>
                <th>Cost Per Sft</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><strong>A.</strong></td>
                <td class="text-left" style="text-align: left">
                    <strong>CIVIL WORKS</strong>
                </td>
                <td class="text-right font-weight-bold numSpan">@money($total_cost) Tk.</td>
                <td class="text-right font-weight-bold numSpan">@money($total_cost/$total_area) Tk.</td>
            </tr>
            <tr>
                <td><strong>B.</strong></td>
                <td class="text-left" style="text-align: left">
                    <strong>SANITARY & PLUMBING WORKS</strong>
                </td>
                <td class="text-right font-weight-bold numSpan">@money($sanitery_total) TK.</td>
                <td class="text-right font-weight-bold numSpan">@money($sanitery_total/$total_area) TK.</td>
            </tr>
            <tr>
                <td><strong>C.</strong></td>
                <td class="text-left" style="text-align: left">
                    <strong>EME WORKS</strong>
                </td>
                <td class="text-right font-weight-bold numSpan">@money($eme_total) TK.</td>
                <td class="text-right font-weight-bold numSpan">@money($eme_total/$total_area) TK.</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <th class="text-left" colspan="2">TOTAL CONSTRUCTION COST</th>
                <th style="text-align: right" class="numSpan">@money($total_cost + $sanitery_total + $eme_total) Tk.</th>
                <th style="text-align: right" class="numSpan">@money(($total_cost + $sanitery_total + $eme_total)/$total_area) Tk.</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<footer>
    <p>Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}}</p>
</footer>

</body>
</html>
