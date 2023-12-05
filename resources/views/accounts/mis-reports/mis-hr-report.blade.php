<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        #tableArea{margin-top: 10px;margin-bottom: 10px;}
        table{
            width: 70%!important; 
            margin: 0 auto; 
        }
        table, table th, table td {border-spacing: 0;border: 1px solid #918c8c;}
        table th, table td{padding:5px;}
        table tbody td:nth-child(4),table tbody td:nth-child(3){
            text-align: right;
        }
        table thead{
            background: #e3e3e3; 
            text-align: center; 
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
        .base_header{font-weight: bold }
        .balance_header{font-weight: bold; padding-left:20px; }
        .balance_line{ padding-left:50px; }        
    </style>
</head>

<body>
    <div style="text-align: center">
        <img src="{{asset('images/ranksfc_log.png')}}" alt="">
        <h2 style="margin:0; padding:0"> HR Data </h2>
        <strong>From Jan'{{now()->format('y')}} to Dec'{{now()->format('y')}}</strong>
    </div>

    <table>
        <thead>
            <tr>
                <td rowspan="2">Lead Column</td>
                <td colspan="3">Q1 2021 </td>
                <td colspan="3">Q2 2021 </td>
                <td colspan="3">Q3 2021 </td>
                <td colspan="3">Q4 2021 </td>
            </tr>
            <tr>
                <td>Jan-21 </td>
                <td>Feb-21	</td>
                <td>Mar-21	</td>
                <td>Apr-21	</td>
                <td>May-21	</td>
                <td>Jun-21	</td>
                <td>Jul-21	</td>
                <td>Aug-21	</td>
                <td>Sep-21	</td>
                <td>Oct-21	</td>
                <td>Nov-21	</td>
                <td>Dec-21</td>
            </tr>         
        </thead>
        <tbody style="text-align: center;">






            <tr>
                <td>Head Count (HC) permanent</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Head Count (HC) Contructual</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Gross Salary Management</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Gross Salary Contructual</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>CTC Management</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>CTC Contructual</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    
</body>
</html>