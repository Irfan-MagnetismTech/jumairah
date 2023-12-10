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
</head>
<body>

<div id="logo" class="pdflogo">
    <img src="{{ asset('images/Jumairah.png')}}" alt="Logo" class="pdfimg">
    <div class="clearfix"></div>
    <h5>JHL Address</h5>
</div>

<div id="pageTitle" style="display: block; width: 100%;">
    <h2 style="text-align: center; width: 30%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">Collections Report</h2>
    <h3 style="text-align: center; margin: 0 3px">
        Date:
        @if($dateType == "weekly")
            {{now()->subDays(7)->format('d-m-Y')}} to {{now()->format('d-m-Y')}}
        @elseif($dateType=="monthly")
            {{now()->subDays(30)->format('d-m-Y')}} to {{now()->format('d-m-Y')}}
        @elseif($dateType=="custom")
            {{$fromDate ? date('d-m-Y', strtotime($fromDate)) : null}} to {{$tillDate ? date('d-m-Y', strtotime($tillDate)) : null}}
        @else
            {{now()->format('d-m-Y')}} to {{now()->format('d-m-Y')}}
        @endif
    </h3>
    <h3 style="text-align: center; margin: 0 3px">
        Payment Mode : {{request()->payment_mode ?? "All"}}
    </h3>
</div>

<div class="container" style="margin-top: 10px; clear: both; display: block; width: 95%;">
    <table id="table" >
        <thead>
        <tr>
            <th>Project<br>Name</th>
            <th>Client's<br>Name</th>
            <th>Apartment<br>ID</th>
            <th>Collection<br>Date</th>
            <th>Payment<br>Mode</th>
            <th>Bank<br>Name</th>
            <th>Cheque<br>Dated</th>
            <th>Cheque<br>No</th>
            <th>Amount</th>
            <th>Purpose</th>
        </tr>
        </thead>
        <tbody>
        @forelse($salesCollections as $salesCollection)
            <tr style="text-align: center">
                <td>{{$salesCollection->sell->apartment->project->name}}</td>
                <td>{{$salesCollection->sell->sellClient->client->name}}</td>
                <td>{{$salesCollection->sell->apartment->name}}</td>
                <td>{{$salesCollection->received_date}}</td>
                <td>{{$salesCollection->payment_mode}}</td>
                <td>{{$salesCollection->source_name ?? "---"}}</td>
                <td>{{$salesCollection->dated ?? "---"}}</td>
                <td>{{$salesCollection->transaction_no ?? "---"}}</td>
                <td style="text-align:right"><strong>@money($salesCollection->received_amount)</strong></td>
                <td>{{$salesCollection->salesCollectionDetails->pluck('particular')->join(', ', ', and ')}}</td>
{{--                <td> {{$salesCollection->payment_status}} </td>--}}
            </tr>
        @empty
            <tr>
                <td colspan="10"> <h5 class="text-muted my-3"> No Data Found Based on your query. </h5> </td>
            </tr>
        @endforelse
        </tbody>
        @if($salesCollections->isNotEmpty())
{{--            <tfoot style="font-weight: bold; text-align: right; background: #e3e3e3">--}}
{{--            <tr>--}}
{{--                <td colspan="8" style="text-align: right">Total</td>--}}
{{--                <td>--}}
{{--                    @money($salesCollections->sum('received_amount'))--}}
{{--                </td>--}}
{{--                <td colspan="2"></td>--}}
{{--            </tr>--}}
{{--            </tfoot>--}}
        @endif
    </table>
</div>
<footer style="position: absolute; bottom: 30px;">
    <p style="text-align: center;">
        <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}}</small>
    </p>
</footer>

</body>
</html>
