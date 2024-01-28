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
            font-size: 12px;
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
            background-color: #f0efed;
        }
        #table tr:nth-child(odd) {
            background-color: #c9c7c1;
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
            position: relative;
        }

        #client {
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            top: 0;
            line-height: 18px;
            padding: 5px;
        }

        #apartment {
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            right: 20px;
            top: 20px;
            line-height: 18px;
            padding: 5px;
        }

        .infoTable {
            font-size: 12px;
            width: 100%;
        }

        .infoTableTable td:nth-child(2) {
            text-align: center;
            width: 20px;
        }

        .pdflogo a {
            font-size: 18px;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        @page {
            margin: 40px 0 0 0;
        }

        /*header - position: fixed */
        #fixed_header {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            right: 0;
        }

        /*fixed_footer - position: fixed */
        #fixed_footer {
            position: fixed;
            width: 94.4%;
            bottom: 20;
            left: 0;
            right: 0;
        }

        .page_break {
            page-break-before: always;
        }

    </style>
</head>

<body>
    @php
        $iteration = 1;
    @endphp

@php $price_index = 0; @endphp
    <div>
    <div>
        <div id="logo" class="pdflogo" id="fixed_header">
            <img src="{{ asset(config('company_info.logo'))}}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}" class="pdfimg">
            <div class="clearfix"></div>
            <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
        </div>

        <div id="pageTitle" style="display: block; width: 100%;">
            <h2 style="text-align: center; width: 65%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">
                Budget Details</h2>
        </div>
        <div class="container" style="margin-top: 10px; clear: both; display: block; width: 96%;">
            <div style="text-align: center !important; position: relative;">
                <table id="table" style="text-align: right">
                    <tr>
                        <td>
                            <b>Projects:</b>
                                {{ $project->name }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

<div class="container" style="margin-top: 10px; clear: both; display: block; width: 55%;">
        <table id="table" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th style="width: 295px;word-wrap:break-word">Material</th>
                <th style="width: 105px;word-wrap:break-word">Unit</th>
                <th style="width: 105px;word-wrap:break-word">Quantity</th>
                <th style="width: 105px;word-wrap:break-word">Material Rate</th>
                {{-- <th style="width: 105px;word-wrap:break-word">Labour Rate</th> --}}
                <th style="width: 105px;word-wrap:break-word">Material Amount</th>
                {{-- <th style="width: 105px;word-wrap:break-word">Labor Amount</th> --}}
                {{-- <th style="width: 105px;word-wrap:break-word">Total Amount</th> --}}
                <th style="width: 105px;word-wrap:break-word">Remarks</th>
                <th style="width: 105px;word-wrap:break-word">Total</th>
            </tr>
            </thead>
            <tbody>

                @foreach($BoqEmeCalculations as $BoqEmeCalculationsGbfloor)
                    <tr style="background-color: #ffffff" class="balanceLineStyle">
                        <td class="text-left" style="padding-left: 15px!important; first_line" >{{ $floop = $loop->iteration}}</td>
                        <td class="text-left first_layer" id="{{'budget_head_'.$BoqEmeCalculationsGbfloor->first()->first()->first()->first()->budget_head_id}}">
                            {{ $BoqEmeCalculationsGbfloor->first()->first()->first()->first()->EmeBudgetHead->name }}
                        </td>
                        <td colspan="6"></td>
                    </tr>
                    @foreach($BoqEmeCalculationsGbfloor as $BoqEmeCalculationsGbitem)
                        <tr class="balanceLineStyle hide_material second_line_{{$BoqEmeCalculationsGbitem->first()->first()->first()->floor_id}}">
                            <td class="text-left " style="padding-left: 15px!important;">{{$sloop = $floop .'.'.  $loop->iteration}}</td>
                            <td class="text-left second_layer" id="{{'floor_name_'.$BoqEmeCalculationsGbitem->first()->first()->first->floor_id ?? 0}}" style="padding-left: 30px!important;">
                                {{ $BoqEmeCalculationsGbitem->first()->first()->first()->BoqFloorProject->floor->name ?? '- - - -' }}
                            </td>
                            <td colspan="6"></td>
                        </tr>
                        @php
                          $rowSpan = 1;
                            $total = $BoqEmeCalculationsGbitem->flatten()->sum('total_material_amount');
                            $rowSpan += count($BoqEmeCalculationsGbitem);
                            if(count($BoqEmeCalculationsGbitem) < 2){
                                $rowSpan -= 1;
                            }
                        @endphp
                        @foreach($BoqEmeCalculationsGbitem as $BoqEmeCalculationsGbmaterial)
                        @php
                            $rowSpan += count($BoqEmeCalculationsGbmaterial);
                            $sl = 1;
                        @endphp
                            <tr class="balanceLineStyle hide_material third_line_{{$BoqEmeCalculationsGbmaterial->first()->first()->item_id}} hide_parent_account_{{$BoqEmeCalculationsGbmaterial->first()->first()->item_id}}">
                                <td class="text-left " style="padding-left: 15px!important;">{{ $ssloop = $sloop .'.'.$loop->iteration }}</td>
                                <td class="text-left third_layer" id="{{'second_layer_materials_'.$BoqEmeCalculationsGbmaterial->first()->first()->material_id}}" style="padding-left: 60px!important; " >
                                    {{ $BoqEmeCalculationsGbmaterial->first()->first()->NestedMaterialSecondLayer->name }}
                                </td>
                                <td colspan="5"></td>
                                @if ($loop->first)
                                <td rowspan ={{ $rowSpan }}>{{ $total }}</td>
                                @endif
                            </tr>
                            @foreach($BoqEmeCalculationsGbmaterial as $datas)
                            @if ($sl % 2 == 0)
                                <?php $row_bg_color = '#f0efed'; ?>
                            @else
                                <?php $row_bg_color = '#c9c7c1'; ?>
                            @endif
                            <tr class="balanceLineStyle hide_material fourth_line_{{$datas->first()->material_id}} hide_parent_account_{{$datas->first()->material_id}}" style="background-color: {{ $row_bg_color }};">
                                <td class="text-left " style="padding-left: 15px!important;">{{ $accloop = $ssloop .'.'.$loop->iteration }}</td>
                                <td class="text-left fourth_layer" id="{{'material_id_'.$datas->first()->material_id}}" style="padding-left: 100px!important; ">
                                    {{ $datas->first()->NestedMaterial->name }}
                                </td>
                                <td>{{ $datas->first()->NestedMaterial->unit->name }}</td>
                                <td>{{ $datas->first()->quantity }}</td>
                                <td>{{ $datas->first()->material_rate }}</td>
                                {{-- <td>{{ $datas->first()->BoqEmeRate->labour_rate }}</td> --}}
                                <td>{{ $datas->first()->total_material_amount }}</td>
                                {{-- <td>{{ $datas->first()->total_labour_amount }}</td> --}}
                                {{-- <td>{{ $datas->first()->total_amount }}</td> --}}
                                <td>{{ $datas->first()->remarks }}</td>
                            </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    <br>

    <br><br><br>
    <div style="display: block; width: 100%;" id="fixed_footer">
        <table style="text-align: center; width: 100%;">
            <tr>
                <td>
                    <span>----------------------</span>
                    <p>Prepared By</p>
                </td>
                <td>
                    <span>----------------------</span>
                    <p>Authorised By</p>
                </td>
                <td>
                    <span>----------------------</span>
                    <p>Checked By</p>
                </td>
                <td>
                    <span>----------------------</span>
                    <p>Verified By</p>
                </td>
                <td>
                    <span>----------------------</span>
                    <p>Approved By</p>
                </td>
            </tr>
        </table>
    </div>
</div>

</body>

</html>
