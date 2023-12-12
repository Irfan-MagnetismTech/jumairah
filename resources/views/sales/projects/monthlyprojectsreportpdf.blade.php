<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Print - Monthly Projects Report</title>
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
    <h3>Monthly Project Report</h3>
</div>

<div class="container" style="margin-top: 10px; clear: both; display: block; width: 100%;">
    <table id="table">
        <thead>
        <tr>
            <th>Project Name</th>
            <th>Project Type</th>
            <th>Total Units</th>
            <th>Unsold Units</th>
            <th>Unsold Space</th>
            <th>Avg. Selling Price</th>
            <th>Parking + Utility</th>
            <th>Total Estimated Value </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>White Oak</td>
            <td>Residential</td>
            <td>12</td>
            <td>0</td>
            <td>12,234</td>
            <td>7,123</td>
            <td>2,345,345</td>
            <td>23,345,454</td>
        </tr>
        </tbody>
    </table>
</div>
<footer>
    <p style="clear: both; text-align: center">
        <small> Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}};</small>
    </p>
</footer>

</body>
</html>
