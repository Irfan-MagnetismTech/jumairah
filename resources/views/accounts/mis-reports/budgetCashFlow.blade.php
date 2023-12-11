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
        <img src="{{asset(config('company_info.logo'))}}" alt="">
        <h2 style="margin:0; padding:0"> Budget Cash Flow </h2>
        <strong>From Jan'{{now()->format('y')}} to Dec'{{now()->format('y')}}</strong>
{{--        <strong>From Jan'{{now()->format('y')}} to Dec'{{now()->format('y')}}</strong>--}}
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">Lead Column</th>
                <th colspan="">Q1  </th>
                <th colspan="">Q2  </th>
                <th colspan="">HY1 </th>
                <th colspan="">Q3 </th>
                <th colspan="">Q4 </th>
                <th colspan="">HY2 </th>
                <th colspan="">YTD </th>
            </tr>
            <tr>
                <th>Jan-Mar-22 </th>
                <th>Apr-Jun-22 </th>
                <th>Jan-Jun-22 </th>
                <th>Jun-Aug-22 </th>
                <th>Aug-Sep-22 </th>
                <th>Jul-Dec-22 </th>
                <th>Total-2022</th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            <tr>
                <td>  Sales (In Value)</td>
                <td>26.38</td>
                <td>23.28</td>
                <td>49.66</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <th> 100.01</th>
            </tr>
            <tr>
                <th>Operating Inflow:</th>
                <td colspan="7"></td>
            </tr>
            <tr>
                <td>  Collection from Sales & Services</td>
                <td> 12.33 </td>
                <td>14.28</td>
                <td>26.66</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <th> 72.01</th>
            </tr>
            <tr>
                <th> Total Operating Inflow</th>
                <th> 12.33 </th>
                <th>14.28</th>
                <th>26.66</th>
                <th>0.00</th>
                <th>0.00</th>
                <th>0.00</th>
                <th> 72.01</th>
            </tr>
            <tr>
                <th>Operating Outflow:</th>
                <td colspan="7"></td>
            </tr>
            <tr>
                <td>Construction Cost</td>
                <td> 10.65 </td>
                <td>12.53</td>
                <td>23.18</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <th> 53.40</th>
            </tr>
            <tr>
                <td>  Architectural Fee</td>
                <td> 0.18</td>
                <td>0.18</td>
                <td>0.36</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <th> 0.71</th>
            </tr>
            <tr>
                <td>  Architectural Fee</td>
                <td> 1.45</td>
                <td>0.67</td>
                <td>2.13</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <th> 7.29</th>
            </tr>
            <tr>
                <td>  HR & Payroll Expenses</td>
                <td> 0.82</td>
                <td>1.31</td>
                <td>2.13</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <th> 4.12</th>
            </tr>
            <tr>
                <td> Final Settlement</td>
                <td>0.01</td>
                <td>0.01</td>
                <td>0.02</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <th>0.04</th>
            </tr>
            <tr>
                <td> Admin</td>
                <td>0.24</td>
                <td>0.16</td>
                <td>0.40</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <th>0.74</th>
            </tr>
            <tr>
                <td> Sales and Marketing, Branding & Promotion</td>
                <td>0.24</td>
                <td>0.38</td>
                <td>0.62</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <th>1.49</th>
            </tr>
            <tr>
                <td> Sales Incentive</td>
                <td>0.07</td>
                <td>0.06</td>
                <td>0.13</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <th>0.26</th>
            </tr>
            <tr>
                <td> Sales Cancellation</td>
                <td>0.20</td>
                <td>0.25</td>
                <td>0.44</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <th>0.69</th>
            </tr>
            <tr>
                <td> Divisional & Mgt Fee</td>
                <td>0.23</td>
                <td>0.23</td>
                <td>0.45</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <th>0.90</th>
            </tr>
            <tr>
                <td> Bank Interest (TL+SOD)</td>
                <td>0.54</td>
                <td>0.53 </td>
                <td>1.07</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00 </td>
                <th>1.99</th>
            </tr>
            <tr>
                <td> Fixed Assets</td>
                <td>1.54</td>
                <td>0.53 </td>
                <td>1.07</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00 </td>
                <th>2.43</th>
            </tr>
            <tr>
                <td> Space Purchase from Land Owner</td>
                <td>0.60</td>
                <td>0.60</td>
                <td>1.20</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <th>2.40</th>
            </tr>
            <tr>
                <th> Total Operating Outflow</th>
                <th>15.82</th>
                <th>17.09</th>
                <th>32.91</th>
                <th>0.00</th>
                <th>0.00</th>
                <th>0.00</th>
                <th>75.04</th>
            </tr>

            <tr>
                <th>  Operational Fund Surplus/(Deficit)</th>
                <td colspan="7"></td>
            </tr>
            <tr>
                <th>  Non Operating Inflow</th>
                <td colspan="7"></td>
            </tr>
            <tr>
                <td>Inter Company Loan Receipt</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Bank Finance</td>
                <td>5.95</td>
                <td>5.30</td>
                <td>11.25</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>12.35</td>
            </tr>
            <tr>
                <th>Non Operating Outflow</th>
                <td colspan="7"></td>
            </tr>
            <tr>
                <td>Inter Company Loan Receipt</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Bank Loan Repayment (Principal Part)</td>
                <td>(1.79)</td>
                <td>(1.81)</td>
                <td>(3.60)</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>(7.36)</td>
            </tr>
            <tr>
                <td>Advance Dividend</td>
                <td>(0.60)</td>
                <td>(0.60)</td>
                <td>(1.20)</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>(2.40)</td>
            </tr>
            <tr>
                <th>Non Operating Surplus/ Deficit</th>
                <th>3.56</th>
                <th>2.89</th>
                <th>6.45</th>
                <th>0.00</th>
                <th>0.00</th>
                <th>0.00</th>
                <th>2.59</th>
            </tr>
            <tr><td colspan="8"></td></tr>
            <tr>
                <th>Net Changes in Cash Flow</th>
                <th>0.07</th>
                <th>0.06</th>
                <th>0.13</th>
                <th>0.00</th>
                <th>0.00</th>
                <th>0.00</th>
                <th>0.20</th>
            </tr>
            <tr>
                <th>Bank Liability Opening Balance</th>
                <th>(17.63)</th>
                <th>(21.79)</th>
                <th>(17.63)</th>
                <th>0.00</th>
                <th>0.00</th>
                <th>0.00</th>
                <th>(17.63)</th>
            </tr>
            <tr>
                <th>Bank Liability Closing Balance</th>
                <th>(21.79)</th>
                <th>(25.28)</th>
                <th>(25.28)</th>
                <th>0.00</th>
                <th>0.00</th>
                <th>0.00</th>
                <th>(22.61)</th>
            </tr>



        </tbody>
    </table>

</body>
</html>
