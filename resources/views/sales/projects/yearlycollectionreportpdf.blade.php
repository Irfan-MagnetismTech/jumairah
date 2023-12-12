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
        @page { margin: 50px 20px 20px 50px; }
    </style>
</head>
<body>

<div id="logo" class="pdflogo">
    <img src="{{ asset(config('company_info.logo'))}}" alt="Logo" class="pdfimg">
    <div class="clearfix"></div>
    <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
</div>

<div class="container" style="margin-top: 10px; clear: both; display: block; width: 95%;">
    <h3 class="text-center"> Yearly Collection - {{$request->year ? $request->year : now()->format('Y')}}</h3>
    <table id="table" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Month</th>
            <th>Target</th>
            <th>Up Coming <br> Project</th>
            <th>Collection</th>
            <th>Backlog</th>
        </tr>
        </thead>
        <tbody>
        @php
            $totalTargets = 0;
            $totalCollections = 0;
            $totalBacklog = 0;
            $totalUpcomingCollections=0;
        @endphp
        @foreach($installments as $key => $installment)
            <tr>
                <td>{{$key}}</td>
                <td class="text-right">
                    @php($target = $installment)
                    @if($bookingMoneys->keys()->contains($key))
                        @php($target += $bookingMoneys[$key])
                    @endif
                    @if($downPayments->keys()->contains($key))
                        @php($target += $downPayments[$key])
                    @endif
                    @money($target)
                    @php($totalTargets+= $target)
                </td>
                <td class="text-right">
                    @if($upComings->keys()->contains($key))
                        @money($upComings[$key])
                        @php($totalUpcomingCollections += $upComings[$key])
                    @endif
                </td>
                <td class="text-right">
                    @if($saleCollections->keys()->contains($key))
                        @money($saleCollections[$key])
                        @php($totalCollections += $saleCollections[$key])
                    @endif
                </td>
                <td class="text-right">
                    @if($saleCollections->keys()->contains($key))
                        @money($target - $saleCollections[$key])
                        @php($totalBacklog += $target - $saleCollections[$key])
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot class="text-right">
            <tr class="bg-warning font-weight-bold">
                <td class="text-right">Total</td>
                <td>@money($totalTargets)</td>
                <td>@money($totalUpcomingCollections)</td>
                <td>@money($totalCollections)</td>
                <td>@money($totalBacklog)</td>
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
