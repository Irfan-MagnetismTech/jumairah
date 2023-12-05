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
            font-size: 9px;
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
            background-color: #227447;
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
        }

        .pdflogo a {
            font-size: 18px;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        /* Page break */
        @page {
            margin: 30px 20px 20px 20px;
        }

        @media print {
            body {
                margin: 30px 20px 20px 20px;
            }
        }

        footer {
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
    <title>Material Summary Sheet [Civil]</title>
</head>

<body>


    <div id="logo" class="pdflogo">
        <img src="{{ asset('images/ranksfc_log.png') }}" alt="Logo" class="pdfimg">
        <h5>Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road, Agrabad C/A, Chattogram.</h5>
        <h2>{{ $project->name }}</h2>
    </div>

    <div class="container">
        <div class="row">
            <table id="table" class="text-center">
                <thead>
                    <tr>
                        <th>SL.</th>
                        <th>Material Name</th>
                        <th>Unit</th>
                        <th>Floor Name</th>
                        <th><span class="numSpan">Quantity</span></th>
                        <th><span class="numSpan">Total</span></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $headWiseTotalAmount = 0;
                    $sl = 1;
                    ?>
                    @foreach ($material_statements as $material_statement_key => $material_statement)
                        @foreach ($material_statement['floors'] as $material_key => $material)
                            @if ($sl % 2 == 0)
                                <?php $row_bg_color = '#f0efed'; ?>
                            @else
                                <?php $row_bg_color = '#c9c7c1'; ?>
                            @endif

                            <tr style="background-color: {{ $row_bg_color }};">
                                @if ($loop->first)
                                    <td style="font-weight: bold" class="text-center">
                                        @if ($loop->first)
                                            {{ $sl }}
                                        @endif
                                    </td>
                                    <td width="40%" style="font-size: 12px" class="font-weight-bold text-center">
                                        @if ($loop->first)
                                            {{ $material_statement['material_name'] }}
                                        @endif
                                    </td>
                                    <td width="10%" style="font-weight: bold;text-align: center">
                                        @if ($loop->first)
                                            {{ $material_statement['material_unit'] }}
                                        @endif
                                    </td>
                                @else
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif
                                <td style="font-weight: bold" width="30%">
                                    {{ \Illuminate\Support\Str::limit($material?->boqCivilCalcProjectFloor?->boqCommonFloor?->name, 50) }}
                                </td>
                                <td style="font-weight: bold;font-size: 12px">
                                    <span class="float-right">@money($material['gross_total_quantity'])</span>
                                </td>
                                @if ($loop->first)
                                    <td rowspan="{{ $loop->first ? count($material_statement['floors']) : '' }}"
                                        style="font-weight: bold;font-size: 12px;text-align: center">
                                        <span style="text-align: center">@money($material_statement['total_quantity'])</span>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        <?php $sl++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>Printing Time: {{ date('d-M-y h:i:s a', strtotime(now())) }}</p>
    </footer>

</body>

</html>
