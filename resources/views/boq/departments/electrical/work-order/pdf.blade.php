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
            <img src="{{ asset(config('company_info.logo')) }}" alt="Logo" class="pdfimg pullRight">
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
        <p>Attn: {{$workorder->supplier->contact_person_name}}, Cell:{{$workorder->supplier->contact}}</p><br>
        <p> <strong>Subject:</strong>

            Work Order for <strong>{{$workorder->workCs->cs_type}}</strong> at Project <strong>"{{$workorder->workCs->project->name}}"</strong> at {{$workorder->workCs->project->location}}.
        </p><br>

        <h4>Dear Mr. Jamal,</h4><br>
        <p>The Management of <span style="font-weight: bold;"> " {!! htmlspecialchars(config('company_info.company_fullname')) !!}."</span> is pleased to inform you that against your offer, you have been awarded the "Word Order"
            for the ceptioned works under the following terms & conditions and rates (enclosed herewith). The terms & conditions, quotation
            and rates are an integral part of this Work Order.
        </p><br>
        <p>You are therefore requested to start the work in consultation with under signee.</p><br>
        <p>Time is allowed maximum {{$workorder->deadline}} or as per requirement of site from the date of issuing work order.</p><br>
        <p>If you agree with the above, please return the duplicate upon your proper signing in acceptance. </p><br><br>
        <p>Thanking you,</p><br><br>
        <p>Very Truly Yours</p>
        <p>For <span style="font-weight: bold;"> {!! htmlspecialchars(config('company_info.company_fullname')) !!}.</span> </p>
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
        <p>Encl: </p>
        @if (isset($workorder->workrate))
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #) Schedule of Rates</p>
        @endif
        @if (isset($workorder->terms) && isset($workorder->terms->payment_terms))
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #)Payment Terms & Conditions</p>
        @endif
        @if (isset($workorder->terms) && isset($workorder->terms->general_terms))
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #)General Terms & Conditions</p>
        @endif
        @if ($workorder->workSpecification->count())
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #)Technical Specification</p>
        @endif
        @if (isset($workorder->workOtherFeature) && isset($workorder->workOtherFeature->special_function))
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #)Other Features Special Function</p>
        @endif
        @if (isset($workorder->workOtherFeature) && isset($workorder->workOtherFeature->safety_feature))
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #)Other Safety Features</p>
        @endif
    </div>

<footer>
    {!! htmlspecialchars(config('company_info.company_address')) !!}<br>
    Phone: {!! htmlspecialchars(config('company_info.company_mobile')) !!} <br>
    {!! htmlspecialchars(config('company_info.company_email')) !!}
</footer>

@if (isset($workorder->workrate))
<div class="page_break"></div>
<h3 style="text-decoration: underline; margin-top: 100px; margin-bottom: 0; Text-align: center;"> Rate Schedule (R.S) : {{$workorder->workCs->cs_type}} </h3>
<div class="container terms" style="max-width: 100%; min-width: 100%;">
    {!!$workorder->workrate!!}
