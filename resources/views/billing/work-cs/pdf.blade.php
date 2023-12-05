<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            font-size: 9px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #646262;
            padding: 5px;
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
            background-color: rgb(233, 230, 230);
            color: Black;
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

        .foot_container {
            margin: 20px;
            margin-bottom: 60px;
        }

        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
        }

        .pdflogo a {
            font-size: 18px;
            font-weight: bold;
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

        @page {
            @bottom-right {}
        }

        .footer {
            position: absolute;
            bottom: 50px;
            left: 0;
            right: 0;
            min-height: 50px;
            padding: 10px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-12 {
            float: left;
            width: 100%;
        }

        .col-3 {
            width: 25%;
            float: left;
        }

        .col-2-5 {
            width: 20%;
            float: left;
        }

        .col-4 {
            float: left;
            width: 33.333333%;
        }

        .word-wrap {
            word-wrap: break-word !important;
        }

        .footer_container {
            display: flex;
            justify-content: space-between;
            /* or space-evenly */
        }
    </style>
</head>

<body>
    <div id="logo" class="pdflogo">
        <img src="{{ asset('images/ranksfc_log.png') }}" alt="Logo" class="pdfimg">
        <div class="clearfix"></div>
        <h5>Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road, Agrabad C/A, Chattogram.</h5>
    </div>
    <div class="container">
        <h2 class="text-center">RANKS FC PROPERTIES LTD.</h2>
        <h2 class="text-center"> {{ $workCs->title }} </h2>
    </div>

    <div class="container" style="width:100%;">
        <p class="text-left">CS: {{ $workCs->reference_no }}</p><br>
        <div style="float:left; width:33%;">
            Project Name: <strong> {{ $workCs->project->name }} </strong>
        </div>
        <div class="text-center" style="float:left; width:33%;">
            Address: <strong> {{ $workCs->project->location }} </strong>
        </div>
        {{-- <div class="text-center" style="float:right; width:33%;">
        Form-Con/03/004/p-01 of 01
    </div> --}}
    </div>
    <div class="container float-left">
    </div>
    <div class="container">
        <p style="text-align: left; font-size: 11px;">
            <strong>A) Description of work:- </strong> <br />
            <!-- {{-- $workCs->description --}} -->
        <p style="text-align: justify;">{{ $workCs->description }}</p>
        <br>
        <strong>B) Involvement status in this work:- </strong> <br>
        @forelse($workCs->workCsInvolvment as $key => $value)
            <li style="list-style:none;padding-left: 20px;"> {{ $value->detail }}</li>
        @empty
        @endforelse
        <!-- <br>
        <strong>C) Remarks:- </strong> <br>
        {{ $workCs->remarks }}<br/>  -->
        </p>
    </div>

    <div class="container my-element" style="margin-top: 10px; clear: both; display: block; width: 100%;">
        <table id="table">
            <thead>
                <tr>
                    <th rowspan="3" > SL</th>
                    <th rowspan="3"> Level of work</th>
                    <th rowspan="3">Apprx.<br> Qty.</th>
                    <th rowspan="3">Unit</th>
                    @foreach ($workCs->workCsSuppliers as $csSupplier)
                        <th colspan="2"> {{ $csSupplier->supplier->name }}</th>
                    @endforeach
                    {{-- <th rowspan="3" >Remarks</th> --}}
                </tr>
                <tr>
                    @foreach ($workCs->workCsSuppliers as $csSupplier)
                        <th colspan="2"> Contact - {{ $csSupplier->supplier->contact }}</th>
                    @endforeach
                </tr>
                <tr>
                    @foreach ($workCs->workCsSuppliers as $csSupplier)
                        <th>Unit rate<br />(TK.)</th>
                        <th>Amount<br />(TK.)</th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @php
                    $total = [];
                @endphp
                @foreach ($workCs->workCsLines as $line)
                    <tr class="text-right">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left word-wrap" style="max-width: 500px!important;">
                            <strong>{{ $line->work_level }}</strong> <br> {{ $line->work_description }}</td>
                        <td>{{ $line->work_quantity }}</td>
                        <td>{{ $line->work_unit }}</td>

                        @foreach ($workCs->workCsSuppliers as $csSupplier)
                            <td>
                                @php
                                    $price = $workCs->csSuppliersRates
                                        ->where('work_cs_supplier_id', $csSupplier->supplier_id)
                                        ->where('work_cs_line_id', $line->id)
                                        ->first()->price;
                                    if (array_key_exists($csSupplier->supplier_id, $total)) {
                                        $total[$csSupplier->supplier_id] += $price * $line->work_quantity;
                                    } else {
                                        $total[$csSupplier->supplier_id] = $price * $line->work_quantity;
                                    }
                                @endphp
                                @money($price)
                            </td>
                            <td>
                                @money($price * $line->work_quantity)
                            </td>
                        @endforeach
                        {{-- <td style="max-width: 75px;overflow: hidden;">
                            @if ($loop->first)
                                {{ $workCs->remarks }}
                            @endif
                        </td> --}}
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td colspan="3" style="font-weight: 800; font-size:x-small;">Total</td>
                    @foreach ($total as $key => $value)
                        <td></td>
                        <td style="text-align: right;font-weight: 800; font-size:x-small;">@moneyWithoutDecimals($value)</td>
                    @endforeach
                    {{-- <td></td> --}}
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3" style="font-weight: 800; font-size:x-small;">VAT / AIT</td>
                    @foreach ($workCs->workCsSuppliers as $value)
                        <td colspan="2" style="text-align: right;font-weight: 800; font-size:x-small;">{{ $value->vat }}</td>
                    @endforeach
                    {{-- <td></td> --}}
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3" style="font-weight: 800; font-size:x-small;">Advanced</td>
                    @foreach ($workCs->workCsSuppliers as $value)
                        <td colspan="2" style="text-align: right;font-weight: 800; font-size:x-small;">{{ $value->advanced }}</td>
                    @endforeach
                    {{-- <td></td> --}}
                </tr>
            </tbody>

        </table>
    </div>
    <div class="foot_container">
        <p><span style="text-decoration: underline;">Remarks: </span>{{ $workCs->remarks }}</p>
    </div>
    <div class="foot_container">
        <div><span style="text-decoration: underline;">Notes:</span>{!! $workCs->notes !!}</div>
    </div>
    <div class="clearfix" style="clear: both;"></div>
    <footer class="footer" data-footer="Footer text">
        <div class="row">
            <div class="col-2-5">
                <div class="text-center" style="text-decoration: underline;">
                    Prepared By
                </div>
                <div class="text-center mt-1">
                    {{ $workCs?->appliedBy?->employee?->fullName ?? '' }}
                </div>
                <div class="text-center mt-1">
                    {{ $workCs?->appliedBy?->employee?->designation?->name ?? '' }}
                </div>
                <div class="text-center mt-1">
                    <img src="{{ asset("{$workCs->appliedBy->signature}") }}" id="signature_view" width="100px"
                        height="40px" alt="Signature">
                </div>
            </div>

            @forelse($approvals as $approval)
                <div class="col-2-5">
                    <div class="text-center" style="text-decoration: underline;">
                        {{ $approval?->approvalLayerDetails?->name ?? '' }}
                    </div>
                    <div class="text-center mt-1">
                        {{ $approval->user?->employee?->fullName ?? '' }}
                    </div>
                    <div class="text-center mt-1">
                        {{ $approval->user?->employee?->designation->name ?? '' }}
                    </div>
                    <div class="text-center mt-1">
                        <img src="{{ asset("{$approval->user->signature}") }}" id="signature_view" width="100px"
                            height="40px" alt="Signature">
                    </div>
                </div>
            @empty
            @endforelse
        </div>

        <p style="text-align: center;">
            <!-- <small> Printing Time: {{ date('d-M-y h:i:s a', strtotime(now())) }}</small> -->
        </p>
    </footer>

</body>

</html>
