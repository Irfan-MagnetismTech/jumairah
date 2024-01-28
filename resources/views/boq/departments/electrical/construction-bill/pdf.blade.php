<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Work Order PDF</title>
</head>
<style>
    .textUpper{
        text-transform: uppercase;
    }
    .textCenter{
        text-align: center;
    }
    .textRight{
        text-align:right;
    }
    p{
        margin: 0;
    }
    .pullLeft{
        float:left;
        width:55%;
        display: block;
    }
    .pullRight{
        float:right;
        width: 25%;
        display: block;
    }
    .pullLeft, .pullRight{
        margin-top: 10px;
        margin-bottom: 10px;
    }
    table, table th, table td {
        border-spacing: 0;
        padding-bottom: 0;
    }
    .terms li{
        word-wrap: break-word;
    }

    #payment_schedule, #payment_schedule th, #payment_schedule td {
        border-spacing: 0;
        padding-bottom: 0;
        border: 1px solid #000;
        font-size: 14px;
        vertical-align: middle;
        border-collapse: collapse;
    }

    .wo_pages {
        position: absolute;
        top: 100px;
        right: 15px;
        background: black;
        color: #fff;
        display:inline-block;
        line-height: 18px;
        font-weight: 14px;
        padding: 3px 5px;
    }

    .page_break { page-break-after: always; }
    @page {
        margin: 80px 30px 80px 30px;
    }
    html body{
        /* background: green!important;  */
    }

    header {
        position: fixed;
        top: -60px;
        left: 0;
        right: 0;
    }
    #signature {
        position: fixed;
        bottom: 28px;
        left: -10;
        right: 0;
        height: 30px;
        width: 100%;
        display: block;
    }
    footer{
        position: fixed;
        bottom: -40px;
        left: 0;
        right: 0;
        height: 30px;
        width: 100%;
        display: block;
        font-size: 11px;
    }

    tr.hide_all > td, td.hide_all{
        border-style:hidden!important;

    }
