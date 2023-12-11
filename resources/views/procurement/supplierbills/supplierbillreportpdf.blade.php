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
            width: 100%;
            bottom: 0;
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
        $sub_total = 0;
        $iteration = 1;
    @endphp
    @foreach ($supplierbill->officebilldetails->chunk(20) as $chunk)
    <div>
        <div class="container" id="fixed_header">
            <div class="row">
                <div class="head1" style="padding-left: 180px; text-align: center">
                    <img src="{{ asset(config('company_info.logo')) }}" alt="Rangsfc">
                    <p>
                        JHL Address.<br>
                        Phone: 0312519906 Mobile: 09617124124.<br>
                        <a style="color:#000;" target="_blank">www.ranksfc.com</a>
                    </p>
                    <h3 style="border: 1px solid #000;">
                        Supplier Bill
                    </h3>
                </div>

            </div>
        </div>
@if($loop->first)

<div class="container">
    <div class="row">

        <div class="head3">
            <table>
                <tr>
                    <td>
                        <p style="font-size:12px">Project Name</p>
                    </td>
                    <td>
                        <p style="font-size:12px">:</p>
                    </td>
                    <td>
                        <p style="font-size:12px"><b>{{$supplierbill->costCenter->name}}</b></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-size:12px">Date</p>
                    </td>
                    <td>
                        <p style="font-size:12px">:</p>
                    </td>
                    <td>
                        <p style="font-size:12px"><b>{{$supplierbill->date}}</b></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-size:12px">Purpose</p>
                    </td>
                    <td>
                        <p style="font-size:12px">:</p>
                    </td>
                    <td>
                        <p style="font-size:12px">{{$supplierbill->purpose}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-size:12px">Applied By</p>
                    </td>
                    <td>
                        <p style="font-size:12px">:</p>
                    </td>
                    <td>
                        <p style="font-size:12px"><b>{{$supplierbill->appliedBy->name}}</b></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-size:12px">Bill No</p>
                    </td>
                    <td>
                        <p style="font-size:12px">:</p>
                    </td>
                    <td>
                        <p style="font-size:12px">{{ $supplierbill->bill_no}}</p>
                    </td>
                </tr>

            </table>
        </div>
    </div>
</div>



@endif
    </div>

    <div style="clear: both"></div>
    <div class="container" style="margin-top: 30px;">
        <table id="detailsTable">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th >MRR<span class="text-danger"></span></th>
                    <th >PO No</th>
                    <th >MPR No</th>
                    <th >Supplier's Name</th>
                    <th >Remarks<span class="text-danger"></span></th>
                    <th >Amount<span class="text-danger"></span></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chunk as $officebilldetail)
                    <tr style="text-align: center">
                        <td> {{ $iteration++ }} </td>
                        <td>{{ $officebilldetail->mrr_no ?? '--' }}</td>
                        <td>{{ $officebilldetail->po_no ?? '--' }}</td>
                        <td>{{ $officebilldetail->mpr_no ?? '--' }}</td>
                        <td>{{ $officebilldetail->supplier->name ?? '--' }}</td>
                        <td>{{ $officebilldetail->remarks ?? '--' }}</td>
                        <td>{{ $officebilldetail->amount ?? '--' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        @if($loop->last)
        <table id="detailsTable" style="border-collapse: collapse; border: 0; border-spacing: 0; margin-top: 10px">
            <tr>
                <td style="vertical-align: top;text-align: right;margin: 10px" colspan="6">
                    Carrying Cost
                </td>
                <td width="62px" style="text-align: center;">
                    {{ $supplierbill->carrying_charge }}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;text-align: right;margin: 10px" colspan="6">
                    Labour Charge
                </td>
                <td width="62px" style="text-align: center;">
                    {{ $supplierbill->labour_charge }}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;text-align: right;margin: 10px" colspan="6">
                    Discount
                </td>
                <td width="62px" style="text-align: center;">
                    {{ $supplierbill->discount }}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;text-align: right;margin: 10px" colspan="6">
                    Total Amount
                </td>
                <td width="62px" style="text-align: center;">
                    {{ $supplierbill->final_total }}
                </td>
            </tr>
        </table>
        @endif


        <table id="fixed_footer" style="position: fixed; left: 12; bottom: 80; width: 88%;">
            <tfoot>
                <tr>
                    <td>
                        <span style="padding-left: 10px; float: left; padding-top: 30px;">----------------------</span>
                    </td>
                    <td>
                        <span style="padding-left: 30px; float: left; padding-top: 30px;margin-left:110px">----------------------</span>
                    </td>
                    <td>
                        <span style="padding-right: 10px; float: right; padding-top: 30px;">----------------------</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span style="padding-left: 0px; margin-left:20px; float: left; padding-top: 50px;">Prepared By</span>
                    </td>
                    <td>
                        <span style="padding-left: 0px; margin-left:150px; float: left; padding-top: 50px;">Accepted By</span>
                    </td>
                    <td>
                        <span style="padding-right: 0px; margin-right:10; float: right; padding-top: 50px;">Approved By</span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    @if (!$loop->last)
        <div class="page_break"></div>
    @endif
    @endforeach
</body>
</html>
