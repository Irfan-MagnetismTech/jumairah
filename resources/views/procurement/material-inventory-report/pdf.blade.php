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
        }
        #tableLeft {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
        }
         #table td,
        #table th {
            padding: 5px 0px;
        }
        #tableLeft td,
        #tableLeft th {
            border: 1px solid rgb(2, 1, 1);
            padding: 5px 0px;
        }
        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        #tableLeft tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        #table tr:hover {
            background-color: #ddd;
        }
        #tableLeft tr:hover {
            background-color: #ddd;
        }
        #table th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
        }
        #tableLeft th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
        }
        p {
            margin: 0;
        }
        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
            position: relative;
        }
        .infoTable {
            font-size: 14px;
            width: 100%;
            /* position: fixed!important;
            top: 150px!important; */
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
            margin-top: 34px;
            margin-bottom: 34px;
        }
        .page_num::after{
            content: counter(page);
        }
        .page_break {
            page-break-before: always;
        }
    </style>
</head>

<body>
@php
    $iteration1 = 1;
    $iteration2 = 1;
@endphp
@foreach ($totals->chunk(10) as $chunk_data )
                @php
                    $ncr = [];
                @endphp
                @foreach ($totals as $key => $total)
                    @php
                            $count_parent = $total->first()->nestedMaterial->ancestors->count();
                            if($count_parent == 2){
                                $r_span = $total->first()->nestedMaterial->id;
                            }else{
                                $r_span = $total->first()->nestedMaterial->parent->id;
                            }
                            if (!array_key_exists($r_span, $ncr)){
                                $ncr[$r_span] = 0;
                            }
                            if(isset($cumulitive_receive[$key])){
                                $cumulitiveReceive = $cumulitive_receive[$key]->first()->total;
                            }else{
                                $cumulitiveReceive = 0;
                            }
                            $ncr[$r_span] += $cumulitiveReceive;
                    @endphp
                @endforeach
                @php
                    $cb = $TotalEstimatedQuantity->countBy(function ($item) {
                                return $item['parent_id'];
                            });
                    $netCumulitiveIssue = 0;
                    $netCumulitivePurchase = 0;
                    $netmovementin = 0;
                    $netmovementout = 0;
                    $chek= [];
                @endphp
                @foreach ($chunk_data as $key => $total)
                    @php
                        $count_parent = $total->first()->nestedMaterial->ancestors->count();
                        if($count_parent == 2){
                            $r_span = $total->first()->nestedMaterial->id;
                        }else{
                            $r_span = $total->first()->nestedMaterial->parent->id;
                        }

                        if(isset($opening_inventory[$key])){
                            $openingInventory = $opening_inventory[$key]->first()->previous_stock;
                        }else{
                            $openingInventory = 0;
                        }

                        if(isset($total_purchase[$key])){
                            $ReceivedFromPurchase = $total_purchase[$key]->first()->total;
                        }else{
                            $ReceivedFromPurchase = 0;
                        }

                        if(isset($total_sale[$key])){
                            $IssuedTowork = $total_sale[$key]->first()->total;
                        }else{
                            $IssuedTowork = 0;
                        }

                        if(isset($cumulitive_receive[$key])){
                            $cumulitiveReceive = $cumulitive_receive[$key]->first()->total;
                        }else{
                            $cumulitiveReceive = 0;
                        }

                        if(isset($cumulitive_issue[$key])){
                            $cumulitiveIssue = $cumulitive_issue[$key]->first()->total;
                        }else{
                            $cumulitiveIssue = 0;
                        }

                        if(isset($TotalEstimatedQuantity[$key])){
                                    $total_estimated_quantity = $TotalEstimatedQuantity[$key]['value'];
                                }else{
                                    $total_estimated_quantity = 0;
                                }


                        if(isset($total_movementin[$key])){
                            $totalMovementin = $total_movementin[$key]->first()->total;
                        }else{
                            $totalMovementin = 0;
                        }

                        if(isset($total_movementout[$key])){
                            $totalMovementout = $total_movementout[$key]->first()->total;
                        }else{
                            $totalMovementout = 0;
                        }

                        $closingStock = $openingInventory + $ReceivedFromPurchase + $totalMovementin - $IssuedTowork - $totalMovementout;
                        $netCumulitiveIssue += $IssuedTowork;
                        $netCumulitivePurchase += $ReceivedFromPurchase;
                        $netmovementin += $totalMovementin;
                        $netmovementout += $totalMovementout;
                    @endphp
                    @if ($loop->first)
                    <header>
                        <div id="logo" class="pdflogo">
                            <img src="{{ asset(config('company_info.logo')) }}" alt="Logo" class="pdfimg">
                            <div class="clearfix"></div>
                            <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
                        </div>
                        <div class="table-responsive" style="width:100%; margin-left:400px">
                        </div>
                        <div class="container">
                            <div class="table-responsive" style="max-width:33%">
                                <table id="table" class="table table-striped table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <td>Project Name: {{ $chunk_data->first()->first()->costCenter->name }}</td>
                                            <td style="text-align: left"></td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="table-responsive" style="max-width:33%; float:right; margin-top:-22px">
                                <table id="table" class="table table-striped table-bordered text-left">
                                    <thead>
                                        <tr>
                                            <td>Page: <span class="page_num"></span></td>
                                        </tr>
                                        <tr style="background-color:white;">
                                            <td>
                                                    @if (isset($fromdate) && isset($todate))
                                                        Period From {{ date('d-m-Y', strtotime($fromdate)) }} to {{ date('d-m-Y', strtotime($todate)) }}
                                                    @endif
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </header>
                    <div class="container" style=" clear: both; width: 100%;">
                        <div class="row">
                            <div class="table-responsive infoTable">
                                <table class="table table-bordered text-center" id="tableLeft">
                                    <tr>
                                        <th >SL No.</th>
                                        <th>Material name</th>
                                        <th >Unit</th>
                                        <th>Opening Stock</th>
                                        <th>Received From Purchase <br/>(Column 3 of) Store ledger</th>
                                        <th >Received From Other Site <br/>(Column 7 of) Store ledger</th>
                                        <th>Transfer To other site <br/>(Column 12 of) Store ledger</th>
                                        <th>Issued To work at site <br/>(Column 16 of) Store ledger</th>
                                        <th>Closing Stock <br/>(Column 18 of) Store ledger</th>
                                        <th >Total Estimated Quantity</th>
                                        <th>Net Cumulative Received <br/>(Column 14 of) store ledger</th>
                                        <th>Cumulative Issue to work site <br/>(Column 14 of) store ledger</th>
                                        <th >Remaining Required Quantity Total <br/>Estimated Quantity less Net Cumin Quantity</th>
                                    </tr>


                    @endif
                    <tr>
                        <td >{{ $loop->iteration }}</td>
                        <td>
                            {{$total->first()->nestedMaterial->name}}
                        </td>
                        <td >{{$total->first()->nestedMaterial->unit->name}}</td>
                        <td>
                            {{ $openingInventory }}
                        </td>
                        <td>
                            {{ $ReceivedFromPurchase }}
                        </td>
                        <td >
                            {{ $totalMovementin }}
                        </td>
                        <td>
                            {{ $totalMovementout }}
                        </td>
                        <td>
                            {{ $IssuedTowork }}
                        </td>
                        <td>
                            {{  $closingStock }}
                        </td>
                        @if (!array_key_exists($r_span, $chek))
                        <td rowspan = "{{ $cb[$r_span] }}">
                            {{ $total_estimated_quantity }}
                        </td>
                        @endif
                        <td>
                            {{ $cumulitiveReceive }}
                        </td>
                        <td>
                            {{ $cumulitiveIssue }}
                        </td>
                        @if (!array_key_exists($r_span, $chek))
                        <td rowspan = "{{ $cb[$r_span] }}">
                            {{ $total_estimated_quantity -  $ncr[$r_span] }}
                        </td>
                        @endif
                        @php
                            $chek[$r_span] = 1;
                        @endphp
                    </tr>

                @if ($loop->last)
                     </table>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($loop->last && !$loop->parent->last)
                <div class="page_break"></div>
                @endif
                @endforeach
@endforeach
</body>
</html>