</style>
<body>
    <header>
        <div id="logo" class="pdflogo">
            <img src="{{ asset('images/ranksfc_log.png')}}" alt="Logo" class="pdfimg pullRight">
        </div>
    </header>

    <footer>
        Atlas Rangs Plaza (Level 9&10), 7, Sk. Mujib Road,<br>
        Agrabad C/A, Chattogram, <br>
        Phone: 2519906-8, 712023-5 <br>
        {!! htmlspecialchars(config('company_info.company_email')) !!}
    </footer>

    <div class="container" style= "width:100%; margin-top:8px;">
        <div class="text-left" style="float:left; width:80%;">
            <p>{{$constructionBill->date}}</p>
        </div>
        <div class="text-center" style="float: right; width:20%;">
            <p> Bill Sl. No. {{ $constructionBill?->bill_no }} </p>
        </div>

    </div>
        <p style="text-align: center; margin-top: 40px;"><strong>BILL</strong></p>
        <p style="text-align: center;"><strong>Name: {{$constructionBill?->supplier?->name}}</strong></p>
        <P style="text-align: center;">Project Name: {{$constructionBill?->project?->name}} </P>
        <P style="text-align: center;">Type of Work:
            @foreach($constructionBill->workorder->workorderRates as $rate)
                {{ $rate->work_level }}
                @if (!$loop->last)
                   ,
                @endif
            @endforeach
        </P><br>
        <div class="container">
            <table style="margin-top: 5px; margin-bottom: 20px; width: 100%;" id="payment_schedule">
                <thead>
                    <tr>
                        <th style="width: 15%;">No. of Bill</th>
                        <th style="width: 13%;">Unit</th>
                        <th style="width: 18%;">Bill Amount</th>
                        <th style="width: 18%;">Cumulative bill <br> Amount</th>
                        <th style="width: 18%;">Paid Amount</th>
                        <th style="width: 18%;">Due <br> Payable Amount</th>
                        <th style="width: 18%;">Adjusted <br>Amount</th>
                    </tr>
                </thead>

                @php
                    $cumulitive_bill = 0;
                    $paid_amount = 0;
                    $security = 0;
                    $due_payable = 0;
                    $adjusted_amount = 0;
                    $bill_no = 1;
                    $security_percent = [];
                    function addOrdinalNumberSuffix($num) {
                        if (!in_array(($num % 100),array(11,12,13))){
                            switch ($num % 10) {
                                // Handle 1st, 2nd, 3rd
                                case 1:  return $num.'st';
                                case 2:  return $num.'nd';
                                case 3:  return $num.'rd';
                            }
                        }
                        return $num.'th';
                    }
                @endphp
                <tbody>
                @foreach ($All_dates as $key => $value)

                    @if (isset($advance[$value]))
                        @foreach ($advance[$value] as $key2 => $value2)
                            <tr>
                                <td class="textCenter">Advanced</td>
                                <td class="textCenter">Tk.</td>
                                <td class="textRight" style="padding-right:5px"></td>
                                @php
                                    $paid_amount += $value2->dr_amount;
                                @endphp
                                <td class="textRight" style="padding-right:5px">@money($cumulitive_bill)</td>
                                <td class="textRight" style="padding-right:5px">@money($value2->dr_amount)</td>
                                <td class="textRight" style="padding-right:5px"></td>
                                <td class="textRight" style="padding-right:5px"></td>
                            </tr>
                        @endforeach
                    @endif
                    @if(isset($allConstructionBill[$value]))
                        @foreach ($allConstructionBill[$value] as $key3 => $value3)
                            <tr>
                                <td class="textCenter">{{addOrdinalNumberSuffix($bill_no)}} Bill ( {{$value3->workorderRates->work_level}}) </td>
                                <td class="textCenter">Tk.</td>
                                <td class="textRight" style="padding-right:5px">@money($value3->bill_amount)</td>
                                @php
                                    $cumulitive_bill += $value3->bill_amount;
                                    $security += $value3->bill_amount * $value3->percentage / 100;
                                    $paid_amount += $value3->paidBill;
                                    $adjusted_amount += $value3->adjusted_amount;
                                    $bill_no++;
                                    array_push($security_percent,$value3->workorderRates->work_level.'_'.$value3->percentage);
                                @endphp
                                <td class="textRight" style="padding-right:5px">@money($cumulitive_bill)</td>
                                <td class="textRight" style="padding-right:5px">@money($value3->paidBill)</td>

                                @if ($loop->last)
                                    <td class="textRight" style="padding-right:5px">0.00</td>
                                @else
                                    @if ($value3->paidBill == 0)
                                        <td class="textRight" style="padding-right:5px">@money($value3->due_payable)</td>
                                        @php
                                            $due_payable += $value3->due_payable;
                                        @endphp
                                    @else
                                        <td class="textRight" style="padding-right:5px">0.00</td>
                                    @endif


                                @endif
                                <td class="textRight" style="padding-right:5px">@money($value3->adjusted_amount)</td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="hide_all">
                    <td class="hide_all" style="width: 90%">Total Bill Amount</td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" style="width: 10%" class="textRight">@money($cumulitive_bill)</td>
                    <td class="hide_all" ></td>
                    <td class="textRight" style="padding-right:5px">@money($paid_amount)</td>
                    <td class="textRight">@money($due_payable)</td>
                    <td class="textRight">@money($adjusted_amount)</td>
                </tr>
                @php
                    $dddd = array_unique($security_percent);
                @endphp
                <tr class="hide_all" style="width: 100%;">
                    <td class="hide_all" style="width: 90%">Less: security money
                        <br /> (
                        @foreach ($dddd as $security_percen)
                            @php
                                $data = explode("_",$security_percen);
                            @endphp
                              {{ $data[1] }}% on {{ $data[0] }}
                              @if (!$loop->last)
                                  ,
                              @endif
                        @endforeach
                        )
                    </td>
                    <td class="hide_all" ></td>
                    <td style="width: 10%" class="textRight">@money($security)</td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                </tr>
                <tr  class="hide_all" style="width: 100%;">
                    <td class="hide_all"  style="width: 90%"><strong>Net total bill amount</strong></td>
                    <td class="hide_all" ></td>
                    <td style="width: 10%" class="textRight"><strong>@money($cumulitive_bill - $security)</strong></td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                </tr>
                <tr  class="hide_all" class="blank_row" style="width: 100%;">
                    <td bgcolor="#FFFFFF" colspan="2">&nbsp;</td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                </tr>
                <tr  class="hide_all" style="width: 100%;">
                    <td style="width: 90%;">Less: Total paid amount (with advance)</td>
                    <td class="hide_all" ></td>
                    <td style="width: 10%" class="textRight">@money($paid_amount)</td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                </tr>
                <tr  class="hide_all" style="width: 100%;">
                    <td style="width: 90%">Less: Total Due payable amount</td>
                    <td class="hide_all" ></td>
                    <td style="width: 10%" class="textRight">@money($due_payable)</td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                </tr>
                <tr  class="hide_all" style="width: 100%;">
                    <td style="width: 90%">Less: Total adjusted Amount</td>
                    <td class="hide_all" ></td>
                    <td style="width: 10%" class="textRight">@money($adjusted_amount)</td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                    <td class="hide_all" ></td>
                </tr>
                <tr style="width: 100%;" class="hide_all">
                    <td style="width: 90%" class="hide_all">
                        <strong>Bill payable against this {{ addOrdinalNumberSuffix($bill_no - 1) }} no.bill</strong>
                        <strong>(After Advance adustment)</strong>
                    </td>
                    <td class="hide_all"></td>
                    <td style="width: 10%" class="textRight hide_all">@money($cumulitive_bill - $security - $paid_amount - $adjusted_amount - $due_payable)</td>
                    <td class="hide_all"></td>
                    <td class="hide_all"></td>
                    <td class="hide_all"></td>
                    <td class="hide_all"></td>
                </tr>
            </tfoot>
            </table>
        </div>

        {{-- <table style="margin-bottom: 20px;width: 100%!important;">
            <tr>
                <th style="width: 15%;">Less {{ $allConstructionBill->first()->percentage }}% security</th>
                <th style="width: 13%;"></th>
                <th style="width: 18%;">@money($security)</th>
                <th style="width: 18%;"></th>
                <th style="width: 18%;"></th>
                <th style="width: 18%;"></th>
                <th style="width: 18%;"></th>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 90%">Less {{ $allConstructionBill->first()->percentage }}% security</td>
                <td style="width: 10%" class="textRight">@money($security)</td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 90%"><strong>Net total bill amount</strong></td>
                <td style="width: 10%" class="textRight"><strong>@money($cumulitive_bill - $security)</strong></td>
            </tr>
            <tr class="blank_row" style="width: 100%;">
                <td bgcolor="#FFFFFF" colspan="2">&nbsp;</td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 90%;">Less Total paid amount (with advance)</td>
                <td style="width: 10%" class="textRight">0.00</td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 90%">Less Total Due payable amount</td>
                <td style="width: 10%" class="textRight">0.00</td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 90%"><strong>Bill payable against this 4th no.bill</strong></td>
                <td style="width: 10%" class="textRight">0.00</td>
            </tr>
            <tr style="width: 100%;">
                <td><strong>(After Advance adustment)</strong></td>
            </tr>
        </table> --}}

        <div>
            @php
                $spell = new \NumberFormatter(locale_get_default(), \NumberFormatter::SPELLOUT);
            @endphp
            <p>Taka (In Words): {{'Taka '. \Str::title($spell->format($cumulitive_bill - $security - $paid_amount - $adjusted_amount - $due_payable)).' Only.'}}</p><br>
            <p>Pls issue an A/C Payee Cheque in favour of  <strong>"{{$constructionBill->supplier->name}}"</strong> </p>
        </div>


        <div class="container" id="signature" style="width:100%; margin-top: 50px;">
            <div style="float:left; width:25%; margin-right:10px;">
                <p style="text-align: center; border-top: solid black 2px;">Prepared By</p>
                <p style="text-align: center;">Billing Dept.</p>
            </div>
            <div style="float:left; width:25%;margin-right:10px;">
                <p style="text-align: center; border-top: solid black 2px;">Prepared By</p>
                <p style="text-align: center;">Audit</p>
            </div>
            <div style="float:left; width:25%;margin-right:10px;">
                <p style="text-align: center; border-top: solid black 2px;">Prepared By</p>
                <p style="text-align: center;">GM (Construction & Head of EME)</p>
            </div>
            <div style="float:left; width:25%;margin-right:10px;">
                <p style="text-align: center; border-top: solid black 2px;">Prepared By</p>
                <p style="text-align: center;">CEO</p>
            </div>
        </div>

{{-- <div class="page_break"></div> --}}




</body>
</html>