</div>
    {{-- <p class="wo_pages">Form-Con/03/005/P-03 of 06</p> --}}
     {{-- <p style="text-decoration: underline; margin-top: 70px;"></p>
    <div class="container">
        {!!$workorder->terms->payment_terms!!}
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
                A) Description of Work:-
                <p style="font-size: 12px;">Completion of all types of civil works i/c. layout setting, Earth Cutting (upto -7"-6" from Road Level/required depth),
                leveling & dressing of earth under ground floor slab, Sand Compaction, Dewatering, C.C casting, all staging with scafolding (including Fittings, fixing & Opening with
                outside safety net fitting) & shuttering, Rebar work & casting (Manual/RMC) of all structural works from Footing / MAT, Gr. floor to roof top and above with all retaining wall, water
                reservoir & septic tank & all types of brick work, plaster work (inside, outside & ceiling) RCC lintel, RCC Stair railing,
                RCC verandah railing, RCC False ceiling, sunshade works & all types of groove making, show slab and other ornamental
                railing, MS door, MS safety grill/railing, canopy work etc.& all kinds of outside ornamental MS work works), sand
                screening, brick soaking pit, daily floor cleaning after of civil work and staking all rubbish at Ground floor & all types of
                major civil materials (MS Rod, Bricks, Stone Chips, Sand) carrying from stock yard (30' radius from project perimeter) to
                working site within 24 hrs. all complete and doing the works as per specification of the design, drawing, direction, instruction &
                approval of the Engineer-in-charge.</p><br>
                B) Involvement status in this work:-
                <p style="font-size: 12px;">i) Rod-Cutter (Automatic/Manual), Rod Bending Machine, Welding, Grinding & Drill machine, Nails GI wires, Rupban sheet,
                Spade, Belcha, Foam & Flower bromm etc. & operator for Roof Hoist, Mixture machine & Compactor machine, also welder, welding machine & welding Road
                for shuttering works only are to be supplied by the contractor. <br>
                ii) All contruction materials, all shuttering with outside scaffolding materials, fuel, shutter oil, shutter foam, Cup Brush,
                Utility (like as Electricity, Generator, Water etc. ) Roof/Tower hoist machine, mixture machine & welding machine for
                shutter resizing & maintenance works only, Curing man, Vibrator, Nozzle, other tools etc. are to be provided by Ranks FC Properties Ltd.</p>

            </td>
        </tr>
        <tr>
            <td style="text-align: center"> {!!$workorder->terms->general_terms!!} </td>
        </tr>

    </table>
    </div>--}}

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
@endif

@if (isset($workorder->terms) && isset($workorder->terms->payment_terms))
<div class="page_break"></div>
<h3 style="text-decoration: underline; margin-top: 100px; margin-bottom: 0; Text-align: center;">Payment Terms & Conditions </h3>
<div class="container terms" style="max-width: 100%">
    {!! $workorder->terms->payment_terms ?? null !!}
</div>
@endif

@if (isset($workorder->terms) && isset($workorder->terms->general_terms))
<div class="page_break"></div>
<h3 style="text-decoration: underline; margin-top: 100px; margin-bottom: 0; Text-align: center;">General Terms & Conditions</h3>
<div class="container terms" style="max-width: 100%">
    {!! $workorder->terms->general_terms ?? null !!}
</div>
@endif


@if($workorder->workSpecification->count())
<div class="page_break"></div>
    <h3 style="text-decoration: underline; margin-top: 100px; margin-bottom: 0; Text-align: center;">Technical Specification:</h3>
    <div class="container">
        <table style="margin-top: 5px; width: 100%" id="payment_schedule">
            <tr>
                <th style="width: 13%">SL No. of R.S</th>
                <th style="width: 13%">Sl No. <br>of P.S</th>
                <th style="width: 70%">Work Status</th>
                <th style="width: 10%">Payable <br> Amount</th>
            </tr>
                @foreach ($workorder->workSpecification as $parentKey => $schedule)
                    @php $totalLines = $schedule->workSpecificationLine->count() @endphp
                    @foreach ($schedule->workSpecificationLine as $key => $line)
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
@if (isset($workorder->workOtherFeature) && isset($workorder->workOtherFeature->special_function))

<div class="page_break"></div>
<h3 style="text-decoration: underline; margin-top: 100px; margin-bottom: 0; Text-align: center;">Other Features Special Function</h3>
<div class="container terms" style="max-width: 100%">
    {!! $workorder->workOtherFeature->special_function ?? null !!}
</div>
@endif

@if (isset($workorder->workOtherFeature) && isset($workorder->workOtherFeature->safety_feature))
<div class="page_break"></div>
<h3 style="text-decoration: underline; margin-top: 100px; margin-bottom: 0; Text-align: center;">Other Safety Features</h3>
<div class="container terms" style="max-width: 100%">
    {!! $workorder->workOtherFeature->safety_feature ?? null !!}
</div>
@endif
</body>
</html>
