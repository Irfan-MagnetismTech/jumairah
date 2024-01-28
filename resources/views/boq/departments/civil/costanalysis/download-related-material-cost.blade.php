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
    <title>RELATED MATERIAL COST FLOOR WISE SHEET</title>
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
                <th>Particulars</th>
                <th>Material</th>
                <th>Unit</th>
                <th>Quantity</th>
                <th><span class="numSpan">Rate(Tk)</span></th>
                <th><span class="numSpan">Amount(Tk)</span></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($material_statements as $key => $item)
                @foreach($item as $material)
                    <tr>
                        @if ($loop->first)
                            @php
                                $row_span = count($item);
                            @endphp
                            <td style="text-align: center;font-size: 10px" class="bg-white">
                                <strong>
                                    {{ $key ?? '---' }}
                                </strong>
                            </td>
                        @else
                            <td></td>
                        @endif
                        <td style="text-align: left" class="bg-white">{{ $loop->index + 1 }}. &nbsp;{{ \Illuminate\Support\Str::limit($material?->nestedMaterial?->name,50) ?? '---' }}</td>
                        <td class="bg-white">{{ $material?->nestedMaterial?->unit?->name ?? '---' }}</td>
                        <td class="bg-white"><span class="numSpan">@money($material?->total_quantity)</span></td>
                        <td class="bg-white"><span class="numSpan">@money($material?->rate)</span></td>
                        <td class="bg-white"><span class="numSpan">@money($material?->total_amount)</span></td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4"></td>
                    <td style="background-color: #f6f4d0"><strong>Total Amount</strong></td>
                    <td style="background-color: #dbecdb"><span class="numSpan"><strong>@money($item->sum('total_amount'))</strong></span></td>
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
