
<!DOCTYPE html>
<html>
<head>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size:12px;
            margin: 0;
            padding: 0;
        }
        table{
            font-size:9px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td, #table th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #table tr:nth-child(even){
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
        .tableHead{
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }

        p{
            margin:0;
        }
        h1{
            margin:0;
        }
        h2{
            margin:0;
        }
        .container{
            margin: 20px;
        }
        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
            position: relative;
        }
        #client{
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            top: 0;
            line-height: 18px;
            padding: 5px;
        }
        #apartment{
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            right: 20px;
            top: 20px;
            line-height: 18px;
            padding: 5px;
        }
        .infoTable{
            font-size: 12px;
            width: 100%;
        }
        .infoTableTable td:nth-child(2) {
            text-align: center;
            width: 20px;
        }
        .pdflogo a{
            font-size: 18px;
            font-weight: bold;
        }
        .text-right{
            text-align: right;
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
        }
        @page { margin: 30px 0 0 30px; }
    </style>
</head>
<body>

<div id="logo" class="pdflogo">
    <img src="{{ asset(config('company_info.logo'))}}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}" class="pdfimg">
    <div class="clearfix"></div>
    <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
</div>

<div id="pageTitle" style="display: block; width: 100%;">
    <h2 style="text-align: center; width: 25%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">Supplier Bill</h2>
</div>


<div class="container" style="margin-top: 10px; clear: both; display: block; width: 100%;">
    <div class="row">

        <div>
            <table style="font-size: 12px">
                <tbody>
                <tr>
                    <td>Date</td>
                    <td>:06/06/2021</td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>:Mr.Manik Miah</td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td>:Procurement</td>
                </tr>
                <tr>
                    <td>Designation</td>
                    <td>:Assitant Manager</td>
                </tr>
                <tr>
                    <td>Project Name</td>
                    <td>:RFPL White Oak</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
<br>
    <table id="table">

        <tbody style="font-size: 12px">
        {{--        @forelse($projects as $key => $project)--}}
        <tr>
            <td class="text-center"  style="background-color: #0C4A77;color: white;font-weight: bold">SL No.</td>
            <td width="400px" class="text-center" style="background-color: #0C4A77;color: white;font-weight: bold">Purpose</td>
            <td class="text-center" style="background-color: #0C4A77;color: white;font-weight: bold">Amount</td>
        </tr>
        <tr>
            <td class="text-center">1.</td>
            <td> Please issue an A/C Payee cheque in favour of M/S MAYA ENTERPRISE.
                A against delivery of Sylhet sand.Use for
                5th Floor coloumn casting purpose.</td>
            <td class="text-right">@money(249303)/-</td>
        </tr>
        <tr>
            <td></td>
            <td>MPR No:17283,28383,38383
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>MRR No:17283,28383,38383
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>PO No:17283,28383,38383
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Bill No:17283,28383,38383
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Office Bill No:17283,28383,38383
            </td>
            <td></td>
        </tr>
        </tbody>

    </table>
    TAKA(In Words):
    <br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br>
    <br><br><br> <br><br><br>

    <div>
        <br><br><br><br>
        <p>Store Incharge   Project Incharge    Project Cordinator    Inventory Management    Approve By<p>
    </div>
</div>


</body>
</html>
