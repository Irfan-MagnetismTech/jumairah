<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        #tableArea{margin-top: 10px;margin-bottom: 10px;}
        table, table th, table td {border-spacing: 0;border: 0px solid #000;}
        table th, table td{padding:5px;}
        .base_header{font-weight: bold;}
        .balance_header{ padding-left:50px; }
        .balance_line{ padding-left:30px;}
        .balance_line:hover{ background: #c5c5c5;}
        .account_name{padding-left:50px;}
        .account_row{display: none}
    </style>
</head>

<body>
<div style="text-align: center">
    <img src="{{asset(config('company_info.logo'))}}" alt="{{ asset(config('company_info.altText')) }}">
    <h1 style="margin:0; padding:0">Cash-Flow Statement</h1>
    <strong>December 31, {{now()->format('Y')}}</strong>
</div>
<br>

<div>
    <table style="width: 100%">
        <thead>
        <tr style="text-align: center; background:#227447; color: white; font-weight: bold">
            <td rowspan=""> Particulars </td>
            {{--                <td rowspan="2"> Opening Balance </td>--}}
            {{--                <td colspan="2"> Transactions </td>--}}
            <td rowspan="">Amount </td>
        </tr>
        <tr>
            <td class="base_header">Cash Flow From Operation</td>
            <td style="text-align: right"></td>
        </tr>
        <tr>
            <td class="balance_line">Net Earnings</td>
            <td style="text-align: right">@money(2250000)</td>
        </tr>
        <tr>
            <td class="balance_line">Additions to Cash</td>
            <td style="text-align: right"></td>
        </tr>
        <tr>
            <td class="balance_header">Depreciation</td>
            <td style="text-align: right">@money(300000)</td>
        </tr>
        <tr>
            <td class="balance_header">Decrease in Account Receivable</td>
            <td style="text-align: right">@money(450000)</td>
        </tr>
        <tr>
            <td class="balance_header">Increase in Account Payable</td>
            <td style="text-align: right">@money(200000)</td>
        </tr>
        <tr>
            <td class="balance_header">Increase in Taxes Payable</td>
            <td style="text-align: right">@money(60000)</td>
        </tr>

        <tr>
            <td class="balance_line">Subtractions From Cash</td>
            <td style="text-align: right"></td>
        </tr>
        <tr>
            <td class="balance_header">Increase Inventory</td>
            <td style="text-align: right">(@money(700000))</td>
        </tr>
        <tr>
            <td class="base_header"><u>Net Cash From Operating</u></td>
            <td style="text-align: right"><u>@money(2740000)</u></td>
        </tr>
        <tr>
            <td class="base_header">Cash Flow from Investing</td>
            <td style="text-align: right"></td>
        </tr>
        <tr>
            <td class="balance_header">Equipment</td>
            <td style="text-align: right">(@money(1500000))</td>
        </tr>
        <tr>
            <td class="base_header">Cash Flow from Financing</td>
            <td style="text-align: right"></td>
        </tr>
        <tr>
            <td class="balance_header">Notes Payable</td>
            <td style="text-align: right">@money(500000)</td>
        </tr>
        <tr>
            <td class="base_header"><u>Cash Flow for FY Ended  - 2022</u></td>
            <th style="text-align: right"><u>@money(1740000)</u></th>
        </tr>
        {{--            <tr style="text-align: center; background:#227447; color: white; font-weight: bold">--}}
        {{--                <td> Debit </td>--}}
        {{--                <td> Credit </td>--}}
        {{--            </tr>--}}
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
    $(function(){
        $(document).on('click', '.balance_line', function(){
            let currentLine = $(this).attr('id');
            $(".balance_account_"+currentLine).toggle();
        });
    });
</script>

</body>
</html>
