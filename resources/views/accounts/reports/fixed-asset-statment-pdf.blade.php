<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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

        table {
            font-family: Arial, Helvetica, sans-serif;
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid black;
        }

        th {
            background-color: #227447;
            color: white;
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
            background-color: #0e2b4e;
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

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <div style="text-align: center">
        <img src="{{asset(config('company_info.logo'))}}" alt="">
        <h1 style="margin:0; padding:0">Fixed Asset Statement</h1>
        <strong>{{$request->fromDate}} - {{$request->toDate}}</strong>
    </div>
    <br>

    <div>
        <table style="width: 100%">
            <thead>
                <tr style="text-align: center; background:#227447; color: white; font-weight: bold">
                    <td rowspan="2"> Particulars </td>
                    <td rowspan="" colspan="2"> Voucher Ref. </td>
                    <td rowspan="2"> Dep Rate </td>
                    <td rowspan="2"> Depreciation <br> Calculation <br> Month </td>
                    <td rowspan="" colspan="4"> Cost </td>
                    <td rowspan="" colspan="4"> Depreciation </td>
                    <td rowspan="2"> WDV </td>
                </tr>
                <tr style="text-align: center; background:#227447; color: white; font-weight: bold">
                    <td> No </td>
                    <td> Date </td>
                    <td> Opening </td>
                    <td> Addition </td>
                    <td> Deletion </td>
                    <td> Closing </td>

                    <td> Opening </td>
                    <td> Addition </td>
                    <td> Deletion </td>
                    <td> Closing </td>
                </tr>
            </thead>
            <tbody>
                @foreach ($fixedAssets as $key => $fixedAsset)
                {{-- {{dd($fixedAsset)}}--}}
                {{-- @php $fixedAssetAccount = $fixedAsset->asset->account()->where('balance_and_income_line_id',86)->first() @endphp--}}
                <tr>
                    <td class="text-left">{{$fixedAsset->tag}}</td>
                    <td> {{$fixedAsset->transaction->id}}</td>
                    <td>{{$fixedAsset->transaction->transaction_date}}</td>
                    <td class="text-center">{{$fixedAsset->percentage}} </td>
                    <td></td>
                    <td class="text-right"> @money($openingCost = $fixedAsset->previousTransection->ledgerEntries->flatten()->sum('dr_amount'))</td>
                    <td class="text-right">@money($additionCost = $fixedAsset->transaction->ledgerEntries->flatten()->sum('dr_amount'))</td>
                    <td class="text-right"></td>
                    <td class="text-right">@money($closingCost = $openingCost + $additionCost)</td>
                    <td class="text-right">@money($openingDepreciation = $fixedAsset->previousMonth->sum('amount'))</td>
                    <td class="text-right"> @money($additionalDepreciation = $fixedAsset->depreciationDetails->sum('amount')) </td>
                    <td class="text-right"></td>
                    <td class="text-right">@money($closingDep = $openingDepreciation + $additionalDepreciation)</td>
                    <td class="text-right">@money($closingCost - $closingDep)</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
