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
    <img src="{{ asset(config('company_info.logo'))}}" alt="Logo" class="pdfimg">
    <div class="clearfix"></div>
    <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
</div>

<div id="pageTitle" style="display: block; width: 100%;">
    <h2 style="text-align: center; width: 50%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">Material Purchase Requisition (MPR)</h2>
</div>


<div class="container" style="margin-top: 10px; clear: both; display: block; width: 100%;">
    <div class="row">

        <div>
            <table style="font-size: 12px">
                <tbody>
                <tr>
                    <td>MPR No.</td>
                    <td>:479</td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>:06/06/2021</td>
                </tr>
                <tr>
                    <td>Project Name</td>
                    <td>:RFPL WHITE OAK</td>
                </tr>
                <tr>
                    <td>Building No.</td>
                    <td>:45645</td>
                </tr>


                </tbody>
            </table>



        </div>
    </div>

    <table id="table">
        <thead>
        <tr style="vertical-align: middle">

            <th>SL No.</th>
            <th>Material Code</th>
            <th>Material Name</th>
            <th>Unit</th>
            <th>Material Type</th>
            <th>Material Size</th>
            <th>Total<br> Estimated <br>Requirement</th>
            <th>Net <br>Comulative<br> Received</th>
            <th>Present <br>Stock</th>
            <th>Required <br>Presently</th>
            <th>Required<br> Delivery <br>Date</th>
        </tr>
        </thead>
        <tbody>
{{--        @forelse($projects as $key => $project)--}}
            <tr class="text-right">
                <td class="text-center">3</td>
                <td class="text-left"> <nobr></nobr>3</td>
                <td class="text-center">3</td>
                <td class="text-center">3</td>
                <td class="text-center">3</td>
                <td class="text-center">3</td>
                <td class="text-center">3</td>
                <td class="text-center">3</td>
                <td class="text-center">3</td>
                <td class="text-center">3</td>
                <td class="text-center">3</td>

            </tr>
{{--        @empty--}}
{{--            <tr>--}}
{{--                <td colspan="29"> <h5 class="text-muted my-3 text-left"> No Data Found Based on your query. </h5> </td>--}}
{{--            </tr>--}}
{{--            @endforeach--}}
        </tbody>

    </table>
    <br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br>
    <br><br><br> <br><br><br>

    <div style="border: 1px solid #000000">

                <p>Remarks from Project/Site: (purpose,Brand,Origin and other Specifications etc (if required)</p>
                <br><br><br><br>

            </div>
            <div style="border:  1px solid #000000">

                <p>Remarks by Inventory Management:</p>
                <br><br><br><br>

            </div>
            <div style="border:  1px solid #000000">

                <p>Remarks by Construction Dept:</p>
                <br><br><br><br>

            </div>
            <div style="border:  1px solid #000000">
                <br><br><br><br>

                <p>Store Incharge   Project Incharge    Project Cordinator    Inventory Management    Approve By<p>


            </div>
        </div>

</div>

<footer style="position: absolute; bottom: 30px;">
    <p style="text-align: center;">
        <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}};</small>
    </p>
</footer>

</body>
</html>
