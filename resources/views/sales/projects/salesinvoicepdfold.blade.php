<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Monthly Invoice</title>
    <style>
        body{margin: 20px ;padding: 0;font-family: sans-serif;font-size:14px;}
        body p{margin-top: 1px;margin-bottom: 1px;}
        .textUpper{text-transform: uppercase;}
        .textCenter{text-align: center;}
        .textRight{text-align:right;}
        .mrTB{margin-top: 8px; margin-bottom: 8px}
        .page_break{ page-break-after: always; }
        .clearFix{
            clear: both;
        }

        #amountTable table{
            width: 100%;
        }
        table, table th, table td {border-spacing: 0;}
        th{text-align: left;}
        #amountTable table th, #amountTable table td{padding:5px;}
        #amountTable table, #amountTable table th, #amountTable table td{
            border: 1px solid;
            border-collapse: collapse;
            font-size: 12px;
        }
        #amountTable table th{
            text-align: center;
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
    </style>
</head>
<body>
    <div class="clearFix" style="display: block; width: 100%; text-align: right">
        <p> Register With AD </p>
    </div>

    <div id="pageTitle" style="display: block; width: 100%;">
        <h2 class="textCenter" style="width: 20%; border: 1px solid #000000; border-radius: 5px; margin: 20px auto"> Invoice </h2>
    </div>

    <div style="clear: both; overflow: hidden"></div>

    <div>
        <p> Ref: Rancon FC/CCR/Atrium/AB-10 & {{now()->format('d/m/Y')}} </p><br>
        <p> {{now()->format('F d, Y')}} </p><br>
        <p style="text-align: right"> Project: <strong>{{$sell->apartment->project->name}}</strong></p>
        <p style="text-align: right"> Apartment: {{$sell->apartment->name}} </p><br>
        <div style="clear: both;"></div>
        <p><strong> {{$sell->sellClient->client->name}}  </strong></p>
        <p> {{$sell->sellClient->client->present_address}} </p>
    </div> <!-- end contentArea -->

    <div id="amountTable" style="margin: 25px;">
        <table>
            <thead style="background: #e3e3e3">
            <tr>
                <th> Particulars </th>
                <th> Amount (In Taka) </th>
            </tr>
            </thead>
            <tbody class="text-center">
                @if($sell->currentInstallment->installment_amount)
                    <tr>
                        <td style="width: 70%;">
                            Installment - {{$sell->currentInstallment->installment_no}}
                        </td>
                        <td class="text-right" style="width: 30%;">
                            Tk. @money($sell->currentInstallment->installment_amount)
                        </td>
                    </tr>
                @endif
                <tr>
                    <td style="width: 70%;"> Due </td>
                    <td class="text-right" style="width: 30%;"> Tk. @money($sell->due_till_today) </td>
                </tr>
            </tbody>
            <tfoot>
            <tr style="font-weight: bold" class="text-right">
                <td style="width: 70%;">Total Amount</td>
                <td style="width: 30%;">Tk. @money($totalDue = $sell->currentInstallment->installment_amount + $sell->due_till_today)</td>
            </tr>
            </tfoot>
        </table>
    </div> <!-- amountTable -->

    <p class="mrTB" style="font-weight: bold">
        In Word(Tk.) :
        @php
            $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        @endphp
        Taka {{Str::title($digit->format($totalDue))}}
    </p>
    <br>
    <p>Scheduled date of Payment: <strong>On or Before {{\Carbon\Carbon::parse($sell->currentInstallment->installment_date)->format('F d, Y')}}</strong></p><br>
    <p><strong>Special Advice:</strong></p>
    <ul style="line-height: 1.2;">
        <li>This will not be applicable if already paid.</li>
        <li>No payment will be granted without Cheque/DD/TT.</li>
        <li>Only DD/TT/PO will be accepted, in case of nation-wide Payments (Payments from outside of
            Dhaka).</li>
        <li>
            <strong>
                As per the terms and condition of the Deed of Agreement, delay in payments beyond the
                schedule date will make the allottee liable to pay a delay charge of {{$sell->apartment->project->delay_charge}}% per month interest on
                the amount of payment delayed.
            </strong>
        </li>
        <li>
            Payable only in favor of
            <strong>Rancon FC Properties Ltd.</strong>
        </li>
    </ul>
    <br>
    <p>Should you have any queries, please feel free to contact.</p><br>
    <p><strong>Contact Person:</strong></p>
    <p><strong>Bijoya</strong></p>
    <p>Executive-Customer Care Revenue</p>
    <p>Mob- xxxxxxxxxx, Email-xxxxxx@rancon.com.bd</p><br>
    <p>Thanking you and assuring you of our best services always.</p><br>
    <p>For Rancon FC Properties Ltd,</p><br><br><br>
    <p style="border-top: 1px solid #333; display: inline-block;"><strong>Authorized Signature</strong></p>

    </body>
</html>
