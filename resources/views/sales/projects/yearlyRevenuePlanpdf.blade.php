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
    <img src="{{ asset(config('company_info.logo'))}}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}" class="pdfimg">
    <div class="clearfix"></div>
    <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
</div>

<div class="container" style="margin-top: 10px; clear: both; display: block; width: 95%;">
    <h3 class="text-center"> Yearly Revenue Plan - {{$request->year ? $request->year : now()->format('Y')}}</h3>

    <table id="table" class="table  table-bordered">
        <thead>
        <tr>
            <tr>
                <th>Project</th>
                <th>Particular</th>
                {{-- <th>Hand <br> Over</th>
                <th>Unsold</th>
                <th>Closing <br> Inventory</th> --}}
                @foreach ($months as $month)
                    <th>{{ date('M', strtotime("$year-$month")) }}</th>
                @endforeach
                <th>Total</th>
            </tr>
        </tr>
        </thead>
        <tbody class="text-right">
            <?php
                $grandTotalBM = 0;
                $grandTotalAC = 0;
                $grandTotalEC = 0;
                ?>
            @foreach ($projects as $key => $project)
                <?php
                $totalBM = 0;
                $totalAC = 0;
                $totalEC = 0;
                ?>
            <tr>
                <td rowspan="4" class="text-left">{{ $project['project'] }}</td>
                <td class="text-center">Approximate Booking Money</td>
                @foreach ($months as $month)
                    <?php
                    $bm = array_key_exists("$year-$month", $project['bookingMoney']) ? $project['bookingMoney']["$year-$month"] : 0;
                    $totalBM += $bm;
                    $grandTotalBM += $bm;
                    ?>
                    <td>{{ number_format($bm) }}</td>
                @endforeach
                <td><strong>{{ number_format($totalBM) }}</strong></td>
            </tr>
            <tr>
                <td class="text-center">Approximate Revenue </td>

                @foreach ($months as $month)
                    <?php
                    $approximateCollection = array_key_exists("$year-$month", $project['approximateCollection']) ? $project['approximateCollection']["$year-$month"] : 0.0;
                    $totalAC += $approximateCollection;
                    $grandTotalAC += $approximateCollection;
                    ?>
                    <td>{{ number_format($approximateCollection) }}</td>
                @endforeach
                <td><strong> {{ number_format($totalAC) }}</strong></td>
            </tr>
            <tr>
                <td class="text-center">Existing Revenue</td>
                @foreach ($months as $month)
                    <?php
                    $exitingCollection = array_key_exists("$year-$month", $project['exitingCollection']) ? $project['exitingCollection']["$year-$month"] : 0.0;
                    $totalEC += $exitingCollection;
                    $grandTotalEC += $exitingCollection;
                    ?>
                    <td>{{ number_format($exitingCollection) }} </td>
                @endforeach
                <td><strong>{{ number_format($totalEC) }}</strong></td>
            </tr>
            <tr style="background-color: #2ed8b626">
                <td class="text-center"><strong>Total</strong></td>
                <?php $projectWiseYearTotal = 0; ?>
                @foreach ($months as $month)
                    <?php
                    $projectWiseBM = array_key_exists("$year-$month", $project['bookingMoney']) ? $project['bookingMoney']["$year-$month"] : 0.0;
                    $projectWiseAC = array_key_exists("$year-$month", $project['approximateCollection']) ? $project['approximateCollection']["$year-$month"] : 0.0;
                    $projectWiseEC = array_key_exists("$year-$month", $project['exitingCollection']) ? $project['exitingCollection']["$year-$month"] : 0.0;
                    $projectWiseTotal = $projectWiseBM + $projectWiseAC + $projectWiseEC;
                    $projectWiseYearTotal += $projectWiseTotal;
                    ?>
                    <td><strong>{{ number_format($projectWiseTotal) }}</strong> </td>
                @endforeach
                <td><strong>{{ number_format($projectWiseYearTotal) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-center"><strong> Approximate Booking Money </strong></td>
                @foreach ($months as $month)
                    <td class="text-right"> <strong>{{ number_format($totalBookingMoney["$year-$month"]) ?? 0 }}
                        </strong></td>
                @endforeach
                <td class="text-right"><strong>{{ number_format($grandTotalBM) }}</strong></td>
            </tr>
            <tr>
                <td colspan="2" class="text-center"><strong> Approximate Revenue </strong></td>
                @foreach ($months as $month)
                    <td class="text-right">
                        <strong>{{ number_format($totalApproximateCollection["$year-$month"]) ?? 0 }} </strong>
                    </td>
                @endforeach
                <td class="text-right"><strong>{{ number_format($grandTotalAC) }}</strong></td>
            </tr>
            <tr>
                <td colspan="2" class="text-center"><strong> Existing Revenue </strong></td>
                @foreach ($months as $month)
                    <td class="text-right"> <strong>{{ number_format($totalCollection["$year-$month"]) ?? 0 }}
                        </strong></td>
                @endforeach
                <td class="text-right"><strong>{{ number_format($grandTotalEC) }}</strong></td>
            </tr>
            <tr style="background-color: #2e91d842">
                <td colspan="2" class="text-center"><strong>Total Approximate Revenue </strong></td>
                <?php $yearlyTotalRevenue = 0 ; ?>
                @foreach ($months as $month)
                    <?php
                    $monthWiseTotal = $totalCollection["$year-$month"] + $totalApproximateCollection["$year-$month"] + $totalBookingMoney["$year-$month"];
                    $yearlyTotalRevenue += $monthWiseTotal;
                    ?>
                    <td class="text-right"> <strong>{{ number_format($monthWiseTotal) ?? 0 }}</strong></td>
                @endforeach
                <td class="text-right"><strong>{{ number_format($yearlyTotalRevenue) }}</strong></td>
            </tr>

            <tr>
                <td colspan="2" class="text-center"><strong> Booking Money Collection </strong></td>
                <?php $yearlyTotalBMCollection = 0 ; ?>
                @foreach ($months as $month)
                    <td class="text-right"> <strong>{{ number_format($totalBmCollection["$year-$month"]) ?? 0 }}
                        </strong></td>

                    <?php  $yearlyTotalBMCollection += $totalBmCollection["$year-$month"]; ?>
                @endforeach
                <td class="text-right"><strong>{{number_format($yearlyTotalBMCollection)}}</strong></td>
            </tr>

            <tr>
                <td colspan="2" class="text-center"><strong> New Project Collection </strong></td>
                <?php $yearlyNewCollectionTotal = 0 ; ?>
                @foreach ($months as $month)
                    <?php $yearlyNewCollectionTotal += $totalNewProjcetCollection["$year-$month"] ; ?>
                    <td class="text-right">
                        <strong>{{ number_format($totalNewProjcetCollection["$year-$month"]) ?? 0 }} </strong></td>
                @endforeach
                <td class="text-right"><strong>{{number_format($yearlyNewCollectionTotal)}}</strong></td>
            </tr>

            <tr>
                <td colspan="2" class="text-center"><strong> Existing Project Collection </strong></td>
                <?php $yearlyECTotal = 0; ?>
                @foreach ($months as $month)
                    <?php $yearlyECTotal += $totalExistingProjcetCollection["$year-$month"]?>
                    <td class="text-right">
                        <strong>{{ number_format($totalExistingProjcetCollection["$year-$month"]) ?? 0 }} </strong>
                    </td>
                @endforeach
                <td class="text-right"><strong>{{number_format($yearlyECTotal)}}</strong></td>
            </tr>

            <tr style="background-color: #484ecf3b">
                <td colspan="2" class="text-center"><strong>Total Actual Collection </strong></td>
                <?php  $YearlyTotalCollection = 0; ?>
                @foreach ($months as $month)
                    <?php
                        $monthlyTotalCollection = $totalExistingProjcetCollection["$year-$month"] +
                                                $totalNewProjcetCollection["$year-$month"] + $totalBmCollection["$year-$month"];
                        $YearlyTotalCollection += $monthlyTotalCollection;
                    ?>
                    <td class="text-right"> <strong>{{number_format($monthlyTotalCollection)}}</strong></td>
                @endforeach
                <td class="text-right"><strong>{{number_format($YearlyTotalCollection)}}</strong></td>
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
