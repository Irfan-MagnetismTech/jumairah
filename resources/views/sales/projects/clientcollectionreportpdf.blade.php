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
            position: relative;
        }
        #client{
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            top: 0;
            line-height: 18px;
            padding: 5px;
        }
        #apartment{
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            right: 20px;
            top: 20px;
            line-height: 18px;
            padding: 5px;
        }
        .infoTable{
            font-size: 12px;
            width: 100%;
        }
        .infoTableTable td:nth-child(2) {
            text-align: center;
            width: 20px;
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
        @page { margin: 00px 0 0 30px; }
    </style>
</head>
<body>

    <div class="container">
        <div id="logo" class="pdflogo">
            <img src="{{ asset(config('company_info.logo'))}}" alt="Logo" class="pdfimg">
            <div class="clearfix"></div>
            <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
        </div>
        <div id="client">
            <table class="infoTable">
                <tr style="vertical-align: top">
                    <td>Client Name</td>
                    <td>:</td>
                    <td><strong>{{$clientCollections->first()->sell->sellClient->client->name}}</strong></td>
                </tr>
                <tr>
                    <td>Project name</td>
                    <td>:</td>
                    <td><strong>{{$clientCollections->first()->sell->apartment->project->name}}</strong></td>
                </tr>
                <tr>
                    <td>Apartment ID</td>
                    <td>:</td>
                    <td><strong>{{$clientCollections->first()->sell->apartment->name}}</strong></td>
                </tr>
                <tr>
                    <td>Sold Date</td>
                    <td>:</td>
                    <td><strong>{{$clientCollections->first()->sell->sell_date}}</strong></td>
                </tr>
            </table>
        </div>

        <div id="apartment">
            <table class="infoTable">
                <tr>
                    <td>Apartment Value</td>
                    <td>:</td>
                    <td  style="text-align: right"><strong>@money($clientCollections->first()->sell->apartment_value)</strong></td>
                </tr>
                <tr>
                    <td>Car Parking</td>
                    <td>:</td>
                    <td  style="text-align: right"><strong>@money($clientCollections->first()->sell->parking_price)</strong></td>
                </tr>
                <tr>
                    <td>Utility</td>
                    <td>:</td>
                    <td  style="text-align: right"><strong>@money($clientCollections->first()->sell->utility_fees)</strong></td>
                </tr>
                <tr>
                    <td>Reserve Fund</td>
                    <td>:</td>
                    <td  style="text-align: right"><strong>@money($clientCollections->first()->sell->reserve_fund)</strong></td>
                </tr>
            </table>
        </div>

    </div>
    <div id="pageTitle" style="display: block; width: 100%;">
        <h2 style="text-align: center; width: 25%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">Collections Report</h2>
    </div>
<div class="container" style="margin-top: 10px; clear: both; display: block; width: 97%;">
    <table id="table">
        <thead>
        <tr>
            <th>Received<br>Date</th>
            <th>Purpose</th>
            <th>Scheduled <br>Amount</th>
            <th>Received <br>Amount</th>
            <th>Due <br>Amount</th>
            <th>Schedule <br>Date</th>
            <th>Cheque<br>Honored<br>Date</th>
            <th>D/A<br>Days</th>
            <th>Delay<br>Charge<br>Rate(%)</th>
            <th>Delay<br>Charge<br>Amount</th>
            <th class="breakWords">Remarks</th>
        </tr>
        </thead>
        <tbody>
        @php($totalScheduledAmount=0)
        @forelse($clientCollections as $key => $clientCollection)
            @php($countRow=count($clientCollection->salesCollectionDetails))
            @foreach($clientCollection->salesCollectionDetails as $collectionDetail)
                <tr>
                    @if($loop->first)
                    <td rowspan="{{$countRow}}">{{$clientCollection->received_date}}</td>
                    @endif
                    <td>{{$collectionDetail->particular}} {{$collectionDetail->installment_no ? "- $collectionDetail->installment_no" : null}}</td>
                    <td class="text-right">
                        @if($collectionDetail->installment_no)
                            @php($scheduledAmount= $collectionDetail->salesCollection->sell->installmentList->where('installment_no', $collectionDetail->installment_no)->first()->installment_amount)
                            @money($scheduledAmount)
                            @php($totalScheduledAmount+=$scheduledAmount)
                        @elseif($collectionDetail->particular == "Booking Money")
                            @php($scheduledAmount=$collectionDetail->salesCollection->sell->booking_money)
                            @money($scheduledAmount)
                            @php($totalScheduledAmount+=$scheduledAmount)
                        @elseif($collectionDetail->particular == "Down Payment")
                            @php($scheduledAmount=$collectionDetail->salesCollection->sell->downpayment)
                            @money($scheduledAmount)
                            @php($totalScheduledAmount+=$scheduledAmount)
                        @endif
                    </td>
                    <td style="text-align: right">@money($collectionDetail->amount)</td>
                    <td>??</td>
                    <td>
                        @if($collectionDetail->installment_no)
                            {{$collectionDetail->salesCollection->sell->installmentList->where('installment_no', $collectionDetail->installment_no)->first()->installment_date}}
                        @elseif($collectionDetail->particular == "Booking Money")
                            {{$collectionDetail->salesCollection->sell->booking_date}}
                        @elseif($collectionDetail->particular == "Down Payment")
                            {{$scheduledAmount=$collectionDetail->salesCollection->sell->downpayment_date}}
                        @endif
                    </td>
                    <td class="text-right">{{$collectionDetail->dated}}</td>
                    <td>Later??</td>
                    <td>Later??</td>
                    <td>Later??</td>
                    <td class="text-left">{{$clientCollection->remarks}}</td>
                </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="10"> <h5 class="text-muted my-3 text-left"> No Data Found Based on your query. </h5> </td>
            </tr>
        @endforelse
        </tbody>
        @if($clientCollections->isNotEmpty())
            <tfoot style="font-weight: bold; text-align: right; background: #e3e3e3">
            <tr>
                <td colspan="2">Total</td>
                <td>@money($totalScheduledAmount)</td>
                <td>@money($clientCollections->sum('sales_collection_details_sum_amount'))</td>
                <td colspan="7"></td>
            </tr>
            </tfoot>
        @endif
    </table>

    <table id="table" style="width: 50%; margin-top: 50px">
        <thead>
            <tr>
                <td colspan="3" class="tableHead">Collection Summary</td>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td>Total Value</td><td style="width: 2px !important;">:</td>
                <td class="text-right"> @money($clientCollections->first()->sell->total_value) </td>
            </tr>
            <tr>
                <td>Receivable as of Today</td><td style="width: 2px !important;">:</td>
                <td class="text-right"> @money($clientCollections->first()->sell->dueTillToday) </td>
            </tr>
            <tr>
                <td>Total Received</td><td style="width: 2px !important;">:</td>
                <td class="text-right"> @money($clientCollections->sum('sales_collection_details_sum_amount'))</td>
            </tr>
            <tr>
                <td>Dues</td><td style="width: 2px !important;">:</td>
                <td class="text-right"> @money($clientCollections->first()->sell->total_value - $clientCollections->sum('sales_collection_details_sum_amount')) </td>
            </tr>
            <tr>
                <td>Delay Charges</td><td style="width: 2px !important;">:</td>
                <td class="text-right"> </td>
            </tr>
            <tr>
                <td>Rebate</td><td style="width: 2px !important;">:</td>
                <td class="text-right"> @money($clientCollections->sum('sales_collection_details_sum_rebate_amount')) </td>
            </tr>
        </tbody>
        <tfoot style="font-weight: bold">
            <tr>
                <td>Total Dues</td><td style="width: 2px !important;">:</td>
                <td class="text-right">
                    {{--(Dues + Delay Char - Rebate +  )--}}
                    @money($clientCollections->first()->sell->total_value - $clientCollections->sum('sales_collection_details_sum_amount') - $clientCollections->sum('sales_collection_details_sum_rebate_amount'))
                </td>
            </tr>
        </tfoot>
    </table>
</div>


<footer style="position: absolute; bottom: 30px;">
    <p style="text-align: center;">
        <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}}</small>
    </p>
</footer>

</body>
</html>
