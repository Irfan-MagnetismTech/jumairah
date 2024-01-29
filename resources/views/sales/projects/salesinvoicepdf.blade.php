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
    <title>Invoice</title>
</head>
<body>

<div id="logo" class="pdflogo">
    <img src="{{ asset(config('company_info.logo'))}}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}" class="pdfimg">
    <div class="clearfix"></div>
    <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
</div>

<div class="container">
    <div style="text-align: center">
        <div align="center" style="padding: 10px;margin: 0 40% 0 40%; border: 1px solid grey; box-shadow: 2px 5px black; font-size: 16px; background-color: rgba(245,243,243,0.9)">
            <strong>Invoice</strong>
        </div>
    </div>
    <br>
    <table width="100%">
        <tr>
            <td> Ref: <strong>{!! htmlspecialchars(config('company_info.company_shortname')) !!}/CSD/{{$sell->apartment->project->shortName}}/{{date('d/m/y', strtotime(now()))}}</strong> </td>
            <td style="text-align: right"> Project: <strong>{{$sell->apartment->project->name}}</strong> </td>
        </tr>
        <tr>
            <td>{{date('F d, Y', strtotime(now()))}}</td>
            <td style="text-align: right"> Apt. ID: <strong>{{$sell->apartment->name}}</strong></td>
        </tr>
    </table>
    <p></p>
    <p></p> <br><br>
    <p><strong>{{$sell->sellClient->client->name}}</strong></p>
    <p>{{$sell->sellClient->client->present_address}}</p>
    <p>{{$sell->sellClient->client->email}},
        {{$sell->sellClient->client->contact}}</p><br>
    <table class="table" width="60">
        <tr>
            <th style="text-align: center"> Particulars</th>
            <th style="text-align: center"> Amount (in Taka)</th>
        </tr>
        <tr>
            <td>Total Value of Apartments</td>
            <td style="text-align: right">Tk. @money($aparmentValua = $sell->total_value)</td>
        </tr>
        <tr>
            <td>Total Paid</td>
            <td style="text-align: right">Tk. @money($paidValue)</td>
        </tr>
        <tr>
            <th>Receivable till handover</th>
            <th style="text-align: right"><strong>Tk. @money($aparmentValua - $paidValue) </strong></th>
        </tr>
    </table>

    <table class="table"  >
        <tr>
            <th style="text-align: center"> Due & Current Installment No</th>
            <th style="text-align: center"> Amount (in Taka)</th>
            <th style="text-align: right">Schedule Date</th>
        </tr>
        @php($currentDate = strtotime(now()))
        @php($bm = $sell->booking_money - $sell->bookingMoneyCollections->sum('amount'))
        @php($bmTotal=0)
        @php($bmDate = strtotime($sell->booking_money_date))
        @if($currentDate >= $bmDate && $bm > 0)
            @php($bmTotal = $bm)
            <tr>
                <td style="text-align: left">Booking Money</td>
                <td style="text-align: right">@money($bm)</td>
                <td style="text-align: right">{{$sell->booking_money_date}}</td>
            </tr>
        @endif
        @php($dp = $sell->downpayment - $sell->downpaymentCollections->sum('amount'))
        @php($dpDate = strtotime($sell->downpayment_date))
        @if($currentDate >= $dpDate && $dp > 0)
            @php($bmTotal = $dp)
            <tr>
                <td style="text-align: left">Down Payment</td>
                <td style="text-align: right">@money($dp)</td>
                <td style="text-align: right">{{$sell->downpayment_date}}</td>
            </tr>
        @endif
        @php($dueInstallment = 0)
        @foreach($sell->installmentList as $key => $installment)
            @php($installmentAmount = $installment->installment_amount - $installment->installmentCollections->sum('amount'))
            @php($installmentData = strtotime($installment->installment_date))
            @if($currentDate >= $installmentData && $installmentAmount > 0)
                @php($dueInstallment += $installmentAmount)
                <tr>
                    <td style="text-align: left">Installment - {{$installment->installment_no}}</td>
                    <td style="text-align: right">@money($installmentAmount)</td>
                    <td style="text-align: right">{{$installment->installment_date}} </td>
                </tr>
            @endif
        @endforeach

        @php($nextbm = $bookingSchedule ? $bookingSchedule->booking_money - $sell->bookingMoneyCollections->sum('amount') : 0)
        @php($nextdp = $downPaymentSchedule ? $downPaymentSchedule->downpayment - $sell->downpaymentCollections->sum('amount'): 0)
        @php($nextInstallmentAmt = $sell->nextInstallment ? $sell->nextInstallment->installment_amount - $sell->nextInstallment->installmentCollections->sum('amount'): 0)
        @php($nextPayment=0)
        @php($upCommingDate ='')
        @if(!empty($bookingSchedule) && $nextbm > 0)
            @php($upCommingDate = $bookingSchedule->booking_money_date)
            @php($nextPayment = $nextbm)
            <tr>
                <td style="text-align: left">Booking Money</td>
                <td style="text-align: right">@money($nextbm)</td>
                <td style="text-align: right">{{$bookingSchedule->booking_money_date}}</td>
            </tr>
        @elseif(!empty($downPaymentSchedule) && $nextdp > 0)
            @php($upCommingDate = $bookingSchedule->downpayment_date)
            @php($nextPayment = $nextdp)
            <tr>
                <td style="text-align: left">Down Payment</td>
                <td style="text-align: right">@money($nextdp)</td>
                <td style="text-align: right">{{$bookingSchedule->downpayment_date}}</td>
            </tr>
        @elseif(!empty($sell->nextInstallment && $nextInstallmentAmt > 0))
            @php($upCommingDate = $sell->nextInstallment->installment_date)
            @php($nextPayment = $nextInstallmentAmt)
            <tr>
                <td style="text-align: left">Installment - {{$sell->nextInstallment->installment_no}}</td>
                <td style="text-align: right">@money($nextInstallmentAmt)</td>
                <td style="text-align: right">{{$sell->nextInstallment->installment_date}} </td>
            </tr>
        @elseif(!empty($sell->nextInstallment ))
            @php($upCommingDate = $sell->nextInstallment->installment_date)
            @php($nextPayment = $sell->nextInstallment->installment_amount)
            <tr>
                <td style="text-align: left">Installment - {{$sell->nextInstallment->installment_no}}</td>
                <td style="text-align: right">@money($sell->nextInstallment->installment_amount)</td>
                <td style="text-align: right">{{$sell->nextInstallment->installment_date}} </td>
            </tr>
        @endif
        <tr>
            <td style="">Delay Charge & Rebate</td>
            <td style="text-align: right">@money($delayCharge)</td>
            <td style="text-align: right; font-weight: bold"></td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold">Total</td>
            <td style="text-align: right; font-weight: bold">@money($totalAmount = $bmTotal + $dueInstallment + $nextPayment + $delayCharge)</td>
            <td style="text-align: right"></td>
        </tr>
    </table>
    <div id="advice">
        @php($inwords = $spell->format($totalAmount))
        <p><strong>In Word (Tk): </strong> {{$inwords}}</p><br>
        <p>Requested to pay- On or Before
            <strong> {{($upCommingDate != '') ? date('F d, Y', strtotime($upCommingDate)) : ''}}</strong>
        </p> <br>
        <h4>Special Advice:</h4>
        <ul>
            <li>This will not be applicable <strong> if already paid.</strong> </li>
            <li>No payment will be granted without Cheque/DD/TT/PO/Bank to Bank Transfer. </li>
            <li>Only DD/TT will be accepted, In cash of nation-wide Payments (Payment from outside of Dhaka). </li>
            <li>
                All dates & calculations mentioned here are based on the Payment Agreement, the allotment letter, or the purchase deed.
            </li>
            <li> <strong>
                 As per the terms and condition of the Deed of Agreement, delay in payments beyond the schedule date will make
                 the allottee liable to pay a delay charge of 2.5% per month interest on the amount of payment delayed. On the other
                 hand, if Allottee(s) pay ahead of schedule date,  he/she get rebate 7% pr/annum on that particular installment.
                </strong>
            </li>
            <li>
                Delay Fees (2.5% pre month) are non-waivable. No apartment will be handed over unless delay fees are
                settled off. if the payments are delayed beyond 90 days, {!! htmlspecialchars(config('company_info.company_fullname')) !!} may exercise its right to cancel the allotment.
            </li>
            <li>
                Sanction of Loan and processing time is not the developer's liabilities. No delay due to loan processing
                will be waived from the schedule.
            </li>
            <li>
                Without settling previous dues, no application or request for rescheduling will be accepted.
            </li>
            <li><strong>Payable only in favor of {!! htmlspecialchars(config('company_info.company_fullname')) !!}</strong></li>
        </ul> <br>
        <p>Should you have any queries, please feel free to contact with our customer service team.</p><br>
        <p>Thanking you and assuring you of our best services always. </p><br>
        <p>For {!! htmlspecialchars(config('company_info.company_fullname')) !!} </p><br><br><br><br>
        <div style="border-top: 2px solid #000000; width: 150px;">
            <p> <strong>   Authorized Signature </strong> </p>
        </div>

    </div>

    {{-- <div id="barcode">
        <br>
        <img src="data:image/svg;base64, {{ base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)->generate(
        "ID: $salesCollection->id, Date: $salesCollection->received_date, Amount: $salesCollection->received_amount,Sell ID: ".$salesCollection->sell->id)) }} ">

    </div> --}}
</div>

<footer style="position: absolute; bottom: 0;">
    <p style="text-align: center;">
        <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}};</small>
    </p>
</footer>
</body>
</html>
