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
        #tableRight {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        #tableBottom {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        #table td,
        #table th {
            padding: 5px 0px;
        }
        #tableLeft td,
        #tableLeft th {
            border: 1px solid rgb(65, 61, 61);
            padding: 5px 0px;
        }


        #tableRight td,
        #tableRight th {
            border: 1px solid rgb(65, 61, 61);
            padding: 5px 0px;
        }

        #tableBottom td,
        #tableBottom th {
            border: 1px solid rgb(65, 61, 61);
            padding: 5px;
        }


        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        #tableLeft tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        #tableRight tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        #tableBottom tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #tableLeft tr:hover {
            background-color: #ddd;
        }
        #tableRight tr:hover {
            background-color: #ddd;
        }

        #tableBottom tr:hover {
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
        #tableRight th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
        }

        #tableBottom th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
        }

        .tableHead {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
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

        /* .container {
            margin: 20px;
        } */

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


        .infoTable {
            font-size: 14px;
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
            margin-top: 34px;
            margin-bottom: 34px;
        }

        .page_num::after{
            content: counter(page);
        }
        .forward_from::after{
            counter-increment: section;
            content: counter(section);
        }

        header { position: fixed; top: 0px; left: 0px; right: 0px;  height: 150px; }
        footer { position: fixed; bottom: 13%; left: 0px; right: 0px;  height: 50px; }
        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto;
            background-color: #2196F3;
            padding: 10px;
        }

        .grid-item {
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.8);
            padding: 20px;
            font-size: 30px;
            text-align: center;
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

