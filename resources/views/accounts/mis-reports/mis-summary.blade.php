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
        table, table th, table td {border-spacing: 0;border: 1px solid #e3e3e3;}
        table th, table td{padding:5px;}
        table tbody td:nth-child(4),table tbody td:nth-child(3){
            text-align: right;
        }
        table thead{
            background: #e3e3e3;
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
        <img src="{{asset(config('company_info.logo'))}}" alt="">
        <h2 style="margin:0; padding:0">MIS For the Month of {{now()->format('M, Y')}} </h2>
    </div>
    <br>

    <table>
        <thead>
            <tr>
                <th rowspan="2">Lead Column</th>
                <th rowspan="2">Jun'21</th>
                <th>YTD</th>
            </tr>
                <th>
                    Calendar Year 2021 <br>
                    (Jan'{{now()->format('y')}}-Dec'{{now()->format('y  ')}})
                </th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            <tr>
                 <td class="base_header">New Sales-Booking Value</td>
                <td> 13.23 </td>
                <td> 33.71 </td>
            </tr>
            <tr>
                <td class="balance_header"> Less: Cancell </td>
                <td> 13.23 </td>
                <td> 33.71 </td>
            </tr>
            <tr>
                <td class="base_header"> Net Sales </td>
                <td> 13.23 </td>
                <td> 33.71 </td>
            </tr>


            <tr>
                <td class="base_header"> Cash Collection From: </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="balance_header"> Real Estate </td>
                <td> 13.23 </td>
                <td> 33.71 </td>
            </tr>
            <tr>
                <td class="balance_header">  Construction Service </td>
                <td> 13.23 </td>
                <td> 33.71 </td>
            </tr>
            <tr>
                <td class="balance_header"> Other </td>
                <td> 13.23 </td>
                <td> 33.71 </td>
            </tr>
            <tr>
                <td class="base_header">Operating Cash outflow </td>
                <td> 13.23 </td>
                <td> 33.71 </td>
            </tr>

        </tbody>
    </table>

    <br>
    <table>
        <thead>
            <tr>
                <td>Lead Column </td>
                <td>As on 30.06.21</td>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            <tr>
                <td>Bank Liability </td>
                <td> </td>
            </tr>
            <tr>
                <td> Unsold Inventory:</td>
                <td> </td>
            </tr>
            <tr>
                <td> Inventory Res</td>
                <td>  128.66  </td>
            </tr>
            <tr>
                <td> Inventory Comm </td>
                <td>  128.66  </td>
            </tr>
            <tr>
                <td> Total Unsold Inventory: </td>
                <td>   187.03 </td>
            </tr>
        </tbody>
    </table>

    <br>
    <table>
        <thead>
            <tr>
                <td>Types of Projects:</td>
                <td> Ongoing Projects No(s) </td>
                <td> Upcoming Projects No(s) </td>
                <td> Total (ongoing + Upcoming) </td>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            <tr>
                <td>Residential </td>
                <td>8 </td>
                <td>4</td>
                <td>12</td>
            </tr>
            <tr>
                <td>Commercial </td>
                <td>1 </td>
                <td>0</td>
                <td>1</td>
            </tr>
            <tr>
                <td>Mixed (Res+ Comm) </td>
                <td>1 </td>
                <td>0</td>
                <td>1</td>
            </tr>
            <tr>
                <td>Total No of Projects </td>
                <td>10</td>
                <td>4</td>
                <td>14</td>
            </tr>
        </tbody>
    </table>

    <br>
    <table>
        <thead>
            <tr>
                <td>No of Employees: </td>
                <td>No(s) </td>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            <tr>
                <td> Permanent </td>
                <td> 52 </td>
            </tr>
            <tr>
                <td> Contructual </td>
                <td> 28 </td>
            </tr>
        </tbody>
    </table>

    <br>
    <table>
        <thead>
            <tr>
                <td>No of Employees: </td>
                <td>No(s) </td>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            <tr>
                <td> Permanent </td>
                <td> 52 </td>
            </tr>
            <tr>
                <td> Contructual </td>
                <td> 28 </td>
            </tr>
        </tbody>
    </table>

    <br>
    <table>
        <thead>
            <tr>
                <td>Total Current Monthly CTC </td>
                <td> 0.35 </td>
            </tr>
        </thead>
    </table>

    <br>
    <table>
        <thead>
            <tr>
                <td>Lead Column </td>
                <td>Jun'21 </td>
                <td> YTD (Jan'21 to Dec'21) </td>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            <td>Monthly Gross Salary (Mgt) </td>
            <td> 0.26  </td>
            <td> 1.63  </td>
        </tbody>
    </table>

</body>
</html>
