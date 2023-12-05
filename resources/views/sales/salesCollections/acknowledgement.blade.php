<!DOCTYPE html>
<html>
<head>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size:12px;
            margin: 15px;
            padding: 0;
        }
        table{
            font-size:12px;
        }

        .table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }

        .table td, .table th {
            border: 1px solid #000000;
            padding: 5px;
        }

        /*#table tr:nth-child(even){*/
            /*background-color: #f2f2f2;*/
        /*}*/

        .table tr:hover {
            background-color: #ddd;
        }

        .table th {
            text-align: left;
            background-color: #ddd;
            color: #000000;
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
        .text-right{
            text-align: right;
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
        }
        @page { margin: 30px; }
    </style>
    <title>Acknowledgement </title>
</head>
<body>

<div id="logo" class="pdflogo">
    <img src="{{ asset('images/ranksfc_log.png')}}" alt="Logo" class="pdfimg">
    <div class="clearfix"></div>
    <h5>Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road, Agrabad C/A, Chattogram.</h5>
</div>

<div class="container">
    <p><strong>We hereby acknowledge the receipt of the following payment with thanks:</strong></p>
    <table class="table">
        <tbody>
            <tr>
                <th>Allottee Name: </th>
                <td colspan="5">
                    @foreach($saleClients as $client)
                        {{$client->client->name}},
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>Apartment No:</th>
                <td colspan="2">{{$salesCollection->sell->apartment->name}}</td>
                <th>Apartment Size:</th>
                <td colspan="2">{{$salesCollection->sell->apartment_size}}</td>
            </tr>
            <tr>
                <th style="width: 16.666%">Project: </th>
                <td style="width: 16.666%">{{$salesCollection->sell->apartment->project->name}}</td>
                <th style="width: 16.666%">Category: </th>
                <td style="width: 16.666%">{{$salesCollection->sell->apartment->project->category}}</td>
                <th style="width: 16.666%">Floor: </th>
                <td style="width: 16.666%">{{$salesCollection->sell->apartment->floor}}</td>
            </tr>
        </tbody>
    </table>
    <table class="table">
        <tbody>
            <tr>
                <th rowspan="2" style="width: 20px">Received Amount </th>
                <td style="width: 95px"><strong>In Tk. : </strong></td>
                <td colspan="3">@money($salesCollection->received_amount)/-</td>
            </tr>
            <tr>
                <td><strong>In Words:</strong> </td>
                <td colspan="3">{{$inwords}}</td>
            </tr>

            <tr>
                <th rowspan="2" style="width: 20px">Paid By </th>
                <td style="width: 95px"><strong>Payment Mode: </strong></td>
                <td>{{$salesCollection->payment_mode}}</td>
                <td style="width: 90px"><strong>Dated: </strong></td>
                <td>{{$salesCollection->dated ?? "N/A"}}</td>
            </tr>
            <tr>
                <td><strong>Bank Name: </strong></td>
                <td>{{$salesCollection->source_name ?? "N/A"}}</td>
                <td style="width: 90px"><strong>Instrument No: </strong></td>
                <td>{{$salesCollection->transaction_no ?? "N/A"}}</td>
            </tr>
        </tbody>
    </table>

    <table class="table">
        <tbody>
            <tr>
                <th colspan="3" style="text-align: center">Payment Details</th>
            </tr>
            <tr>
                <th style="text-align: center">Purpose</th>
                <th style="text-align: center">Received Amount</th>
                <th style="text-align: center">Schedule Date</th>
            </tr>
            @foreach($salesCollection->salesCollectionDetails as $salesCollectionDetail)
                <tr>
                    <td>
                        {{$salesCollectionDetail->particular}}
                        @if($salesCollectionDetail->particular == 'Installment')
                            - {{$salesCollectionDetail->installment_no}}
                        @endif
                    </td>
                    <td style="text-align: right">
                       @money($salesCollectionDetail->amount)
                    </td>
                    <td style="text-align: center">
                        @if($salesCollectionDetail->particular == 'Installment')
                            {{$salesCollectionDetail->installment->installment_date}}
                        @elseif($salesCollectionDetail->particular == 'Booking Money')
                            {{$salesCollection->sell->booking_money_date}}
                        @elseif($salesCollectionDetail->particular == 'Down Payment')
                            {{$salesCollection->sell->downpayment_date}}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <table class="table">
        <tbody>
{{--        @foreach($salesCollection->salesCollectionDetails as $salesCollectionDetail)--}}
            <tr>
                <th rowspan="3" style="width: 20px">Payment Status </th>
                <td> Due</td>
                <td style="text-align: right">
                    @php
                        $bmTotal=0; $dpTotal=0; $dueInstallment = 0;
                        $currentDate = strtotime(now());
                        $bmDate = strtotime($salesCollection->sell->booking_money_date);
                        $dpDate = strtotime($salesCollection->sell->downpayment_date);
                        $bm = $salesCollection->sell->booking_money - $bmCollection->sum('amount');
                        $dp = $salesCollection->sell->downpayment - $dpCollection->sum('amount');
                    @endphp
                    @if($currentDate >= $bmDate && $bm > 0)
                        @php($bmTotal = $bm)
                    @endif
                    @if($currentDate >= $dpDate && $dp > 0)
                        @php($dpTotal = $dp)
                    @endif

                    @foreach($salesCollection->sell->installmentList as $key => $installment)
                        <?php
                            $installmentData = strtotime($installment->installment_date);
                            $paidInstallment =0;
                        ?>
                        @if($currentDate >= $installmentData)
                            <?php
                                $installmentAmount = $installment->installment_amount - $installment->installmentCollections->sum('amount');
                                $paidInstallment = $installment->installmentCollections()
                                    ->whereHas('salesCollection', function ($q) use($salesCollection){
                                        $q->where('sales_collection_id', '!=', $salesCollection->id);
                                    })->get();
                              $dueInstallment += $installment->installment_amount - $paidInstallment->sum('amount');
                            ?>
                        @endif
                    @endforeach
                    @money($totalDueAmount = $bmTotal + $dpTotal + $dueInstallment)
                </td>
                <td> Amount</td>
                <td style="text-align: right">@money($salesCollection->sell->total_value)</td>
            </tr>
            <tr>
                <td>Total Received</td>
                <td style="text-align: right">@money($salesCollection->received_amount)</td>
                <td>Paid Amount</td>
                <td style="text-align: right">
                    @if($salesCollection->payment_mode == 'cheque')
                        @money($paidValue - $salesCollection->received_amount)
                    @else
                        @money($paidValue)
                    @endif
                </td>
            </tr>
            <tr>
                <td>Balance</td>
                <td style="text-align: right">@money($totalDueAmount - $salesCollection->received_amount)</td>
                <td>Due Amount</td>
                <td style="text-align: right">@money($salesCollection->sell->total_value - $paidValue)</td>
            </tr>
{{--        @endforeach--}}
        </tbody>
    </table>
    <div align="right"  style="  color: red">
        Note: This Receipt is valid subject to realization of Cheque / Payorder / DD / TT
    </div>

    <div>
        <div id="barcode" style="width: 20%; ">
            <br>
            <img src="data:image/svg;base64, {{ base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)->generate(
        "ID: $salesCollection->id, Date: $salesCollection->received_date, Amount: $salesCollection->received_amount,Sell ID: ".$salesCollection->sell->id)) }} ">
        </div>

    </div>

</div>

<footer style="position: absolute; bottom: 0;">
    <p style="text-align: center;">
        <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}};</small>
    </p>
</footer>
</body>
</html>
