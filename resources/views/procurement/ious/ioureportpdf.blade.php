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
            margin: 10px;
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

        .customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .customers td, .customers th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        .customers tr:nth-child(even){
            background-color: #f2f2f2;
        }

        .customers tr:hover {
            background-color: #ddd;
        }

        .customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #ddd;
            color: black;
        }

        .approval {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .approval td, .approval th {
            border: 1px solid #fff;
            padding: 5px;
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
        $iteration = 1;
        $itemCount = 0;
    @endphp
    @foreach ( $iou->ioudetails->chunk(15) as $chunk )

    <div>
        <div class="container" id="fixed_header">
            <div class="row">
                <div class="head1" style="padding-left: 180px; text-align: center">
                    <img src="{{ asset(config('company_info.logo')) }}" alt="Rangsfc">
                    <p>
                        JHL Address.<br>
                        Phone: 2519906-8; 712023-5<br>
                        <a style="color:#000;" target="_blank">www.ranksfc.com</a>
                    </p>
                    <h2 style="text-align: center; width: 25%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">IOU SLIP</h2>
                </div>
                <div style="padding:50 0 0 50; ">
                    <h4 >
                        PO No: {{isset($iou->iou_no) ? $iou->iou_no : 'N/A' }}
                    </h4>
                    <h4>
                        Date: {{ $iou->applied_date }}
                    </h4>
                </div>
            </div>
        </div>

        <div style="clear: both"></div>

        <div class="container">

            <p>
                Project Name: {{ $iou->costCenter->name }}
            </p><br>
            <p>
                IOU For:
                @if ($iou->type == 0)
                    Employee
                @elseif ($iou->type == 1)
                    Supplier
                @elseif($iou->type == 2)
                    Construction
                @elseif ($iou->type == 3)
                    EME
                @endif
            </p><br>

            @if ($iou->type == 1)
            <p>
                PO No.: {{$iou->po_no}}
            </p>
            <br>
            @elseif ($iou->type == 2)
            <p>
                Work Order No.: {{$iou->workOrder->workorder_no}}
            </p>
            <br>
            @elseif ($iou->type == 3)
            <p>
                Work Order No.:  {{$iou->EmeWorkOrder->workorder_no}}
            </p>
            <br>
            @endif
            @if ($iou->type != 0)
             <span class="font-weight-bold ml-5"> Supplier Name:</span><span>{{ $iou->supplier->name }} </span>
            @endif
            <p>
                Applied By: {{ $iou->appliedBy->name}}
            </p>
            <br>
            <p>
                Mpr No: {{$iou?->mpr?->mpr_no ?? 'N/A'}}
            </p>
            <br>
            <p>
                Note: {{$iou->remarks}}
            </p>
            <br>

        </div>
    </div>


    <div class="container" style="margin-top: 25px;">
        <table class="customers">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Purpose</th>
                    @if($iou->type == 0)
                    <th>Remarks</th>
                    @endif
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody style="text-align: center">

                @foreach ($chunk as $requisitiondetail)


                <tr>
                    <td> {{ $iteration++ }} </td>
                    <td> {{ $requisitiondetail->purpose }} </td>
                    @if($iou->type == 0)
                     <td>{{$requisitiondetail->remarks}} </td>
                    @endif
                    <td> {{ $requisitiondetail->amount }} </td>
                </tr>
                @endforeach
                @if($loop->last)
                <tr>
                    <td @if($iou->type == 0) colspan="3" @else colspan ="2" @endif class="text-right">(Rate Approx)  TOTAL TAKA =</td>
                    <td class="text-right">{{$iou->total_amount}}/=</td>
                </tr>
                @endif
            </tbody>

        </table>
        <div id="fixed_footer" style="margin-top:30px; padding-left: 10px; width: 97%;">



            <div  style="margin-top: 30px;">
                <table class="approval" style="text-align: center; border:none!important">
                    <tr>
                        <td >
                            <p style="margin-top: 50px;">---------------------</p>
                            <p>Requisition By</p>
                        </td>
                        <td >
                            <p style="margin-top: 50px;">---------------------</p>
                            <p>Authorized By</p>
                        </td>
                        <td >
                            <p style="margin-top: 50px;">---------------------</p>
                            <p>Checked By</p>
                        </td>
                        <td >
                            <p style="margin-top: 50px;">---------------------</p>
                            <p>Verified By</p>
                        </td>
                        <td >
                            <p style="margin-top: 50px;">---------------------</p>
                            <p>Approved By</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin-top: 50px;">---------------------</p>
                            <p>Received By</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @if (!$loop->last)
            <div class="page_break"></div>
        @endif
    @endforeach

</body>
</html>
