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
            font-size: 12px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
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

        #client {
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            top: 0;
            line-height: 18px;
            padding: 5px;
        }

        #apartment {
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            right: 20px;
            top: 20px;
            line-height: 18px;
            padding: 5px;
        }

        .infoTable {
            font-size: 12px;
            width: 100%;
        }

        .infoTableTable td:nth-child(2) {
            text-align: center;
            width: 20px;
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
            margin: 40px 0 0 0;
        }

        /*header - position: fixed */
        #fixed_header {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            right: 0;
        }

        /*fixed_footer - position: fixed */
        #fixed_footer {
            position: fixed;
            width: 94.4%;
            bottom: 20;
            left: 0;
            right: 0;
        }

        .page_break {
            page-break-before: always;
        }

    </style>
</head>

<body>
    @php
        $iteration = 1;
    @endphp

@php $price_index = 0; @endphp
{{-- @foreach ($scrapCs->ScrapcsMaterials->chunk(5) as $chunk) --}}

    <div>
        <div id="logo" class="pdflogo" id="fixed_header">
            <img src="{{ asset(config('company_info.logo')) }}" alt="Logo" class="pdfimg">
            <div class="clearfix"></div>
            <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
        </div>

        {{-- <div id="pageTitle" style="display: block; width: 100%;">
            <h2 style="text-align: center; width: 65%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">
                Comparative Statement & Supplier Selection Form</h2>
        </div> --}}
        <div class="container" style="clear: both; display: block; width: 96%;">
            <div style="text-align: center !important; position: relative;">
                <div>
                    <div style="float: left;">Ref: JHL / {{$ScrapCsMaterialSupplier->first()->Cs->reference_no}}</div>
                    <div style="float:right;">Date : {{$ScrapCsMaterialSupplier->first()->Cs->effective_date}}</div>
                </div>
                <div style="clear: both;"></div>
                <div style="clear: both;float: left;text-align: left !important">
                    <br />
                To <br />
                {{ $ScrapCsMaterialSupplier->first()->Cssupplier->supplier->name }} <br />
                {{ $ScrapCsMaterialSupplier->first()->Cssupplier->supplier->address }} <br />
                Mobile No- {{ $ScrapCsMaterialSupplier->first()->Cssupplier->supplier->contact }}<br />
                Subject : Sale order for Scrap buying project.<br /><br /><br />
                Dear {{ $ScrapCsMaterialSupplier->first()->Cssupplier->supplier->name }}<br /><br />
                The management of Jumairah Holdings LTD. is pleased to inform you that you have been selected for Scrap sale against your offer. The terms & condition and rates for the work are summarized below.
                </div>
                <table id="table" style="text-align: right;clear: both;margin-top: 2%!important;">
                    <tr>
                        <td>
                            <b>SL NO</b>
                        </td>
                        <td><b>Item Name</b></td>
                        <td><b>Unit</td>
                        <td><b>Rate(TK)</td>
                    </tr>
                    @foreach ($ScrapCsMaterialSupplier as $key => $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->Csmaterial->nestedMaterial->name}}</td>
                        <td>{{ $value->Csmaterial->nestedMaterial->unit->name}}</td>
                        <td>{{ $value->price}}</td>
                        {{-- <td>{{ $value->nestedMaterial->unit->name }}</td>
                        <td>{{ $value->price }}</td> --}}
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>



    <div class="container" style="margin-top: 10px; clear: both; display: block; width: 96%;">
        @php
            $start_date = new DateTime($ScrapCsMaterialSupplier->first()->Cs->effective_date);
            $end_date = new DateTime($ScrapCsMaterialSupplier->first()->Cs->expiry_date);
            $dd = date_diff($start_date,$end_date);
        @endphp
        <br/>
        <div>Time allowed for completion of Scrap sale from project carrying is within {{ $ScrapCsMaterialSupplier->first()->Cssupplier->lead_time }} days from the date of sale orser.Total amount has to be paid in {{ $ScrapCsMaterialSupplier->first()->Cssupplier->payment_type }} before scrap sale from project. This rate is applicable for

        @if ($dd->y)
             {{ $dd->y }} year
        @endif
        @if ($dd->m)
            {{ $dd->m }} month
        @endif
        @if ($dd->d)
            {{ $dd->d }} days
        @endif
        effect ftom the work order issue date. Scrap buyer will get return their deposited security money {{ $ScrapCsMaterialSupplier->first()->Cssupplier->security_money }} Taka after sale the whole scrap. <br /><br />
        If you agree with the above, please return the duplicate upon your proper signing in acceptance.
        </div>
        <br>

        <br><br><br>
        <div style="display: block; width: 100%;" id="fixed_footer">
            <table style="text-align: center; width: 100%;">
                <tr>
                    <td>
                        <span>-----------------------------</span>

                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        <span>----------------------------</span>

                    </td>
                </tr>
                <tr>
                    <td>
                        <p>MD. Shafiul Alam jewel <br/> DGM (Head Of Logistics)</p>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        <p>Signature of Buyer <br /> {{ $ScrapCsMaterialSupplier->first()->Cssupplier->supplier->name }} <br />  Mobile No- {{ $ScrapCsMaterialSupplier->first()->Cssupplier->supplier->contact }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    {{-- @if (!$loop->last)
            <div class="page_break"></div>
        @endif --}}
    {{-- @endforeach --}}

</body>

</html>
