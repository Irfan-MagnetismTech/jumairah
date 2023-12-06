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
            font-size: 10px;
        }

        #detailsTable {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #detailsTable td,
        #detailsTable th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #detailsTable tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #detailsTable tr:hover {
            background-color: #ddd;
        }

        #detailsTable th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #5387db;
            color: white;
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

        .row {
            clear: both;
        }

        .head1 {
            width: 45%;
            float: left;
            margin: 0;
        }

        .head2 {
            width: 55%;
            float: right;
            margin: 0;
        }

        .head3 {
            width: 45%;
            float: left;
            padding-bottom: 20px;
        }

        .head4 {
            width: 45%;
            float: right;
            padding-bottom: 20px;
        }

        .textarea {
            width: 100%;
            float: left;
        }

    </style>
</head>

<body>
    @php
        $copies = ['Account', 'Project', 'Supplier'];
    @endphp
    @foreach ($copies as $copy)
        <div class="container">
            <div class="row">
                <div class="head1" style="padding-left: 180px; text-align: center">
                    <img src="{{ asset('images/ranksfc_log.png') }}" alt="Rangsfc">
                    <p>
                        Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road, Agrabad C/A, Chattogram.<br>
                        Phone: 0312519906 Mobile: 09617124124.<br>
                        <a style="color:#000;" target="_blank">www.ranksfc.com</a>
                    </p>
                    <h3 style="border: 1px solid #000;">
                        Purchase Order Form
                    </h3>
                </div>
                <div style="float: right">
                    <h3 style="border: 1px solid #000; width:18%; margin-left: 1.938rem auto; font-size: 0.938rem; padding: 0.225rem;">
                        {{ $copy }}'s Copy
                    </h3>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="head3">
                    <table>
                        <tr>
                            <td>
                                <p style="font-size:12px">To</p>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size:12px"><b>{{ $purchaseOrder->cssupplier->supplier->name }}</b></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size:12px">{{ $purchaseOrder->cssupplier->supplier->address }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size:12px">{{ $purchaseOrder->cssupplier->supplier->contact }}</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="head4">
                    <table>
                        <tr>
                            <td>
                                <p style="font-size:12px">M.P.R No.</p>
                            </td>
                            <td>
                                <p style="font-size:12px">:</p>
                            </td>
                            <td>
                                <p style="font-size:12px"><b>{{ $purchaseOrder->mpr_no }}</b></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size:12px">P.O No.</p>
                            </td>
                            <td>
                                <p style="font-size:12px">:</p>
                            </td>
                            <td>
                                <p style="font-size:12px"><b>{{ $purchaseOrder->id }}</b></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size:12px">P.O Date</p>
                            </td>
                            <td>
                                <p style="font-size:12px">:</p>
                            </td>
                            <td>
                                <p style="font-size:12px">{{ date_format(date_create($purchaseOrder->date), 'd/m/Y') }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size:12px">Project Name</p>
                            </td>
                            <td>
                                <p style="font-size:12px">:</p>
                            </td>
                            <td>
                                <p style="font-size:12px"><b>{{ $purchaseOrder->mpr->project->name }}</b></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size:12px">Project Mobile</p>
                            </td>
                            <td>
                                <p style="font-size:12px">:</p>
                            </td>
                            <td>
                                <p style="font-size:12px">{{ $purchaseOrder->mpr->project->project_contact ?? '---' }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size:12px">
                                    <nobr>Project Address</nobr>
                                </p>
                            </td>
                            <td>
                                <p style="font-size:12px">:</p>
                            </td>
                            <td>
                                <p style="font-size:12px">{{ $purchaseOrder->mpr->project->location }}</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div style="clear: both"></div>
        <div class="container" style="margin-top: 30px;">
            <table id="detailsTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Material Code</th>
                        <th>Material Name</th>
                        <th>Brand</th>
                        <th>Unit</th>
                        <th>Qty</th>
                        @if ($copy != 'Project')
                            <th>Rate</th>
                            <th>Amount</th>
                        @endif
                        <th>R. Date</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sub_total = 0;  @endphp
                    @foreach ($purchaseOrder->purchaseOrderDetails as $purchaseOrderDetail)
                        <tr>
                            <td> {{ $loop->iteration }} </td>
                            <td> {{ $purchaseOrderDetail->materials->material_code ?? '---' }}</td>
                            <td class="text-left"> {{ $purchaseOrderDetail->materials->name ?? '---' }} </td>
                            <td> {{ $purchaseOrderDetail->brand ?? '---' }}</td>
                            <td> {{ $purchaseOrderDetail->materials->unit->name ?? '---' }}</td>
                            <td> {{ $purchaseOrderDetail->quantity ?? '' }}</td>
                            @if ($copy != 'Project')
                                <td> {{ $purchaseOrderDetail->unit_price }} </td>
                                <td> {{ $purchaseOrderDetail->total_price }} @php $sub_total += $purchaseOrderDetail->total_price @endphp </td>
                            @endif
                            <td> {{ $purchaseOrderDetail->required_date ? date('d-m-Y', strtotime($purchaseOrderDetail->required_date)) : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table role="presentation" style="margin: 0px auto; border-collapse: collapse; border: 0; border-spacing: 0;">
                <tr>
                    <td style="width: 400px; vertical-align: top; color: #000;border: 1px solid #000;padding: 1rem; margin: 10px">
                        <p>With Carrying</p>
                        <p>CS Ref : {{ $purchaseOrder->cs->reference_no }}</p>
                        <p> {{ $purchaseOrder->remarks }} </p>
                    </td>
                    <td style="width: 10px;"></td>
                    <td style="width: 300px; padding: 0; vertical-align: top; color: #000; text-align: right !important;">
                        <table style="float:left;text-align:left;width: 200px;border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td>
                                        <p style="font-size: 12px;font-weight: 600;">Sub Total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</p>
                                    </td>
                                    <td>
                                        <p style="font-size: 12px; font-weight: 600;"> {{ $sub_total }} </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="font-size:12px;font-weight: 600;">Carrying Cost &nbsp;&nbsp;&nbsp;&nbsp;:</p>
                                    </td>
                                    <td>
                                        <p style="font-size:12px;font-weight: 600;">{{ $purchaseOrder->carrying_charge }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="font-size:12px;font-weight: 600;">Labour Cost &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</p>
                                    </td>
                                    <td>
                                        <p style="font-size:12px;font-weight: 600;">{{ $purchaseOrder->labour_charge }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 2px dashed #000;">
                                        <p style="font-size:12px;font-weight: 600; ">Discount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</p>
                                    </td>
                                    <td style="border-bottom: 2px dashed #000;">
                                        <p style="font-size:12px;font-weight: 600;">{{ $purchaseOrder->discount }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="font-size:12px;font-weight: 600;">Total Amount:</p>
                                    </td>
                                    <td style="border-bottom: 2px dashed #000;line-height: 30px;">
                                        <p style="font-size:12px; font-weight: 600;">{{ round($purchaseOrder->final_total) }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><p style="text-align: left; padding-left:0px; font-size: 12px">Amount in words: <b>{{ (new NumberFormatter('en', NumberFormatter::SPELLOUT))->format(round($purchaseOrder->final_total)) }} Only</b></p></td>
                </tr>
            </table>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


            <table style="margin: 0px auto; border: 0px; border-spacing: 0;">
                <tr>
                    <td style="width: 400px; color: #000;border: 1px solid #000; padding: 1rem;">
                        <p style="font-size:15px;font-weight: 600;">Instructions:</p>
                        <p>1. Please read all your bills in duplicate.</p>
                        <p>2. Payment shall be made after ({{ $purchaseOrder->cssupplier->credit_period }}) days of receipt of all materials in good conditions.</p>
                        <p>3. Please attace a copy of receipted delivery challan with your bill.</p>
                        <p>4. Company may have the right to the PO at any time.</p>
                        <p>5. Source TAX : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input style="height:15px;" type="checkbox" @if ($purchaseOrder->source_tax == 'Applicable') echo checked @endif> Applicable &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input style="height:15px;" type="checkbox"> Not Applicable
                        </p>
                        <div>6. Source VAT : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input style="height:15px; margin: 0px; margin-top: 5px;" type="checkbox" @if ($purchaseOrder->source_vat == 'Applicable') echo checked @endif>
                            Applicable &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input style="height:15px;" type="checkbox"> Not Applicable
                        </div>
                        <p>Print Date: {{ date('d-m-Y') }}</p>
                    </td>
                    <td style="width: 230px; border: 1px solid #000 ; border-left: none; ">
                        <span style="padding-left: 10px; float: left; padding-top: 30px;">----------------------</span>
                        <span style="padding-left: 0px; margin-left:-60px; float: left; padding-top: 50px;">Prepared By</span>

                        <span style="padding-right: 10px; float: right; padding-top: 30px;">----------------------</span>

                        <span style="float: right; padding-right: 0px; padding-top: 50px; margin-right:-70px;">Authorised By</span> <br><br><br>

                        <span style="padding-left: 90px;">----------------------</span>
                        <span style="padding-left: 100px;">Approved By</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 1rem;font-size: 13px;color: #000;font-weight: 600;">
                        This terms is applicable on October 20, 2021.
                    </td>
                </tr>
            </table>
        </div>
    @endforeach
</body>

</html>