@foreach ( $csd_final_costing_demand->chunk(10) as $key1 => $chunk_csd_final_costing_demand )

    @foreach ( $csd_final_costing_refund->chunk(10) as $key2 => $chunk_csd_final_costing_refund )
        @if ($loop->parent->first && $loop->first)
            <header>
                <div id="logo" class="pdflogo">
                    <img src="{{ asset('images/ranksfc_log.png') }}" alt="Logo" class="pdfimg">
                    <div class="clearfix"></div>
                    <h5>Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road, Agrabad C/A, Chattogram.</h5>
                </div>
                <div class="table-responsive" style="width:100%; margin-left:400px">
                    <table id="table" class="table table-striped table-bordered text-left">
                        <thead>
                        <tr>
                            <td><b>Owner Name: </b></td>
                            <td style="text-align: left; ">{{ $client->client->name }}</td>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="container">
                    <div class="table-responsive" style="max-width:33%">
                        <table id="table" class="table table-striped table-bordered text-center">
                            <thead>
                            <tr>
                                <td>Project Name: </td>
                                <td style="text-align: left">{{ $costing->projects->name }}</td>
                            </tr>
                            </thead>
                            <tbody>
                            <td>Apartment No: </td>
                            <td style="text-align: left">{{ $costing->apartments->name }}</td>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive" style="max-width:33%; float:right; margin-top:-50px">
                        <table id="table" class="table table-striped table-bordered text-left">
                            <thead>
                            <tr>
                                <td>Page: <span class="page_num"></span></td>
                            </tr>
                            <tr style="background-color:white;">
                                <td>Final</td>
                            </tr>
                            <tr>
                                <td>Civil & Finishing item</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </header>
        @endif



        <div class="container" style=" clear: both; width: 100%;">
            <div class="table-responsive" style="max-width:49%; float:left;width: 50%;">
                <table id="tableLeft" class="table table-striped table-bordered text-center" style="width: 100%;">
                    <thead>
                    <tr>
                        <th colspan="6">Additional/Demand Work</th>

                    </tr>
                    <tr>
                        <th>SL</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($csd_final_costing_demand->chunk(10)[$key1] as $data)
                        <tr>
                            <td>{{ $iteration1++ }}</td>
                            <td class="text-left" style="padding-left:4px;">{{ $data->csdMaterials->name }}</td>
                            <td>{{ $data->csdMaterials->unit->name }}</td>
                            <td>{{ $data->quantity }}</td>
                            <td>{{ $data->demand_rate }}</td>
                            <td>{{ number_format($data->amount,2) }}</td>
                        </tr>

                    @endforeach
                    @php
                        $Forwarded_total = 0;
                        foreach($csd_final_costing_demand->chunk(10) as $key3 => $value3){
                            if($key3 <= $key1){
                                continue;
                            }
                            $Forwarded_total += $csd_final_costing_demand->chunk(10)[$key3]->sum('amount');
                        }
                    @endphp

                    @if ($loop->parent->remaining != 0)
                        @if (isset($csd_final_costing_demand->chunk(10)[$key1]))
                            <tr>
                                <th colspan="5" class="text-right">Total (Current Page) </th>
                                <th>
                                    {{ number_format($csd_final_costing_demand->chunk(10)[$key1]->sum('amount'),2) }}
                                </th>
                            </tr>
                        @endif
                        <tr>
                            <th colspan="5" class="text-right">Forwarded from Page: {{ $loop->parent->iteration + 1}} </th>
                            <th>
                                @if (isset($csd_final_costing_demand->chunk(10)[$key1 + 1]))
                                    {{ number_format($Forwarded_total,2) }}
                                @endif
                            </th>
                        </tr>
                    @endif

                    </tbody>
                    <tfoot>
                    @if ($loop->parent->first)
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th>{{ number_format($csd_final_costing_demand->sum('amount'),2) }}</th>
                        </tr>
                    @else

                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th>{{ number_format($Forwarded_total + $csd_final_costing_demand->chunk(10)[$key1]->sum('amount'),2) }}</th>
                        </tr>
                    @endif
                    </tfoot>
                </table>
            </div>

            <div class="table-responsive" style="float:right; width: 49%;">
                <table id="tableRight" class="table table-striped table-bordered text-center" style="width: 100%;">
                    <thead>
                    <tr>
                        <th colspan="6">Refund Work</th>
                    </tr>
                    <tr>
                        <th>SL</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>

                    </tr>
                    </thead>

                    <tbody>
                    @if (isset($csd_final_costing_refund->chunk(10)[$key1]))

                        @forelse ($csd_final_costing_refund->chunk(10)[$key1] as $data)
                            <tr>
                                <td>{{ $iteration2++ }}</td>
                                <td class="text-left" style="padding-left:4px;"> {{ $data->csdMaterials->name }}</td>
                                <td>{{ $data->csdMaterials->unit->name }}</td>
                                <td>{{ $data->quantity_refund }}</td>
                                <td>{{ $data->refund_rate }}</td>
                                <td>{{ number_format($data->amount_refund,2) }}</td>
                            </tr>
                        @empty

                        @endforelse

                    @endif
                    @php
                        $Forwarded_total1 = 0;
                        foreach($csd_final_costing_refund->chunk(10) as $key3 => $value3){
                            if($key3 <= $key1){
                                continue;
                            }
                            $Forwarded_total1 += $csd_final_costing_refund->chunk(10)[$key3]->sum('amount_refund');
                        }
                    @endphp

                    @if ($loop->parent->remaining != 0 && isset($csd_final_costing_refund->chunk(10)[$key1 + 1]))
                        @if (isset($csd_final_costing_refund->chunk(10)[$key1]))
                            <tr>
                                <th colspan="5" class="text-right">Total (Current Page) </th>
                                <th>
                                    {{ number_format($csd_final_costing_refund->chunk(10)[$key1]->sum('amount_refund'),2) }}
                                </th>
                            </tr>
                        @endif
                        <tr>
                            <th colspan="5" class="text-right">Forwarded from Page: {{ $loop->parent->iteration + 1}} </th>
                            <th>
                                @if (isset($csd_final_costing_refund->chunk(10)[$key1 + 1]))
                                    {{ number_format($Forwarded_total1,2) }}
                                @endif
                            </th>
                        </tr>
                    @endif
                    </tbody>
                    @php
                        $amount_refund = $csd_final_costing_refund->sum('amount_refund')
                    @endphp
                    <tfoot>
                    @php
                        $sum = 0;
                        $total_modification_cost = 0;
                    @endphp
                    @foreach ($payment_received->sellCollections as $key => $sellCollection)
                        @foreach($sellCollection->salesCollectionDetails as $salesCollectionDetail)
                            @if($salesCollectionDetail->particular == 'Modification Cost')
                                <tr>
                                    <th colspan="4" >Payment received as an Advanced <br />(
                                        @if ($sellCollection->payment_mode == "Cheque")

                                            Cheque number: {{ $payment_received->sellCollections[0]->transaction_no}},
                                            Date: {{$payment_received->sellCollections[0]->received_date}})
                                    </th>
                                    <th>
                                        {{number_format($sellCollection->received_amount)}}
                                        @php
                                            $total_modification_cost += $sellCollection->received_amount;
                                        @endphp
                                    </th>
                                    @elseif ($sellCollection->payment_mode == "Cash")
                                        Cash,
                                        Date: {{$payment_received->sellCollections[0]->received_date}})
                                        </th>
                                        <th>
                                            {{number_format($sellCollection->received_amount)}}
                                            @php
                                                $total_modification_cost += $sellCollection->received_amount;
                                            @endphp
                                        </th>
                                        @else
                                        </th>
                                        <th></th>
                                    @endif
                                    @if($loop->parent->last)
                                        <th>{{ number_format($total_modification_cost,2) }}</th>
                                </tr>
                            @else
                                <th></th>
                                </tr>
                            @endif
                            @endif
                        @endforeach


                        @php
                            $sum += $sellCollection->received_amount;
                        @endphp
                    @endforeach

                    @if ($loop->parent->first)
                        @php
                            $refund_minus_modificationCost = $amount_refund - $total_modification_cost;
                        @endphp
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th>{{ number_format($refund_minus_modificationCost,2) }}</th>
                        </tr>
                    @elseif(isset($csd_final_costing_refund->chunk(10)[$key1]))
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th>{{ number_format($Forwarded_total1 + $csd_final_costing_refund->chunk(10)[$key1]->sum('amount_refund'),2) }}</th>
                        </tr>
                    @endif
                    </tfoot>
                </table>
            </div>

            <div class="container" style="clear:both; width: 100%;">
                <footer>
                    <div class="table-responsive" style="width:100%;">
                        @if ($loop->parent->first)
                            <table id="tableBottom" class="table table-striped table-bordered text-center">
                                <thead>
                                <tr>
                                    @php
                                        $amount_demand = $csd_final_costing_demand->sum('amount');
                                        $amount_refund = $csd_final_costing_refund->sum('amount_refund');
                                        $total = $amount_demand - $refund_minus_modificationCost;
                                    @endphp

                                    @if ($total > 0)
                                        <th width="50%">Payable to Ranconfc</th>
                                        <th colspan="2" width="50%">{{ number_format(abs($total)) }}</th>
                                    @else
                                        <th width="50%">Payable to Client</th>
                                        <th colspan="2" width="50%">{{ number_format(abs($total)) }}</th>
                                    @endif
                                </tr>

                                <tr>
                                    <td colspan="3"><p style="text-align: left; padding-left:0px; font-size: 12px">In Words: <b>{{ ucfirst((new NumberFormatter('en', NumberFormatter::SPELLOUT))->format(round(abs($total)))) }} only</b></p></td>
                                </tr>
                                {{-- <tr>
                                    <td colspan="3"><p style="text-align: left; padding-left:0px; font-size: 12px">In Words: <b>{{ ucfirst(getBanglaCurrency((round(abs($total))))) }} only</b></p></td>
                                </tr> --}}
                                </thead>
                            </table>
                        @endif
                        <div style="margin-top:5%;">
                            <table style="text-align: center; width: 100%;">

                                <tr>
                                    <td>
                                        <span>---------------------------------</span>
                                        <p>Prepared By(Manager-CSD)</p>
                                    </td>
                                    <td>
                                        <span>---------------------------------</span>
                                        <p>Checked By(Audit)</p>
                                    </td>
                                    <td>
                                        <span>---------------------------------</span>
                                        <p>Approved By(CEO)</p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
            </div>
            </footer>
        </div>



        @break
    @endforeach
    @if (!$loop->last)
        <div class="page_break"></div>
    @endif
@endforeach




@php
    function getBanglaCurrency(float $number){
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paisa' : '';
        return ($Rupees ? $Rupees . 'Taka ' : '') . $paise;
    }
@endphp
</body>
</html>
