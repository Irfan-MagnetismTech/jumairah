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
            background-color: #227447;
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
    <title>MATERIAL COST FLOOR WISE SHEET</title>
</head>
<body>


<div id="logo" class="pdflogo">
    <img src="{{ asset(config('company_info.logo'))}}" alt="Logo" class="pdfimg">
    <h5>JHL Address.</h5>
    <h2>{{ $project->name }}</h2>
</div>

<div class="container">
    <div class="row">
        <table id="table" class="text-center">
            <thead>
            <tr>
                <th>Work Description</th>
                <th>Material</th>
                <th>Unit</th>
                <th>Quantity</th>
                <th><span class="numSpan">Rate(Tk)</span></th>
                <th><span class="numSpan">Amount(Tk)</span></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($material_statements as $floor_name => $work_types)
                <tr>
                    <td colspan="8" style="background-color: #d6e5ff">
                        <h4><b>At {{ $floor_name }}</b></h4>
                    </td>
                </tr>
                @php
                    $total_work_amount = 0;
                @endphp
                @foreach ($work_types as $work_type_id => $works)
                    @if ($works->first()->first()->boq_work_id != $work_type_id)
                        <tr>
                            <td colspan="3" style="background-color: #dbecdb">
                                <h4><b>{{ $works?->first()?->first()?->workType?->name }}</b></h4>
                            </td>
                            <td style="background-color: #ecfeff" colspan="7"></td>
                        </tr>
                    @endif
                    @php
                        $total_sub_work_amount = 0;
                        $sub_work_total_amount = 0;
                    @endphp
                    @foreach ($works as $work_id => $budgets)
                        @php $total_sub_quantity = $total_wastage = $total_quantity = 0; @endphp
                        @foreach ($budgets as $key => $item)
                            @php
                                $ancestor_str = '';
                                foreach ($budgets->ancestors as $id => $ancestor) {
                                    $ancestor_str .= $ancestor->name . ' > ';
                                }
                            @endphp
                            @php
                                $wastage = $item?->wastage * $item?->quantity;
                                $total_wastage += $wastage;
                                $total_sub_quantity += $item?->quantity;
                                $total_quantity += $item->total_quantity + $wastage;
                            @endphp
                            <tr>
                                @if ($loop->first)
                                    @php
                                        $row_span = count($budgets);
                                    @endphp
                                    <td style="text-align: center" class="bg-white">
                                        <strong>
                                            {{ $item?->boqWork?->name ?? '---' }}
                                        </strong>
                                    </td>
                                @else
                                <td></td>
                                @endif
                                <td style="text-align: left;max-width: 30%;white-space: inherit" class="bg-white">{{ $loop->index + 1 }}. &nbsp;{{ \Illuminate\Support\Str::limit($item?->nestedMaterial?->name,50) ?? '---' }}</td>
                                <td class="bg-white">{{ $item?->nestedMaterial?->unit?->name ?? '---' }}</td>
                                <td class="bg-white"><span class="numSpan" title="{{ $item?->formula_percentage }}">@money($item?->total_quantity)</span></td>
                                <td class="bg-white"><span class="numSpan">@money($item?->rate)</span></td>
                                <td class="bg-white"><span class="numSpan">@money($item?->total_amount)</span></td>
                            </tr>
                        @endforeach
                        @php
                            $total_sub_work_amount += $budgets->sum('total_amount');
                            $total_work_amount += $budgets->sum('total_amount');
                        @endphp
                    @endforeach
                    @php
                        $sub_work_total_amount += $total_sub_work_amount;
                    @endphp
                    <tr>
                        <td colspan="4" class="bg-white font-bold"></td>
                        <td style="background-color: #f6f4d0;text-align: right;font-weight: bold" class="font-bold">Sub Total</td>
                        <td style="background-color: #dbecdb;font-weight: bold" class="font-bold"><span class="numSpan">@money($sub_work_total_amount)</span></td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" style="background-color: #ccc97a;text-align: right;font-size: 12px;font-weight: bold" class="font-bold">Total Cost of {{ $floor_name }}</td>
                    <td style="background-color: #dbecdb;font-weight: bold" class="font-bold"><span class="numSpan">@money($total_work_amount)</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<footer>
    <p>Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}}</p>
</footer>

</body>
</html>
