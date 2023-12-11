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
            display: block !important;
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



    </style>
</head>

<body>



    <div id="logo" class="pdflogo">
        <div  style=" width:100% ; float:right !imoirtant; padding-left:750px;padding-top:0px; padding-right:0px;margin-right:-67px;">
            <p style="text-align: center; width: 55%; border: 1px solid #000000;  margin: 10px auto; padding: 10px;">
                Page No...........of .........</p>
        </div>
        <div  style=" width:100% ; float:right !imoirtant; padding-left:750px;padding-top:0px; padding-right:0px;margin-right:-67px; margin-top:50px;">
            <p style="text-align: center; width: 55%; border: 1px solid #000000;  margin: 10px auto; padding: 10px;">
                Date: ......../......../.............</p>
        </div>
        <img src="{{ asset(config('company_info.logo')) }}" alt="Logo" class="pdfimg">
        <div class="clearfix"></div>
        <p>JHL Address.</p>
        <p>Ph.: +88(031)2519906-8, Fax: 88(031)712023-5.</p>

    </div>


    <div id="pageTitle" style="display: block; width:100%  float:right">
        <h2 style="text-align: center; width: 30%; margin: 10px auto">
            Inter Project Transfer Report</h2>
    </div>

    <div class="container" style="margin-top: 10px; ">
        <div style="float: left; max-width: 500px !important; word-wrap:break-word; white-space: normal;">
            <div style="padding: 10px; border: 1px solid black;">
               <p>Name of Donor Project: {{ $material_movement?->inLocation?->name ?? ''}}</p>
            </div>
        </div>
        <div style="float: right;  max-width: 500px !important; word-wrap:break-word; white-space: normal;">
            <div style="padding: 10px; border: 1px solid black;">
                <p>Name of Donor Project: {{ $material_movement?->inLocation?->name ?? '' }}</p>

            </div>
        </div>
    </div><br><br>


    <div class="container" style=" width: 100%;">
        <div style="float: right;  max-width: 500px !important; word-wrap:break-word; white-space: normal;">
            <div style="padding: 10px; border: 1px solid black;">
                <p>For the Month Of: ..................................20......</p>
            </div>
        </div>
    </div>

    <br>
    <div class="container" style="margin-top: 10px; clear: both; display: block; width: 100%;">


        <table id="table">
            <thead>
                <tr style="vertical-align: middle" class="text-center">
                    <th >SL No</th>
                    <th >Materials Name</th>
                    <th >Transfear Date</th>
                    <th >MTO No</th>
                    <th >Unit</th>
                    <th >Quantity</th>
                    <th >Unit Price</th>
                    <th >Total Value</th>
                    <th >Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movements as $movement)
                <tr style="text-align: center">
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $movement->nestedMaterial->name }}</td>
                    <td>{{ $movement->transfer_date }}</td>
                    <td>{{ $movement->mto_no }}</td>
                    <td>{{ $movement->nestedMaterial->unit->name }}</td>
                    <td>{{ $movement->quantity }}</td>
                    <td>{{ $movement->unit_price }}</td>
                    <td>{{ $movement->total_value }}</td>
                    <td>{{ $movement->remarks }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                    <tr >
                        <td colspan="6" rowspan="2"> </td>
                        <td class="text-center"> Page Total = </td>
                        <td colspan=""> </td>
                        <td colspan="7" >  </td>
                    </tr>
                    <tr>
                        <td class="text-center"> Project Total = </td>
                        <td colspan=""></td>
                        <td colspan="7" >  </td>
                    </tr>
                </tfoot>
        </table>

        <br><br><br>
        <div style="display: block; width: 100%;">
            {{-- <h2 style="text-align: center; width: 65%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">
                Comparative Statement & Supplier Selection Form</h2> --}}
            <table style="text-align: center; width: 100%;">
                <tr>
                    <td>
                        <span>--------------------------------------------</span>
                        <p>Prepared By</p>
                        <p>Inventory Officer</p>
                    </td>
                    <td>
                        <span>--------------------------------------------</span>
                        <p>Authorised By</p>
                        <p>Project In Charge</p>
                    </td>
                    <td>
                        <span>--------------------------------------------</span>
                        <p>Checked By</p>
                        <p>Executive Inventory</p>
                    </td>
                    <td>
                        <span>--------------------------------------------</span>
                        <p>Head Of</p>
                        <p>Inventory Management</p>
                    </td>
                </tr>
            </table>

        <br>
        <span style="font-size: 11px; padding-left: 60px">This Report submit to Head Office every Month the date of 5th even if it is nil.</span>
        <br>
        </div>
    </div>
</body>

</html>
