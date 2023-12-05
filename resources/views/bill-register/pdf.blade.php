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

        .customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .customers td,
        .customers th {
            border: 1px solid #000;
            padding: 5px;
        }

        .customers tr:nth-child(even) {
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

        .approval td,
        .approval th {
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
    @endphp
    @foreach ($requisitions->first()->requisitiondetails->chunk(15) as $chunk)
        <div >
            <div class="container" id="fixed_header">
                <div class="row">
                    <div class="head1" style="padding-left: 180px; text-align: center">
                        <img src="{{ asset('images/ranksfc_log.png') }}" alt="Rangsfc">
                        <p>
                            Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road, Agrabad C/A, Chattogram.<br>
                            Phone: 2519906-8; 712023-5<br>
                            <a style="color:#000;" target="_blank">www.ranksfc.com</a>
                        </p>
                        <h3>
                            MATERIAL PURCHASE REQUISITION(MPR)
                        </h3>
                    </div>
                    <div style="padding:50 0 0 50; ">
                        <h4>
                            MPR No: {{ $requisitions[0]->mpr_no }}
                        </h4>
                        <h4>
                            Date: {{ $requisitions[0]->applied_date }}
                        </h4>
                    </div>
                </div>
            </div>

            <div style="clear: both"></div>

            <div class="container">
                <p>
                    Project Name: {{ $requisitions[0]->costCenter->name }}
                </p><br>
                <p>
                    Note: {{ $requisitions[0]->note }}
                </p>
            </div>
        </div>
        <div class="container" style="margin-top: 30px;">
            <table class="customers">
                <thead>
                    <tr>
                        <th>SL No.</th>
                        <th>Materials Name</th>
                        <th>Unit</th>
                        <th>Net<br>Cumulative<br>Received</th>
                        <th>Required<br>Presently</th>
                        <th>Required<br>Delivery<br>Date</th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @foreach ($chunk as $requisitiondetail)
                        <tr>
                            <td> {{ $iteration++ }} </td>
                            <td> {{ $requisitiondetail->nestedMaterial->name }} </td>
                            <td> {{ $requisitiondetail->nestedMaterial->unit->name }} </td>
                            <td> {{ $taken_quantity ?? 0 }} </td>
                            <td> {{ $requisitiondetail->quantity }} </td>
                            <td> {{ $requisitiondetail->required_date }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="container" id="fixed_footer">
                <div style="margin-top: 30px;">
                    <table class="customers">
                        <tr>
                            <td>
                                <p>Remarks from Project/Site: {{ $requisitions[0]->remarks }} </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="margin-top: 30px;">
                    <table class="customers">
                        <tr>
                            <td>
                                <p>Remarks by Inventory Management: </p>
                            </td>
                            <td>
                                <p>Remarks by Construction Department: </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="margin-top: 30px;">
                    <table class="customers">
                        <tr>
                            <td>
                                <p>Remarks by Inventory Management: </p>
                            </td>
                            <td>
                                <p>Remarks by Construction Department: </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="margin-top: 30px;">
                    <table class="approval" style="text-align: center; border:none!important">
                        <tr>
                            <td>
                                <p style="margin-top: 50px;">---------------------</p>
                                <p>Store in-charge</p>
                            </td>
                            <td>
                                <p style="margin-top: 50px;">---------------------</p>
                                <p>Project Incharge</p>
                            </td>
                            <td>
                                <p style="margin-top: 50px;">---------------------</p>
                                <p>Project Cordinator</p>
                            </td>
                            <td>
                                <p style="margin-top: 50px;">---------------------</p>
                                <p>Inventory Management</p>
                            </td>
                            <td>
                                <p style="margin-top: 50px;">---------------------</p>
                                <p>Approved By</p>
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
