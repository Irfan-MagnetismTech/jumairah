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
    <img src="{{ asset('images/ranksfc_log.png')}}" alt="Logo" class="pdfimg">
    <div class="clearfix"></div>
    <h5>Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road, Agrabad C/A, Chattogram.</h5>
</div>

<div id="pageTitle" style="display: block; width: 100%;">
    <h2 style="text-align: center; width: 25%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">STORE ISSUE NOTE</h2>
</div>


<div class="container" style="margin-top: 10px; clear: both; display: block; width: 100%;">
    <div class="row">
        <div>
            <table style="font-size: 12px">
                <tbody>
                <tr>
                    <td>DATE</td>
                    <td>:21/04/2021</td>
                </tr>
                <tr>
                    <td>Project Name</td>
                    <td>:Park Windsor</td>
                </tr>
                <tr>
                    <td>SRF No.</td>
                    <td>:12-04-2021</td>
                </tr>
                <tr>
                    <td>SIN. No</td>
                    <td>:162428</td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
    <br>
    <br>
    <table id="table">
        <thead>
        <tr style="vertical-align: middle">

            <th width="20px">SL No.</th>
            <th width="100px">Material Name</th>
            <th width="60px">Ledger Folio No.</th>
            <th width="30px">Unit</th>
            <th width="60px">Issued Quantity/<br>Consumed</th>
            <th width="120px">Purpose of Works</th>

        </tr>
        </thead>
        <tbody>
        {{--        <!--        @forelse($projects as $key => $project)-->--}}
        <tr class="text-right">
            <td class="text-center">3</td>
            <td class="text-right"> <nobr></nobr>3</td>
            <td class="text-right">3</td>
            <td class="text-right">3</td>
            <td class="text-right">3</td>
            <td class="text-right">3</td>
        </tr>

        <!--        {{--                @empty--}}-->
        <!--        {{--                    <tr>--}}-->
        <!--            {{--                        <td colspan="29"> <h5 class="text-muted my-3 text-left"> No Data Found Based on your query. </h5> </td>--}}-->
        <!--            {{--                    </tr>--}}-->
        <!--        {{--                    @endforeach--}}-->
        </tbody>
    </table>
    <br>

    <br><br><br>
    <div class="row">
        <div class="col-md-6">
            <br>
            <span>----------------------</span>
            <p>Isuued By<br>Inventory Officer</p>
            <br>
            <span>----------------------</span>
            <p>Receieved/Returned By<br>Supersing Engineer</p>
            <br>
            <span>----------------------</span>
            <p>Approved By<br>Engineer Incharge</p>
            <span>----------------------</span>
        </div>
    </div>
</div>
</body>
</html>


