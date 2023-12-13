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
            background-color: #0e2b4e;
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
        .head3{
            width: 55%;
            float: left;
            padding-bottom: 20px;
        }
        .head4{
            width: 42%;
            float: right;
            padding-bottom: 20px;
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
        @page { margin: 30px 0 0 30px; }
    </style>
    <title>Final Settlement Report </title>
</head>
<body>

<div id="logo" class="pdflogo">
    <img src="{{ asset(config('company_info.logo'))}}" alt="Logo" class="pdfimg">
    <div class="clearfix"></div>
    <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
</div>

<div class="container">
    <div class="row">
        <div class="head3">
            <table id="table">
                <tbody>
                    <tr>
                        <td colspan="3" class="tableHead">Collection Status</td>
                    </tr>
                    <tr>
                        <td>Project Name</td>
                        <td style="width: 2px !important;">:</td>
                        <td>{{$sell->apartment->project->name}}</td>

                    </tr>
                    <tr>
                        <td>Location</td>
                        <td style="width: 2px !important;">:</td>
                        <td>{{$sell->apartment->project->location}}</td>
                    </tr>
                    <tr>
                        <td>Apartment</td>
                        <td style="width: 2px !important;">:</td>
                        <td>{{$sell->apartment->name}}</td>
                    </tr>
                    <tr>
                        <td>Area(in sft)</td>
                        <td style="width: 2px !important;">:</td>
                        <td>@money($sell->apartment_size)</td>
                    </tr>
                    <tr>
                        <td>Rate/sft</td>
                        <td style="width: 2px !important;">:</td>
                        <td>@money($sell->apartment_rate)</td>
                    </tr>
                    <tr>
                        <td>Face</td>
                        <td style="width: 2px !important;">:</td>
                        <td>{{$sell->apartment->face}}</td>
                    </tr>
                    <tr>
                        <td>Floor</td>
                        <td style="width: 2px !important;">:</td>
                        <td>{{$sell->apartment->floor}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="head4">
            <h5 style="text-align: center; padding: 2px; ">Date: {{$sell->sell_date}}</h5>
            <div class="clientArea" style="border: 2px; color: #333;">
                @foreach($saleClients as $saleClient)
                    <p> Client Name: <strong>{{$saleClient->client->name}}</strong></p>
                    <p>Contact No.:  <strong>{{$saleClient->client->contact}}</strong></p>
                    <p>Email: <strong>{{$saleClient->client->email}}</strong> </p>
                    <br>
                @endforeach
            </div>
        </div>

    </div>
</div>

<div class="clearfix" style="clear: both;"></div>
<div class="container" style="width: 70%">
    <table id="table">
        <tbody>
            <tr>
                <td colspan="3" class="tableHead text-left">A. Collectable Amount</td>
            </tr>
            <tr>
                <td style="width: 80%">Space Cost</td>
                <td style="width: 2px !important;">:</td>
                <td style="text-align: right">@money($sell->apartment_value)</td>
            </tr>
            <tr>
                <td style="width: 80%">Parking ({{$sell->soldParking->count()}})</td>
                <td style="width: 2px !important;">:</td>
                <td style="text-align: right">@money($sell->soldParking->sum('parking_rate'))</td>
            </tr>
            <tr>
                <td style="width: 80%">Utility</td>
                <td style="width: 2px !important;">:</td>
                <td style="text-align: right">@money($sell->utility_fees)</td>
            </tr>
            <tr>
                <td style="width: 80%">Co-operative Fund [Refundable]</td>
                <td style="width: 2px !important;">:</td>
                <td style="text-align: right">@money($sell->reserve_fund)</td>
            </tr>
            <tr>
                <td style="width: 80%">Registration Cost</td>
                <td style="width: 2px !important;">:</td>
                <td style="text-align: right">@money($regCost = $sell->finalSettlement->registration_cost ?? 0)</td>
            </tr>
            <tr>
                <td style="width: 80%">Less: Refund by JHL</td>
                <td style="width: 2px !important;">:</td>
                <td style="text-align: right">@money($csd_final_costing_refund->sum('amount_refund'))</td>
            </tr>
            <tr>
                <td style="width: 80%">Cost of Additional & Modification Works</td>
                <td style="width: 2px !important;">:</td>
                <td style="text-align: right">@money($csd_final_costing_demand->sum('amount'))</td>
            </tr>
            <tr>
                <td style="width: 80%">Less: Special Discount</td>
                <td style="width: 2px !important;">:</td>
                <td style="text-align: right">@money( $discount = $sell->finalSettlement->discount ?? 0)</td>
            </tr>
            <tr>
                <td style="width: 80%">Delay Charge & Rebate</td>
                <td style="width: 2px !important;">:</td>
                <td style="text-align: right">@money($delayAmount = $sell->salesCollections->pluck('salesCollectionDetails')->flatten()->sum('applied_amount'))</td>
            </tr>
            <tr>
                <td style="width: 80%">Rental Compensation</td>
                <td style="width: 2px !important;">:</td>
                <td style="text-align: right">@money($totalrentalComponcetion)</td>
            </tr>

        </tbody>
        <tfoot>
        @php($totalPayable = $sell->total_value + $delayAmount + $csd_final_costing_demand->sum('amount') -
                            $csd_final_costing_refund->sum('amount_refund') + $regCost -
                             $discount - $totalrentalComponcetion)
            <tr>
                <td style="width: 80%; font-weight: bold; text-align: right">Total Collectable Amount</td>
                <td style="width: 2px !important;">:</td>
                <td style="text-align: right">@money($totalPayable)</td>
            </tr>
        </tfoot>
    </table>
</div>


<div class="container" style="width: 30%">
    <h5></h5>
</div>
<div class="clearfix" style="clear: both;"></div>
<div class="container" style="width: 95%;">
    <table id="table">
        <thead>
        <tr>
            <td colspan="8" class="tableHead text-left">B. Collected Amount</td>
        </tr>
        <tr>
            <th>Collection Date</th>
            <th>Payment Mode</th>
            <th>DD/PO/CQ No.</th>
            <th>MR No.</th>
            <th>Bank Name</th>
            <th>Bank Date</th>
            <th>Amount(Tk)</th>
            <th>Purpose</th>
        </tr>
        </thead>
        <tbody class="text-center">
            @forelse($sell->salesCollections as $saleCollection)
                <tr>
                    <td> {{$saleCollection->received_date}}</td>
                    <td> {{$saleCollection->payment_mode}}</td>
                    <td> {{$saleCollection->transaction_no ?? "---"}}</td>
                    <td> {{ $saleCollection->id }} </td>
                    <td> {{$saleCollection->source_name ?? "---"}} </td>
                    <td> {{$saleCollection->dated ?? "---"}} </td>
                    <td class="text-right"> @money($saleCollection->received_amount) </td>
                    <td> {{$saleCollection->salesCollectionDetails->pluck('particular')->join(', ', ', and ')}} </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8"> Not Found Any Record Yet. </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right"> Total Collected Amount </td>
                <td class="text-right">@money($totalReceive = $sell->salesCollections->sum('received_amount'))</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="container" style="width: 30%">
</div>
<div class="clearfix" style="clear: both;"></div>
<div class="container" style="width: 70%;">
    <table id="table">
        <thead>
        <tr>
            <td rowspan="2" class="tableHead text-left">C</td>
            <th>Collectable Amount</th>
            <th>Collected Amount</th>
            <th>Net Receivable</th>
        </tr>
        <tr>
            <td style="text-align: right">@money($totalPayable)</td>
            <td style="text-align: right">@money($totalReceive)</td>
            <td style="text-align: right">@money($totalPayable - $totalReceive)</td>
        </tr>
        </thead>

    </table>
</div>
<br>
<br>
<br>
<div class="" style="width:100%;">
    <div class="text-center" style="float:left; width:25%;">
        <span style="text-decoration: overline;">Prepared By </span>
    </div>
    <div class="text-center" style="float:left; width:25%;">
        <span style="text-decoration: overline;">Verified By </span>
    </div>
    <div class="text-center" style="float:left; width:25%;">
        <span style="text-decoration: overline;">Checked By </span>
    </div>
    <div class="text-center" style="float:left; width:25%; ">
        <span style="text-decoration: overline;">Authorized By </span>
    </div>
</div>

<footer style="position: absolute; bottom: 30px;">
    <p style="text-align: center;">
        <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}}</small>
    </p>
</footer>

{{--<div class="" style="width:100%; margin-top: 50px; position: absolute; bottom: 100px">--}}


</body>
</html>
