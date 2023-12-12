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

    #rate_table, #rate_table th, #rate_table td,
    #payment_schedule, #payment_schedule th, #payment_schedule td {
        border-spacing: 0;
        padding-bottom: 0;
        border: 1px solid #000;
        font-size: 12px;
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
</style>
<body>
    <header>
        <div id="logo" class="pdflogo">
            <img src="{{ asset(config('company_info.logo'))}}" alt="Logo" class="pdfimg pullRight">
        </div>
    </header>

    {{-- <p class="wo_pages">Form-Con/03/005/P-01 of 06</p> --}}
    <div class="container" style= "width:100%; margin-top: 70px;">
        <div class="text-center" style="float:left; width:75%;">
            Ref: {{$workorder->workorder_no}}
        </div>
        <div class="text-center" style="float:left; width:25%;">
            Date: {{$workorder->issue_date}}
        </div>
    </div>
    <div class="address">
        <h3> {{$workorder->supplier->name}} </h3>
        <P> {{$workorder->supplier->address}}</P>
        <p>Attn: {{$workorder->supplier->contact_person_name}}, Cell:{{ $workorder->supplier->contact }}</p><br>
        <p> <strong>Subject:</strong>

            Work Order for <strong>{{$workorder->workCs->cs_type}}</strong> at Project <strong>"{{$workorder->workCs->project->name}}"</strong> at {{$workorder->workCs->project->location}}.
        </p><br>

        <h4>Dear {{$workorder->supplier->contact_person_name}},</h4><br>
        <p>The Management of <span style="font-weight: bold;"> "RANKS FC PROPERTIES LTD."</span> is pleased to inform you that against your offer, you have been awarded the "Work Order"
            for the captioned works under the following terms & conditions and rates etc (enclosed herewith). The terms & conditions, quotation
            and rates are an integral part of this Work Order.
        </p><br>
        <p>You are therefore requested to start the work in consultation with under signee.</p><br>
        <p>Time is allowed maximum {{$workorder->deadline}} or as per requirement of site from the date of issuing work order.</p><br>
        <p>If you agree with the above, please return the duplicate upon your proper signing in acceptance. </p><br><br>
        <p>Thanking you,</p><br><br>
        <p>Very Truly Yours</p>
        <p>For <span style="font-weight: bold;">RANKS FC PROPERTIES LTD.</span> </p>
    </div>
    <div class="container" style= "width:100%; margin-top: 50px;">
        <div class="text-left" style="float:left; width:75%;">
            <p style="text-decoration: overline;">(Engr. Biswajit Chowdhury)</p>
            <p>GM (Construction) & Head of EME</p>
        </div>
        <div class="text-center" style="float:left; width:25%;">
            <p style="text-decoration: overline;">Signature of Contractor</p>
            <p class="text-center">in Acceptance</p>
        </div>
    </div>
    <div class="container">
        <p>Encl: a) Schedule of Rates</p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; b) Terms & Conditions</p>
    </div>

<footer>
    Atlas Rangs Plaza (Level 9&10), 7, Sk. Mujib Road,<br>
    Agrabad C/A, Chattogram, <br>
    Phone: 2519906-8, 712023-5 <br>
    {!! htmlspecialchars(config('company_info.company_email')) !!}
</footer>

<div class="page_break"></div>

    {{-- <p class="wo_pages">Form-Con/03/005/P-03 of 06</p> --}}
    <p style="text-decoration: underline; margin-top: 70px;"> Rate Schedule (R.S) :</p>
    <div class="container">
    <table style="margin-top: 5px; width: 100%;" id="rate_table">
        <tr>
            <th style="width: 7%">SL <br> No.</th>
            <th style="width: 50%">Description of Work</th>
            <th style="width: 8%">Unit</th>
            <th style="width: 12%">Rate(Tk.)</th>
            <th style="width: 23%">Remarks</th>
        </tr>
        <tr>
            <td></td>
            <td colspan="4">
                <!-- A) Description of Work:-
                <p style="font-size: 12px;">Completion of all types of civil works i/c.
                   @foreach ($workorder->workorderRates as $workorderRate)
                       {{$workorderRate->work_description}}
                       @if (!$loop->last)
                         ,
                       @endif
                   @endforeach
                    . All complete and doing the works as per specification of the design, drawing, direction, instruction &
                approval of the Engineer-in-charge.</p><br>
                B) Involvement status in this work:-
                <p style="font-size: 12px;">
                    @php
                        function numberToRomanRepresentation($number) {
                            $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
                            $returnValue = '';
                            while ($number > 0) {
                                foreach ($map as $roman => $int) {
                                    if($number >= $int) {
                                        $number -= $int;
                                        $returnValue .= $roman;
                                        break;
                                    }
                                }
                            }
                            return $returnValue;
                        }
                    @endphp
                    @foreach ($workorder->workorderRates as $workorderRate)
                   {{ numberToRomanRepresentation($loop->iteration) }} )
                    {{$workorderRate->work_level}} .
                        @if (!$loop->last)
                        <br>
                        @endif
                    @endforeach
                    </p> -->

                A) Description of Work:-
                <p style="font-size: 12px;">
                    {{ $workorder->description }}
                </p><br>
                B) Involvement status in this work:-
                <p style="font-size: 12px;">
                    {{ $workorder->involvement }}
                </p>
            </td>
        </tr>
        @foreach ($workorder->workorderRates as $rate)
        <tr>
            <td style="text-align: center"> {{$loop->iteration}} </td>
            <td style="font-size: 12px;">
                <strong> {{$rate->work_level}} </strong>

                {{$rate->work_description}}
            </td>
            <td style="text-align: center"> {{$rate->work_unit}} </td>
            <td style="text-align: center"> {{$rate->work_rate}} </td>
            <td></td>
        </tr>
        @endforeach

    </table>
    </div>

    {{-- <div class="container" style= "width:100%; margin-top: 50px;">
        <div class="text-left" style="float:left; width:75%;">
            <p style="text-decoration: overline;">(Engr. Biswajit Chowdhury)</p>
            <p>GM (Construction) & Head of EME</p>
        </div>
        <div class="text-center" style="float:left; width:25%;">
            <p style="text-decoration: overline;">Signature of Contractor</p>
            <p class="text-center">in Acceptance</p>
        </div>
    </div> --}}

