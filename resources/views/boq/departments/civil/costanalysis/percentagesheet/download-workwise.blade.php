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

        .numSpan{
            float: right;
            margin-right: 5px;
        }

    </style>
    <title>PERCENTAGE SHEET FLOOR WISE</title>
</head>
<body>


<div id="logo" class="pdflogo">
    <img src="{{ asset('images/ranksfc_log.png')}}" alt="Logo" class="pdfimg">
    <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
    <h2>{{ $project->name }}</h2>
</div>

<div class="container">
    <div class="row">
        <table id="table" class="text-center">
            <thead>
            <tr>
                <th colspan="8">PERCENTAGE SHEET WORK WISE</th>
            </tr>
            <tr>
                <th>SL.</th>
                <th>Work Description</th>
                <th>Material Cost</th>
                <th>Labour Cost</th>
                <th>Material & Labour</th>
                <th>Total Cost</th>
                <th>Cost Per SFT</th>
                <th>Cost In Percentage</th>
            </tr>
            </thead>
            <tbody>
            @php
                $total_cost_in_percentage = 0;
                $total_cost_per_sft = 0;
            @endphp
            @foreach($percentage_sheet_work_wise as $key => $work_wise_sheet)
                @php
                    $total_cost_in_percentage += ($work_wise_sheet?->total_amount*100/$total_cost);
                    $total_cost_per_sft += $work_wise_sheet?->cost_per_sft;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $key }}</strong></td>
                    <td><span class="numSpan">@money($work_wise_sheet?->material_total_amount)</span></td>
                    <td><span class="numSpan">@money($work_wise_sheet?->labour_total_amount)</span></td>
                    <td><span class="numSpan">@money($work_wise_sheet?->material_labour_total_amount)</span></td>
                    <td><span class="numSpan">@money($work_wise_sheet?->total_amount)</span></td>
                    <td><span class="numSpan">@money($work_wise_sheet?->cost_per_sft)</span></td>
                    <td><span class="numSpan">@money($work_wise_sheet?->total_amount*100/$total_cost)</span></td>
                </tr>
            @endforeach

            <tr>
                <td>{{ $percentage_sheet_work_wise->count() + 1 }}</td>
                <td><strong>Other Related Cost</strong></td>
                <td>---</td>
                <td>---</td>
                <td>---</td>
                <td><span class="numSpan">@money($other_related_costs)</span></td>
                <td><span class="numSpan">@money($other_related_costs/$total_areas)</span></td>
                <td>
                                <span class="numSpan">
                                        @if ($other_related_costs == 0)
                                        @money(0)
                                        @php
                                            $total_cost_in_percentage += 0;
                                        @endphp
                                    @else
                                        @money(($other_related_costs) * 100 /$total_cost)
                                    @endif
                                    </span>
                </td>
            </tr>
            <tr style="background-color: #116A7B;color: #fff;font-weight: bold">
                <td colspan="5">TOTAL COST WITH RESPECT TO CONSTRUCTION AREA</td>
                <td colspan="" class="grand_total"><span class="numSpan">@money($total_cost)</span></td>
                <td colspan="" class="grand_total"><span class="numSpan">@money($total_cost_per_sft + ($other_related_costs/$total_areas))</span></td>
                <td colspan="" class="grand_total"><span class="numSpan">@money($total_cost_in_percentage + ($other_related_costs) * 100 /$total_cost)</span></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<footer>
    <p>Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}}</p>
</footer>

</body>
</html>
