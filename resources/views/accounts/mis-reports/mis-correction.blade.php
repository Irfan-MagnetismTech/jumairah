<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        #tableArea{margin-top: 10px;margin-bottom: 10px;}
        table, table th, table td {border-spacing: 0;border: 1px solid #e3e3e3;}
        table th, table td{padding:5px;}
        table tbody td:nth-child(4),table tbody td:nth-child(3){
            text-align: right;
        }
        .text-left{
            text-align: left;
        }
        .text-right{
            text-align: right;
        }
        .text-center{
            text-align: center; 
        }
        table tbody td:first-child {
            text-align: left;
        }
    </style>
</head>

<body>
    <div style="text-align: center">
        <img src="{{asset('images/ranksfc_log.png')}}" alt="">
        <h2 style="margin:0; padding:0">Correction of MIS Report </h2>
        <strong>for the Calendar Year {{now()->format('Y')}}</strong>
    </div>
    <br>

    <table style="width: 100%">
        <thead>
            <tr>
                <th>Lead Column</th>
                <th>Jan-21 </th>
                <th>Feb-21</th>
                <th>Mar-21</th>
                <th>Apr-21</th>
                <th>May-21</th>
                <th>Jun-21</th>
                <th>Jul-21</th>
                <th>Aug-21</th>
                <th>Sep-21</th>
                <th>Oct-21</th>
                <th>Nov-21</th>
                <th>Dec-21</th>
                <th>YTD 2020</th>
            </tr>            
        </thead>
        <tbody style="text-align: center;">
            <tr>
                <td> New Sales-Booking Value </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 4.96 </td>
                <td> 1.49 </td>
                <td> 13.23 </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 4.96 </td>
                <td> 1.49 </td>
                <td> 13.23 </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 13.23 </td>
            </tr>
            <tr>
                <td> Cash Collection From: </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 4.96 </td>
                <td> 1.49 </td>
                <td> 13.23 </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 4.96 </td>
                <td> 1.49 </td>
                <td> 13.23 </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 13.23 </td>
            </tr>
            <tr>
                <td> Real Estate </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 4.96 </td>
                <td> 1.49 </td>
                <td> 13.23 </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 4.96 </td>
                <td> 1.49 </td>
                <td> 13.23 </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 13.23 </td>
            </tr>
            <tr>
                <td> Construction Service </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 4.96 </td>
                <td> 1.49 </td>
                <td> 13.23 </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 4.96 </td>
                <td> 1.49 </td>
                <td> 13.23 </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 13.23 </td>
            </tr>
            <tr>
                <td> Bank Liability </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 4.96 </td>
                <td> 1.49 </td>
                <td> 13.23 </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 4.96 </td>
                <td> 1.49 </td>
                <td> 13.23 </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 13.23 </td>
            </tr>
            <tr>
                <td> Inventory Res </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 4.96 </td>
                <td> 1.49 </td>
                <td> 13.23 </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 4.96 </td>
                <td> 1.49 </td>
                <td> 13.23 </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 13.23 </td>
            </tr>
            <tr>
                <td> Inventory Comm </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 4.96 </td>
                <td> 1.49 </td>
                <td> 13.23 </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 4.96 </td>
                <td> 1.49 </td>
                <td> 13.23 </td>
                <td> 5.08 </td>
                <td> 5.87 </td>
                <td> 13.23 </td>
            </tr>
        </tbody>

    </table>
    <p><strong class="text-center">* Closing Balance of CD A/c is BDT 558,324 on 30.06.2021 </strong></p>
    
</body>
</html>