@if($workorder->workOrderSchedules->count())
<div class="page_break"></div>
    <p style="text-decoration: underline; margin-top: 70px;">Payment Schedule (P.S) :</p>
    <div class="container">
        <table style="margin-top: 5px; width: 100%" id="payment_schedule">
            <tr>
                <th style="width: 13%">SL No. of R.S</th>
                <th style="width: 13%">Sl No. <br>of P.S</th>
                <th style="width: 70%">Work Status</th>
                <th style="width: 10%">Payable <br> Amount</th>
            </tr>
                @foreach ($workorder->workOrderSchedules as $parentKey => $schedule)
                    @php $totalLines = $schedule->workOrderScheduleLines->count() @endphp
                    @foreach ($schedule->workOrderScheduleLines as $key => $line)
                        <tr>
                            @if($loop->first)
                            <td rowspan="{{$totalLines}}" style="text-align: center">
                                {{$schedule->rs_title}}
                            </td>
                            @endif
                            <td style="text-align: center"> {{"RS-".$loop->parent->iteration."-PS-".$loop->iteration}} </td>
                            <td style="text-align: center">{{$line->work_status}}</td>
                            <td style="text-align: center">{{$line->payment_ratio}}%</td>
                        </tr>
                    @endforeach
                @endforeach
        </table>
    </div>
@endif
{{-- end payment Schedule      --}}

<div class="page_break"></div>
<h3 style="text-decoration: underline; margin-top: 100px; margin-bottom: 0; Text-align: center;">General Terms & Conditions for {{$workorder->workCs->cs_type}} </h3>
<div class="container terms" style="max-width: 100%">
    <p><strong>A:</strong></p>
    {!! $workorder->terms->general_terms ?? null !!}

<div class="page_break"></div>
<h3 style="text-decoration: underline; margin-top: 100px; margin-bottom: 0; Text-align: center;">Payment Terms & Conditions </h3>
<div class="container terms" style="max-width: 100%">
    <p><strong>B:</strong></p>
    {!! $workorder->terms->payment_terms ?? null !!}

    <!--{{-- <div class="row">
        <div class="col-2-5">
            <div class="text-center" style="text-decoration: underline;">
                Prepared By
            </div>
            <div class="text-center mt-1">
                {{ $workorder?->appliedBy?->employee?->fullName ?? ""}}
            </div>
            <div class="text-center mt-1">
                {{ $workorder?->appliedBy?->employee?->designation?->name ?? "" }}
            </div>
            <div class="text-center mt-1">
                <img src="{{ asset("{$workorder->appliedBy->signature}") }}" id="signature_view" width="100px" height="40px" alt="Signature">
            </div>
        </div>

        @forelse($approvals as $approval)
            <div class="col-2-5">
                <div class="text-center" style="text-decoration: underline;">
                {{ $approval?->approvalLayerDetails?->name ?? "" }}
                </div>
                <div class="text-center mt-1">
                    {{ $approval?->user?->employee?->fullName ?? "" }}
                </div>
                <div class="text-center mt-1">
                    {{ $approval?->user?->employee?->designation?->name ?? ""}}
                </div>
                <div class="text-center mt-1">
                    <img src="{{ asset("{$approval->user->signature}") }}" id="signature_view" width="100px" height="40px" alt="Signature">
                </div>
            </div>
        @empty
        @endforelse --}}-->

</body>
</html>
